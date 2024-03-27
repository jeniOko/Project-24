-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 11:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mgeni`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `departmentID` varchar(120) NOT NULL,
  `department` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departmentID`, `department`) VALUES
('Dept001', 'Administration'),
('Dept003', 'Customer Service'),
('Dept002', 'Finance'),
('Dept004', 'Registry');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `ID` int(20) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `created at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`ID`, `name`, `email`, `subject`, `message`, `created at`) VALUES
(1, 'MWANA NJAA', 'mwananjaa@gmail.com', 'postponed appointment', '1234', '2024-03-25 16:29:40'),
(2, 'MWANA NJAA', 'mwananjaa@gmail.com', 'postponed appointment', '1234', '2024-03-25 16:44:13');

-- --------------------------------------------------------

--
-- Stand-in structure for view `purpose`
-- (See below for the actual view)
--
CREATE TABLE `purpose` (
`name` varchar(42)
,`purpose` varchar(100)
,`date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `sajili`
--

CREATE TABLE `sajili` (
  `VisitorID` int(42) NOT NULL,
  `username` varchar(42) NOT NULL,
  `name` varchar(120) NOT NULL,
  `identification` varchar(120) NOT NULL,
  `email` varchar(42) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `password` varchar(42) NOT NULL,
  `otp` varchar(20) NOT NULL,
  `createdAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sajili`
--

INSERT INTO `sajili` (`VisitorID`, `username`, `name`, `identification`, `email`, `phone`, `gender`, `password`, `otp`, `createdAt`) VALUES
(1, 'admin', 'The Admiministrator', '111111', 'trial@localhost.com', '0712345678', 'female', 'admin', 'otp', '2024-03-11'),
(3, 'mimi', '', '', 'mimi@mail.com', '0712345678', '', 'mimi2', 'otp', '2024-03-11'),
(4, 'mzee mwala', '', '222333', 'mwala@localhost.com', '0711114758', 'male', 'mwala', 'otp', '2024-03-18'),
(6, 'Tunde', '', '', 'Ttunde@gmail.com', '0789890089', '', 'Tunde1234', '694176', '2024-03-20'),
(8, 'Wing', '', '', 'wing@localhost.com', '0744114400', '', 'wingman', 'otp', '2024-03-20'),
(10, 'Mjaa', '', '', 'mwananjaa@gmail.com', '0715487963', '', 'mwenyenjaa', '632204', '2024-03-25');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(20) NOT NULL,
  `name` text NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `department` varchar(120) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `name`, `gender`, `email`, `phone`, `department`, `username`, `password`, `created at`) VALUES
(1, 'Mwenye Goods ', 'male', 'mrgoods@localhost.com', '0785588558', 'Registry', 'Mr goods', 'goods', '2024-03-25 00:46:14'),
(2, 'Pesa Mingi', 'female', 'mapesa@localhost.com', '0710010066', 'Finance', 'Mapesa', '1000K', '2024-03-25 00:46:14'),
(3, 'Smiley Face', 'female', 'smiley@localhost.com', '0780880822', 'Customer service', 'smiley', 'smile4me', '2024-03-25 00:46:14'),
(4, 'Knows All', 'male', 'knowitall@localhost.com', '0791199900', 'Administration', 'admin', 'admin', '2024-03-25 00:46:14'),
(5, 'Fungua Mlango', 'male', 'fungua@gmail.com', '0700099909', 'security', 'Fungua', 'openthedoor', '2024-03-25 07:38:03');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statID` varchar(200) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `status` varchar(20) NOT NULL,
  `updatesAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `username` varchar(120) NOT NULL,
  `VisitorID` int(42) NOT NULL,
  `identification` varchar(20) NOT NULL,
  `name` varchar(42) NOT NULL,
  `company` varchar(42) NOT NULL,
  `email` varchar(42) NOT NULL,
  `phone` int(13) NOT NULL,
  `ArrivalDate` date NOT NULL,
  `expectedArrival` time NOT NULL,
  `departmentID` varchar(120) NOT NULL,
  `department` varchar(120) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `host` varchar(42) NOT NULL,
  `vehicle` varchar(20) NOT NULL,
  `card` varchar(120) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL,
  `comment` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`username`, `VisitorID`, `identification`, `name`, `company`, `email`, `phone`, `ArrivalDate`, `expectedArrival`, `departmentID`, `department`, `purpose`, `host`, `vehicle`, `card`, `date`, `status`, `comment`) VALUES
('', 0, '', 'trial five', 'cocacola', 'trial5@localhost.com', 2147483647, '0000-00-00', '17:07:42', '', '', 'delivery of goods', 'Mr Fanta', '', '', '2024-03-11', 'Cancelled', ''),
('', 0, '', 'trial six', 'G4S', 'trialsix@g4s.com', 711117777, '0000-00-00', '17:10:23', '', '', 'pick up parcels', 'Mr Goods', '', '', '2024-03-11', 'Cancelled', ''),
('', 0, '', 'trial six', 'G4S', 'trialsix@g4s.com', 711117777, '0000-00-00', '17:11:43', '', '', 'pick up parcels', 'Mr Goods', '', '', '2024-03-11', 'Cancelled', ''),
('', 0, '10101010', 'John Doe', 'peppa', 'trialten@localhost.com', 711447788, '0000-00-00', '12:42:02', '', 'Administration', 'peppa pig', 'Mr Goods', 'KBQ191J', '', '2024-03-12', 'Cancelled', ''),
('', 0, '10101010', 'John Doe', 'peppa', 'trialten@localhost.com', 711447788, '0000-00-00', '00:00:00', '', 'Administration', 'peppa pig', 'Mrs Dee', 'KBQ191J', '', '2024-03-12', 'Cancelled', ''),
('', 0, '10101010', 'John Doe', 'peppa', 'trialten@localhost.com', 711447788, '2024-03-12', '07:08:00', '', 'Administration', 'peppa pig', 'Mrs Dee', 'KBQ191J', '', '2024-03-12', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-15', '12:12:00', '', 'Registry', 'delivery', 'Mr Goods', '', '', '2024-03-15', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-18', '17:50:00', '', 'Registry', 'delivery', 'Mr Goods', 'KBQ191J', '', '2024-03-18', 'Cancelled', ''),
('', 0, '11111111111', 'jane doe', 'coke', 'janedoe@localhost.com', 2147483647, '2024-03-18', '18:51:00', '', 'Registry', 'delivery', 'Mr Goods', 'KBQ191J', '', '2024-03-18', 'Cancelled', ''),
('', 0, '', 'trial four', '', 'trial@localhost.com', 712345678, '0000-00-00', '16:51:01', '', '', 'fee balance', '', '', '', '2024-03-11', 'Cancelled', ''),
('', 0, '', 'trial four', '', 'trial@localhost.com', 712345678, '0000-00-00', '17:05:26', '', '', 'fee balance', '', '', '', '2024-03-11', 'Cancelled', ''),
('', 0, '', 'trial four', '', 'trial@localhost.com', 712345678, '0000-00-00', '17:06:14', '', '', 'fee balance', '', '', '', '2024-03-11', 'Cancelled', ''),
('admin', 0, '222333', 'Angaza Juu', '', 'angaza@localhost.com', 722332233, '2024-03-21', '14:52:00', '', 'Customer care', 'inquiry', '', '', '', '2024-03-20', 'Cancelled', ''),
('admin', 0, '222333', 'Angaza Juu', '', 'angaza@localhost.com', 722332233, '2024-03-20', '14:00:00', '', 'Customer care', 'inquiry', '', '', '', '2024-03-20', 'Cancelled', ''),
('admin', 1, '111111', 'The Administrator', '', '', 0, '2024-03-24', '20:32:57', '', 'Finance', 'transfer test case', '', '', '', '2024-03-24', '', ''),
('admin', 1, '111111', 'The Administrator', '', '', 711111111, '2024-03-24', '20:32:57', '', 'Finance', 'transfer test case', '', '', '', '2024-03-24', '', ''),
('admim', 1, '111111', 'The Administrator', '', '', 0, '2024-03-25', '20:32:57', '', 'Finance', 'transfer test case', '', '', '', '2024-03-25', 'penfing', ''),
('Mjaa', 0, '', '', '', 'mwananjaa@gmail.com', 715487963, '2024-03-26', '08:00:00', '', 'Customer Service', 'presentation', '', '', '', '2024-03-25', '', '');

-- --------------------------------------------------------

--
-- Structure for view `purpose`
--
DROP TABLE IF EXISTS `purpose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `purpose`  AS SELECT `visitors`.`name` AS `name`, `visitors`.`purpose` AS `purpose`, `visitors`.`date` AS `date` FROM `visitors` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`departmentID`),
  ADD UNIQUE KEY `departmentname` (`department`),
  ADD UNIQUE KEY `department` (`department`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sajili`
--
ALTER TABLE `sajili`
  ADD PRIMARY KEY (`VisitorID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sajili`
--
ALTER TABLE `sajili`
  MODIFY `VisitorID` int(42) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
