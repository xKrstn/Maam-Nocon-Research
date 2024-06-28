<?php 
    include "include/connection.php";
    include "include/userheader.php";

    $id = $_SESSION['id'];
?>

<div class="container px-5 pt-4">
    <h3 class="mb-3">New Messages</h3>
    <hr>
    <?php
        $sql = "SELECT * FROM message_tbl WHERE active='1' AND customerID = '$id'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="card w-75 mb-3">
        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
        </span>
            <div class="card-body">
                <h5 class="card-title text-capitalize"><span class="text-wrap bg-danger badge">New</span> Message From Admin</h5>
                <p class="card-text d-inline">Message: <?php echo htmlspecialchars($row['message']); ?></p>
                <div class="mt-3 d-flex">
                    <p class="card-text me-auto p-2 bd-highlight">Sent at: <?php echo htmlspecialchars($row['date']).' '.htmlspecialchars($row['time']); ?></p>
                    <div class="d-flex align-items-center">
                        <a href="usermark.php?id=<?php echo htmlspecialchars($row['msgID']); ?>" class="btn btn-dark btn-sm">Mark as Read</a>
                    </div>            
                </div>
            </div>
        </div>
    <?php 
            }
        } else {
            echo '<p>No New Messages</p>';
        }
    ?>
</div>

<div class="container px-5 pt-4">
    <h3 class="mb-3">Read Messages</h3>
    <hr>
    <?php
        $read = "SELECT * FROM message_tbl WHERE active='0' ORDER BY date DESC, time DESC LIMIT 5";

        $result1 = mysqli_query($con, $read);
        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
    ?>
        <div class="card w-75 mb-3">
            <div class="card-body">
                <h5 class="card-title text-capitalize">Message From Admin</h5>
                <p class="card-text d-inline">Message: <?php echo htmlspecialchars($row1['message']); ?></p>
                <div class="mt-3 d-flex">
                    <p class="card-text me-auto p-2 bd-highlight">Sent at: <?php echo htmlspecialchars($row1['date']).' '.htmlspecialchars($row1['time']); ?></p>           
                </div>
            </div>
        </div>
    <?php 
            }
        } else {
            echo '<p>No Read Messages</p>';
        }
    ?>
</div>
    
<?php include "include/userfooter.php"; ?>
