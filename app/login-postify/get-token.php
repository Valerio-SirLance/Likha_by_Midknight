<?php
include('../include/db.php');

header("Access-Control-Allow-Origin: https://hypehive.cloud, https://postify.tech, http://localhost");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

// Your existing code for fetching user data
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

$response = array();

if (!$conn) {
    $response['error'] = "Connection failed: " . mysqli_connect_error();
} else {
    $sql = "SELECT tbluser.email, tblregistration.* FROM tbluser
            LEFT JOIN tblregistration ON tbluser.user_id = tblregistration.user_id
            WHERE tbluser.user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the user_id parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the user and registration data
    $userAndRegistration = mysqli_fetch_assoc($result);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($conn);

    // Generate an authorization token (you can use any method you prefer)
    $authorizationToken = bin2hex(random_bytes(16));

    // Store the token and userAndRegistration in the session
    $_SESSION['authorization_token'] = $authorizationToken;
    $_SESSION['userAndRegistration'] = $userAndRegistration;

    $response['token'] = $authorizationToken;
    $response['userAndRegistration'] = $userAndRegistration;
}

$cookie_name = "authorization_token";
$cookie_value = $authorizationToken;
if(!isset($_COOKIE[$cookie_name])){
  setcookie('authorization_token', $authorizationToken, time() + 3600, '/', '', true, true);
}
// Output JSON response
header('Content-Type: application/json');
echo json_encode($response + ['https://hypehive.cloud/?authorization-token=' => $authorizationToken]);
// echo json_encode($response);
exit;


// session_start();

// if (isset($_SESSION['user_id'])) {    
//     displayAuthorizationPage();
//     exit;
// } else {
//     header('Location: ../view/login.php');
//     exit;
// }
// function displayAuthorizationPage() {
    
//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['allow_access'])) {
        
//         $token = $_SESSION['token'];
//         $redirectUrl = $_POST['redirect_url'];
//         header("Location: $redirectUrl?token=$token");
//         exit();
//     } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deny_access'])) {
//         echo "Access denied. Please try again.";
//     }

        
//     echo "<h1>Authorization Page</h1>";
//     echo "<p>{$_GET['application_name']} wants to 
//         access your data and post on your behalf.</p>";    
//     echo "<p>List of data that can be accessed:</p>";
    
//     echo "<input type='checkbox' name='data[]' 
//         value='data1' checked readonly> Your Post<br>";
//     echo "<input type='checkbox' name='data[]' 
//         value='data2' checked readonly> User Personal Details<br>";
    
//     echo "<input type='hidden' 
//         name='redirect_url' value='{$_GET['redirect_url']}'>";
//     echo "<input type='hidden' 
//         name='token' value='{$_SESSION['token']}'>";
//     echo "<input type='submit' name='allow_access' value='Allow Access'>";
//     echo "<input type='submit' name='deny_access' value='Deny Access'>";
    
// }


?>