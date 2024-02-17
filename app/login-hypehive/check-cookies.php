<?php
$cookie_email = "email";
$cookie_username = "username";

if (isset($_COOKIE[$cookie_email]) && isset($_COOKIE[$cookie_username])) {
    $email = $_COOKIE[$cookie_email];
    $username = $_COOKIE[$cookie_username];
    echo json_encode(['email' => $email, 'username' => $username]);
} else {
    echo json_encode(['error' => 'Cookies not set']);
}

?>