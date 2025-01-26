<?php
session_start();
include('../../include/db.php');

// Ciphering function (from your provided code)
function cipherPassword($password, $user_avatar) {
    $keys = [$user_avatar, "user", "avatar"];
    $ciphered_password = '';
    
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $email = $_SESSION['email']; // Get the user's email from the session

    if ($email && $password) {
        // Check if the provided password matches the user's password
        $stmt = $conn->prepare("SELECT * FROM tbluser WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $user_avatar = $user['user_avatar'];

                // Cipher the provided password
                $cipheredPassword = cipherPassword($password, $user_avatar);

                if ($cipheredPassword === $user['password']) {
                    // Password is correct, update the deleted_at column
                    $updateStmt = $conn->prepare("UPDATE tbluser SET deleted_at = NOW() WHERE user_id = ?");
                    $updateStmt->bind_param("i", $user['user_id']);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // You may also want to perform additional cleanup or handle dependent records here

                    echo "Account deleted successfully.";

                } else {
                    // Incorrect password
                    echo "Incorrect password.";
                }
            } else {
                // User not found
                echo "User not found.";
            }
        } else {
            // Error executing the query
            echo "Error executing query.";
        }

        $stmt->close();
    } else {
        // Insufficient data provided for account deletion
        echo "Insufficient data provided for account deletion.";
    }
}
?>
