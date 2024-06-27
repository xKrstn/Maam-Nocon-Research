<?php

function checkAccess($requiredType) {
    if (!isset($_SESSION['type'])) {
        echo '<script> alert("You must be logged in to view this page"); 
                   window.location="/carwashtest/registration/login.html"; 
        </script>';
        exit();
    }

    $sessionType = $_SESSION['type'];

    if ($sessionType !== $requiredType) {
        switch ($sessionType) {
            case 'a':
                header("Location: /carwashtest/admin/dashboard.php");
                break;
            case 's':
                header("Location: /carwashtest/staff/staff-home.php");
                break;
            case 'c':
            default:
                header("Location: /carwashtest/customer-home.php");
                break;
        }
        exit();
    }
}
?>
