<?php
include "include/connection.php";

// SQL query to fetch data
$sql1 = "SELECT * FROM service_tbl s
        INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
        WHERE s.stypeID = '6' ORDER BY s.sizeID ASC";

$sql2 = "SELECT * FROM service_tbl s
        INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
        WHERE s.stypeID = '7' ORDER BY s.sizeID ASC";

$sql3 = "SELECT * FROM service_tbl s
        INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
        WHERE s.stypeID = '8' ORDER BY s.sizeID ASC";

$sql4 = "SELECT * FROM service_tbl s
INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
WHERE s.stypeID = '9' ORDER BY s.sizeID ASC";

$sql5 = "SELECT * FROM service_tbl s
INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
WHERE s.stypeID = '1' ORDER BY s.sizeID ASC";

$sql6 = "SELECT * FROM service_tbl s
INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
WHERE s.stypeID = '2' ORDER BY s.sizeID ASC";

$sql7 = "SELECT * FROM service_tbl s
INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
WHERE s.stypeID = '3' ORDER BY s.sizeID ASC";

$sql8 = "SELECT * FROM service_tbl s
INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
WHERE s.stypeID = '4' ORDER BY s.sizeID ASC";

$sql9 = "SELECT * FROM service_tbl s
INNER JOIN size_tbl sz ON s.sizeID = sz.sizeID
WHERE s.stypeID = '5' ORDER BY s.sizeID ASC";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="homepage/homepage.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <title>Carwash Admin</title>
</head>
<body>
    <header>
        <nav class="navbar" id="nav">
            <img src="img/jcl logo.jpg" alt="JCL Logo" class="logo-image">
            <ul class="links" id="links">
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <a href="registration/reg.html"><button class="hm-btn">Sign In</button></a>
                    <!--<div class="login-btn-container">
                        <a href="registration/login.html"><button class="login-btn">LOGIN</button></a>
                    </div>-->
            </ul>
        </nav>
    </header>
    <section class="home" id="home">
            <div class="home-content">
                <h1>Get Your Car Clean</h1>
                <p>At JCL Carwash and Detailing, we believe your vehicle deserves the best care possible. Located conveniently in the heart of the city, our state-of-the-art facility is designed to cater to all your car cleaning needs with precision and professionalism.</p>
                <div class="header-btn">
                </div>
            </div>
    </section>
    <section class="about" id="about">
        <div class="about1">
            <div class="text">
                <h2>About The Shop</h2>
                <p>Welcome to JCL Carwash, your trusted choice in vehicle care since our opening five months ago. We operate daily from 7 am to 8 pm, ensuring your car receives the highest quality service every visit. Count on us for expert cleaning and detailing to keep your vehicle looking its best.</p>
            </div>
            <div class="loc">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1932.247149584772!2d120.8577957348602!3d14.39864535769065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33962dedf234a507%3A0x2992a1128a8f5da5!2sJCL%20Carwash%20and%20Food%20Corner!5e0!3m2!1sen!2sph!4v1719131756528!5m2!1sen!2sph" width="500" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <section class="services" id="services">
        <h1>Our Services</h1>
        <div class="container">
            
            <div class="service">
                <div class="service-details">
                    <h2>Package A</h2>
                    <h3>Services</h3>
                    <ul>
                        <li>CAR WASH</li>
                        <li>ARMOR ALL</li>
                        <li>HAND WAX</li>
                    </ul>
                </div>
                <div class="service-details1">
                    <h3>Sizes</h3>
                    <?php 
                    $result1 = mysqli_query($con, $sql1);
                    if(mysqli_num_rows($result1)>0){
                        while($row = mysqli_fetch_assoc($result1)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="service">
                <div class="service-details">
                    <h2>Package B</h2>
                    <h3>Services</h3>
                    <ul>
                        <li>CAR WASH</li>
                        <li>ARMOR ALL</li>
                        <li>BUFFING WAX</li>
                    </ul>
                </div>
                <div class="service-details1">
                    <h3>Sizes</h3>
                    <?php 
                    $result2 = mysqli_query($con, $sql2);
                    if(mysqli_num_rows($result2)>0){
                        while($row = mysqli_fetch_assoc($result2)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="service">
                <div class="service-details">
                    <h2>Package C</h2>
                    <h3>Services</h3>
                    <ul>
                        <li>CARWASH</li>
                        <li>ARMOR ALL</li>
                        <li>BACK TO ZERO</li>
                    </ul>
                </div>
                <div class="service-details1">
                    <h3>Sizes</h3>
                    <?php 
                    $result3 = mysqli_query($con, $sql3);
                    if(mysqli_num_rows($result3)>0){
                        while($row = mysqli_fetch_assoc($result3)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="service">
                <div class="service-details">
                    <h2>Package D</h2>
                    <h3>Services</h3>
                    <ul>
                        <li>CARWASH</li>
                        <li>ARMOR ALL</li>
                        <li>HAND WAX</li>
                        <li>ENGINE WASH</li>
                        <li>BACK TO ZERO</li>
                    </ul>
                </div>
                <div class="service-details">
                    <h3>Sizes</h3>
                    <?php 
                    $result4 = mysqli_query($con, $sql4);
                    if(mysqli_num_rows($result4)>0){
                        while($row = mysqli_fetch_assoc($result4)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
        <h1>Other Services</h1>
        <div class="container1">
            <div class="service1">
                <div class="service-details1">
                    <h3>Basic Wash</h3>
                    <?php 
                    $result5 = mysqli_query($con, $sql5);
                    if(mysqli_num_rows($result5)>0){
                        while($row = mysqli_fetch_assoc($result5)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="service1">
                <div class="service-details1">
                <h3>Car Wash</h3>
                    <?php 
                    $result6 = mysqli_query($con, $sql6);
                    if(mysqli_num_rows($result6)>0){
                        while($row = mysqli_fetch_assoc($result6)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="service1">
                <div class="service-details1">
                    <h3>Deep Cleaning</h3>
                    <?php 
                    $result7 = mysqli_query($con, $sql7);
                    if(mysqli_num_rows($result7)>0){
                        while($row = mysqli_fetch_assoc($result7)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                    
                </div>
            </div>
            <div class="service1">
                <div class="service-details1">
                <h3>Interior Detailing</h3>
                    <?php 
                    $result8 = mysqli_query($con, $sql8);
                    if(mysqli_num_rows($result8)>0){
                        while($row = mysqli_fetch_assoc($result8)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="service1">
                <div class="service-details1">
                <h3>Exterior Detailing</h3>
                    <?php 
                    $result9 = mysqli_query($con, $sql9);
                    if(mysqli_num_rows($result9)>0){
                        while($row = mysqli_fetch_assoc($result9)){
                    ?>
                    <ul class="sizes">
                        <li><?php echo $row['size'].' - '. $row['price'] ?></li>
                    </ul>
                    <?php 
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="contact" id="contact">
        <h2>Get in Touch</h2>
        <h6>Want to get in touch? We'd love to hear from you.<br/>Here's how you can reach us...</h6>
        <div class="containers">
            <div class="contact-info">
                <div class="icon">
                    <img src="img/phone1.png" class="icons">
                    <h6>Phone Number</h6>
                    <p>Interested on our services? Just pick up the phone to the chat with a staff of us</p>
                    <h5>0969 021 3868</h5>
                </div>
            </div>
            <div class="contact-info">
                <div class="icon">
                    <img src="img/fb1.png" class="icons">
                    <h6>Facebook Page</h6>
                    <p>Directly Message Us At</p>
                    <div class="link1">
                        <a href="https://www.facebook.com/profile.php?id=61555060306137" class="link">https://www.facebook.com/profile.php?id=61555060306137</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <ul class="foot">
            <li class="n-item"><a href="#nav">Home</a></li>
            <li class="n-item"><a href="#about">About</a></li>
            <li class="n-item"><a href="#services">Services</a></li>
            <li class="n-item"><a href="#contact">Contact</a></li>
        </ul>
        <p>2024, JCL Carwash and Food Corner</p>
    </footer>
</body>
<script src="homepage/homepage.js"></script>
</html>