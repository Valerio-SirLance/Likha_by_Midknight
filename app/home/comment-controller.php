<?php
include('../include/db.php');

session_start();

function getComment($conn, $comment_id)
{
    $sql = "SELECT tbl_comment.*, tblregistration.username as `comment-user`
    FROM tbl_comment 
    LEFT JOIN tblregistration ON tbl_comment.user_id = tblregistration.user_id
    WHERE tbl_comment.comment_id = $comment_id";
    $result = $conn->query($sql);

    // Check for errors
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_assoc();
}

function getUserAvatar($conn, $comment_id,$user_id)
{
    $sql = "SELECT user_avatar as `avatar-user`
    FROM tbluser 
    JOIN tbl_comment ON tbl_comment.user_id = tbluser.user_id
    WHERE tbl_comment.comment_id = $comment_id AND tbluser.user_id";
    $result = $conn->query($sql);

    // Check for errors
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    return $result->fetch_assoc();
}

$user_id = $_SESSION['user_id'];
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values sent from the AJAX request
    $postId = $_POST['postId'];
    $type = 'comment';
    $comment = $_POST['comment'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO tbl_comment (comment, update_at, delete_at, created_at, user_id, post_id) VALUES (?, NULL, NULL, NOW(), ?, ?)");
    $stmt->bind_param("sii", $comment, $user_id, $postId);

    if ($stmt->execute()) {
        // Get the last inserted comment
        $lastInsertedId = $stmt->insert_id;
        $newComment = getComment($conn, $lastInsertedId);
        $avatarComment = getUserAvatar($conn, $lastInsertedId,$user_id);
        
        // var_dump($avatarComment);

        $notification_content = "commented on your post.";
        $notification_sql = "INSERT INTO tblnotification (interacting_user_id, 
        post_id, type, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($notification_sql);
        $stmt->bind_param('iiss', $user_id, $postId, $type, $notification_content);
        
        if ($stmt->execute()) {
            // Encode the new comment into JSON and send it as the response
            echo json_encode(["success" => true, "action" => "commented", "comment" => $newComment, "userAvatar" => $avatarComment]);
        } else {
            echo json_encode(["success" => false, "message" => "Error inserting notification: " . $stmt->error]);
        }
        
    } else {
        echo json_encode(["success" => false, "message" => "Error inserting: " . $stmt->error]);
    }

    $stmt->close();
} else {
    // Handle other HTTP methods if needed
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
