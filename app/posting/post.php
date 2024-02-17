<?php
include('../include/db.php');

session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    // Redirect to login.php
    header("Location: ../login/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$user_avatar = $_SESSION['user_avatar']; 

$cookie_name = "email";
$cookie_value = $email;
if (!isset($_COOKIE[$cookie_name])) {
    setcookie($cookie_name, $cookie_value, time() + 3600, '/', 'localhost');
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
    <script src="post.js"></script>
    <script src="../assets/10fa757270.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="post.css">
</head>

<body>
    <!-- modal for registration notification -->
    <div id="my_modal" class="post-modal">
        <div class="modal-content slide-bottom">
            <p id="modal_message"></p>
            <div class="close-modal" id="close_post">
                <button class="close-post" onclick="closeModal()">OK</button>
            </div>
        </div>
    </div>

    <div class="header-mobile">
        <a href="../home/home.php" class="logo-link-mobile">
            <img src="../assets/images/logo_word.png" alt="Likha" class="logo">
        </a>

        <a href="#" id="notif_btn_mobile" class="notif-mobile">
            <img src="../assets/images/notification_icon.png" alt="Notifications"> 
        </a>
    </div>

    <div class="container">
        <?php include('../view/components/search.php'); ?>
        <?php include('../view/components/sidebar.php'); ?>
        <?php include('../notification/notification.php'); ?>
        <?php include('../view/components/sidebar-mobile.php'); ?>

        <div class="gallery-container">
            <h1>Create New Post</h1>
            <div class="posting">
                <div class="post-img">
                    <img id="preview" src="#" alt="Preview">
                    <img id="select_icon" src="../assets/images/selectfcomp_icon.png" alt="Select from computer"></img>
                    <div class="file-img">
                        <label for="input-tag" id="select_img">
                            Select from files
                            <input id="input-tag" type="file" name="fileInput" accept="image/*"
                                onchange="previewFile()" />
                            <span id="image-name"></span>
                        </label>
                    </div>
                </div>
                <div class="post-text">
                    <div class="user">
                        <div class="circle-img">
                        <img src="../assets/images/<?php echo $user_avatar; ?>" alt="User Avatar">
                        </div>
                        <label>
                            <?php echo $username ?>
                        </label>
                    </div>

                    <textarea placeholder="Got something to share?" name="" id="post_text" cols="60" rows="20"
                        required></textarea>
                    <div id="share_btn" onclick="openShareModal()">
                        <label for="share_btn">Share this post to...</label>
                        <img id="arrow_icon" src="../assets/images/arrow_icon.png"></img>
                    </div>

                    <div id="shareModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeShareModal()">&times;</span>
                            <h2>Share this post to...</h2>
                            <div class="share-app">
                                <div class="app-item">
                                    <img src="../assets/images/img_postify.png" id="img_postify"></img>
                                    <span>Postify</span>
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="app-item">
                                    <img src="../assets/images/img_hypehive.png" id="img_hypehive"></img>
                                    <span>Hype Hive</span>
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <button onclick="closeShareModal()">Done</button>
                        </div>
                    </div>
                    <button id="submit_post" onclick="submitPost()">Post</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>