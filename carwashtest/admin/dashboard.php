<?php 
    include "../include/connection.php";
    include "../include/header.php";

    date_default_timezone_set('Asia/Manila');

    $date = date('Y-m-d');

    $appointToday = "SELECT COUNT(*) as total 
                           FROM `appointment_tbl` 
                           WHERE status = 'Booked' AND date = '$date'";

    $resultToday = $con->query($appointToday);
    $rowToday = $resultToday->fetch_assoc();
    $today = $rowToday['total'];
    
    $customer = "SELECT COUNT(*) as total 
                           FROM `customer_tbl` 
                           WHERE customerID";

    $resultcustomer = $con->query($customer);
    $rowcustomer = $resultcustomer->fetch_assoc();
    $customertotal = $rowcustomer['total'];
    
    $staff = "SELECT COUNT(*) as total 
                           FROM `staff_tbl` 
                           WHERE staffID";

    $resultstaff = $con->query($staff);
    $rowstaff = $resultstaff->fetch_assoc();
    $stafftotal = $rowstaff['total'];

    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $endOfWeek = date('Y-m-d', strtotime('sunday this week'));

    $appointThisWeek = "SELECT COUNT(*) as total 
                        FROM `appointment_tbl` 
                        WHERE status = 'Completed' AND date BETWEEN '$startOfWeek' AND '$endOfWeek'";

    $resultThisWeek = $con->query($appointThisWeek);
    $rowThisWeek = $resultThisWeek->fetch_assoc();
    $thisWeek = $rowThisWeek['total'];

    $query = "SELECT st.sname, COUNT(a.servID) as total 
          FROM appointment_tbl a
          INNER JOIN service_tbl s ON a.servID = s.servID
          INNER JOIN servicetype_tbl st ON s.stypeID = st.stypeID
          GROUP BY st.stypeID";

    $result = $con->query($query);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row['sname'], (int)$row['total']];
    }

    $data_json = json_encode($data);

    $weeklyData = [];
    for ($i = 3; $i >= 0; $i--) {
        $startDate = date('Y-m-d', strtotime("-$i week"));
        $endDate = date('Y-m-d', strtotime("-$i week +6 days"));

        $sql = "SELECT COUNT(*) as total
                FROM `appointment_tbl`
                WHERE `date` BETWEEN '$startDate' AND '$endDate'
                AND status IN ('Booked', 'Cancelled', 'Completed')";

        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        $weeklyData[] = [$i + 1, $row['total']]; 
    }
?>
<div class="container px-5 pt-4 d-flex">
    <div class="card border-dark mx-3 d-inline text-center shadow" style="width: 15rem;">
        <div class="card-header"></div>
        <div class="card-body text-dark">
            <h5 class="card-title">Appointments Today</h5>
            <div class="mt-4">
                <strong><p class="card-text fs-1"><?php echo $today; ?></p></strong>  
            </div> 
        </div>
    </div>
    <div class="card border-dark mx-3 d-inline text-center shadow" style="width: 15rem;">
        <div class="card-header"></div>
        <div class="card-body text-dark">
            <h5 class="card-title">Appointments Completed (per week)</h5>
            <div class="mt-2">
                <strong><p class="card-text fs-1"><?php echo $thisWeek; ?></p></strong>  
            </div> 
        </div>
    </div>
    <div class="card border-dark mx-3 d-inline text-center shadow" style="width: 15rem;">
        <div class="card-header"></div>
        <div class="card-body text-dark">
            <h5 class="card-title">Registered Users</h5>
            <div class="mt-4">
                <strong><p class="card-text fs-1"><?php echo $customertotal; ?></p></strong>  
            </div> 
        </div>
    </div>
    <div class="card border-dark mx-3 d-inline text-center shadow" style="width: 15rem;">
        <div class="card-header"></div>
        <div class="card-body text-dark">
            <h5 class="card-title">No. of Staff</h5>
            <div class="mt-4">
                <strong><p class="card-text fs-1"><?php echo $stafftotal; ?></p></strong>  
            </div> 
        </div>
    </div>
</div>
<div class="container px-5 pt-4">
    <div class="card rounded-3 shadow">
        <div class="card-body d-flex flex-wrap justify-content-center">
            <div id="piechart" class="me-3 mb-3" style="width: 800px; height: 400px;"></div>
        </div>
    </div>
</div>


<?php include "../include/footer.php"; ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Service Type', 'Count'],
      <?php
      foreach($data as $d) {
        echo "['" . $d[0] . "', " . $d[1] . "],";
      }
      ?>
    ]);

    var options = {
      title: 'Percentage of Availing Service Types'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>
