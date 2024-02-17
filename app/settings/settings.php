<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle the case when the username is not set
    header("Location: ../login/login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likha</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/blue_logo.png">
    <link rel="stylesheet" href="settings.css">
    <script src="settings.js"></script>
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

    <div class="container">

        <?php include('../view/components/search.php'); ?>
        <?php include('../view/components/sidebar.php'); ?>
        <?php include('../notification/notification.php'); ?>
        <!-- <div class="settings-content"> -->
        <div class="settings-container">
            <div class="settings-nav">
                <div class="settings-title">
                    <h1 class="settings-text">
                        Settings
                    </h1>
                </div>

                <div class="account-settings">
                    <h2 class="settings-name">
                        Account
                    </h2>
                    <div class="accounts-sub">
                        <div class="sub-item" onclick="handleItemClick(0)">
                            Change Email
                        </div>
                        <div class="sub-item" onclick="handleItemClick(1)">
                            Change Password
                        </div>
                        <div class="sub-item" onclick="handleItemClick(2)">
                            Delete Account
                        </div>
                    </div>
                </div>

                <div class="notifications-settings">
                    <input type="text" id="notif-badge" 
                    value="<?php echo $_SESSION['notif_badge']; ?>" hidden >
                    <h2 class="settings-name">
                        Notifications
                    </h2>
                    <div class="notifications-sub">
                        <div class="sub-item" onclick="handleItemClick(3)">
                            Notification Badge
                        </div>
                    </div>
                </div>

                <!--
                <div class="blocked-settings">
                    <h2 class="settings-name">
                        Blocked
                    </h2>
                    <div class="blocked-sub">
                        <div class="sub-item" onclick="handleItemClick(4)">
                            Blocked Accounts
                        </div>
                    </div>
                </div>
                -->
            </div>
            <div class="sub-settings-content" id="sub_settings_content">
            </div>
        </div>


        <!-- </div> -->
    </div>
</body>

</html>