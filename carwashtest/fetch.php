<?php
include 'include/connection.php';

// Get POST data
$wid = $_POST['wid']; // washtype ID
$vid = $_POST['vid']; // vehicle ID

// SQL query to fetch service types based on wash type and vehicle size
$sql = "SELECT st.sname, s.price
        FROM service_tbl s
        INNER JOIN servicetype_tbl st ON s.stypeID = st.stypeID
        WHERE s.wtypeID = $wid
        AND s.sizeID = (SELECT sizeID FROM vehicle_tbl WHERE vID = $vid);";

$result = mysqli_query($con, $sql);

// Check if query was successful
if ($result) {
    // Build options for service select dropdown
    $options = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . $row['servID'] . '">' . $row['sname'] . ' - PHP ' . $row['price'] . '</option>';
    }
    echo $options;
} else {
    echo '<option value="">No services available</option>';
}

mysqli_close($con);
?>
