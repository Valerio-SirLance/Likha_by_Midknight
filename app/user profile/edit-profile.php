<?php
include('../include/db.php');

session_start();

$user_id = $_SESSION['user_id'];
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values sent from the AJAX request
    $avatar_img = $_POST['avatar'];
    $user_bio = $_POST['bio'];

    // Update the values in the database
    $stmt = $conn->prepare("UPDATE tbluser SET user_avatar = ?, bio = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $avatar_img, $user_bio, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Profile updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating profile"]);
    }

    $stmt->close();

} else {
    // Handle other HTTP methods if needed
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
