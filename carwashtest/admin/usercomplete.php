<?php
include "../include/connection.php";
$id = $_GET["id"];
$sql = "UPDATE appointment_tbl SET status='Completed' WHERE appointID='$id'";
$result = mysqli_query($con, $sql);

if ($result) {
  header("Location: admin-appoint.php?msg=Appointment Completed Successfully");
} else {
  echo "Failed: " . mysqli_error($con);
}

?>