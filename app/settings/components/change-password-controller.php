<?php
include('../../include/db.php');

session_start();


$currEmail = $_SESSION['email'];
$currpass = $_POST['currPass'];
$newPass = $_POST['newPass'];

if ($currEmail && $newPass && $currpass) {        
    $stmt = $conn->prepare("SELECT * FROM tbluser WHERE email = ?");
    $stmt->bind_param("s", $currEmail);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {                
            $user = $result->fetch_assoc();

            if (password_verify($currpass, $user['password'])) {                    
                $newHashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE tbluser 
                SET password = ? WHERE email = ?");
                $updateStmt->bind_param("ss", $newHashedPassword, $currEmail);

                if ($updateStmt->execute()) {                        
                    echo "Password update successful!";
                } else {                        
                    echo "Password update failed: " . $updateStmt->error;
                }

                $updateStmt->close();
            } else {                    
                echo "Incorrect password.";
            }
        } else {                
            echo "User with the current email not found.";
        }

        $result->close();
    } else {            
        echo "Database query failed: " . $stmt->error;
    }

    $stmt->close();
} else {        
    echo "Insufficient data provided for password update.";
}

?>
