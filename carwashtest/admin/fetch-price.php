<?php
include '../include/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sizeID = $_POST['sizeID'];
    $serviceTypeID = $_POST['serviceTypeID'];
    $washTypeID = $_POST['washTypeID'];

    $sql = "SELECT s.price
            FROM service_tbl s
            INNER JOIN washtype_tbl wt ON s.wtypeID = wt.wtypeID
            WHERE s.stypeID = $serviceTypeID AND s.sizeID = $sizeID AND s.wtypeID = $washTypeID";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['price'];
    } else {
        echo '';
    }
}
?>