<?php 
    include "../include/connection.php";
    include "../include/staffheader.php";

  if (isset($_GET["apid"])) {
    $appointID = $_GET["apid"];

    // Query to fetch appointment details based on the appointID
    $sql1 = "SELECT a.appointID, c.firstname, c.lastname, c.phonenum, v.vname AS vehicle_type, wt.washtype AS wash_type, st.sname AS service_type, s.price, a.date, a.timeslot, a.mop AS mode_of_payment, a.note
            FROM appointment_tbl a
            INNER JOIN customer_tbl c ON a.customerID = c.customerID
            INNER JOIN vehicle_tbl v ON a.vID = v.vID
            INNER JOIN washtype_tbl wt ON a.wtypeID = wt.wtypeID
            INNER JOIN service_tbl s ON a.servID = s.servID
            INNER JOIN servicetype_tbl st ON s.stypeID = st.stypeID
            WHERE a.appointID = $appointID";

    $result1 = mysqli_query($con, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $row1 = mysqli_fetch_assoc($result1);

        echo '<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
                        </div>
                <div class="modal-body">
                  <form>
                    <div class="mb-3 row">
                      <label for="name" class="col-sm-4 col-form-label">Name:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['firstname'].' '.$row1['lastname'].'" class="form-control-plaintext text-capitalize" name="name">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="phonenum" class="col-sm-4 col-form-label">Contact Number:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['phonenum'].'" class="form-control-plaintext text-capitalize" name="phonenum">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="vehicleType" class="col-sm-4 col-form-label">Vehicle Type:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['vehicle_type'].'" class="form-control-plaintext" name="vehicleType">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="washType" class="col-sm-4 col-form-label">Wash Type:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['wash_type'].'" class="form-control-plaintext" name="washType">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="serviceType" class="col-sm-4 col-form-label">Service Type:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['service_type'].'" class="form-control-plaintext" name="serviceType">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="price" class="col-sm-4 col-form-label">Price:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['price'].'" class="form-control-plaintext" name="price">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="date" class="col-sm-4 col-form-label">Date:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['date'].'" class="form-control-plaintext" name="date">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="timeslot" class="col-sm-4 col-form-label">Timeslot:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly  value="'.$row1['timeslot'].'" class="form-control-plaintext" name="timeslot">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="mode" class="col-sm-4 col-form-label">Mode of Payment:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['mode_of_payment'].'" class="form-control-plaintext" name="mode">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="note" class="col-sm-4 col-form-label">Note:</label>
                      <div class="col-sm-8">
                        <input type="text" readonly value="'.$row1['note'].'" class="form-control-plaintext" name="note">
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>';
    }

  }
?>
<div class="container px-3 pt-4">
<?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
?>
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h3>View Appointments</h3>
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by Name, Vehicle Type, or Date" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-dark">Search</button> &nbsp;
            <a href="admin-appoint.php" class = "btn btn-dark">Reset</a>
        </form>
    </div>
    <table class="table table-hover text-center ">
    <thead class="table-dark align-middle">
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Contact Number</th>
        <th scope="col">Vehicle Type</th>
        <th scope="col">Date</th>
        <th scope="col">Timeslot</th>
        <th scope="col">Option</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT a.appointID, c.customerID, c.firstname, c.lastname, c.phonenum, v.vname AS vehicle_type, wt.washtype AS wash_type, st.sname AS service_type, s.price, a.date, a.timeslot, a.mop AS mode_of_payment, a.note, s.servID
        FROM appointment_tbl a
        INNER JOIN customer_tbl c ON a.customerID = c.customerID
        INNER JOIN vehicle_tbl v ON a.vID = v.vID
        INNER JOIN washtype_tbl wt ON a.wtypeID = wt.wtypeID
        INNER JOIN service_tbl s ON a.servID = s.servID
        INNER JOIN servicetype_tbl st ON s.stypeID = st.stypeID
        WHERE a.status='Booked'";

      if (isset($_GET['search']) && !empty($_GET['search'])) {
          $searchQuery = $_GET['search'];
          $sql .= " AND (CONCAT(c.firstname, ' ', c.lastname) LIKE '%$searchQuery%'
                    OR v.vname LIKE '%$searchQuery%'
                    OR a.date LIKE '%$searchQuery%')";
      }
      
      $sql .= " ORDER BY a.date ASC";
      
      $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr class="align-middle fs-6">
                <td><?php echo $row["appointID"]; ?></td>
                <td class="text-capitalize"><?php echo $row["firstname"] . " " . $row["lastname"]; ?></td>
                <td><?php echo $row["phonenum"]; ?></td>
                <td><?php echo $row["vehicle_type"]; ?></td>
                <td><?php echo $row["date"]; ?></td>
                <td><?php echo $row["timeslot"]; ?></td>
                <td>
                <button type="button" class="btn btn-dark btn-sm viewbtn" data-bs-toggle="modal" data-bs-target="#view" 
                data-appointid="<?php echo $row['appointID']; ?>" 
                data-name="<?php echo $row['firstname'] . ' ' . $row['lastname']; ?>"
                data-phonenum="<?php echo $row['phonenum']; ?>"
                data-vehicletype="<?php echo $row['vehicle_type']; ?>"
                data-washtype="<?php echo $row['wash_type']; ?>"
                data-servicetype="<?php echo $row['service_type']; ?>"
                data-price="<?php echo "PHP " . $row['price']; ?>"
                data-date="<?php echo $row['date']; ?>"
                data-timeslot="<?php echo $row['timeslot']; ?>"
                data-mode="<?php echo $row['mode_of_payment']; ?>"
                data-note="<?php echo $row['note']; ?>">View</button>
                &nbsp;
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
            <label for="phonenum" class="col-sm-4 col-form-label">Contact Number:</label>
            <div class="col-sm-8">
              <input type="text" readonly class="form-control-plaintext text-capitalize" id="phonenum" name="phonenum">
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
    var phonenum = $(this).data('phonenum');
    var vehicleType = $(this).data('vehicletype');
    var washType = $(this).data('washtype');
    var serviceType = $(this).data('servicetype');
    var price = $(this).data('price');
    var date = $(this).data('date');
    var timeslot = $(this).data('timeslot');
    var mode = $(this).data('mode');
    var note = $(this).data('note');

    $('#name').val(name);
    $('#phonenum').val(phonenum);
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

<script>
    // Get the value of the "apid" parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const apid = urlParams.get('apid');

    // Check if the "apid" parameter exists
    if (apid) {
        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
        modal.show();
    }
</script>