<?php 
include "include/connection.php";
include "include/userheader.php";

date_default_timezone_set('Asia/Manila');

if(isset($_GET['date'])){
    $date = $_GET['date'];
}

$customerID = $_SESSION['id'];
$statuses = ["Booked", "Completed"];

function getBookingCount($con, $date, $timeslot, $statuses) {
    $statusPlaceholders = implode(',', array_fill(0, count($statuses), '?'));
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM appointment_tbl WHERE date = ? AND timeslot = ? AND status IN ($statusPlaceholders)");
    
    $types = str_repeat('s', count($statuses) + 2); // Two 's' for $date and $timeslot, the rest for statuses
    $stmt->bind_param($types, $date, $timeslot, ...$statuses);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];
    $stmt->close();
    return $count;
}

if(isset($_POST['submit'])){
    $msg = "";
    $timeslot = $_POST['timeslot'];
    $vname = $_POST['vname'];
    $wash = $_POST['wash'];
    $service = $_POST['service'];
    $payment = $_POST['payment'];
    $note = $_POST['message'];
    $status = "Booked";

    // Check if the timeslot has reached the maximum capacity
    if(getBookingCount($con, $date, $timeslot,$statuses) >= 2) {
        $msg = "<div class='alert alert-danger'>This timeslot is fully booked.</div>";
    } else {
        $stmt = $con->prepare("INSERT INTO appointment_tbl (`customerID`, `wtypeID`, `servID`, `vID`, `date`, `timeslot`, `mop`, `note`, `status`) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssss', $customerID, $wash, $service, $vname, $date, $timeslot, $payment, $note, $status);
        if($stmt->execute()) {
            $sql = "SELECT * FROM appointment_tbl WHERE date ='$date' AND customerID ='$customerID' AND status = '$status'";
            $result = mysqli_query($con, $sql);
            $row = $result->fetch_assoc();
            $appointID = $row['appointID'];
            $active = 1;

            $createdDate = date('Y-m-d');
            $createdTime = date('h:iA');

            $stmt1 = $con->prepare("INSERT INTO notification_tbl (`appointID`, `active`, `date`, `time`) VALUES (?,?,?,?)");
            $stmt1->bind_param('siss',$appointID,$active,$createdDate,$createdTime);
            $stmt1->execute();

            echo "<script>window.location='appointment.php?msg=Booking Successful.';</script>";
        } else {
            $msg = "<div class='alert alert-danger'>Booking Failed.</div>";
        }
        $stmt->close();
        $stmt1->close();
    }
}

$duration = 60;
$cleanup = 0;
$start = "07:00";
$end = "20:00";

function timeslots($duration, $cleanup, $start, $end, $date) {
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    $currentDateTime  = new DateTime();
    $currentDate = $currentDateTime->format('Y-m-d'); 
    $date = date('Y-m-d', strtotime($date)); 

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        
        $endPeriod->sub(new DateInterval('PT1M'));

        $startTime = new DateTime($date . ' ' . $intStart->format('H:i:s'));
        $endTime = new DateTime($date . ' ' . $endPeriod->format('H:i:s'));

        if ($currentDate == $date && $currentDateTime >= $startTime && $currentDateTime <= $endTime) {
            continue; 
        }

        if ($endTime <= $currentDateTime && $date == $currentDate) {
            continue; 
        }

        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("h:iA") . "-" . $endPeriod->format("h:iA");
    }
    return $slots;
}

?>
<div class="container">
    <div class="header mt-2 d-flex">
        <a href="appointment.php" class=" p-2"><button class="btn btn-dark">Back</button></a>
        <h2 class="p-2 mx-auto">Book for Date: <?php echo date('m/d/Y',strtotime($date));?></h2>
    </div>
    <hr>
<div class="row mt-5">
    <div class="col-md-12">
        <?php echo isset($msg)?$msg:"";?>
    </div>
    <?php 
        $timeslots = timeslots($duration, $cleanup, $start, $end, $date);
        foreach($timeslots as $ts){
            $bookingCount = getBookingCount($con, $date, $ts,$statuses);
    ?>
    <div class="col-md-2">
        <div class="form-group mb-3">
            <?php if($bookingCount >= 2){ ?>
                <button class="btn btn-dark btn-xs px-3 disabled" tabindex='-1' role='button' aria-disabled='true'>Fully Booked</button>
            <?php } else { ?>
                <button class="btn btn-dark btn-xs px-3 book" data-bs-toggle="modal" data-bs-target="#exampleModal" data-timeslot="<?php echo $ts;?>"><?php echo $ts;?></button>
            <?php } ?>  
        </div>
    </div>
    <?php } ?>
</div>
</div>

    <!-- Modal -->
<form action="" method="post" autocomplete="off">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Booking <span class="slot"></span></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="form-group row mb-2">
              <div class="mb-2">
                <label for="timeslot">Timeslot</label>
                <input type="text" name="timeslot" id="timeslot" class="form-control" required readonly/>
              </div>
              <div class="mb-2">
                <label for="vname">Choose Vehicle Type:</label>
                <select name="vname" id="vid" class="form-select" aria-label="Default select example" required>
                    <?php 
                        $list = $con->query("SELECT * FROM vehicle_tbl order by vname asc;");
                        for($y=0;$y<$list->num_rows;$y++){
                            $row = $list->fetch_assoc();
                            $vn = $row['vname'];
                            $vid = $row['vID'];
                            echo "<option value=".$vid.">$vn</option>"; 
                        }
                    ?>
                </select>
              </div>
              <div class="mb-2">
              <label for="wash">Choose Wash Type:</label>
                <select name="wash" id="washid" class="form-select" aria-label="Default select example" required>
                    <?php 
                        $list1 = $con->query("SELECT * FROM washtype_tbl order by wtypeID asc;");
                        echo '<option value="" hidden>Select an option</option>';
                        for($y=0;$y<$list1->num_rows;$y++){
                            $row = $list1->fetch_assoc();
                            $wt = $row['washtype'];
                            $wid = $row['wtypeID'];
                            echo "<option value=".$wid.">$wt</option>"; 
                        }
                    ?>
                </select>
              </div>
              <div class="mb-2">
                <label for="service">Choose Service Type:</label>
                    <select name="service" id="show" class="form-select" aria-label="Default select example" required>
                    </select>
              </div>
              <div class="mb-2">
                <label for="">Mode of Payment:</label>
              </div>
              <div class="mb-2">
                <input class="form-check-input me-1" type="radio" name="payment" id="payment1" value = "On-Site" checked>
                <label class="form-check-label me-2" for="payment1">
                    On-Site
                </label>
                <input class="form-check-input me-1" type="radio" name="payment" id="payment2" value="Gcash">
                <label class="form-check-label me-2" for="payment2">
                    Gcash
                </label>
                <input class="form-check-input me-1" type="radio" name="payment" id="payment3" value="Paymaya">
                <label class="form-check-label me-2" for="payment3">
                    Paymaya
                </label>
              </div>
              <div class="mb-2">
                <label for="message">Note (optional)</label>
              </div>
                <div class="form-floating">
                <textarea class="form-control" placeholder="Place Your Message Here." name="message" maxlength="50" style="height: 100px; resize:none;"></textarea>
                </div>
                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Book</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php include "include/userfooter.php";?>