<?php
include '../include/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceTypeID = $_POST['serviceTypeID'];

    $sql = "SELECT s.sizeID, s.size
            FROM size_tbl s
            INNER JOIN service_tbl serv ON s.sizeID = serv.sizeID
            WHERE serv.stypeID = $serviceTypeID";
    $result = mysqli_query($con, $sql);

    $options = '<option value="" hidden>Select an option</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . $row['sizeID'] . '">' . $row['size'] . '</option>';
    }

    echo $options;
}
?>