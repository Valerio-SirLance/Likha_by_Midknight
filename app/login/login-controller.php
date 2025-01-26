<?php
include('../include/db.php');
session_start();
header('Content-Type: application/json');

// Cipher function
function cipherPassword($password, $user_avatar) {
    $keys = [$user_avatar, "user", "avatar"];
    $ciphered_password = "";
    
    foreach ($keys as $key) {
        $key = strrev($key); // Reverse the key
        $key_length = strlen($key);
        
        for ($i = 0; $i < strlen($password); $i++) {
            $key_char = $key[$i % $key_length]; // Cycle through the key
            $char_code = ord($password[$i]) + ord($key_char); // Combine ASCII values
            $ciphered_password .= chr($char_code % 256); // Wrap around if it exceeds 255
        }
    }
    return bin2hex($ciphered_password); // Convert to hexadecimal
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    $sql_user = "SELECT * FROM tbluser WHERE email = '$email' 
        AND verify_at IS NOT NULL AND deleted_at IS NULL ";
    $query = $conn->query($sql_user);

    if ($query->num_rows > 0) {
        $result = $query->fetch_array();
        $user_avatar = $result['user_avatar']; // Fetch user_avatar from DB

        // Cipher the password using the same function
        $ciphered_password = cipherPassword($password, $user_avatar);

        if ($ciphered_password === $result['password']) { // Compare ciphered passwords
            $_SESSION['status'] = "Login Successful";
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['token'] = $result['verify_token'];
            $_SESSION['user_avatar'] = $result['user_avatar'];
            $_SESSION['notif_badge'] = $result['notif_badge'];
            
            $sql_username = "SELECT username FROM tblregistration 
            INNER JOIN tbluser ON tblregistration.user_id = tbluser.user_id
            WHERE tbluser.user_id = " . $_SESSION['user_id'];

            $query_username = $conn->query($sql_username);

            if ($query_username->num_rows > 0) {
                $result_username = $query_username->fetch_assoc();
                $_SESSION['username'] = $result_username['username'];
            } else {
                $_SESSION['username'] = 'Unknown';
            }

            echo 'Login Successful';

            // Set cookies
            setcookie("email", $_SESSION['email'], time() + 3600, '/', 'localhost');
            setcookie("username", $_SESSION['username'], time() + 3600, '/', 'localhost');
        } else {
            $_SESSION['status'] = "Incorrect Password";
            echo 'Incorrect Password';
        }
    } else {
        $_SESSION['status'] = "Incorrect Email";
        echo 'Incorrect Email';
    }
}
$conn->close();
?>
