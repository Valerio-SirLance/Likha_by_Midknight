<?php
session_start();
include('../include/db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../include/email.php';
$avatarImg = array("bear.jpg", "bird.jpg","capricorn.jpg","cat.jpg","dog.jpg","eagle.jpg","egg.jpg","goat.jpg","lion.jpg","whitecat.jpg");
$randomImg = $avatarImg[array_rand($avatarImg)];

//function for emailVerification
function sendEmailVerification($email, $verify_token)
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
    //Recipients
    $mail->setFrom('pupt.midknight@gmail.com');
    $mail->addAddress($email);     //Add a recipient

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email Address for Likha Application';
    $mail->Body = 'Thank you for signing up with Likha!<br>
    We are excited to have you on board. To ensure the security of your account
    and to provide you with the best possible experience, we need to verify
    your email address. Please follow the link below to verify your email:
        <br><br>
        <a href="http://localhost/project-midknight/app/registration/verified.php?token=' .
            $verify_token . '">Verify Here</a>';
    try {
        // Try sending the email
        $mail->send();

        // Email sent successfully
        return true;
    } catch (Exception $e) {
        // Email sending failed
        return false;
    }

}
//function for checking exisiting email
function isEmailExists($conn, $email)
{
    // Prepare the query
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    // Prepare the query
    $query = "SELECT * FROM tbluser WHERE email = '$email'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the email exists
    $exists = ($result && mysqli_num_rows($result) > 0);

    mysqli_free_result($result);

    // Return true if the email exists, false otherwise
    return $exists;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $verification_token = bin2hex(random_bytes(32));
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $middlename = mysqli_real_escape_string($conn, $_POST["middlename"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $birthday = $_POST["birthday"];
    $timestamp = strtotime($birthday);
    $formattedBirthday = date('Y-m-d H:i:s', $timestamp);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    //check if email is exist or not
    if (isEmailExists($conn, $email)) {
        $response = array("success" => false, "message" =>
            "Email already exists");
    } else {
        //check if sending an email is success
        if (sendEmailVerification($email, $verification_token)) {
            
            $sql_user = "INSERT INTO tbluser
                (email, password,verify_token,created_at,user_avatar) VALUES
                ('$email', '$password','$verification_token', NOW(),'$randomImg')";
            if ($conn->query($sql_user) === TRUE) {
                // If the user insertion was successful, get the user_id
                $user_id = mysqli_insert_id($conn);
                // Insert registration data into the tblregistration table
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
// Close the database connection
$conn->close();
?>