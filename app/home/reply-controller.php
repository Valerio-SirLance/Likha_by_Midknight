<?php
include('../include/db.php');

session_start();
$user_id = $_SESSION['user_id'];

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commentId = $_POST['commentId'];
    $reply = $_POST['reply'];
    $currentDate = date('Y-m-d H:i:s');

    if (isset($commentId)) {
        // Fetch username from tblregistration
        $usernameQuery = $conn->prepare("SELECT username FROM tblregistration WHERE user_id = ?");
        $usernameQuery->bind_param("i", $user_id);
        $usernameQuery->execute();
        $usernameResult = $usernameQuery->get_result();
        $usernameRow = $usernameResult->fetch_assoc();
        $username = $usernameRow['username'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO tblreply (comment_id, user_id, reply, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $commentId, $user_id, $reply, $currentDate);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Replied successfully.';
            $response['reply'] = $reply;
            $response['username'] = $username; // Include the username in the response
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong! Try again later.';
    }

    $usernameQuery->close(); // Close the username query
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
