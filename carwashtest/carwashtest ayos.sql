-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 05:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carwashtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_tbl`
--

CREATE TABLE `appointment_tbl` (
  `appointID` int(10) UNSIGNED NOT NULL,
  `customerID` int(11) UNSIGNED NOT NULL,
  `wtypeID` int(11) UNSIGNED NOT NULL,
  `vID` int(11) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `timeslot` varchar(20) NOT NULL,
  `mop` varchar(20) NOT NULL,
  `note` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_tbl`
--

CREATE TABLE `customer_tbl` (
  `customerID` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phonenum` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tbl`
--

INSERT INTO `customer_tbl` (`customerID`, `firstname`, `lastname`, `username`, `email`, `phonenum`, `password`) VALUES
(1, 'adrian jensen', 'enriquez', 'damoji', 'adrian@gmail.com', '061045105', '$2y$10$xvbNrQ1YBc9G5CjEMk7F.eW78/DfxwrbNrtD8oOTqiqdDDCKr1JWa');

-- --------------------------------------------------------

--
-- Table structure for table `manager_tbl`
--

CREATE TABLE `manager_tbl` (
  `mID` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicetype_tbl`
--

CREATE TABLE `servicetype_tbl` (
  `stypeID` int(11) NOT NULL,
  `sname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicetype_tbl`
--

INSERT INTO `servicetype_tbl` (`stypeID`, `sname`) VALUES
(1, 'Basic Wash'),
(2, 'Carwash'),
(3, 'Deep Cleaning'),
(4, 'Interior Detailing'),
(5, 'Exterior Detailing'),
(6, 'Package A'),
(7, 'Package B'),
(8, 'Package C'),
(9, 'Package D');

-- --------------------------------------------------------

--
-- Table structure for table `service_tbl`
--

CREATE TABLE `service_tbl` (
  `servID` int(11) UNSIGNED NOT NULL,
  `stypeID` int(11) UNSIGNED NOT NULL,
  `wtypeID` int(11) UNSIGNED NOT NULL,
  `sizeID` int(11) UNSIGNED NOT NULL,
  `price` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_tbl`
--

INSERT INTO `service_tbl` (`servID`, `stypeID`, `wtypeID`, `sizeID`, `price`) VALUES
(1, 1, 1, 1, '100'),
(2, 1, 1, 2, '120'),
(3, 1, 1, 3, '150'),
(4, 1, 1, 4, '180'),
(5, 2, 1, 1, '130'),
(6, 2, 1, 2, '150'),
(7, 2, 1, 3, '180'),
(8, 2, 1, 4, '210'),
(9, 3, 1, 1, '2000'),
(10, 3, 1, 2, '3000'),
(11, 3, 1, 3, '4000'),
(12, 3, 1, 4, '5000'),
(13, 4, 2, 1, '3500'),
(14, 4, 2, 2, '4000'),
(15, 4, 2, 3, '5500'),
(16, 4, 2, 4, '6000'),
(17, 5, 2, 1, '3000'),
(18, 5, 2, 2, '4500'),
(19, 5, 2, 3, '5000'),
(20, 5, 2, 4, '6000'),
(21, 6, 3, 1, '450'),
(22, 6, 3, 2, '500'),
(23, 6, 3, 3, '550'),
(24, 6, 3, 4, '600'),
(25, 7, 3, 1, '560'),
(26, 7, 3, 2, '660'),
(27, 7, 3, 3, '700'),
(28, 7, 3, 4, '760'),
(29, 8, 3, 1, '660'),
(30, 8, 3, 2, '700'),
(31, 8, 3, 3, '780'),
(32, 8, 3, 4, '900'),
(33, 9, 3, 1, '1300'),
(34, 9, 3, 2, '1400'),
(35, 9, 3, 3, '1500'),
(36, 9, 3, 4, '1600');

-- --------------------------------------------------------

--
-- Table structure for table `size_tbl`
--

CREATE TABLE `size_tbl` (
  `sizeID` int(11) UNSIGNED NOT NULL,
  `size` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size_tbl`
--

INSERT INTO `size_tbl` (`sizeID`, `size`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `staff_tbl`
--

CREATE TABLE `staff_tbl` (
  `staffID` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phonenum` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_tbl`
--

INSERT INTO `staff_tbl` (`staffID`, `firstname`, `lastname`, `username`, `phonenum`, `password`, `status`) VALUES
(1, 'robrto', 'par', 'robert', '0912123', '$2y$10$Mim5/9yvTKZC.CIyKNt4..RsiqjMaieaJnoVffnM5TvyAubrOAGkm', '');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_tbl`
--

CREATE TABLE `vehicle_tbl` (
  `vID` int(3) UNSIGNED NOT NULL,
  `vname` varchar(50) NOT NULL,
  `sizeID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_tbl`
--

INSERT INTO `vehicle_tbl` (`vID`, `vname`, `sizeID`) VALUES
(1, 'Sedan', 1),
(2, 'Pickup', 4),
(3, 'Van', 4),
(4, 'AUV', 2),
(5, 'SUV', 3);

-- --------------------------------------------------------

--
-- Table structure for table `washtype_tbl`
--

CREATE TABLE `washtype_tbl` (
  `wtypeID` int(11) UNSIGNED NOT NULL,
  `washtype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `washtype_tbl`
--

INSERT INTO `washtype_tbl` (`wtypeID`, `washtype`) VALUES
(1, 'Basic Carwash'),
(2, 'Detailing'),
(3, 'Package');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_tbl`
--
ALTER TABLE `appointment_tbl`
  ADD PRIMARY KEY (`appointID`);

--
-- Indexes for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `manager_tbl`
--
ALTER TABLE `manager_tbl`
  ADD PRIMARY KEY (`mID`);

--
-- Indexes for table `servicetype_tbl`
--
ALTER TABLE `servicetype_tbl`
  ADD PRIMARY KEY (`stypeID`);

--
-- Indexes for table `service_tbl`
--
ALTER TABLE `service_tbl`
  ADD PRIMARY KEY (`servID`);

--
-- Indexes for table `size_tbl`
--
ALTER TABLE `size_tbl`
  ADD PRIMARY KEY (`sizeID`);

--
-- Indexes for table `staff_tbl`
--
ALTER TABLE `staff_tbl`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `vehicle_tbl`
--
ALTER TABLE `vehicle_tbl`
  ADD PRIMARY KEY (`vID`);

--
-- Indexes for table `washtype_tbl`
--
ALTER TABLE `washtype_tbl`
  ADD PRIMARY KEY (`wtypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_tbl`
--
ALTER TABLE `appointment_tbl`
  MODIFY `appointID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  MODIFY `customerID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manager_tbl`
--
ALTER TABLE `manager_tbl`
  MODIFY `mID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicetype_tbl`
--
ALTER TABLE `servicetype_tbl`
  MODIFY `stypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_tbl`
--
ALTER TABLE `service_tbl`
  MODIFY `servID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `size_tbl`
--
ALTER TABLE `size_tbl`
  MODIFY `sizeID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_tbl`
--
ALTER TABLE `staff_tbl`
  MODIFY `staffID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle_tbl`
--
ALTER TABLE `vehicle_tbl`
  MODIFY `vID` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `washtype_tbl`
--
ALTER TABLE `washtype_tbl`
  MODIFY `wtypeID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
