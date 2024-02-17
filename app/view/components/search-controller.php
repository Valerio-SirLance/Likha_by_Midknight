<?php
include('../../include/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming 'searchTerm' is the parameter sent from your front end
    $searchTerm = $_POST['searchTerm'];

    // Perform the search query with a JOIN operation
    $sql = "SELECT r.username, u.user_avatar FROM tblregistration r
            JOIN tbluser u ON r.user_id = u.user_id
            WHERE LOWER(r.username) = LOWER('$searchTerm') AND deleted_at IS NULL";

    // Check if the connection is successful
    if (!$conn) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit();
    }

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // User found
            $user = $result->fetch_assoc();
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            // User not found
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    } else {
        // Query execution failed
        echo json_encode(['success' => false, 'message' => 'Error executing the search query']);
    }
}
?>
