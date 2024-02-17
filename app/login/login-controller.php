<?php
include('../include/db.php');

session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    $sql_user = "SELECT * FROM tbluser WHERE email = '$email' 
        AND verify_at IS NOT NULL AND deleted_at IS NULL ";
    $query = $conn->query($sql_user);

    if ($query->num_rows > 0) {
        $result = $query->fetch_array();

        if (password_verify($password, $result['password'])) {
            $_SESSION['status'] = "Login Successful";
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['token'] = $result['verify_token'];
            $_SESSION['user_avatar'] = $result['user_avatar'];
            $_SESSION['notif_badge'] = $result['notif_badge'];
            
            $sql_username = "SELECT username FROM tblregistration 
            INNER JOIN tbluser ON tblregistration.user_id = tbluser.user_id
            WHERE tbluser.user_id = " . $_SESSION['user_id'];

            $query_username = $conn->query($sql_username);

            if ($query_username->num_rows > 0) {
                $result_username = $query_username->fetch_assoc();
                $_SESSION['username'] = $result_username['username'];
            } else {
                $_SESSION['username'] = 'Unknown'; // Set a default value if username is not found
            }
            echo 'Login Successful';
            $cookie_name = "email";
            $cookie_value = $_SESSION['email'];
            if (!isset($_COOKIE[$cookie_name])) {
                setcookie($cookie_name, $cookie_value, time() + 3600, '/', 'localhost');
            }
            $cookie_name_username = "username";
            $cookie_value_username = $result_username['username'];
            if (!isset($_COOKIE[$cookie_name_username])) {
                setcookie($cookie_name_username, $cookie_value_username, time() + 3600, '/', 'localhost');
            }
        } else {
            $_SESSION['status'] = "Incorrect Password";
            echo 'Incorrect Password';
        }
    } else {
        $_SESSION['status'] = "Incorrect Email";
        echo 'Incorrect Email';
    }

}
// Close the database connection
$conn->close();

?>