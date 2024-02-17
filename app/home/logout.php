<?php
include('../include/db.php');

session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to another page or perform other actions as needed
header("Location: ../login/login.php");
exit();

?>