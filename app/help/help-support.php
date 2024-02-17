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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likha</title>
    <link rel="icon" type="image/x-icon" href="..\assets\images\blue_logo.png">
    <script src="help-support.js"></script>
    <script src="../assets/10fa757270.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="help-support.css">
</head>

<body>
    <div class="container">
        <?php include('../view/components/search.php'); ?>
        <?php include('../view/components/sidebar.php'); ?>
        <?php include('../notification/notification.php'); ?>
        <?php include('../view/components/sidebar-mobile.php'); ?>

        <div id="loading_modal" class="modal">
            <div class="loading-modal-content slide-bottom">
            <div class="spinner"></div>
            <label>Please wait...</label>
            </div>
        </div>

        <div id="my_modal" class="modal">
            <div class="modal-content slide-bottom">
                <p id="modal_message"></p>
                <div class="close-modal">
                    <button class="close" onclick="closeModal()" id="btn_close">OK</button>
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

        <div class="gallery-container">

            <h1>Welcome to Our Help and Support Center</h1>
            <div>
                <p>At Likha, we are committed to providing you with the best
                    experience possible. Our Help and Support Center is here
                    to assist you with any questions or concerns you may have.
                    Your feedback is crucial in maintaining a safe and
                    enjoyable environment for all users. If you encounter

                    any issues, report them by:</p>

                <ul>
                    <li>
                        Identify the specific content, feature, or interaction
                        where you encountered the problem.</li>

                    <li>Clearly describe the issue you are facing.
                        Include relevant information such as error
                        messages, timestamps, and any other details
                        that can help our team understand the problem.</li>
                    <li>To provide a more comprehensive overview, you
                        can attach images or screenshots that illustrate
                        the issue. This will assist our developers in quickly
                        identifying and resolving the problem.</li>
                </ul>

                <p>Thank you for choosing Likha. We value your presence

                    in our community and are here to assist you every
                    step of the way.</p>
            </div>

            <div>
                <!-- <form method="post" action="help-support-controller.php" enctype="multipart/form-data" > -->
                    <div class="reporting">

                        <div class="report-img">
                            <img id="preview" src="#" alt="Preview">
                            <i class="fa-solid fa-image" id="default_image"></i>
                            <div class="file-img">
                                <label for="input-tag" id="select_img">
                                    Select from computer
                                    <input id="input-tag" type="file" accept="image/*" onchange="previewFile()" />
                                    <span id="image-name"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="report-form" id="report_form">
                            <label for="problem">Report a problem:</label>
                            <textarea placeholder="Please include as much info as possible..." name="problem" id="problem" cols="80" rows="10" required=""></textarea>

                            <button onclick="submitReport()" id="submit_report">Report</button>
                        </div>

                        
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</body>

</html>
