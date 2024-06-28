<?php
include '../include/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $washTypeID = $_POST['washTypeID'];

    $sql = "SELECT st.stypeID, st.sname
            FROM servicetype_tbl st
            INNER JOIN service_tbl s ON st.stypeID = s.stypeID
            WHERE s.wtypeID = $washTypeID
            GROUP BY st.stypeID, st.sname";
    $result = mysqli_query($con, $sql);

    $options = '<option value="" hidden>Select an option</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . $row['stypeID'] . '">' . $row['sname'] . '</option>';
    }

    echo $options;
}
?>