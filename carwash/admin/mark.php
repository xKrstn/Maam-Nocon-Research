<?php 
    include "../include/connection.php";

    $id = $_GET['id'];

    $sql = "UPDATE notification_tbl SET active='0' WHERE notifID='$id'";
    $result = mysqli_query($con, $sql); 

    if ($result) {
        header("Location: admin-notification.php");
    } else {
        echo "Failed: " . mysqli_error($con);
    }
?>