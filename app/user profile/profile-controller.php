<?php
// profile-controller.php
include('../include/db.php');
// Include the session handler to ensure that session variables are set
include('session-handler.php');

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];

// Fetch posts for the current user
if (isset($_GET['username'])) {
    $requestedUsername = $_GET['username'];

    // Fetch user details for the requested user
    $userDetailsQuery = "SELECT tbluser.*, tblregistration.*
                         FROM tbluser
                         JOIN tblregistration ON tbluser.user_id = tblregistration.user_id
                         WHERE tblregistration.username = '$requestedUsername'";

    $userDetailsResult = $conn->query($userDetailsQuery);

    if ($userDetailsResult && $userDetailsResult->num_rows > 0) {
        $userDetails = $userDetailsResult->fetch_assoc();
        $username = $userDetails['username'];
        $userAvatar = $userDetails['user_avatar'];
        $user_id = $userDetails['user_id']; // Update the user_id for the requested profile

        // Reset the pointer to the beginning of the result set
        $userDetailsResult->data_seek(0);
    
        // Fetch posts for the requested user
        $postsQuery = "SELECT tblpost.*, tbl_acclike.like_at AS liked
                       FROM tblpost
                       LEFT JOIN tbl_acclike ON tblpost.post_id = tbl_acclike.post_id AND tbl_acclike.user_id = $user_id
                       WHERE tblpost.user_id = $user_id AND tblpost.deleted_at IS NULL
                       ORDER BY tblpost.created_at DESC";
    
        $result = $conn->query($postsQuery);
    } else {
        echo "User not found.";
        exit();
    }
}

?>
