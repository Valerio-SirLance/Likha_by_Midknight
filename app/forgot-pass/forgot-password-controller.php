<?php

session_start();

include('../include/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../include/email.php';

function sendNotification($email)
{
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
    
    // Properly concatenate the email body
    $mail->Body = "
        Your password is successfully changed. 
        You can now log in using your new password.
    ";

    try {
        // Try sending the email
        $mail->send();
        echo "Please review your email once more to confirm the successful password reset.";
    } catch (Exception $e) {
        // Email sending failed
        echo "Error, please try again: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);    
    
    $sql_check_email = "SELECT password FROM tbluser WHERE email = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();        
        
        $newPass = password_hash($_POST["newPass"], PASSWORD_DEFAULT);
        
        $sql_update_password = "UPDATE tbluser SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql_update_password);
        $stmt->bind_param("ss", $newPass, $email);
        $stmt->execute();

        sendNotification($email);
      
    } else {        
        echo "Email does not exist.";
    }

}   

$conn->close();
?>