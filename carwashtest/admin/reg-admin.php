<?php 
    include '../include/connection.php';

    if(isset($_POST['submit'])){
        $firstname=filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname=filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        $conpass=filter_input(INPUT_POST,'conpass',FILTER_SANITIZE_SPECIAL_CHARS);

        if($password !== $conpass){
            echo "<script> alert('Password and Confirm Password Do Not Match');</script>";
            echo '<script> window.location.href="reg-admin.php";</script>';
        }
        else{
            $sql = "SELECT * FROM manager_tbl";
            $result = $con->query($sql);

            if($result->num_rows == 1){
                echo "<script> alert('Maximum Limit Has Been Reached'); </script>";
                echo '<script> window.location.href="reg-admin.php";</script>'; 
            }
            else{
                $hashpass = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO manager_tbl(firstname, lastname, username,password) VALUES ('$firstname','$lastname','$username','$hashpass')";

                if($con->query($sql)===TRUE){
                    echo '<script> alert("Registered Successfully");</script>';
                    echo '<script> window.location.href="../registration/login.html";</script>'; 
                }
                else{
                    echo '<script>alert("Error: ' .$sql. '\n'. $con->error.'");</script>';
                    echo '<script> window.location.href="reg-admin.php";</script>';     
                }
            }
        }   
    }

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carwash</title>
    <link rel="stylesheet" href="../registration/login-reg.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <img src="../img/jcl logo.jpg" alt="JCL Logo" class="logo-image">
            <ul class="links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php#services">Services</a></li>
                <li><a href="../index.php#contact">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="box">
            <h2>Register Admin</h2>
            <form method="POST" class="formbox">
                <div class="input">
                    <input type="text" name="firstname" placeholder="First Name" required>
                </div>
                <div class="input">
                    <input type="text" name="lastname" placeholder="Last Name" required>
                </div>
                <div class="input">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input">
                    <input type="password" name="conpass" placeholder="Confirm Password" required>
                </div>
                <button type="submit" name="submit" class="button">Register</button>
            </form>
        </div>
    </div>
</body>
</html>