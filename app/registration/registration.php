<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <script src="../assets/10fa757270.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../assets/images/blue_logo.png">
    <link rel="stylesheet" href="registration.css">
    <script src="registration.js"></script>
</head>

<body>
    <!-- modal for registration notification -->
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

    <!-- modal for terms and condition -->
    <div id="terms_condition" class="terms-modal">
        <div class="terms-content">
            <!-- <p id="terms-message"></p> -->
            <iframe src="../view/terms_and_conditions.html" width="100%" height="300px" frameborder="0"></iframe>
            <div class="close-terms-modal">
                <button class="close-terms" onclick="closeTermsModal()">OK</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="img-sign">
            <h2>WELCOME TO LIKHA</h2>
            <p>
                Join us in the realm of artistic expression -
                it's as easy as paint on canvas.
                Let's turn your passion into a digital masterpiece!
            </p>
            <!-- <img class="logo" src="../assets/images/white_logo.png"> -->

            <img class="register-img" src="../assets/images/register.png" alt="">

        </div>
        <div class="container-form">
            <h2>Sign Up</h2>
            <form action="registration-controller.php" method="post" id="registrationForm">
                <div class="input-form text-dark">
                    <label>Username:</label>
                    <input type="text" name="username" placeholder="Enter your username" required>

                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <label>Password:</label>
                    <div class="password-container">
                        <input type="password" id="password_field" name="password" placeholder="Enter your password"
                            required>
                        <img src="../assets/images/EyeSlash.svg" id="hide_pass" onclick="showPass()">
                        <img src="../assets/images/Eye.svg" id="show_pass" onclick="hidePass()">
                    </div>

                    <label>Confirm Password:</label>
                    <div class="confirm-password-container">
                        <input type="password" id="confirm_password_field" name="confirm_password"
                            placeholder="Confirm your password" required>
                        <img src="../assets/images/EyeSlash.svg" id="hide_confirm_pass" onclick="showConfirmPass()">
                        <img src="../assets/images/Eye.svg" id="show_confirm_pass" onclick="hideConfirmPass()">
                    </div>



                    <label>First Name:</label>
                    <input type="text" name="firstname" placeholder="Enter your first name" required>

                    <label>Middle Name:</label>
                    <input type="text" name="middlename" placeholder="Enter your middle name">

                    <label>Last Name:</label>
                    <input type="text" name="lastname" placeholder="Enter your last name" required>

                    <label>Birthday:</label>
                    <input type="date" name="birthday" required>

                    <div class="terms_condition">
                        <input type="checkbox" name="check" required>
                        <label class="text-dark">I've read and agree to </label>
                        <a href="#" id="terms" onclick="openTermsModal()">
                            Terms and Condition</a>
                    </div>

                    <input type="submit" value="Register" id="btn_submit">
                    <div class="login">
                        <label class="text-dark">Already have an account?
                        </label>
                        <a href="../login/login.php" id="signin">Sign In</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>