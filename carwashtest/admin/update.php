<?php
    include "../include/connection.php";
    include "../include/header.php";
    
    $id=$_GET['id'];
    $select="SELECT * FROM staff_tbl s INNER JOIN staffstatus_tbl st ON s.stID = st.stID WHERE staffID='$id'";
    $result=mysqli_query($con, $select);
    $row=mysqli_fetch_assoc($result);

?>
<div class="ms-5 px-5 pt-4">
    <div class="mb-4">
      <h3>Edit Staff Information</h3>
    </div>
    <div class="container d-flex mb-4">
        <form  method="post" style="width:30vw; min-width:150px;">
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
                    <div class="mb-2">
                        <label for="status">Status:</label>
                            <select name="status" id="statusid" class="form-select" aria-label="Default select example" required>
                                <?php 
                                    $list1 = $con->query("SELECT * FROM staffstatus_tbl order by status asc;");
                                    echo '<option value="'.$row['stID'].'" hidden>'.$row['status'].'</option>';
                                    for($y=0;$y<$list1->num_rows;$y++){
                                        $row1 = $list1->fetch_assoc();
                                        $status = $row1['status'];
                                        $stid = $row1['stID'];
                                        echo "<option value=".$wistid.">$status</option>"; 
                                    }
                                ?>
                            </select>
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
                    $stat=filter_input(INPUT_POST,'status',FILTER_SANITIZE_SPECIAL_CHARS);
            
                    $query= "UPDATE staff_tbl SET firstname='$firstname',lastname='$lastname', phonenum='$phonenum', stID='$stat' WHERE staffID='$id'";
            
                    if ($con->query($query)===TRUE){
                        echo "<script>window.location='admin.php?msg=Data Updated Successfully';</script>";
                    } else {
                        echo "Failed: " . mysqli_error($con);
                    }
                }
            ?>
        </form>
    </div>
</div>
<?php include "../include/footer.php"; ?>