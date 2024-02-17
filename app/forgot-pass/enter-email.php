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
  <div class="img-logo">
    <img src="..\assets\images\withname_logo.png" alt="logo" />
  </div>

  <div class="container">
    <h2>Forgot Password</h2>
    <form method="post" id="forgotpass_form">
      <input type="email" id="email" name="email" placeholder="Email Address" required />
      <button type="submit">Confirm</button>
    </form>
    <a href="../login/login.php">Cancel</a>
  </div>
</body>
<script src="enter-email.js"></script>

</html>