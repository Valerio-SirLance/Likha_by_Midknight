<?php
session_start();
include('../../include/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    // Get the user's email from the session
    $email = $_SESSION['email'];

    if ($email && $password) {
        // Check if the provided password matches the user's password
        $stmt = $conn->prepare("SELECT * FROM tbluser WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Password is correct, update the deleted_at column
                    $updateStmt = $conn->prepare("UPDATE tbluser SET deleted_at = NOW() WHERE user_id = ?");
                    $updateStmt->bind_param("i", $user['user_id']);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // You may also want to perform additional cleanup or handle dependent records here

                    echo "Account deleted successfully.";

                } else {
                    // Incorrect password
                    echo "Incorrect password.";
                }
            } else {
                // User not found
                echo "User not found.";
            }
        } else {
            // Error executing the query
            echo "Error executing query.";
        }

        $stmt->close();
    } else {
        // Insufficient data provided for account deletion
        echo "Insufficient data provided for account deletion.";
    }
}
?>
