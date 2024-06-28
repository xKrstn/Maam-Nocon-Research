<?php 
    include "../include/connection.php";
    include "../include/header.php";

    $check = "SELECT * FROM announcement_tbl WHERE active = '1'";
    $check_result = mysqli_query($con,$check);
    
    $check1 = "SELECT * FROM announcement_tbl WHERE active = '0'";
    $check_result1 = mysqli_query($con,$check1);

    if($check_result->num_rows > 0 ){
        $sql = "UPDATE announcement_tbl SET active ='0' WHERE active='1'";
        $result = mysqli_query($con, $sql);
        
        if ($result) {
            echo "<script>window.location='announcement.php?msg=Announcement Successfully Clear.';</script>";
        } else {
            echo "Failed: " . mysqli_error($con);
        }
    }else if ($check_result1->num_rows > 0){
        echo "<script>window.location='announcement.php?msg=Theres no announcement to clear.';</script>";
    }
?>