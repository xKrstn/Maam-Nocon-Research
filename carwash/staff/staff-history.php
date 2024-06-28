<?php 
    include "../include/connection.php";
    include "../include/staffheader.php";
?>
<div class="container px-3 pt-4">
<?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
?>
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3>Appointment History</h3>
      <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-flex">
          <input type="text" name="search" class="form-control me-2" placeholder="Search by Name, Vehicle Type, Wash Type, Date, or Status" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button type="submit" class="btn btn-dark">Search</button> &nbsp;
          <a href="staff-history.php" class = "btn btn-dark">Reset</a>
      </form>
    </div>
    <table class="table table-hover text-center ">
    <thead class="table-dark align-middle">
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Vehicle Type</th>
        <th scope="col">Wash Type</th>
        <th scope="col">Date</th>
        <th scope="col">Timeslot</th>
        <th scope="col">Status</th>
        <th scope="col">Option</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT a.appointID, c.firstname, c.lastname, v.vname AS vehicle_type, wt.washtype AS wash_type, st.sname AS service_type, s.price, a.date, a.timeslot, a.status, a.mop AS mode_of_payment, a.note, s.servID
        FROM appointment_tbl a
        INNER JOIN customer_tbl c ON a.customerID = c.customerID
        INNER JOIN vehicle_tbl v ON a.vID = v.vID
        INNER JOIN washtype_tbl wt ON a.wtypeID = wt.wtypeID
        INNER JOIN service_tbl s ON a.servID = s.servID
        INNER JOIN servicetype_tbl st ON s.stypeID = st.stypeID
        WHERE a.status = 'Completed' OR a.status = 'Cancelled'";

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchQuery = $_GET['search'];
            $sql .= " AND (CONCAT(c.firstname, ' ', c.lastname) LIKE '%$searchQuery%'
                      OR v.vname LIKE '%$searchQuery%'
                      OR wt.washtype LIKE '%$searchQuery%'
                      OR a.date LIKE '%$searchQuery%'
                      OR a.status LIKE '%$searchQuery%')";
        }

        $sql .= " ORDER BY a.date ASC";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr class="align-middle fs-6">
                <td><?php echo $row["appointID"]; ?></td>
                <td class="text-capitalize"><?php echo $row["firstname"] . " " . $row["lastname"]; ?></td>
                <td><?php echo $row["vehicle_type"]; ?></td>
                <td><?php echo $row["wash_type"]; ?></td>
                <td><?php echo $row["date"]; ?></td>
                <td><?php echo $row["timeslot"]; ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td>
                <button type="button" class="btn btn-dark btn-sm viewbtn" data-bs-toggle="modal" data-bs-target="#view" 
                data-appointid="<?php echo $row['appointID']; ?>" 
                data-name="<?php echo $row['firstname'] . ' ' . $row['lastname']; ?>"
                data-vehicletype="<?php echo $row['vehicle_type']; ?>"
                data-washtype="<?php echo $row['wash_type']; ?>"
                data-servicetype="<?php echo $row['service_type']; ?>"
                data-price="<?php echo "PHP " . $row['price']; ?>"
                data-date="<?php echo $row['date']; ?>"
                data-timeslot="<?php echo $row['timeslot']; ?>"
                data-mode="<?php echo $row['mode_of_payment']; ?>"
                data-note="<?php echo $row['note']; ?>">View</button>
                </td>
            </tr>
        <?php
        }
        } else {
        echo '<tr><td colspan="10">No appointments found.</td></tr>';
        }
        ?>
    </tbody>
    </table>

</div>

<!--Modal-->
<div class="modal fade" id="view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Appointment Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3 row">
            <label for="name" class="col-sm-4 col-form-label">Name:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext text-capitalize" id="name" name="name">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="vehicleType" class="col-sm-4 col-form-label">Vehicle Type:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="vehicleType" name="vehicleType">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="washType" class="col-sm-4 col-form-label">Wash Type:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="washType" name="washType">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="serviceType" class="col-sm-4 col-form-label">Service Type:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="serviceType" name="serviceType">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="price" class="col-sm-4 col-form-label">Price:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="price" name="price">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="date" class="col-sm-4 col-form-label">Date:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="date" name="date">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="timeslot" class="col-sm-4 col-form-label">Timeslot:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="timeslot" name="timeslot">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="mode" class="col-sm-4 col-form-label">Mode of Payment:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="mode" name="mode">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="note" class="col-sm-4 col-form-label">Note:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext" id="note" name="note">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include "../include/stafffooter.php";?>

<script>
$(document).ready(function() {
  $(document).on('click', '.viewbtn', function() {
    var appointID = $(this).data('appointid');
    var name = $(this).data('name');
    var vehicleType = $(this).data('vehicletype');
    var washType = $(this).data('washtype');
    var serviceType = $(this).data('servicetype');
    var price = $(this).data('price');
    var date = $(this).data('date');
    var timeslot = $(this).data('timeslot');
    var mode = $(this).data('mode');
    var note = $(this).data('note');

    $('#name').val(name);
    $('#vehicleType').val(vehicleType);
    $('#washType').val(washType);
    $('#serviceType').val(serviceType);
    $('#price').val(price);
    $('#date').val(date);
    $('#timeslot').val(timeslot);
    $('#mode').val(mode);
    $('#note').val(note);
  });
});
</script>