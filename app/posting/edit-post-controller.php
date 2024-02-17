<?php
session_start();
include('../include/db.php');
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    parse_str(file_get_contents("php://input"), $data);
    $post_id = $data['id'];
    $caption = $data['caption'];
     
    // echo $caption;
    if (isset($post_id)) {
        $sql_query = "UPDATE tblpost SET post = '$caption' WHERE
        post_id = '$post_id' AND user_id = '$user_id'";

        if ($conn->query($sql_query) === TRUE) {            
            echo "The post was updated succesfully.";
        } else {            
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }   

    }else {
        echo "Something went wrong! Try again later.";
    }
}


?>