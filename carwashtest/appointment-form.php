<?php 
include "include/connection.php";
include "include/userheader.php";

date_default_timezone_set('Asia/Manila');

if(isset($_GET['date'])){
    $date = $_GET['date'];
}

$id = $_SESSION['id'];

// Function to get the number of bookings for a timeslot
function getBookingCount($con, $date, $timeslot) {
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM appointment_tbl WHERE date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $timeslot);
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
    $payment = $_POST['payment'];
    $note = $_POST['message'];
    $status = "Booked";

    // Check if the timeslot has reached the maximum capacity
    if(getBookingCount($con, $date, $timeslot) >= 2) {
        $msg = "<div class='alert alert-danger'>This timeslot is fully booked.</div>";
    } else {
        $stmt = $con->prepare("INSERT INTO appointment_tbl (`customerID`, `wtypeID`, `vID`, `date`, `timeslot`, `mop`, `note`, `status`) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', $id, $s, $vname, $date, $timeslot, $payment, $note, $status);
        if($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Booking Successful.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Booking Failed.</div>";
        }
        $stmt->close();
    }
}

$duration = 60;
$cleanup = 0;
$start = "07:00";
$end = "20:00";

function timeslots($duration,$cleanup,$start,$end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();

    for($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod > $end){
            break;
        }
        $slots[] = $intStart->format("h:iA")."-".$endPeriod->format("h:iA");
    }
    return $slots;
}
?>
<div class="container">
<h2 class="text-center">Book for Date: <?php echo date('m/d/Y',strtotime($date));?></h2><hr>
<div class="row mt-5">
    <div class="col-md-12">
        <?php echo isset($msg)?$msg:"";?>
    </div>
    <?php 
        $timeslots = timeslots($duration, $cleanup, $start, $end);
        foreach($timeslots as $ts){
            $bookingCount = getBookingCount($con, $date, $ts);
    ?>
    <div class="col-md-2">
        <div class="form-group mb-3">
            <?php if($bookingCount >= 2){ ?>
                <button class="btn btn-dark btn-xs px-3 disabled" tabindex='-1' role='button' aria-disabled='true'><?php echo $ts;?></button>
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
                <select name="vname" id="vid" class="form-select" aria-label="Default select example">
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
                <select name="wash" id="washid" class="form-select" aria-label="Default select example">
                    <?php 
                        $list1 = $con->query("SELECT * FROM washtype_tbl order by wtypeID asc;");
                        echo '<option value="">Select an option</option>';
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
                    <select name="service" id="show" class="form-select" aria-label="Default select example">
                    </select>
              </div>
              <div class="mb-2">
                <label for="">Mode of Payment:</label>
              </div>
              <div class="mb-2">
                <input class="form-check-input pe-3" type="radio" name="payment" id="payment" value = "On-Site" checked>
                <label class="form-check-label" for="payment">
                    On-Site
                </label>
                <input class="form-check-input" type="radio" name="payment" id="payment" value="Gcash">
                <label class="form-check-label" for="payment">
                    Gcash
                </label>
                <input class="form-check-input" type="radio" name="payment" id="payment" value="Paymaya">
                <label class="form-check-label" for="payment">
                    Paymaya
                </label>
              </div>
              <div class="mb-2">
                <label for="message">Note</label>
              </div>
                <div class="form-floating">
                <textarea class="form-control" placeholder="Place Your Message Here." name="message" minlength="50" style="height: 50px"></textarea>
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
<?php include "include/footer.php";?>