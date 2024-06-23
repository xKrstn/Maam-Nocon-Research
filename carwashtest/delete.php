<?php
include "include/connection.php";
$id = $_GET["id"];
$sql = "DELETE FROM staff_tbl WHERE staffID = '$id'";
$result = mysqli_query($con, $sql);

if ($result) {
  header("Location: admin.php?msg=Data deleted Successfully");
} else {
  echo "Failed: " . mysqli_error($con);
}