<?php
session_start();
include('../include/db.php');
if (isset($_GET['token'])) {
    $verify_token = $_GET['token'];
    $verify_query = "SELECT verify_token FROM tbluser WHERE verify_token = 
    '$verify_token' LIMIT 1";
    $verify_run = mysqli_query($conn, $verify_query);

    if (mysqli_num_rows($verify_run) > 0) {
        $row = mysqli_fetch_array($verify_run);
        if ($row['verify_at'] == null) {
            $verified_token = $row['verify_token'];
            $update_query = "UPDATE tbluser SET verify_at = NOW() WHERE 
            verify_token='$verified_token' LIMIT 1";
            $update_run = mysqli_query($conn, $update_query);
            if ($update_run) {
                $_SESSION['status'] = "Your Account has beed verified successfully!";
                header("Location:../login/login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Verification Failed";
                header("Location:../login/login.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Email Already Verified, Please Log In";
            header("Location:../login/login.php");
            exit(0);
        }

    } else {
        $_SESSION['status'] = "The token does not exists";
        header("Location:../login/login.php");
    }
} else {
    $_SESSION['status'] = "Now Allowed";
    header("Location:../login/login.php");
}
?>