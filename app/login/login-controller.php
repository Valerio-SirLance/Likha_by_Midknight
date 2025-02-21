<?php
include('../include/db.php');
session_start();
header('Content-Type: application/json');

// Function to generate alternate letters from a string
function alternateLetters($string) {
    $result = '';
    for ($i = 0; $i < strlen($string); $i += 2) {
        $result .= $string[$i];
    }
    return $result;
}

// Cipher function
function cipherPassword($password, $user_avatar) {
    $keys = [
        $user_avatar,  // Original
        strrev($user_avatar),  // Reversed
        alternateLetters($user_avatar)  // Alternate letters
    ];
    $ciphered_password = "";

    foreach ($keys as $key) {
        $key_length = strlen($key);

        for ($i = 0; $i < strlen($password); $i++) {
            $key_char = $key[$i % $key_length]; // Cycle through the key
            $char_code = ord($password[$i]) + ord($key_char); // Combine ASCII values
            $ciphered_password .= chr($char_code % 256); // Wrap around if it exceeds 255
        }
    }
    return bin2hex($ciphered_password); // Convert to hexadecimal
}

// Decipher function
function decipherPassword($ciphered_password, $user_avatar) {
    $ciphered_password = hex2bin($ciphered_password); // Convert from hexadecimal to binary
    $keys = [
        $user_avatar,  // Original
        strrev($user_avatar),  // Reversed
        alternateLetters($user_avatar)  // Alternate letters
    ];

    $key_count = count($keys);
    $ciphered_length = strlen($ciphered_password);
    $segment_length = $ciphered_length / $key_count;

    $deciphered_password = "";

    for ($key_index = 0; $key_index < $key_count; $key_index++) {
        $key = $keys[$key_index];
        $key_length = strlen($key);

        // Extract the segment corresponding to this key
        $segment = substr($ciphered_password, $key_index * $segment_length, $segment_length);

        for ($i = 0; $i < strlen($segment); $i++) {
            $key_char = $key[$i % $key_length]; // Cycle through the key
            $char_code = ord($segment[$i]) - ord($key_char); // Reverse ASCII addition
            $deciphered_password .= chr(($char_code + 256) % 256); // Handle negative values
        }
    }

    // Remove the duplicates from the deciphered password
    $deciphered_password = substr($deciphered_password, 0, $segment_length);  // Keep only the first segment

    return $deciphered_password;
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
        $stored_password = $result['password']; 

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
            $deciphered_password = decipherPassword($stored_password, $user_avatar);

            echo 'Incorrect Password' . "\n";
            // Echo the encrypted and decrypted passwords (for testing only)
            echo 'Ciphered Password (Input): ' . $ciphered_password . "\n";
            echo 'Deciphered Password (From DB): ' . $deciphered_password;
        }
    } else {
        $_SESSION['status'] = "Incorrect Email";
        echo 'Incorrect Email';
    }
}
$conn->close();
?>
