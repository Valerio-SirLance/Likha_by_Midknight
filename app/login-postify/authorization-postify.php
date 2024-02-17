<?php
session_start();

// Check if 'userId' and 'email' parameters are set in the URL
if (isset($_GET['username']) && isset($_GET['email'])) {
    // Retrieve the values from the URL
    $username = $_GET['username'];
    $email = $_GET['email'];
    // $appname = $_GET['applicationName'];


    // Store them in the session
    $_SESSION['userName'] = $username;
    $_SESSION['email'] = $email;
    // $_SESSION['applicationName'] = $appname;


    // // Redirect to the desired page
    // header("Location: authorization-hypehive.php");
    // exit();
} else {
    echo "Invalid parameters in the URL";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
    <link rel="icon" type="image/x-icon" href="..\assets\images\blue_logo.png">
    <link rel="stylesheet" href="authorization-postify.css">
    <script src="authorization-postify.js"></script>
</head>

<body>
    <div class="container">
        <h1>Authorize this Application</h1>

        <div class="logo">
            <img 
                class="logo-likha"
                src="../assets/images/blue_logo.png" 
                id="logo_likha">

            <img 
                class="connect-icon"
                src="../assets/images/connect_icon.png" 
                id="connect">

            <img 
                class="logo-postify"
                src="../assets/images/img_postify.png" 
                id="logo_postify">
        </div>

        <p>Hi <?php echo $username; ?>, Likha is requesting access to your 
            Postify credentials</p>
        <h3> Likha utilizes Postify credentials to personalize your 
            experience by:</h3>
        <ul>
            <li>fetching your profile information.</li>
            <li>allowing you to post content seamlessly.</li>
        </ul>
        <h3>Important Notes:</h3>
        <ul>
            <li>Likha will only access the information necessary 
                for its functionalities, as outlined
                above.</li>
            <li>Your Postify password will not be shared with Likha. 
                Access is granted through secure authentication tokens.</li>
            <li>If you encounter any issues or have questions, please contact 
                our support team.</li>
        </ul>

        <button 
            class="allow-button"
            type="button" 
            onclick="allowUser()">
            Allow
        </button>
        
        <button 
            class="deny-button"
            type="button" 
            onclick="denyUser()">
            Deny
        </button>   
        

    </div>
</body>

</html>