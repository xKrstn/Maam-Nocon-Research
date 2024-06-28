<?php 
    include "../include/connection.php";
    include "../include/header.php";

    date_default_timezone_set('Asia/Manila');

    if (isset($_GET['cid'])) {
        $customerID = intval($_GET['cid']); 
        $sql = "SELECT firstname FROM customer_tbl WHERE customerID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $customerID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $firstname = htmlspecialchars($row['firstname']);
        } else {
            echo "<p class='mx-3'>Customer not found.</p>";
            exit;
        }
        $stmt->close();
    } else {
        echo "<p class='mx-3'>No customer ID provided.</p>";
        exit;
    }

    if (isset($_POST['submit'])) {
        $message = $_POST['message'];
        $customerID = intval($_POST['customerID']);
        
        $active = 1;
        $createdDate = date('Y-m-d');
        $createdTime = date('h:iA');

        $stmt = $con->prepare("INSERT INTO message_tbl (`customerID`, `message`, `active`, `date`, `time`) VALUES (?,?,?,?,?)");
        $stmt->bind_param('isiss', $customerID, $message, $active, $createdDate, $createdTime);
        if ($stmt->execute()) {
            echo "<script>window.location='admin-appoint.php?msg=Message sent to $firstname';</script>";
        } else {
            echo "<p>Failed to send message.</p>";
        }
        $stmt->close();
    }
?>
<div class="ms-4 px-3 pt-4 ">
    <div class="container mb-4">
        <div class="mb-3">
            <h3>Message Recipient</h3>
        </div>
        <form method="post" style="width:30vw; min-width:300px;">
            <input type="hidden" name="customerID" value="<?php echo $customerID; ?>">
        <h5 class="text-capitalize">To: <?php echo $firstname; ?></h5>
            <div class="form-floating my-3">
                <textarea class="form-control" name="message" placeholder="Leave a message here" id="floatingTextarea" style="resize:none; height: 200px;" required></textarea>
                <label for="floatingTextarea">Message Here</label>
            </div>           
            <div>
                <button type="submit" class="btn btn-dark" name="submit">Send</button>
            </div>
        </form>
    </div>
</div>

<?php 
    include "../include/footer.php";
?>
