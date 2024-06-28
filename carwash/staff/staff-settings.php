<?php 
    include "../include/connection.php";
    include "../include/staffheader.php";

    $id=$_SESSION['id'];
    $select="SELECT * FROM staff_tbl WHERE staffID='$id'";
    $result=mysqli_query($con, $select);
    $row=mysqli_fetch_assoc($result);
?>
<?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-primary alert-dismissible fade show mx-3" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
?>

<div class="ms-4 px-3 pt-4 d-flex">
    <div class="container d-inline my-4">
        <div class="mb-4">
        <h3>Account Settings</h3>
        </div>
        <form  method="post" style="width:25vw; min-width:30px;">
                <div class="row mb-3">
                    <div class="col">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $row['firstname'] ?>" required/>
                    </div>
                    <div class="col">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $row['lastname'] ?>" required/>
                    </div>
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" readonly/>
                    </div>
                    <div class="mb-3">
                        <label for="phonenum">Phone Number</label>
                        <input type="number" name="phonenum" class="form-control" value="<?php echo $row['phonenum']?>" required/>
                    </div>              
                </div>
                <div>
                <button type="submit" class="btn btn-dark" name="submit">Update</button>
                </div>

            <?php 
                if(isset($_POST['submit'])){
                    $firstname=filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
                    $lastname=filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
                    $phonenum=filter_input(INPUT_POST,'phonenum',FILTER_SANITIZE_NUMBER_INT);
            
                    $query= "UPDATE staff_tbl SET firstname='$firstname',lastname='$lastname', phonenum='$phonenum' WHERE staffID='$id'";
            
                    if ($con->query($query)===TRUE){
                        echo "<script>window.location='staff-settings.php?msg=Account Updated Successfully';</script>";
                    } else {
                        echo "Failed: " . mysqli_error($con);
                    }
                }
            ?>
        </form>
    </div>
    
    <div class="container d-inline my-4">
        <div class="mb-4">
        <h3>Change Password</h3>
        </div>
        <form  method="post" style="width:20vw; min-width:100px;">
                <div class="row mb-3">
                    <div class="mb-3">
                        <label for="currentpass">Enter Current Password</label>
                        <input type="password" name="currentpass" class="form-control"  required/>
                    </div>
                    <div class="mb-3">
                        <label for="password">Enter New Password</label>
                        <input type="password" name="password" class="form-control"  required/>
                    </div>
                    <div class="mb-3">
                        <label for="conpass">Confirm New Password</label>
                        <input type="password" name="conpass" class="form-control" required/>
                    </div>            
                </div>
                <div>
                <button type="submit" class="btn btn-dark" name="change">Confirm</button>
                </div>

            <?php 
                if(isset($_POST['change'])){
                    $currentpass=filter_input(INPUT_POST,'currentpass',FILTER_SANITIZE_SPECIAL_CHARS);
                    $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
                    $conpass=filter_input(INPUT_POST,'conpass',FILTER_SANITIZE_SPECIAL_CHARS);

                    $hashpass = $row['password'];
                    if(password_verify($currentpass,$hashpass)){
                        if($password !== $conpass){
                            echo '<script> window.location.href="staff-settings.php?msg=Password and Confirm Password doesnt match";</script>';
                        }
                        else{
                            $newhashpass = password_hash($password, PASSWORD_DEFAULT);
                            $query= "UPDATE customer_tbl SET password='$newhashpass' WHERE customerID='$id'";
                            if ($con->query($query)===TRUE){
                                echo "<script>window.location='staff-settings.php?msg=Password Updated Successfully';</script>";
                            } else {
                                echo "Failed: " . mysqli_error($con);
                            }
                        }
                    }
                    else{
                        echo '<script> window.location.href="staff-settings.php?msg=Invalid Current Password";</script>';
                    }
                    
                }
            ?>
        </form>
    </div>
</div>

<?php include "../include/stafffooter.php";?>