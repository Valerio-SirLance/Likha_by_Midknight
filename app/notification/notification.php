<?php
include('../include/db.php');


$notif_sql = "SELECT tblnotification.*, tblnotification.created_at AS notification_created_at, tblpost.*, tblregistration.username
            FROM tblnotification
            JOIN tblpost ON tblnotification.post_id = tblpost.post_id
            JOIN tblregistration ON tblnotification.interacting_user_id = tblregistration.user_id
            LEFT JOIN tbluser ON tbluser.user_id = tblregistration.user_id
            WHERE tblpost.user_id = '{$_SESSION['user_id']}'
            AND tbluser.deleted_at IS NULL
            ORDER BY tblnotification.is_read ASC, tblnotification.created_at DESC;";


$notif_result = $conn->query($notif_sql);

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         // print_r($row);
//     }
// } else {
//     echo "No results found for user with ID $user_id.";
// }
?>

    
    <script src="../notification/notification.js"></script>
    <link rel="stylesheet" href="../notification/notification.css">
        
    <div id="notificationContainer" class="notification-container">

        <h1 style="color: #739ad1; font-style: bold">Notifications</h1>
        <div class="filter">
            <div>
                <button onclick="filterNotifications('all')">All</button>
                <button onclick="filterNotifications('unread')">Unread</button>
            </div>
            <button onclick="markAllAsRead()">Mark All as Read</button>
        </div>        
        <div class="notif-body">
            <?php
            while ($row = $notif_result->fetch_assoc()) {
                $id = $row['id'];
                $type = $row['type'];
                $user_name = $row['username'];
                $timestamp = $row['notification_created_at'];
                $message = $row['message'];
                $is_read = $row['is_read'];
                
                // Check if the notification is read or unread
                if ($is_read) {
                    $class = "read-notification";
                } else {
                    $class = "unread-notification";
                }
                ?>
                <div class="notifications <?php echo $class; ?>">
                    <a href="../home/display-post.php?post_id=<?php echo $row['post_id']; ?>" 
                        class="notif-anchor">
                        <div class="notification" >
                            <div class="notif_chunk">
                                <span class="notification-message">
                                <?php
                                    if ($is_read) {
                                        echo "<span class='read-notif-user'>
                                            <b> " . $user_name ." </b>
                                        </span>
                                        <span class='read-notif-user'>
                                        " . $message ."                                    
                                        </span>";
                                    }else {
                                        echo "<span class='notif-user'>
                                            <b>" . $user_name ."</b>
                                        </span>                                    
                                        " . $message ."";
                                    }
                                ?>                                                                
                                </span>
                                <span class="notification-timestamp"><?php echo $timestamp; ?></span>
                            </div>                        
                            <?php
                            if (!$is_read) echo "<button onclick=\"readNotif('$id')\">Mark as read</button>";

                            ?>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>