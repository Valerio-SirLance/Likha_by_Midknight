<?php

session_start();

include('../include/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
header('Content-Type: application/json');
require '../vendor/autoload.php';
require_once '../include/email.php';

function sendForgotPasswordLink($email)
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
    $mail->Subject = 'Link for changing the password!';
    
    
    $mail->Body = '
        If you initiated the request, kindly click the 
        link to be redirected to the forgot password form. 
        Otherwise, please ignore this message and ensure 
        the security of your account.

        <br><br>
        <a href="http://localhost/likha-socmed/app/forgot-pass/forgot-password.php?email=' .
        $email . '">
            Verify Here</a>
    ';

    try {
        
        $mail->send();
        // echo "Kindly check your email to 
        // confirm your forgot password request.";
        echo json_encode(["success" => true, "message" => "Email sent successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error, please try again"]);
        // echo "Error, please try again: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);    
    
    $sql_check_email = "SELECT COUNT(*) AS email_count FROM tbluser
    WHERE email = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
   
    $stmt->bind_result($email_count);
   
    $stmt->fetch();
    
    if ($email_count > 0) {
        sendForgotPasswordLink($email);
    } else {
        // echo "Email does not exist.";
        echo json_encode(["success" => false, "message" => "Email does not exist"]);

    }

}   

$conn->close();
?>