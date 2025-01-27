<?php
session_start();
include('../include/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../include/email.php';
$avatarImg = array("bear.jpg", "bird.jpg","capricorn.jpg","cat.jpg","dog.jpg","eagle.jpg","egg.jpg","goat.jpg","lion.jpg","whitecat.jpg");
$randomImg = $avatarImg[array_rand($avatarImg)];

// Function to generate alternate letters from a string
function alternateLetters($string) {
    $result = '';
    for ($i = 0; $i < strlen($string); $i += 2) {
        $result .= $string[$i];
    }
    return $result;
}

// Ciphering function
function cipherPassword($password, $user_avatar) {
    $keys = [
        $user_avatar,  // Orignial
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

// Function for emailVerification
function sendEmailVerification($email, $verify_token) {
    $mail = new PHPMailer(true);

    $emailSettings = getEmailSettings();

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
    $mail->Subject = 'Verify Your Email Address for Likha Application';
    $mail->Body = 'Thank you for signing up with Likha!<br>
    To ensure the security of your account, please verify your email using the link below:
    <br><br>
    <a href="http://localhost/project-midknight/app/registration/verified.php?token=' .
        $verify_token . '">Verify Here</a>';

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to check if email exists
function isEmailExists($conn, $email) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $query = "SELECT * FROM tbluser WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $exists = ($result && mysqli_num_rows($result) > 0);
    mysqli_free_result($result);
    return $exists;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $verification_token = bin2hex(random_bytes(32));
    $password = cipherPassword($_POST["password"], $randomImg); // Apply ciphering
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $middlename = mysqli_real_escape_string($conn, $_POST["middlename"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $birthday = $_POST["birthday"];
    $timestamp = strtotime($birthday);
    $formattedBirthday = date('Y-m-d H:i:s', $timestamp);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    if (isEmailExists($conn, $email)) {
        $response = array("success" => false, "message" => "Email already exists");
    } else {
        if (sendEmailVerification($email, $verification_token)) {
            $sql_user = "INSERT INTO tbluser
                (email, password, verify_token, created_at, user_avatar) VALUES
                ('$email', '$password', '$verification_token', NOW(), '$randomImg')";
            if ($conn->query($sql_user) === TRUE) {
                $user_id = mysqli_insert_id($conn);
                $sql_registration = "INSERT INTO tblregistration
                    (user_id, username, first_name, middle_name,
                    last_name, birthday) VALUES ('$user_id', '$username',
                    '$firstname', '$middlename', '$lastname',
                    '$formattedBirthday')";
                if ($conn->query($sql_registration) === TRUE) {
                    $response = array("success" => true, "message" =>
                        "Registration Successful, Please Check your Email");
                } else {
                    $response = array("success" => false, "message" =>
                        "Registration Failed");
                }
            } else {
                $response = array("success" => false, "message" =>
                    "User Registration Failed");
            }
        } else {
            $response = array("success" => false, "message" =>
                "Failed to send verification email");
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
$conn->close();
?>