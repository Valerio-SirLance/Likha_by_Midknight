<?php
include('home-controller.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likha</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/blue_logo.png">
    <script src="home.js"></script>
    <script src="../assets/10fa757270.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="home.css">
    <script src="../login/test.js"></script> 
</head>

<body>
    <div class="header-mobile">
        <a href="../home/home.php" class="logo-link-mobile">
            <img src="../assets/images/logo_word.png" alt="Likha" class="logo">
        </a>

        <a href="#" id="notif_btn_mobile" class="notif-mobile">
            <img src="../assets/images/notification_icon.png" alt="Notifications"> 
        </a>
    </div>

    <div class="container">
        <?php include('../view/components/search.php'); ?>
        <?php include('../view/components/sidebar.php'); ?>
        <?php include('../notification/notification.php'); ?>
        <?php include('../view/components/sidebar-mobile.php'); ?>
        
        <div class="gallery-container">
            <div class="gallery">
                <?php
                $counter = 0;
                while ($row = $result->fetch_assoc()) {
                    $post_image = "../posting/uploads/" . $row['img_post'];
                    ?>
                    <div class="post-thumbnail">
                        <a href="display-post.php?post_id=<?php echo $row['post_id']; ?>">
                            <img src="<?php echo $post_image; ?>" alt="Posted Image">
                        </a>
                    </div>
                    <?php
                    $counter++;
                    if ($counter % 4 == 0) {
                        // Start a new row after every 4 images
                        echo '<div class="clearfix"></div>';
                    }
                }
                ?>
            </div>
    </div>
</body>

</html>