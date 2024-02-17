<?php
include('../include/db.php');

session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $postId = $_POST['post_id'];
    $updateQuery = "UPDATE tblpost SET deleted_at = NOW() WHERE post_id = $postId";

    // Execute the query
    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Post deleted successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error deleting post.";
    }

    // Close the database connection if needed
    $conn->close();


} else {
    // Handle other request methods or provide an error message
    $response['success'] = false;
    $response['message'] = "Invalid Request Method";
}
header('Content-Type: application/json');
echo json_encode($response);

?>