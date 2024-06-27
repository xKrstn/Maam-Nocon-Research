<?php
include "include/connection.php";
$id = $_GET["aid"];
$sql = "DELETE FROM appointment_tbl WHERE appointID='$id'";
$result = mysqli_query($con, $sql);

if ($result) {
  header("Location: appointment.php?msg=Choose date and time to Rebook");
} else {
  echo "Failed: " . mysqli_error($con);
}
?>
