<?php
// Start the session at the beginning of the file
session_start();

// Include the session handler to ensure that session variables are set
include('profile-controller.php');

// Check if the username is set in the session
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle the case when the username is not set
    header("Location: ../login/login.php");
    exit();
}


if (isset($userDetailsResult) && $userDetailsResult->num_rows > 0) {
    // Fetch details of the requested user
    $userDetails = $userDetailsResult->fetch_assoc();

    // Initialize variables with default values
    $username = $userDetails['username'] ?? '';
    $userAvatar = $userDetails['user_avatar'] ?? '';
    $userBio = $userDetails['bio'] ?? '';
    $user_id = $userDetails['user_id']; // Update the user_id for the requested profile

    // Create a separate variable for fetching posts
    $postsResult = $conn->query($postsQuery);

    // Fetch posts for the requested user and store them in an array
    $posts = array();
    while ($row = $postsResult->fetch_assoc()) {
        $posts[] = $row;
    }
    // ...
} else {
    echo "User not found.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likha</title>
    <link rel="icon" type="image/x-icon" href="..\assets\images\blue_logo.png">
    <script src="profile.js"></script>
    <link rel="stylesheet" href="profile.css">
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

            <div class="profile">
                <div class="post-img">
                    <h2>Gallery</h2>
                    <!--lalagyan ng posts ni user-->
                    <div class="gallery">
                    <?php if (isset($posts) && count($posts) > 0): ?>
                        <?php foreach ($posts as $row): ?>
                            <?php $post_image = "../posting/uploads/" . $row['img_post']; ?>
                            <div class="post-thumbnail">
                                <a href="../home/display-post.php?post_id=<?php echo $row['post_id']; ?>">
                                    <img src="<?php echo $post_image; ?>" alt="Posted Image">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h1 class="no-post-message">Stay tuned for my masterpieces!</h1>
                    <?php endif; ?>
                </div>

                </div>

                <div class="post-text">
                    <div class="user">
                        <div class="circle-img">
                            <img src="../assets/images/<?php echo $userAvatar; ?>">
                        </div>
                    </div>

                    <div class="user-name">
                        <h1>
                            <?php echo $username; ?>
                        </h1>
                    </div>

                    <div class="user-bio">
                        <p>User Bio</p>
                        <h2>
                        <?php echo !empty($userBio) ? $userBio : 'Yet to Share My Story.'; ?>
                        </h2>
                    </div>
                    

                    <?php
                    if ($username !== $mainLoggedInUsername) {
                        // Display "Block User" button for other user's profile
                        // echo '<button id="red">Block User</button>';
                    } else {
                        // Display "Edit Profile" button for the logged-in user's profile
                        echo '<button id="blue" onclick="openAvatarModal()" >Edit Profile</button>';
                    }
                    ?>
                </div>
                <div id="avatarModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeAvatarModal()">&times;</span>
                        <h1>Choose Your Avatar...</h1>
                        <div class="avatar-container">
                            <div class="avatar-img">
                                <img src="../assets/images/bear.jpg" id="bear" onclick="selectAvatar('bear.jpg')"></img>
                                <img src="../assets/images/bird.jpg" id="img_postify" onclick="selectAvatar('bird.jpg')"></img>
                                <img src="../assets/images/capricorn.jpg" id="img_postify" onclick="selectAvatar('capricorn.jpg')" class="selected-avatar"></img>
                                <img src="../assets/images/cat.jpg" id="img_postify" onclick="selectAvatar('cat.jpg')"></img>
                                <img src="../assets/images/dog.jpg" id="img_postify" onclick="selectAvatar('dog.jpg')"></img>
                            </div>
                            <div class="avatar-img">
                                <img src="../assets/images/eagle.jpg" id="img_postify" onclick="selectAvatar('eagle.jpg')"></img>
                                <img src="../assets/images/egg.jpg" id="img_postify" onclick="selectAvatar('egg.jpg')"></img>
                                <img src="../assets/images/goat.jpg" id="img_postify" onclick="selectAvatar('goat.jpg')"></img>
                                <img src="../assets/images/lion.jpg" id="img_postify" onclick="selectAvatar('lion.jpg')"></img>
                                <img src="../assets/images/whitecat.jpg" id="img_postify" onclick="selectAvatar('whitecat.jpg')"></img>
                            </div>
                        </div>
                        <h1>Set Up Your Bio...</h1>
                        <div class="avatar-container"> 
                            <div class="div-input">
                                <input 
                                    type="text" 
                                    id="bio_input" 
                                    placeholder="Tell something about yourself...">
                            </div>
                            <button onclick="submitBio()">Save</button>
                        </div>
            </div>
        </div>
    </div>
</body>

</html>