<?php
include('../include/db.php');

session_start();
function getNumberOfLikes($post_id)
{
    global $conn;

    $sql = "SELECT COUNT(*) as like_count FROM tbl_acclike WHERE post_id = $post_id AND like_at IS NOT NULL";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['like_count'];
    }

    return 0; // Return 0 if no likes are found
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];
    $type = 'like';
    $user_id = $_SESSION['user_id'];
    $query = "SELECT username FROM tblregistration WHERE user_id = ?";
    $stmt1 = $conn->prepare($query);
    $stmt1->bind_param('i', $user_id);
    $stmt1->execute();
    $stmt1->bind_result($result_username);
    $stmt1->fetch();
    $stmt1->close();

    $stmt = $conn->prepare("SELECT * FROM tbl_acclike WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the row exists
    if ($result->num_rows > 0) {
        // Row exists
        $row = $result->fetch_assoc();
        if (!is_null($row['like_at'])) {
            // 'like_at' column has a non-null value
            $update_sql = "UPDATE tbl_acclike SET like_at = NULL WHERE post_id = '$post_id' AND user_id = '$user_id'";

            if ($conn->query($update_sql) === TRUE) {
                $likeCount = getNumberOfLikes($post_id);
                echo json_encode(["success" => true, "action" => "unlike", "likeCount" => $likeCount]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
            }
        } else {
            // 'like_at' column is null
            $like_at = date("Y-m-d H:i:s");

            $update_sql = "UPDATE tbl_acclike SET like_at = '$like_at' WHERE post_id = '$post_id' AND user_id = '$user_id'";

            if ($conn->query($update_sql) === TRUE) {
                // Insert a like notification into tblnotification
                $notification_content = "liked your post.";
                $notification_sql = "INSERT INTO tblnotification (interacting_user_id, 
                post_id, type, message) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($notification_sql);
                $stmt->bind_param('iiss', $user_id, $post_id, $type, $notification_content);

                if ($stmt->execute()) {
                    $likeCount = getNumberOfLikes($post_id);
                    echo json_encode(["success" => true, "action" => "like", "likeCount" => $likeCount]);
                } else {
                    echo json_encode(["success" => false, "message" => "Error inserting notification: " . $stmt->error]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Error inserting like: " . $conn->error]);
            }
        }
    } else {
        $like_at = date("Y-m-d H:i:s");

        // Insert data into tblacclike
        $insert_sql = "INSERT INTO tbl_acclike (like_at, update_at, user_id, post_id) VALUES ('$like_at', NULL, '$user_id', '$post_id')";
        if ($conn->query($insert_sql) === TRUE) {
            // Insert a like notification into tblnotification
            $notification_content = $result_username . " liked your post";
            $notification_sql = "INSERT INTO tblnotification (interacting_user_id, 
                post_id, type, message) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($notification_sql);
            $stmt->bind_param('iiss', $user_id, $post_id, $type, $notification_content);

            if ($stmt->execute()) {
                $likeCount = getNumberOfLikes($post_id);
                echo json_encode(["success" => true, "action" => "like", "likeCount" => $likeCount]);
            } else {
                echo json_encode(["success" => false, "message" => "Error inserting notification: " . $stmt->error]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Error inserting like: " . $conn->error]);
        }
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    // Send a JSON response indicating failure
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}



?>