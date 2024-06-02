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
    if($customer_result->num_rows>0){
        $row = $customer_result->fetch_assoc();
        $hashpass = $row['password'];
        if(password_verify($password,$hashpass)){

            $_SESSION['username']=$username;
            echo "<script type='text/javascript'> alert('Welcome'); 
            window.location = 'admin.php'; </script>";
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
        if(password_verify($password,$hashpass)){

            $_SESSION['username']=$username;
            echo "<script type='text/javascript'> alert('Welcome'); 
            window.location = 'admin.php'; </script>";
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