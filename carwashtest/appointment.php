<?php 
 include "include/connection.php";
 include "include/userheader.php";

 date_default_timezone_set('Asia/Manila');

 $id = $_SESSION['id'];
 $status = "Booked";
 $status1 = "Completed";

 $duration = 60;
 $cleanup = 0;
 $start = "07:00";
 $end = "20:00";

 function build_calendar($month, $year, $con, $id, $status, $status1, $duration, $cleanup, $start, $end) {
    $stmt = $con->prepare("SELECT date, status FROM appointment_tbl WHERE MONTH(date) = ? AND YEAR(date) = ? AND customerID = ?");
    $stmt->bind_param('ssi', $month, $year, $id);
    $bookings = array();
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[$row['date']] = $row['status'];
            }
        }
        
        $stmt->close();
    }

    $daysofweek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstdayofmonth = mktime(0, 0, 0, $month, 1, $year);
    $numberdays = date('t', $firstdayofmonth);
    $dateCompo = getdate($firstdayofmonth);
    $monthName = $dateCompo['month'];
    $dayofweek = $dateCompo['wday'];
    $dateToday = date('Y-m-d');

    $prevmonth = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prevyear = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $nextmonth = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $nextyear = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));

    $calendar = "<center class='mt-3'><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn btn-dark btn-xs px-3' href='?month=" . $prevmonth . "&year=" . $prevyear . "'>&lt;</a>&nbsp;";
    $calendar .= "<a class='btn btn-dark btn-xs px-3' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a>&nbsp;";
    $calendar .= "<a class='btn btn-dark btn-xs px-3' href='?month=" . $nextmonth . "&year=" . $nextyear . "'>&gt;</a></center>";
    $calendar .= "<br><table class='table table-bordered mt-3'>";
    $calendar .= "<tr>";

    foreach ($daysofweek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    $calendar .= "</tr><tr>";
    $currentDay = 1;

    if ($dayofweek > 0) {
        for ($k = 0; $k < $dayofweek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberdays) {
        if ($dayofweek == 7) {
            $dayofweek = 0;
            $calendar .= "<tr></tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('l', strtotime($date)));
        $today = $date == date('Y-m-d') ? 'today' : '';
        $status = isset($bookings[$date]) ? $bookings[$date] : '';

        // Get the end of the day for comparison
        $endTimeOfDay = new DateTime($date . ' 08:00:00 PM');
        $currentDateTime = new DateTime();

        if ($endTimeOfDay < $currentDateTime) {
            $calendar .= "<td class='$today'><h6>" . $currentDayRel . "</h6><a class='btn btn-danger btn-xs btn-sm disabled' tabindex='-1' role='button' aria-disabled='true'>N/A</a></td>";
        } else if ($status == 'Booked') {
            $calendar .= "<td class='$today'><h6>" . $currentDayRel . "</h6><a class='btn btn-danger btn-sm btn-xs'>Booked</a></td>";
        } else if ($status == 'Completed') {
            $calendar .= "<td class='$today'><h6>" . $currentDayRel . "</h6><a class='btn btn-success btn-sm btn-xs'>Completed</a></td>";
        } else if ($status == 'Cancelled') {
            $calendar .= "<td class='$today'><h6>" . $currentDayRel . "</h6><a class='btn btn-warning btn-sm btn-xs'>Cancelled</a></td>";
        } else {
            $totalbookings = checkSlots($con, $date, $status, $status1, $duration, $cleanup, $start, $end);

            if ($totalbookings == 26) {
                $calendar .= "<td class='$today'><h6>" . $currentDayRel . "</h6><a href='#'class='btn btn-danger btn-sm btn-xs'>Fully Booked</a></td>";
            } else {
                $availslots = 26 - $totalbookings;
                $calendar .= "<td class='$today'><h6>" . $currentDayRel . "</h6><a href='appointment-form.php?date=" . $date . "'class='btn btn-success btn-sm btn-xs'>Book</a><small><i>&nbsp; $availslots slots left</i></small></td>";
            }
        }

        $currentDay++;
        $dayofweek++;
    }

    if ($dayofweek < 7) {
        $remaining = 7 - $dayofweek;

        for ($i = 0; $i < $remaining; $i++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr></table>";
    return $calendar;
}



 function checkSlots($con, $date, $status,$status1, $duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");

    $currentDateTime = new DateTime();
    $currentDate = $currentDateTime->format('Y-m-d');

    $skip = 0;

    for($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);

        $endPeriod->sub(new DateInterval('PT1M'));

        $startTime = new DateTime($date . ' ' . $intStart->format('H:i:s'));
        $endTime = new DateTime($date . ' ' . $endPeriod->format('H:i:s'));

        if ($currentDate == $date && $currentDateTime >= $startTime && $currentDateTime <= $endTime) {
            $skip+=2;
            continue; 
        }

        if ($endTime <= $currentDateTime && $date == $currentDate) {
            $skip+=2;
            continue; 
        }

        if($endPeriod > $end){
            break;
        }
    }

    if ($date >= $currentDate) {
        $stmt = $con->prepare("SELECT (SELECT COUNT(*) FROM appointment_tbl WHERE date = ? AND status = 'Booked') +
                                      (SELECT COUNT(*) FROM appointment_tbl WHERE date = ? AND status = 'Completed') AS total");
        $stmt->bind_param('ss', $date, $date);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalbookings = $result->fetch_assoc()['total'];
        }
        $stmt->close();
    }

    return $totalbookings+$skip;
}
    $currentDateTime = date('Y-m-d H:i');
    $updateSql = "UPDATE announcement_tbl SET active = '0' WHERE active = '1' AND CONCAT(effectiveDate, ' ', effectiveTime) <= ?";
    $updateStmt = $con->prepare($updateSql);
    $updateStmt->bind_param('s', $currentDateTime);
    $updateStmt->execute();
    $updateStmt->close();

    $sql = "SELECT * FROM announcement_tbl WHERE active = '1'";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<div class="container1">
    <?php echo '<div class="alert alert-dark mx-3 mt-1" role="alert"><i class="fa-solid fa-bullhorn"></i> : '.$row['message'].'</div>'; ?>
</div>
<?php }?>
<div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <?php 
                $dateCompo = getdate();
                if(isset($_GET['month'])&& isset($_GET['year'])){
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                }else{
                    $month = $dateCompo['mon'];
                    $year = $dateCompo['year'];
                }

                echo build_calendar($month,$year,$con,$id,$status,$status1, $duration, $cleanup, $start, $end);
            ?>
        </div>
    </div>
</div>


<?php include "include/userfooter.php"; ?>