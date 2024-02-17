<?php
session_start();
include('../include/db.php');
$user_id = $_SESSION['user_id'];
$defImg = array("def1.png", "def2.png", "def3.png", "def4.png", "def5.png");

// Randomly select one value from the array
$randomImg = $defImg[array_rand($defImg)];
function jsonResponse($status, $message) {
    $response = [
        'status' => $status,
        'message' => $message,
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'caption' parameter is set in the POST data
    if (isset($_POST["post"]) && isset($_FILES['fileInput'])) {
        // Get the caption value from the POST data
        $caption = $_POST["post"];
        $file = $_FILES['fileInput'];

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        if (empty($caption)) {
            // var_dump($caption);
            jsonResponse('error', 'Caption cannot be blank');
        } else {
            if ($fileError === 0) {

                $uploadPath = 'uploads/' . $fileName;
                move_uploaded_file($fileTmpName, $uploadPath);

                $sql_user = "INSERT INTO tblpost
            (post, img_post,deleted_at,updated_at,created_at,user_id) VALUES
            ('$caption', '$fileName',NULL,NULL,NOW(),'$user_id')";
                // Print the received caption
                if ($conn->query($sql_user) === TRUE) {
                    // If the query is successful, print success message
                    jsonResponse('success', 'Post inserted successfully!');
                } else {
                    // If there is an error in the query, print error message
                    // echo "Error: " . $sql_user . "<br>" . $conn->error;
                    jsonResponse('success', 'Post failed!');
                }
            }
        }
    } else {
        // If 'caption' parameter is not set, print an error message
        $caption = $_POST["post"];
        if (empty($caption)) {
            jsonResponse('error', 'Caption cannot be blank');
        } else {
            $sql_user = "INSERT INTO tblpost
            (post, img_post,deleted_at,updated_at,created_at,user_id) VALUES
            ('$caption', '$randomImg',NULL,NULL,NOW(),'$user_id')";
            // Print the received caption
            if ($conn->query($sql_user) === TRUE) {
                // If the query is successful, print success message
                // echo "Success! Post inserted into the database.";
                jsonResponse('success', 'Post inserted successfully!');
            } else {
                // If there is an error in the query, print error message
                // echo "Error: " . $sql_user . "<br>" . $conn->error;
                jsonResponse('error', 'Post failed!');
            }
        }
    }
}
?>