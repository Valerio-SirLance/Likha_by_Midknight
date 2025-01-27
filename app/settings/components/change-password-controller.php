<?php
include('../../include/db.php');

session_start();

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
    $ciphered_password = '';

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

$currEmail = $_SESSION['email'];
$currpass = $_POST['currPass'];
$newPass = $_POST['newPass'];

if ($currEmail && $newPass && $currpass) {
    $stmt = $conn->prepare("SELECT * FROM tbluser WHERE email = ?");
    $stmt->bind_param("s", $currEmail);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_avatar = $user['user_avatar'];

            // Verify current password using cipherPassword
            $cipheredCurrentPassword = cipherPassword($currpass, $user_avatar);
            if ($cipheredCurrentPassword === $user['password']) {
                // Cipher the new password
                $cipheredNewPassword = cipherPassword($newPass, $user_avatar);

                // Update the password in the database
                $updateStmt = $conn->prepare("UPDATE tbluser SET password = ? WHERE email = ?");
                $updateStmt->bind_param("ss", $cipheredNewPassword, $currEmail);

                if ($updateStmt->execute()) {
                    echo "Password update successful!";
                } else {
                    echo "Password update failed: " . $updateStmt->error;
                }

                $updateStmt->close();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User with the current email not found.";
        }

        $result->close();
    } else {
        echo "Database query failed: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Insufficient data provided for password update.";
}

?>
