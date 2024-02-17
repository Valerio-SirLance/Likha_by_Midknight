<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    // Redirect to login.php
    header("Location: ../login/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];

$cookie_name = "email";
$cookie_value = $email;
if (!isset($_COOKIE[$cookie_name])) {
    setcookie($cookie_name, $cookie_value, time() + 3600, '/', 'localhost');
}
$post_id = urldecode($_GET['post_id']);
$post_image = urldecode(($_GET['post_image']));
$post_caption = urldecode(($_GET['post_caption']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likha</title>
    <link rel="icon" type="image/x-icon" href="..\assets\images\blue_logo.png">
    <script src="post.js"></script>
    <script src="../assets/10fa757270.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="post.css">
</head>

<body>
    <div class="container">
        <?php include('../view/components/sidebar.php'); ?>
        <div class="gallery-container">
            <h2>Edit Post</h2>      
            <div class="posting">
                <div class="post-img">
                    <img id="preview-edit" src="<?php echo $post_image?>" alt="Preview">                                                                                              
                </div>
                <div class="post-text">
                    <div class="user">
                        <div class="circle-img">
                        <i class="fa-solid fa-user"></i>
                        </div>
                        <label><?php echo $username?></label>
                    </div>

                    <textarea placeholder="Write a caption for your creation..." name="" id="post_text" cols="60"
                        rows="20" required><?php echo $post_caption?></textarea>
                    <div id="share_btn">
                        <label>Share this post to...</label>
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
                    <button id="submit_post" onclick="editPost(<?php echo $post_id?>)">Edit Post</button>
                </div>
            </div>
            <!-- Add image gallery here -->
            <!-- Each image should be a separate div or figure -->
            <!-- Use CSS to style the gallery -->
        </div>
    </div>
</body>

</html>