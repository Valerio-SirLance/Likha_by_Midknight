<div class="sub-settings">
    <div class="sub-settings-title">
        <h1 class="settings-text">
            Your Account
        </h1>
    </div>

    <div class="sub-settings-container">
        <h2 class="settings-name">
            Change Password
        </h2>
        <div class="account-form">
            <form class="change-password-form">
                <label for="currentPassword">Current Password:</label>
                <div class="password-container">
                    <input type="password" id="currentPassword" class="password_field" name="currentPassword" placeholder="Enter your Current Password" required>
                    <img src="../assets/images/EyeSlash.svg" id="hide_pass" onclick="showPass1()">
                    <img src="../assets/images/Eye.svg" id="show_pass" onclick="hidePass1()">
                </div>

                <label for="newPassword">New Password:</label>
                <div class="password-container">
                    <input type="password" id="newPassword" class="password_field1" name="newPassword" placeholder="Enter your New Password" required>
                    <img src="../assets/images/EyeSlash.svg" id="hide_pass1" onclick="showPass2()">
                    <img src="../assets/images/Eye.svg" id="show_pass1" onclick="hidePass2()">
                </div>

                <label for="confirmNewPassword">Confirm New Password:</label>
                <div class="password-container">
                    <input type="password" id="confirmNewPassword" class="password_field2" name="confirmNewPassword" placeholder="Enter your New Password" required>
                    <img src="../assets/images/EyeSlash.svg" id="hide_pass2" onclick="showPass3()">
                    <img src="../assets/images/Eye.svg" id="show_pass2" onclick="hidePass3()">
                </div>

                <div class="submit-button" onclick="submitChangePassword()">

                    Change Password
                </div>
            </form>
        </div>
    </div>
</div>