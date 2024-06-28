<?php 
    include "include/connection.php";

    $id = $_GET['id'];

    $sql = "UPDATE message_tbl SET active='0' WHERE msgID='$id'";
    $result = mysqli_query($con, $sql); 

    if ($result) {
        header("Location: user-notification.php");
    } else {
        echo "Failed: " . mysqli_error($con);
    }
?>