-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 15, 2023 at 06:58 PM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u765675535_mechanicShop`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_table`
--

CREATE TABLE `car_table` (
  `carID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `make` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(4) NOT NULL,
  `vin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `engine` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderID` int(11) NOT NULL,
  `lastOrderDate` int(11) DEFAULT NULL,
  `picture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

CREATE TABLE `customer_table` (
  `customerID` int(11) NOT NULL,
  `firstName` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`customerID`, `firstName`, `lastName`, `phone`, `email`) VALUES
(1, 'Steve', 'Jobs', '9051119999', 'steve.jobs@apple.com');

-- --------------------------------------------------------

--
-- Table structure for table `note_table`
--

CREATE TABLE `note_table` (
  `noteID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `person` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `title` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `finished` tinyint(1) NOT NULL DEFAULT 0,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateBegun` datetime DEFAULT NULL,
  `dateCompleted` datetime DEFAULT NULL,
  `parts` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_table`
--
ALTER TABLE `car_table`
  ADD PRIMARY KEY (`carID`),
  ADD KEY `car_cons_order_custID` (`customerID`),
  ADD KEY `car_cons_note_orderID` (`orderID`);

--
-- Indexes for table `customer_table`
--
ALTER TABLE `customer_table`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `note_table`
--
ALTER TABLE `note_table`
  ADD PRIMARY KEY (`noteID`),
  ADD KEY `note_cons_car_orderID` (`orderID`);

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `ot_cons_car_custID` (`customerID`),
  ADD KEY `ot_cons_car_carID` (`carID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car_table`
--
ALTER TABLE `car_table`
  ADD CONSTRAINT `car_cons_customer_custID` FOREIGN KEY (`customerID`) REFERENCES `customer_table` (`customerID`),
  ADD CONSTRAINT `car_cons_note_orderID` FOREIGN KEY (`orderID`) REFERENCES `note_table` (`orderID`),
  ADD CONSTRAINT `car_cons_order_custID` FOREIGN KEY (`customerID`) REFERENCES `order_table` (`customerID`),
  ADD CONSTRAINT `car_cons_order_orderID` FOREIGN KEY (`orderID`) REFERENCES `order_table` (`orderID`);

--
-- Constraints for table `note_table`
--
ALTER TABLE `note_table`
  ADD CONSTRAINT `note_cons_car_orderID` FOREIGN KEY (`orderID`) REFERENCES `car_table` (`orderID`),
  ADD CONSTRAINT `note_cons_order_orderID` FOREIGN KEY (`orderID`) REFERENCES `order_table` (`orderID`);

--
-- Constraints for table `order_table`
--
ALTER TABLE `order_table`
  ADD CONSTRAINT `ot_cons_car_carID` FOREIGN KEY (`carID`) REFERENCES `car_table` (`carID`),
  ADD CONSTRAINT `ot_cons_car_custID` FOREIGN KEY (`customerID`) REFERENCES `car_table` (`customerID`),
  ADD CONSTRAINT `ot_cons_customer_custID` FOREIGN KEY (`customerID`) REFERENCES `customer_table` (`customerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
