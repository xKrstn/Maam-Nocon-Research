<?php 
    include "../include/connection.php";
    include "../include/header.php";

    date_default_timezone_set('Asia/Manila');

    $message = $date = $time = '';
    $errors = '';
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $message = htmlspecialchars($_POST['message']);
        $date = $_POST['date']; 
        $time = $_POST['time'];

        $sql = "SELECT active FROM announcement_tbl WHERE active ='1'";
        $result = mysqli_query($con, $sql);
        
        if($result->num_rows == 1){
            $errors = "Currently you have a Announcement, please clear it before you announce";
        }
        else{
            if (empty($date)) {
                $errors = "Date is required";
            } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $errors = "Invalid date format";
            } else { 
                if ($date < $currentDate || ($date == $currentDate && $time < $currentTime)) {
                    $errors = "Invalid Date and Time";
                }
            }
        }
        

        if (empty($errors)) {
            $stmt = $con->prepare("INSERT INTO announcement_tbl (`message`, `effectiveDate`, `effectiveTime`, `createdDate`, `active`) VALUES (?, ?, ?, ?, '1')");
            $stmt->bind_param('ssss', $message, $date, $time, $currentDate);
            if ($stmt->execute()) {
                echo "<script>window.location='announcement.php?msg=Announcement successfully posted.';</script>";
            } else {
                echo "<script>window.location='announcement.php?msg=Failed to post announcement.';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>window.location='announcement.php?msg=$errors';</script>";
        }  
    }
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
<div class="ms-4 px-3 pt-4 d-flex ">
    <div class="container mb-4 d-inline">
        <div class="mb-3">
            <h3>Announcement</h3>
        </div>
        <form method="post" style="width:30vw; min-width:300px;">
            <h5>Type announcement you want to announce: </h5>
            <div class="form-floating my-3">
                <textarea class="form-control" name="message" placeholder="Leave a message here" id="floatingTextarea" style="resize:none; height: 200px;" required></textarea>
                <label for="floatingTextarea">Type Here</label>
            </div>  
            <div class="col">
                <label for="date">Effective Until:</label>
                <input type="date" name="date" class="form-control" required/>
            </div>        
            <div class="col mt-3">
                <input type="time" name="time" class="form-control" required/>
            </div>        
            <div class="mt-3">
                <button type="submit" class="btn btn-dark" name="submit">Announce</button>
            </div>
        </form>
    </div>
    <div class="container mb-4 d-inline">
        <div class="mb-3">
            <h3>Clear Announcement</h3>
        </div>
        <div class="mt-3">
            <a href="clearannounce.php" class="btn btn-dark">Clear Current Announcement</a>
        </div>
    </div>
</div>

<?php 
    include "../include/footer.php";
?>
