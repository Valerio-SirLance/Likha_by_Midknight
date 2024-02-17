<?php
include('../../include/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
require_once '../../include/email.php';
header('Content-Type: application/json');

function sendChangeEmailConfirmation($newEmail)
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
    $mail->addAddress($newEmail);
    $mail->isHTML(true);
    $mail->Subject = 'Email Change Confirmation';

    $mail->Body = 'Your email has been successfully changed to ' . $newEmail;

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $currentEmail = $_POST['currentEmail'];
    $newEmail = $_POST['newEmail'];   
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tbluser WHERE email = ?");
    $stmt->bind_param("s", $currentEmail);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        
            if (password_verify($password, $user['password'])) {
                
                $updateStmt = $conn->prepare("UPDATE tbluser SET email = ? WHERE email = ?");
                $updateStmt->bind_param("ss", $newEmail, $currentEmail);

                if ($updateStmt->execute()) {
                    // echo json_encode(["message" => "Email update successful!"]);    
                     echo json_encode(["success" => true, "message" => "Email sent successfully!"]);
                    $_SESSION['email'] = $newEmail;
                    sendChangeEmailConfirmation($newEmail);
                } else {
                    // Email update failed
                    // echo "Email update failed: " . $updateStmt->error;
                    echo json_encode(["success" => false, "message" => "Email update failed"]);

                }

                $updateStmt->close();
            } else {
                // Password is incorrect
                // echo "Incorrect password.";
                echo json_encode(["success" => false, "message" => "Incorrect password"]);

            }
        } else {
            // User with the current email not found
            // echo "User with the current email not found.";
            echo json_encode(["success" => false, "message" => "User with the current email not found"]);
            
        }
    } 
}

?>
