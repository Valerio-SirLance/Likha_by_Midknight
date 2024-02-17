<?php
if (isset($_GET['application_name'])) {
    $applicationName = $_GET['application_name'];
     $_SESSION['application_name'] = $applicationName;
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/blue_logo.png">
    <link rel="stylesheet" href="../login-hypehive/authorization-hypehive.css">
    <script src="authorization.js"></script>
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
            <?php
                if($applicationName ="Postify"){
                    echo'<img class="logo-hype"src="../assets/images/img_postify.png" id="logo_hype">';
                }else{
                      echo'<img class="logo-hype"src="../assets/images/img_hypehive.png" id="logo_hype">';
                }
            ?>
            
        </div>
        
        <p><?php echo $applicationName?> is requesting access to your Likha
            credentials</p>
        <h3><?php echo $applicationName?> utilizes Likha credentials to personalize your 
            experience by:</h3>
        <ul>
            <li>fetching your profile information.</li>
            <li>allowing you to post content seamlessly.</li>
        </ul>
        <h3>Important Notes:</h3>
        <ul>
            <li><?php echo $applicationName?> will only access the information necessary 
                for its functionalities, as outlined
                above.</li>
            <li>Your Likha password will not be shared with <?php echo $applicationName?>. 
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