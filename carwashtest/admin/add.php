<?php 
    include "include/connection.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $firstname=filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname=filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $phonenum=filter_input(INPUT_POST,'phonenum',FILTER_SANITIZE_NUMBER_INT);
        $stat=filter_input(INPUT_POST,'status',FILTER_SANITIZE_SPECIAL_CHARS);
        $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        $conpass=filter_input(INPUT_POST,'conpass',FILTER_SANITIZE_SPECIAL_CHARS);

        if($password !== $conpass){
            header("Location: admin.php?msg=Password and Confirm Password do not match");
        }
        else{
            $username_check_sql = "SELECT * FROM staff_tbl WHERE username='$username'";
            $username_check_result = $con->query($username_check_sql);

            if($username_check_result->num_rows > 0){
                header("Location: admin.php?msg=Username Already Exist");
            }
            else{
                $hashpass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO staff_tbl(firstname, lastname, username, phonenum, password, stID) VALUES ('$firstname','$lastname','$username','$phonenum','$hashpass','$stat')";

                if($con->query($sql)===TRUE){
                    header("Location: admin.php?msg=New record created successfully");
                }
                else{
                    header("Location: admin.php?msg=Failed");
                    echo '<script>alert("Error: ' .$sql. '\n'. $con->error.'");</script>';     
                }
            }
        }   
    }
$con->close();
?>