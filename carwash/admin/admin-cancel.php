<?php
include "include/connection.php";
$id = $_GET["aid"];
$sql = "UPDATE appointment_tbl SET status='Cancelled' WHERE appointID='$id'";
$result = mysqli_query($con, $sql);

if ($result) {
  header("Location: admin-appoint.php?msg=Appointment Cancelled Successfully");
} else {
  echo "Failed: " . mysqli_error($con);
}

?>