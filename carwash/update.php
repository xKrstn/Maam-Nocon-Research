<?php
    include "include/connection.php";
    include "include/header.php";
    
    $id=$_GET['id'];
    $select="SELECT * FROM staff_tbl WHERE staffID='$id'";
    $result=mysqli_query($con, $select);
    $row=mysqli_fetch_assoc($result);

?>
<div class="container">
    <div class="mb-4">
      <h3>Edit Staff Information</h3>
    </div>

<div class="container d-flex mb-4">
    <form  method="post" style="width:50vw; min-width:300px;">
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
            <button type="submit" class="btn btn-success" name="submit">Update</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
            </div>

        <?php 
            if(isset($_POST['submit'])){
                $firstname=filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
                $lastname=filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
                $phonenum=filter_input(INPUT_POST,'phonenum',FILTER_SANITIZE_NUMBER_INT);
        
                $query= "UPDATE staff_tbl SET firstname='$firstname',lastname='$lastname', phonenum='$phonenum' WHERE staffID='$id'";
        
                $result = mysqli_query($con, $query);
        
                if ($result) {
                    header("Location: admin.php?msg=Data Updated Successfully");
                } else {
                    echo "Failed: " . mysqli_error($con);
                }
            }
        ?>
    </form>
</div>
<?php include "include/footer.php"; ?>