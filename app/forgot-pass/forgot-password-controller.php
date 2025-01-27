<?php
session_start();

include('../include/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../include/email.php';

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

// Function to send notification
function sendNotification($email) {
    $mail = new PHPMailer(true);

    // Get email settings
    $emailSettings = getEmailSettings();

    // Server settings
    $mail->isSMTP();
    $mail->Host = $emailSettings['host'];
    $mail->SMTPAuth = $emailSettings['smtpAuth'];
    $mail->Username = $emailSettings['username'];
    $mail->Password = $emailSettings['password'];
    $mail->SMTPSecure = $emailSettings['smtpSecure'];
    $mail->Port = $emailSettings['port'];

    $mail->setFrom('pupt.midknight@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Password Changed Successfully!';
    $mail->Body = "
        Your password is successfully changed. 
        You can now log in using your new password.
    ";

    try {
        $mail->send();
        echo "Please review your email once more to confirm the successful password reset.";
    } catch (Exception $e) {
        echo "Error, please try again: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);    

    // Check if email exists
    $sql_check_email = "SELECT user_avatar FROM tbluser WHERE email = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();        
        $user_avatar = $row['user_avatar'];

        // Generate new ciphered password
        $newPass = cipherPassword($_POST["newPass"], $user_avatar);

        // Update the password in the database
        $sql_update_password = "UPDATE tbluser SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql_update_password);
        $stmt->bind_param("ss", $newPass, $email);
        $stmt->execute();

        // Send a notification email
        sendNotification($email);
      
    } else {        
        echo "Email does not exist.";
    }
}   

$conn->close();
?>
