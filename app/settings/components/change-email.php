
<div class="sub-settings">
    <div class="sub-settings-title">
        <h1 class="settings-text">
            Your Account
        </h1>
    </div>

    <div class="sub-settings-container">
        <h2 class="settings-name">
            Change Email
        </h2>
        <div class="account-form">
            <form class="change-email-form" id="changeEmailForm">
                <label for="currentEmail">Current Email:</label>
                <input type="email" id="currentEmail" name="currentEmail" placeholder="Enter your Current Email" required>

                <label for="newEmail">New Email:</label>
                <input type="email" id="newEmail" name="newEmail" placeholder="Enter your New Email" required>

                <label for="password">Password:</label>
                <div class="password-container">
                    <input type="password" id="password" class="password_field" name="password_field" placeholder="Enter your Password" required>
                    <img src="../assets/images/EyeSlash.svg" id="hide_pass" onclick="showPass1()">
                    <img src="../assets/images/Eye.svg" id="show_pass" onclick="hidePass1()">
                </div>

                <div class="submit-button" onclick="submitChangeEmail()">

                    Change Email
                </div>
            </form>
        </div>
    </div>
</div>