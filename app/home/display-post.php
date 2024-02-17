<?php
include('home-controller.php');
// Ensure that the post_id is set in the URL
if (!isset($_GET['post_id'])) {
    // Redirect or display an error message
    header("Location: error.php");
    exit();
}

$post_id = $_GET['post_id'];
$userId = $_SESSION['user_id'];
// Function to get details for a specific post_id
function getPostDetails($post_id)
{
    global $conn;

    $sql = "SELECT tblpost.*, tblregistration.username
            FROM tblpost
            JOIN tblregistration ON tblpost.user_id = tblregistration.user_id
            WHERE tblpost.post_id = $post_id AND tblpost.deleted_at IS NULL";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}


// Function to check if the user liked the post
function checkUserLiked($post_id, $user_id)
{
    global $conn;

    $sql = "SELECT like_at FROM tbl_acclike WHERE post_id = $post_id AND user_id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // User has liked the post, return the like timestamp
        $row = $result->fetch_assoc();
        return $row['like_at'];
    }

    // User hasn't liked the post
    return null;
}

// Fetch details for the specific post_id
$postDetails = getPostDetails($post_id);

if (!$postDetails) {
    // Handle the case where post details couldn't be retrieved
    echo "Error fetching post details.";
    exit();
}

$post_image = $postDetails['img_post'];
$post_caption = $postDetails['post'];
$username = $postDetails['username'];


// Check if the user liked the post
$userLiked = checkUserLiked($post_id, $_SESSION['user_id']);

function getComments($post_id)
{
    global $conn;

    $sql = "SELECT 
    c.*, 
    u.user_avatar AS  `img-user`,
    r.username AS comment_username,
    rr.username AS reply_username,
    GROUP_CONCAT(rpl.reply ORDER BY rpl.created_at ASC SEPARATOR '|') AS replies
    FROM tbl_comment c
    JOIN tbluser u ON c.user_id = u.user_id
    JOIN tblregistration r ON c.user_id = r.user_id
    LEFT JOIN tblreply rpl ON c.comment_id = rpl.comment_id
    LEFT JOIN tblregistration rr ON rpl.user_id = rr.user_id
    WHERE c.post_id = '$post_id' AND u.deleted_at IS NULL
    GROUP BY c.comment_id;";

    $result = $conn->query($sql);

    $comments = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $row['replies'] = array_filter(explode('|', $row['replies']), 'strlen');
            $comments[] = $row;
        }
    }

    return $comments;
}


// Function to get the number of likes for a specific post
function getNumberOfLikes($post_id)
{
    global $conn;

    $sql = "SELECT COUNT(*) as like_count FROM tbl_acclike WHERE post_id = $post_id AND like_at IS NOT NULL";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['like_count'];
    }

    return 0; // Return 0 if no likes are found
}

function getAvatarFilenameFromDatabase($post_id)
{
    global $conn;

    // Replace this query with your actual query to fetch the avatar filename from the database
    $sql = "SELECT u.user_avatar FROM tbluser u
            JOIN tblpost p ON u.user_id = p.user_id
            WHERE p.post_id = $post_id";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['user_avatar'];
    } else {
        // Return a default filename or handle the case where the filename is not found
        return "default_avatar.jpg";
    }
}
// Function to get the avatar URL based on user_id
function getAvatarUrl($post_id)
{
    $avatarDirectory = "../assets/images/"; // Change the directory path as needed

    // Get the avatar filename from the database
    $avatarFilename = getAvatarFilenameFromDatabase($post_id);

    // Construct the full path to the avatar
    $avatarPath = $avatarDirectory . $avatarFilename;

    // Check if the avatar file exists, use a default if not
    if (file_exists($avatarPath)) {
        return $avatarPath;
    } else {
        // Return a default avatar if the specific avatar file is not found
        return $avatarDirectory . "default_avatar.jpg";
    }
}
$userAvatar = getAvatarUrl($post_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likha</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/blue_logo.png">
    <script src="home.js"></script>
    <script src="../assets/10fa757270.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="display-post.css">

</head>

<body>
    <div class="container">
        <?php include('../view/components/search.php'); ?>
        <?php include('../view/components/sidebar.php'); ?>
        <?php include('../notification/notification.php'); ?>
        <?php include('../view/components/sidebar-mobile.php'); ?>

        <div class="header-mobile">
            <a href="../home/home.php" class="logo-link-mobile">
                <img src="../assets/images/logo_word.png" alt="Likha" class="logo">
            </a>

            <a href="#" id="notif_btn_mobile" class="notif-mobile">
                <img src="../assets/images/notification_icon.png" alt="Notifications"> 
            </a>
        </div>

        <div class="gallery-container">
            <div class="posting">
                <div class="post-img">
                    <!-- Display the post image -->
                    <button id="previous" class="nav-button" onclick="navigatePost('previous')"><img src="../assets/images/left_arrow_icon.png" alt="Previous"></button>
                    <img src="../posting/uploads/<?php echo $post_image; ?>" alt="Posted Image"> 
                    <button id="next" class="nav-button" onclick="navigatePost('next')"><img src="../assets/images/right_arrow_icon.png" alt="Next"></button>
                </div>
                <div class="post-text">
                    <div class="user">
                        <div class="user-content">
                            <div class="circle-img">
                                <!-- <img src="../assets/images/goat.jpg" alt="">
                             -->
                                <img src="<?php echo $userAvatar; ?>" alt="User Avatar">
                            </div>
                            <label>
                                <a href="../user profile/profile.php?username=<?php echo $username; ?>">
                                    <?php echo $username ?>
                                </a>
                            </label>
                        </div>
                        <?php
                        if ($userId == $postDetails['user_id']) {
                            echo '<div class="ellipses" onclick="showMore()">';
                            echo '<img src="../assets/images/more-vertical.svg">';
                            echo '<div class="dropdown" id="dropdown">';
                            echo '<button type="button" onclick="openShareModal(\'' . $post_id . '\')">Delete</button>';
                            echo '<button type="button" onclick="toggleEdit()">Edit Post</button>';
                            echo '</div>';
                            echo '</div>';
                        }

                        ?>
                    </div>

                    <div class="post-text-caption">
                        <!-- Display the post text caption -->
                        <textarea placeholder="Write a caption for your creation..." name="" id="post_text" cols="60"
                            rows="20" required readonly><?php echo $post_caption ?></textarea>
                        <!-- <p id="post_text">
                         
                        </p> -->
                        <div class="actions">
                            <?php
                            $userLikeInfo = checkUserLiked($post_id, $_SESSION['user_id']);
                            if ($userLikeInfo !== null) {
                                $userLiked = true;
                                $likeTimestamp = $userLikeInfo;
                            } else {
                                $userLiked = false;
                                $likeTimestamp = null;
                            }
                            ?>
                            <?php if ($userLiked): ?>
                                <?php if ($likeTimestamp !== null): ?>
                                    <!-- User has liked the post, display solid heart -->
                                    <i class="like-icon fa-solid fa-heart" onclick="likePost('<?php echo $post_id; ?>')"></i>
                                <?php else: ?>
                                    <!-- User has liked the post, but like_at is null (handle this case as needed) -->
                                    <!-- Display a solid heart or another appropriate icon -->
                                    <i class="like-icon fa-solid fa-heart" onclick="likePost('<?php echo $post_id; ?>')"></i>
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- User hasn't liked the post, display regular heart -->
                                <i class="like-icon fa-regular fa-heart" onclick="likePost('<?php echo $post_id; ?>')"></i>
                            <?php endif; ?>
                            <p id="num_likes">
                                <?php echo getNumberOfLikes($post_id) . " likes"; ?>
                            </p>
                            <button id="submit_post" onclick="editPost(<?php echo $post_id ?>)">Submit</button>
                        </div>
                    </div>

                    <h3>Comments</h3>
                    <div class="comments">
                        <?php
                        $comments = getComments($post_id);
                        foreach ($comments as $comment) {
                            ?>
                            <div class='comments-container' id='comment-container-<?php echo $comment['comment_id']; ?>'>
                                <div class='user-info'>
                                    <img src="../assets/images/<?= $comment['img-user'] ?>" alt="User Avatar"
                                        class="comment-avatar">
                                    <p class='username'>
                                        <a href='../user profile/profile.php?username=<?= $comment['comment_username'] ?>'>
                                            <?php echo $comment['comment_username']; ?>
                                        </a>
                                    </p>
                                </div>
                                <div class='user-comment'>
                                    <p>
                                        <?php echo $comment['comment']; ?>
                                    </p>
                                    <button id="btn_reply"
                                        onclick="showReplyField('<?php echo $comment['comment_id']; ?>')">Reply</button>
                                </div>
                                <div class='reply-field' id='reply-field-<?php echo $comment['comment_id']; ?>'>
                                    <input type='text' placeholder='Your reply'
                                        id='reply-<?php echo $comment['comment_id']; ?>'>
                                    <img src="../assets/images/send.svg" id="btn_submit_reply"
                                        onclick="submitReply('<?php echo $comment['comment_id']; ?>')">
                                    <!-- <button>Submit
                                        Reply</button> -->
                                </div>
                                <div id="replyContainer" class="reply-container"></div>
                            </div>
                            <?php
                            foreach ($comment['replies'] as $reply) {
                                ?>
                                <div class='reply'>
                                    <?php echo '<span class="bold-username">' . $comment['reply_username'] . ' :</span> ' . $reply; ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div id="commentsContainer"></div>

                    </div>
                    <div class="comment-form">
                        <input type="text" id="comment_box" placeholder="Add a comment..."
                            onkeypress="handleKeyPress(event, '<?php echo $post_id; ?>')">
                        <i class="fa-regular fa-paper-plane" onclick="postComment('<?php echo $post_id; ?>')"></i>
                        <!-- Add an onclick event to handle comment submission -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="shareModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeShareModal()">&times;</span>
                            <h2>Are you sure you want to delete this post?</h2>
                                <div id="buttons"><button id="red" onclick="deletePostAndRedirect('<?php echo $post_id; ?>')">Delete Post</button>
                                <button id="blue" onclick="closeShareModal()">Cancel</button>
                            </div>                            
                        </div>
                    </div>

<script>
    function navigatePost(direction) {
        // Retrieve the current post ID
        var currentPostId = <?php echo $post_id; ?>;

        // Fetch the next or previous post ID from the server based on the current post ID
        <?php
        // Fetch next post ID
        $sqlNext = "SELECT MIN(post_id) AS next_post_id FROM tblpost WHERE post_id > $post_id AND deleted_at IS NULL";
        $resultNext = $conn->query($sqlNext);
        $nextRow = $resultNext->fetch_assoc();
        $nextPostId = $nextRow['next_post_id'];

        // Fetch previous post ID
        $sqlPrev = "SELECT MAX(post_id) AS prev_post_id FROM tblpost WHERE post_id < $post_id AND deleted_at IS NULL";
        $resultPrev = $conn->query($sqlPrev);
        $prevRow = $resultPrev->fetch_assoc();
        $prevPostId = $prevRow['prev_post_id'];

        // Fetch the last post ID
        $sqlLast = "SELECT MAX(post_id) AS last_post_id FROM tblpost WHERE deleted_at IS NULL";
        $resultLast = $conn->query($sqlLast);
        $lastRow = $resultLast->fetch_assoc();
        $lastPostId = $lastRow['last_post_id'];
        ?>

        // Determine the next or previous post ID based on the direction
        var nextPostId, prevPostId;
        if (direction === 'next') {
            nextPostId = <?php echo $nextPostId !== null ? $nextPostId : 1; ?>;
            window.location.href = 'display-post.php?post_id=' + nextPostId;
        } else if (direction === 'previous') {
            prevPostId = <?php echo $prevPostId !== null ? $prevPostId : $lastPostId; ?>;
            window.location.href = 'display-post.php?post_id=' + prevPostId;
        }
    }
</script>



</body>

</html>