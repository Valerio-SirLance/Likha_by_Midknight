<?php

session_start();
include('../include/db.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
    $isRead = true;
      
    if (isset($user_id)) {
        

        $sql_query = "UPDATE tblnotification SET is_read ='$isRead'
         WHERE post_id IN (SELECT post_id FROM tblpost 
            WHERE user_id = '$user_id')";

        if ($conn->query($sql_query) === TRUE) {            
            echo "Marking as read successfully!.";
        } else {            
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }    
    } else {
        echo "Something went wrong!";
    }    
}

if ($_SERVER["REQUEST_METHOD"] == "PATCH") {

    parse_str(file_get_contents("php://input"), $data);
   
    $isRead = true;
      
    if (isset($data['id'])) {
        $id = $data['id'];

        $sql_query = "UPDATE tblnotification SET is_read ='$isRead'
         WHERE post_id IN (SELECT post_id FROM tblpost 
            WHERE user_id = '$user_id') AND id = '$id'";

        if ($conn->query($sql_query) === TRUE) {            
            echo "Marking as read successfully!.";
        } else {            
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }    
    } else {
        echo "Something went wrong!";
    }    
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $isRead = false;
    
    if (isset($user_id)) {
        $sql_query = "SELECT COUNT(*) AS notification_count
            FROM tblnotification
            WHERE post_id IN (SELECT post_id FROM tblpost 
            WHERE user_id = '$user_id')
            AND is_read = '$isRead'";

        $result = $conn->query($sql_query);

        if ($result !== FALSE) {
            $row = $result->fetch_assoc();
            $notification_count = $row['notification_count'];

            echo $notification_count;
        } else {
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }
    } else {
        echo "Please Login to your account!";
    }
}


