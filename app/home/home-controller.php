<?php
include('../include/db.php');

session_start();

// $apiKey = 'J7hP2fR1dVgQ9sX4tY0aL6mB3nZ8cO5'; // Replace with your actual API key

// $user_id = $_SESSION['user_id'];
// Assuming you're expecting JSON data

// Assuming you have the API URL

if (isset($_GET['authorization_token'])) {
    // Retrieve the values from the URL
    $apiUrl = 'https://likha.website/api.php';
    $auth_token = $_GET['authorization_token'];
    $action = 'get-user';
    $app = 'HypeHive';
    $postData = array(
        'auth_token' => $auth_token,
        'action' => $action,
        'appname' => $app,
    );
    $ch = curl_init($apiUrl);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            // 'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/x-www-form-urlencoded',
        )
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
    } else {
        $decodedResponse = json_decode($response, true);

        if ($decodedResponse && isset($decodedResponse['data']['user_id'], $decodedResponse['data']['username'])) {
            // Print specific data
            $username = $decodedResponse['data']['username'];
            $email = $decodedResponse['data']['email'];
            $user_id = $decodedResponse['data']['user_id'];

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user_id;

        } else {
            echo json_encode(['error' => 'Invalid response format or missing data']);
        }
    }

    curl_close($ch);

}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

$email = $_SESSION['email'];
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// $sql = "SELECT *
//         FROM tblpost
//         JOIN tbluser ON tblpost.user_id = tbluser.user_id
//         JOIN tblregistration ON tblpost.user_id = tblregistration.user_id
//         ORDER BY tblpost.created_at DESC";

// $result = $conn->query($sql);

$sql = "SELECT tblpost.*, tbluser.*, tblregistration.*, tbl_acclike.like_at AS liked
        FROM tblpost
        JOIN tbluser ON tblpost.user_id = tbluser.user_id
        JOIN tblregistration ON tblpost.user_id = tblregistration.user_id
        LEFT JOIN tbl_acclike ON tblpost.post_id = tbl_acclike.post_id AND tbl_acclike.user_id = $user_id
        WHERE tblpost.deleted_at IS NULL AND tbluser.deleted_at IS NULL
        ORDER BY tblpost.created_at DESC";

$result = $conn->query($sql);

?>