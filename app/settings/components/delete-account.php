<div class="sub-settings">
    <div class="sub-settings-title">
        <h1 class="settings-text">Your Account</h1>
    </div>

    <div class="sub-settings-container">
        <h2 class="settings-name">Delete Account</h2>
        <div class="account-form">
            <form class="delete-account-form">
                <p>Do you want to delete your account? Likha will miss you!</p>
                <label for="deletePassword">Password:</label>
                <div class="password-container">
                    <input type="password" id="deletePassword" class="password_field" name="password_field" placeholder="Enter your Password" required>
                    <img src="../assets/images/EyeSlash.svg" id="hide_pass" onclick="showPass1()">
                    <img src="../assets/images/Eye.svg" id="show_pass" onclick="hidePass1()">
                </div>
                <div class="submit-button" onclick="openShareModal()">
                Delete Account
                </div>
            </form>
        </div>
    </div>

    <div id="shareModal" class="modal">
                        <div class="modal-content">
                            <span class="close1" onclick="closeShareModal()">&times;</span>
                            <h2>Are you really sure you want to delete your Likha account?</h2>
                                <div id="buttons"><button id="red" onclick="submitDeleteAccount()">Delete Account</button>
                                <button id="blue" onclick="closeShareModal()">Cancel</button>
                            </div>                            
                        </div>
                    </div>
    </div>