<?php
// session-handler.php

$mainLoggedInUsername = $_SESSION['username'];
$mainLoggedInEmail = $_SESSION['email'];
$mainLoggedInUserID = $_SESSION['user_id'];
// Check if the username is set in the session
if (!isset($mainLoggedInUsername)) {
    // Redirect to the login page or handle the case when the username is not set
    header("Location: ../login/login.php");
    exit();
}


?>
