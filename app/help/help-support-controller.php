<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../include/email.php';
require_once '../include/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $problemDescription = $_POST['problem'];

    // Check if the email is in the session
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    if ($userEmail) {
        // Upload file
        $uploadedFile = uploadFile();

        // Send email to developers with attachment
        sendSupportEmail($userEmail, $problemDescription, $uploadedFile);

        // Provide a success message or redirect the user
        echo json_encode(["success" => true, "message" => "Email sent successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "User email not found in the session."]);
    }
}

function getUserEmailFromDatabase($conn, $email)
{
    $sql_user = "SELECT * FROM tbluser WHERE email = '$email'";
    $result = $conn->query($sql_user);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['email'];
    }

    return null;
}

function uploadFile()
{
    $targetDirectory = "uploads/"; // Specify the directory where you want to save the uploaded files
    $uploadedFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;

    // Check if the file already exists
    if (file_exists($uploadedFile)) {
        echo json_encode(["success" => false, "message" => "Sorry, file already exists."]);
        $uploadOk = 0;
        exit();
    }

    // Check file size
    if ($_FILES["file"]["size"] > 25000000) {
        echo json_encode(["success" => false, "message" => "Sorry, your file is too large."]);
        $uploadOk = 0;
        exit();
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo json_encode(["success" => false, "message" => "Sorry, your file was not uploaded."]);
        exit();
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadedFile)) {
            return $uploadedFile;
        } else {
            echo json_encode(["success" => false, "message" => "Sorry, there was an error uploading your file."]);
        }
    }
    return null; // Return null if the file upload fails
}

function sendSupportEmail($userEmail, $problemDescription, $attachment)
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

    $mail->setFrom($userEmail);
    $mail->addAddress('pupt.midknight@gmail.com');  // Change email to the one you're testing
    $mail->isHTML(true);
    $mail->Subject = 'User Report - Help and Support';

    $mail->Body = "
        <p><strong>User Email:</strong> $userEmail</p>
        <p><strong>Problem Description:</strong></p>
        <p>$problemDescription</p>
    ";

    // Attach the file if it's provided
    if (!empty($attachment)) {
        $mail->addAttachment($attachment);
    }

    try {
        $mail->send();
    } catch (Exception $e) {
        // echo "Error, please try again: {$mail->ErrorInfo}";
        echo json_encode(["success" => false, "message" => "Error, please try again"]);
    }
}
$conn->close();
?>
