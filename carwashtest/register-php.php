<?php 
    include "include/connection.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $firstname=filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname=filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $phonenum=filter_input(INPUT_POST,'phonenum',FILTER_SANITIZE_NUMBER_INT);
        $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        $conpass=filter_input(INPUT_POST,'conpass',FILTER_SANITIZE_SPECIAL_CHARS);

        if($password !== $conpass){
            echo "<script> alert('Password and Confirm Password Do Not Match');</script>";
            echo '<script> window.location.href="registration/reg.html";</script>';
        }
        else{
            $email_check_sql = "SELECT * FROM customer_tbl WHERE email='$email'";
            $email_check_result = $con->query($email_check_sql);

            $username_check_sql = "SELECT * FROM customer_tbl WHERE username='$username'";
            $username_check_result = $con->query($username_check_sql);

            if($email_check_result->num_rows > 0){
                echo "<script> alert('Email Already In Use'); </script>";
                echo '<script> window.location.href="registration/reg.html";</script>'; 
            }
            elseif($username_check_result->num_rows > 0){
                echo "<script> alert('Username Already Exist');</script>";
                echo '<script> window.location.href="registration/reg.html";</script>';  
            }
            else{
                $hashpass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO customer_tbl(firstname, lastname, username, email, phonenum, password) VALUES ('$firstname','$lastname','$username','$email','$phonenum','$hashpass')";

                if($con->query($sql)===TRUE){
                    echo '<script> alert("Registered Successfully");</script>';
                    echo '<script> window.location.href="registration/login.html";</script>'; 
                }
                else{
                    echo '<script>alert("Error: ' .$sql. '\n'. $con->error.'");</script>';
                    echo '<script> window.location.href="registration/reg.html";</script>';     
                }
            }
        }   
    }
$con->close();
?>