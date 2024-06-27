<?php 
include "include/connection.php";
session_start();


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
    $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);

    $customer_sql="SELECT * FROM customer_tbl WHERE username='$username'";
    $customer_result=$con->query($customer_sql);

    $staff_sql="SELECT * FROM staff_tbl WHERE username='$username'";
    $staff_result=$con->query($staff_sql);

    $admin_sql = "SELECT * FROM manager_tbl WHERE username ='$username'";
    $admin_result = $con->query($admin_sql);

    if($customer_result->num_rows>0){
        $row = $customer_result->fetch_assoc();
        $hashpass = $row['password'];
        $cid = $row['customerID'];
        if(password_verify($password,$hashpass)){

            $_SESSION['username']=$username;
            $_SESSION['id']=$cid;
            $_SESSION['type']='c';
            echo "<script type='text/javascript'> alert('Welcome ".$_SESSION['username']."'); 
            window.location = 'appointment.php'; </script>";
        }
        else{
            echo "<script type='text/javascript'> 
            alert('Invalid Email or Password');
            window.location='registration/login.html';
            </script>";
        }
    }
    elseif($staff_result->num_rows > 0){
        $row = $staff_result->fetch_assoc();
        $hashpass = $row['password'];
        $sid = $row['staffID'];
        if(password_verify($password,$hashpass)){

            $_SESSION['username']=$username;
            $_SESSION['id']=$sid;
            $_SESSION['type']='s';
            echo "<script type='text/javascript'> alert('Welcome ".$_SESSION['username']."');  
            window.location = 'admin/admin.php'; </script>";
        }
        else{
            echo "<script type='text/javascript'> 
            alert('Invalid Email or Password');
            window.location='registration/login.html';
            </script>";
        }
    }
    elseif($admin_result->num_rows == 1){
        $row = $admin_result->fetch_assoc();
        $hashpass = $row['password'];
        $mid = $row['mID'];
        if(password_verify($password,$hashpass)){

            $_SESSION['username']=$username;
            $_SESSION['id']=$mid;
            $_SESSION['type']='a';
            echo "<script type='text/javascript'> alert('Welcome ".$_SESSION['username']."');  
            window.location = 'admin/dashboard.php'; </script>";
        }
        else{
            echo "<script type='text/javascript'> 
            alert('Invalid Email or Password');
            window.location='registration/login.html';
            </script>";
        }
    }
    else{
        echo "<script type='text/javascript'> 
            alert('Invalid Email or Password');
            window.location='registration/login.html';
            </script>";
    }
}

$con->close();
?>