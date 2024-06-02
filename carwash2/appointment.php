<?php 
 include "include/connection.php";
 include "include/header.php";

 function build_calendar($month,$year){
    $daysofweek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    $firstdayofmonth = mktime(0,0,0, $month, 1, $year);
    $numberdays = date('t',$firstdayofmonth);
    $dateCompo = getdate($firstdayofmonth);
    $monthName = $dateCompo['month'];
    $dayofweek = $dateCompo['wday'];
    $dateToday = date('Y-m-d');
    $calendar = "<center>$monthName $year</center>";
    $prevmonth = date('m',mktime(0,0,0,$month-1,1,$year));
    $prevyear = date('Y',mktime(0,0,0,$month-1,1,$year));
    $nextmonth = date('m',mktime(0,0,0,$month+1,1,$year));
    $nextyear = date('Y',mktime(0,0,0,$month+1,1,$year));
    $calendar = "<center><h2>$monthName $year</h2>";
    $calendar.= "<a class='btn btn-primary btn-xs' href='?month=".$prevmonth."&year=".$prevyear."'>Prev Month</a>";
    $calendar.= "<a class='btn btn-primary btn-xs' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a>";
    $calendar.= "<a class='btn btn-primary btn-xs' href='?month=".$nextmonth."&year=".$nextyear."'>Next Month</a></center>";
    $calendar.="<table class='table table-bordered mt-3'>";
    $calendar.="<tr>";
    foreach($daysofweek as $day){
        $calendar.="<th class='header'>$day</th>";
    }
    return $calendar;
 }
?>
<div class="container">
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

                echo build_calendar($month,$year);
            ?>
        </div>
    </div>
</div>


<?php include "include/footer.php"; ?>