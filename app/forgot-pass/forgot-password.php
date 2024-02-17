<?php

if (!isset($_GET['email'])) {
  // Redirect to login.php
  header("Location: enter-email.php");
  exit();
}
$email = $_GET['email'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="forgot_password.css" />
    <title>Forgot Password</title>
  </head>
  <body>
    <div class="img-logo">
      <img src="..\assets\images\withname_logo.png" alt="logo" />
    </div>

    <div class="container">
      <h2>Forgot Password</h2>
      <form method="post" id="forgotpass_form">
        <input
          type="email"
          id="email"
          name="email"
          value="<?php echo $email; ?>"
          hidden          
        />      
        <input
          type="password"
          id="new_pass"
          name="new_pass"
          placeholder="New Password"
          required
        />
        <button type="submit">Reset Password</button>
      </form>
    </div>
  </body>
  <script src="forgot-password.js"></script>
</html>
