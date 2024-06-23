<?php 
 include "include/connection.php";
 include "include/userheader.php";

 date_default_timezone_set('Asia/Manila');

 $id = $_SESSION['id'];

 function build_calendar($month,$year,$con,$id){
    $stmt = $con->prepare("SELECT * FROM appointment_tbl WHERE MONTH(date) = ? AND YEAR(date) = ? AND customerID = ?");
    $stmt->bind_param('ssi',$month,$year,$id);
    $bookings = array();
    if($stmt->execute()){
       $result = $stmt->get_result();
       if($result->num_rows > 0){
           while($row = $result->fetch_assoc()){
               $bookings[]=$row['date'];
           }
           $stmt->close();
       }
    }

    $daysofweek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    $firstdayofmonth = mktime(0,0,0, $month, 1, $year);
    $numberdays = date('t',$firstdayofmonth);
    $dateCompo = getdate($firstdayofmonth);
    $monthName = $dateCompo['month'];
    $dayofweek = $dateCompo['wday'];
    $dateToday = date('Y-m-d');

    $prevmonth = date('m',mktime(0,0,0,$month-1,1,$year));
    $prevyear = date('Y',mktime(0,0,0,$month-1,1,$year));
    $nextmonth = date('m',mktime(0,0,0,$month+1,1,$year));
    $nextyear = date('Y',mktime(0,0,0,$month+1,1,$year));
    $calendar = "<center class='mt-3'><h2>$monthName $year</h2>";
    $calendar.= "<a class='btn btn-dark btn-xs px-3' href='?month=".$prevmonth."&year=".$prevyear."'>&lt;</a>&nbsp;";
    $calendar.= "<a class='btn btn-dark btn-xs px-3' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a>&nbsp;";
    $calendar.= "<a class='btn btn-dark btn-xs px-3' href='?month=".$nextmonth."&year=".$nextyear."'>&gt;</a></center>";
    $calendar.="<br><table class='table table-bordered mt-3'>";
    $calendar.="<tr>";
    foreach($daysofweek as $day){
        $calendar.="<th class='header'>$day</th>";
    }
    $calendar.="</tr><tr>";
    $currentDay = 1;
    if($dayofweek>0){
        for($k=0;$k < $dayofweek; $k++){
            $calendar.="<td class = 'empty'></td>";
        }
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while($currentDay <= $numberdays){
        if($dayofweek==7){
            $dayofweek=0;
            $calendar.="<tr></tr>";
        }
        $currentDayRel = str_pad($currentDay,2,"0",STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('l',strtotime($date)));
        $today = $date == date('Y-m-d') ? 'today' : '';
        if($date<date('Y-m-d')){
            $calendar.="<td class='$today'><h6>".$currentDayRel."</h6><a class='btn btn-danger btn-xs btn-sm disabled' tabindex='-1' role='button' aria-disabled='true'>N/A</a></td>";
        }
        else if(in_array($date, $bookings)){
            $calendar.="<td class='$today'><h6>".$currentDayRel."</h6><a class='btn btn-danger btn-sm btn-xs'>Booked</a></td>";
        }
        else{
            $totalbookings = checkSlots($con, $date);
            if($totalbookings==26){  
                $calendar.="<td class='$today'><h6>".$currentDayRel."</h6><a href='#'class='btn btn-danger btn-sm btn-xs'>Fully Booked</a></td>";
            }
            else{
                $availslots = 26 - $totalbookings;
                $calendar.="<td class='$today'><h6>".$currentDayRel."</h6><a href='appointment-form.php?date=".$date."'class='btn btn-success btn-sm btn-xs'>Book</a><small><i>&nbsp; $availslots slots left</i></small></td>";
            }
        }
        
        $currentDay++;
        $dayofweek++;
    }
    if($dayofweek<7){
        $remaining = 7 - $dayofweek;
        for($i = 0; $i<$remaining;$i++){
            $calendar.="<td class='empty'></td>";
        }
    }
    $calendar.="</tr></table>";
    return $calendar;
 }
 function checkSlots($con, $date){
    $stmt = $con->prepare("SELECT * FROM appointment_tbl WHERE date = ?");
    $stmt->bind_param('s',$date);
    $totalbookings = 0;
    if($stmt->execute()){
       $result = $stmt->get_result();
       if($result->num_rows > 0){
           while($row = $result->fetch_assoc()){
               $totalbookings++;
           }
           $stmt->close();
       }
    }
    return $totalbookings;
 }
?>
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

                echo build_calendar($month,$year,$con,$id);
            ?>
        </div>
    </div>
</div>


<?php include "include/footer.php"; ?>