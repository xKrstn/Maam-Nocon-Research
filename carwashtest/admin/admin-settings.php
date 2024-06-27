<?php 
    include "../include/connection.php";
    include "../include/header.php";

    $id=$_SESSION['id'];
    $select="SELECT * FROM manager_tbl WHERE mID='$id'";
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
                </div>
                <div>
                <button type="submit" class="btn btn-dark" name="submit">Update</button>
                </div>

            <?php 
                if(isset($_POST['submit'])){
                    $firstname=filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
                    $lastname=filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
            
                    $query= "UPDATE manager_tbl SET firstname='$firstname',lastname='$lastname' WHERE mID='$id'";
            
                    if ($con->query($query)===TRUE){
                        echo "<script>window.location='admin-settings.php?msg=Account Updated Successfully';</script>";
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
                            echo '<script> window.location.href="admin-settings.php?msg=Password and Confirm Password Do Not Match";</script>';
                        }
                        else{
                            $newhashpass = password_hash($password, PASSWORD_DEFAULT);
                            $query= "UPDATE manager_tbl SET password='$newhashpass' WHERE mID='$id'";
                            if ($con->query($query)===TRUE){
                                echo "<script>window.location='admin-settings.php?msg=Password Updated Successfully';</script>";
                            } else {
                                echo "Failed: " . mysqli_error($con);
                            }
                        }
                    }
                    else{
                        echo '<script> window.location.href="admin-ssettings.php?msg=Invalid Current Password";</script>';
                    }
                    
                }
            ?>
        </form>
    </div>
</div>
<hr>
<div class="ms-4 px-3 pt-2 d-flex">
    <div class="container d-inline my-4">
            <div class="mb-4">
            <h3>Update Service Settings</h3>
            </div>
            <form method="post" style="width:25vw; min-width:300px;">
                <div class="mb-2">
                    <label for="wash">Choose Wash Type:</label>
                    <select name="wash" id="washid" class="form-select" aria-label="Default select example" required>
                        <?php 
                            $list1 = $con->query("SELECT * FROM washtype_tbl ORDER BY wtypeID ASC;");
                            echo '<option value="" hidden>Select an option</option>';
                            while ($row = $list1->fetch_assoc()) {
                                $wt = $row['washtype'];
                                $wid = $row['wtypeID'];
                                echo "<option value=\"$wid\">$wt</option>"; 
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="service">Choose Service Type:</label>
                    <select name="service" id="serviceid" class="form-select" aria-label="Default select example" required>
                        <option value="" hidden>Select an option</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="size">Choose Size:</label>
                    <select name="size" id="sizeid" class="form-select" aria-label="Default select example" required>
                        <option value="" hidden>Select an option</option>
                    </select>
                </div>
                <div class="col">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" class="form-control" value="" required/>
                </div>
                <button type="submit" class="btn btn-dark mt-3" name="updateprice">Update</button>

                <?php 
                    if(isset($_POST['updateprice'])){
                        $washtype = $_POST['wash'];
                        $servicetype = $_POST['service'];
                        $size = $_POST['size'];
                        $price = $_POST['price'];
                
                        $update= "UPDATE service_tbl SET price='$price' WHERE wtypeID ='$washtype' AND stypeID = '$servicetype' AND sizeID = '$size'";
                
                        if ($con->query($update)===TRUE){
                            echo "<script>window.location='admin-settings.php?msg=Service Updated Successfully';</script>";
                        } else {
                            echo "Failed: " . mysqli_error($con);
                        }
                    }
                ?>
            </form>
        </div>
</div>
<?php include "../include/footer.php";?>

<script>
    $(document).ready(function() {
        // Fetch service types based on selected wash type
        $('#washid').on('change', function() {
            var washTypeID = $(this).val();
            if (washTypeID) {
                $.ajax({
                    url: 'fetch-services.php',
                    type: 'POST',
                    data: { washTypeID: washTypeID },
                    success: function(data) {
                        $('#serviceid').html(data);
                    }
                });
            } else {
                $('#serviceid').html('<option value="" hidden>Select an option</option>');
                $('#sizeid').html('<option value="" hidden>Select an option</option>');
                $('#price').val('');
            }
        });

        // Fetch sizes based on selected service type
        $('#serviceid').on('change', function() {
            var serviceTypeID = $(this).val();
            if (serviceTypeID) {
                $.ajax({
                    url: 'fetch-sizes.php',
                    type: 'POST',
                    data: { serviceTypeID: serviceTypeID },
                    success: function(data) {
                        $('#sizeid').html(data);
                    }
                });
            } else {
                $('#sizeid').html('<option value="" hidden>Select an option</option>');
                $('#price').val('');
            }
        });

        // Fetch price based on selected size
        $('#sizeid').on('change', function() {
            var sizeID = $(this).val();
            var serviceTypeID = $('#serviceid').val();
            var washTypeID = $('#washid').val();
            if (sizeID && serviceTypeID && washTypeID) {
                $.ajax({
                    url: 'fetch-price.php',
                    type: 'POST',
                    data: { sizeID: sizeID, serviceTypeID: serviceTypeID, washTypeID: washTypeID },
                    success: function(data) {
                        $('#price').val(data);
                    }
                });
            } else {
                $('#price').val('');
            }
        });
    });
</script>
