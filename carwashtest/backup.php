<?php 
 include "include/connection.php";
 include "include/userheader.php";

 date_default_timezone_set('Asia/Manila');

 if(isset($_GET['date'])){
    $date = $_GET['date'];
    
 }
 
 $id = $_SESSION['id'];
 $bookings = [];
 if(isset($_POST['submit'])){
    $msg = "";
    $timeslot = $_POST['timeslot'];
    $vname = $_POST['vname'];
    $package = $_POST['package'];
    $payment = $_POST['payment'];
    $note = $_POST['message'];
    $stmt = $con->prepare("SELECT * FROM appointment_tbl WHERE date = ? AND timeslot = ? ");
    $stmt->bind_param('ss',$date,$timeslot);
    if($stmt->execute()){
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        $msg = "<div class='alert alert-danger'>Already Booked</div>";
      }else{
        $stmt = $con->prepare("INSERT INTO appointment_tbl (`customerID`, `date`, `timeslot`, `pID`, `mop`, `note`, `vID`) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss',$id,$date,$timeslot,$package,$payment,$note,$vname);
        $stmt->execute();
        $bookings[]=$timeslot;
        echo "<script>window.location='appointment.php?msg=Booking Successful';</script>";
        $stmt->close();
      }  
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
        ?>
        <div class="col-md-2">
            <div class="form-group mb-3">
                <?php if(in_array($ts, $bookings)){ ?>
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
                <select name="vname" id="" class="form-select" aria-label="Default select example">
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
              <label for="package">Choose Package Type:</label>
                <select name="package" id="" class="form-select" aria-label="Default select example">
                    <?php 
                        $list1 = $con->query("SELECT * FROM package_tbl order by pID asc;");
                        for($y=0;$y<$list1->num_rows;$y++){
                            $row = $list1->fetch_assoc();
                            $pt = $row['ptitle'];
                            $pid = $row['pID'];
                            echo "<option value=".$pid.">$pt</option>"; 
                        }
                    ?>
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
                <textarea class="form-control" placeholder="Place Your Message Here." name="message" style="height: 100px"></textarea>
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