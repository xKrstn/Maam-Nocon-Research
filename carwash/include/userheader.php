<?php 
    include "include/session.php";
    include "access.php";
    checkAccess('c');

    $sql = "SELECT * FROM customer_tbl WHERE customerID=".$_SESSION['id']."";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $unique = $_SESSION['id'];

    $count_sql = "SELECT COUNT(*) as total_active_booked 
                  FROM message_tbl 
                  WHERE active='1' AND customerID = '$unique'";

    $count_result = mysqli_query($con, $count_sql);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_active_booked = $count_row['total_active_booked'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="include/user.css">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="include/admin.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">

  <!-- Jquery -->
   <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
   <script src="jquery/jquery.min.js"></script>
  <title> Carwash Users</title>

  <style>
        #notification {
            background: #f8f9fa;
            border: 1px solid #ced4da;
            padding: 20px;
            margin: 20px;
            border-radius: 4px;
        }
        .appointment {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .appointment:last-child {
            border-bottom: none;
        }
        .today{
            background-color: grey;
        }
    </style>
</head>
<body>
<div class="main-container d-flex">
  <div class="sidebar" id="sidenav">
      <div class="header-box px-3 pt-3 pb-4 d-flex justify-content-between">
          <h1 class="fs-4 ms-2"><span class="text-white">JCL Carwash & Detailing</span>
          </h1>
      </div>
      <ul class="list-unstyled px-2">
          <li class="active"><a href="#" class="text-decoration-none d-block px-3 py-2"><i class="fa-solid fa-house"></i> Home</a></li>
          <li class=""><a href="appointment.php" class="text-decoration-none d-block px-3 py-2"><i class="fa-regular fa-calendar-days"></i> Appointments</a></li>
          <li class=""><a href="manage-appoint.php" class="text-decoration-none d-block px-3 py-2"><i class="fa-regular fa-calendar-check"></i> My Appointments</a></li>
          <li class=""><a href="user-history.php" class="text-decoration-none d-block px-3 py-2"><i class="fa-solid fa-clock-rotate-left"></i> Appointment History</a></li>
          <li class=""><a href="user-notification.php" class="text-decoration-none d-block px-3 py-2 d-flex justify-content-between">
              <span><i class="fa-regular fa-bell"></i> Notification</span>
              <span class="bg-danger rounded-pill text-white py-0 px-2"><?php echo $total_active_booked; ?></span>
          </a>
          </li>
          <li class=""><a href="usersettings.php" class="text-decoration-none d-block px-3 py-2"><i class="fa-solid fa-gear"></i> Settings</a></li>
      </ul>
      <hr class="h-color mx-2">
      <div class="sidebar-footer">
          <ul class="list-unstyled px-2">
            <li class=""><a href="logout.php" class="text-decoration-none d-block px-3 py-2">
              <i class="fa-solid fa-right-from-bracket"></i>
              <span>Logout</span>
          </a></li> 
          </ul>
      </div>
  </div>
  <div class="content">
      <nav class="navbar navbar-expand-md navbar-light bg-light">
          <div class="container-fluid">
              <div class="d-flex justify-content-between d-md-none d-block">
              <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
                  <a class="navbar-brand fs-4" href="#"><span class="bg-dark rounded px-2 py-0 text-white"></span></a>
                
              </div>
              <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                  aria-expanded="false" aria-label="Toggle navigation">
                  <i class="fal fa-bars"></i>
              </button>
              <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                  <ul class="navbar-nav mb-2 mb-lg-0">
                      <li class="nav-item">
                          <a class="nav-link active text-capitalize" aria-current="page" href="#"><i class="fa-solid fa-user"></i> <?php echo $row['firstname'] ?></a>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
  