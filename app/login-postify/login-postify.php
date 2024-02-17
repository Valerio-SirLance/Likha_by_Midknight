<?php

$apiUrl = 'https://likha.website/api.php';
$apiKey = 'J7hP2fR1dVgQ9sX4tY0aL6mB3nZ8cO5'; // Replace with your actual API key

if ($_POST['action'] === 'login') {
    $postData = array(
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'action' => $_POST['action'],
    );
} elseif ($_POST['action'] === 'get-token') {
    $postData = array(
        'email' => $_POST['email'],
        'action' => $_POST['action'],
    );
} else {
    // Handle other actions if needed
    echo json_encode(['error' => 'Invalid action']);
    exit; // Stop further execution
}

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
} else {
    echo $response; // Remove json_encode here if the response is already in JSON format
}

curl_close($ch);

?>
