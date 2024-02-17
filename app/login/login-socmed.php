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

        </div>

    </div>
    <script src="login.js"></script>
    <script src="test.js"></script>

</body>

</html>