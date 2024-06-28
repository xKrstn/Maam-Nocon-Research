<?php 
    include "../include/connection.php";
    include "../include/header.php";
?>

<div class="container px-5 pt-4">
    <h3 class="mb-3">New Request</h3>
    <hr>
    <?php
        $sql = "SELECT a.appointID, c.firstname, c.customerID, a.note, n.date, n.time, n.notifID
                FROM notification_tbl n
                INNER JOIN appointment_tbl a ON n.appointID = a.appointID
                INNER JOIN customer_tbl c ON a.customerID = c.customerID 
                WHERE a.status='Booked' AND n.active='1' ORDER BY n.date DESC, n.time DESC";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="card w-75 mb-3">
        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
        </span>
            <div class="card-body">
                <h5 class="card-title text-capitalize"><span class="text-wrap bg-danger badge">New</span> Appointment From <?php echo htmlspecialchars($row['firstname']); ?></h5>
                <p class="card-text d-inline">Note: <?php echo htmlspecialchars($row['note']); ?></p>
                <div class="mt-3 d-flex">
                    <p class="card-text me-auto p-2 bd-highlight">Created at: <?php echo htmlspecialchars($row['date']).' '.htmlspecialchars($row['time']); ?></p>
                    <div class="d-flex align-items-center">
                        <a href="mark.php?id=<?php echo htmlspecialchars($row['notifID']); ?>" class="btn btn-dark btn-sm">Mark as Read</a>&nbsp;&nbsp;
                        <a href="admin-reply.php?cid=<?php echo htmlspecialchars($row['customerID']); ?>" class="btn btn-dark btn-sm">Reply</a>&nbsp;&nbsp;
                        <a href="admin-appoint.php?apid=<?php echo htmlspecialchars($row['appointID']); ?>" class="btn btn-dark btn-sm">View</a>
                    </div>
                    
                </div>
            </div>
        </div>
    <?php 
            }
        } else {
            echo '<p>No New Appointments</p>';
        }
    ?>
</div>

<div class="container px-5 pt-4">
    <h3 class="mb-3">Read Requests</h3>
    <hr>
    <?php
        $read = "SELECT a.appointID, c.firstname, c.customerID, a.note, n.date, n.time, n.notifID
                FROM notification_tbl n
                INNER JOIN appointment_tbl a ON n.appointID = a.appointID
                INNER JOIN customer_tbl c ON a.customerID = c.customerID 
                WHERE a.status='Booked' AND n.active='0'
                ORDER BY n.date DESC, n.time DESC
                LIMIT 10";

        $result1 = mysqli_query($con, $read);
        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
    ?>
        <div class="card w-75 mb-3">
            <div class="card-body">
                <h5 class="card-title text-capitalize">Appointment From <?php echo htmlspecialchars($row1['firstname']); ?></h5>
                <p class="card-text d-inline">Note: <?php echo htmlspecialchars($row1['note']); ?></p>
                <div class="mt-3 d-flex">
                    <p class="card-text me-auto p-2 bd-highlight">Created at: <?php echo htmlspecialchars($row1['date']).' '.htmlspecialchars($row1['time']); ?></p>
                    <div class="d-flex align-items-center">
                        <a href="admin-reply.php?cid=<?php echo htmlspecialchars($row1['customerID']); ?>" class="btn btn-dark btn-sm">Reply</a>&nbsp;&nbsp;
                        <a href="admin-appoint.php?apid=<?php echo htmlspecialchars($row1['appointID']); ?>" class="btn btn-dark btn-sm">View</a>
                    </div>
                    
                </div>
            </div>
        </div>
    <?php 
            }
        } else {
            echo '<p>No Read Appointments</p>';
        }
    ?>
</div>
    
<?php include "../include/footer.php"; ?>
