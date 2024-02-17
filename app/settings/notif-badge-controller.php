
<?php

session_start();
include('../include/db.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $state = $_POST['state'];

    if ($state === 'true') $state = true;
    
    if (isset($user_id)) {

        $sql_query = "UPDATE tbluser SET notif_badge = '$state'
        WHERE user_id = '$user_id'";

        if ($conn->query($sql_query) === TRUE) {            
            $_SESSION['notif_badge'] = $state;
            echo "Successfully Updated!.";

        } else {            
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }    

    } else {
        echo "Something went wrong!";
    }    



}

?>