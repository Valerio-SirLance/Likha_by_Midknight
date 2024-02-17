<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/x-icon" href="../assets/images/blue_logo.png">
    <title>Login</title>
</head>

<body>
    <div>

        <!-- message modal -->
        <div id="my_modal" class="modal">
            <div class="modal-content slide-bottom">
                <p id="modal_message"></p>
                <div class="close-modal">
                    <button class="close" onclick="closeModal()" id="btn_close">OK</button>
                </div>

            </div>
        </div>

        <!-- hype hive login modal -->
        <div id="hypehive_modal" class="modal">
            <div class="modal-content slide-bottom">
                <div class="hype-container">
                    <div class="hype-close-modal">
                    <img src="../assets/images/x.svg" onclick="closeHypeHiveModal()" id="hype_close">
                    </div>
                    <img src="../assets/images/img_hypehive.png" id="logo_hype">
                    <h2>Hype Hive</h2>
                    <input type="text" name="email" id="email_hype" placeholder="Enter your email...">
                    <input type="password" name="password" id="password_hype" placeholder="Enter your password...">

                    <button onclick="hypeHiveSubmit()" id="hype_btn">Sign in</button>
                </div>
            </div>
        </div>

          <!-- postify login modal -->
          <div id="postify_modal" class="modal">
            <div class="modal-content slide-bottom">
                <div class="posti-container">
                    <div class="posti-close-modal">
                        <img src="../assets/images/x.svg" onclick="closePostifyModal()" id="posti_close">
                    </div>
                    <img src="../assets/images/img_postify.png" id="logo_posti">
                    <h2>Postify</h2>
                    <input type="text" name="email" id="email_postify" placeholder="Enter your email...">
                    <input type="password" name="password" id="password_postify" placeholder="Enter your password...">

                    <button onclick="postifySubmit()" id="posti_btn">Sign in</button>
                </div>
            </div>
        </div>

        <div class=img-logo>
            <img src="../assets/images/withname_logo.png" alt="logo">
        </div>

        <div class="container">
            <h2>Login Page</h2>

            <input type="email" name="email" id="email_field" placeholder="Enter your email" required>

            <div class="password-container">
                <input type="password" id="password_field" name="password" placeholder="Enter your password" required>
                <img src="../assets/images/EyeSlash.svg" id="hide_pass" onclick="showPass()">
                <img src="../assets/images/Eye.svg" id="show_pass" onclick="hidePass()">
            </div>

            <div class="login-button">
                <button id="login" onclick="loginAccount()">Log In</button>
            </div>
            <a href="..\forgot-pass\enter-email.php">Forgot Password?</a>
            <hr>
            <div id="loginAsBlock">

                <div class="login-as">
                    <button onclick="logPostify()" type="button"><img src="../assets/images/img_postify.png"
                            id="img_postify">Log In as Postify</button>
                    <button onclick="logHypeHive()" type="button"><img src="../assets/images/img_hypehive.png"
                            id="img_hypehive">Log In as Hype Hive</button>
                </div>
                <hr>
                <label>New to Likha? </label>

                <a href="../registration/registration.php">Click Here</a>
            </div>
        </div>

    </div>
    <script src="login.js"></script>
    <script src="test.js"></script>

</body>

</html>