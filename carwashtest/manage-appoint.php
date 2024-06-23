<?php 
    include 'include/connection.php';
    include 'include/userheader.php';
?>

<div class="mb-4">
  <h3>Manage Appointments</h3>
</div>
<table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Wash Type</th>
          <th scope="col">Vehicle Type</th>
          <th scope="col">Date</th>
          <th scope="col">Timeslot</th>
          <th scope="col">Mode of Payment</th>
          <th scope="col">Note</th>
          <th scope="col">Status</th>
          <th scope="col">Option</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM staff_tbl";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["staffID"] ?></td>
            <td><?php echo $row["firstname"] ?></td>
            <td><?php echo $row["lastname"] ?></td>
            <td><?php echo $row["username"] ?></td>
            <td><?php echo $row["phonenum"] ?></td>
            <td>
              <a href="update.php?id=<?php echo $row["staffID"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a onclick="return confirm('Are you sure you want to delete this record?')" href="delete.php?id=<?php echo $row["staffID"] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

</div>