-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 01:50 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AID`, `Name`, `Email`, `Password`, `Role`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Admin', 'admin@wis.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 1, '2021-04-08 09:30:42', 1, '2021-08-24 06:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE `attendence` (
  `AttID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `CheckInTime` datetime NOT NULL,
  `CheckOutTime` datetime NOT NULL,
  `Shift` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `BrID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BrName` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `BrLangitude` varchar(255) NOT NULL,
  `BrLatitude` varchar(100) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`BrID`, `OrgID`, `BrName`, `Address`, `BrLangitude`, `BrLatitude`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 1, 'Kukatpally', 'Hyderabad', '213123333', '4324324444', 1, 1, '2022-06-22 06:45:00', 1, '2022-06-27 04:50:18'),
(2, 1, 'Kompally', 'Hyderabad', '234324', '3424', 1, 1, '2022-06-22 06:46:07', 1, '2022-06-27 04:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `BID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BuildingName` varchar(100) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`BID`, `OrgID`, `BuildingName`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(2, 1, 'Yuvanava', 1, 1, '2022-06-24 01:20:27', 1, '2022-06-27 05:01:45'),
(3, 1, 'Jain', 1, 1, '2022-06-24 03:14:14', 1, '2022-06-27 05:02:02'),
(4, 4, 'Srinivasa', 1, 1, '2022-06-24 03:14:21', 1, '2022-06-27 05:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DeptID` int(11) NOT NULL,
  `ParentDept` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BrID` int(11) NOT NULL,
  `DeptName` varchar(255) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DeptID`, `ParentDept`, `OrgID`, `BrID`, `DeptName`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 0, 1, 2, 'Electrician', 1, 1, '2022-06-22 08:08:32', 1, '2022-06-27 04:47:36'),
(7, 0, 1, 1, 'Supervisor', 1, 1, '2022-06-27 04:47:02', 1, '2022-06-27 04:47:02'),
(9, 1, 1, 1, 'Senior Electrician', 1, 1, '2022-06-27 06:04:24', 1, '2022-06-27 06:04:24'),
(10, 1, 1, 1, 'Junior Electrician', 1, 1, '2022-06-27 06:04:54', 1, '2022-06-27 06:04:54'),
(11, 1, 1, 1, 'DG Operator', 1, 1, '2022-06-27 06:05:34', 1, '2022-06-27 06:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmpID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `EmpName` varchar(100) NOT NULL,
  `DeptID` int(11) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `EmailID` varchar(100) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Address` text NOT NULL,
  `Contact` varchar(15) NOT NULL,
  `JobType` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `DateOfJoining` date NOT NULL,
  `Doc` text NOT NULL,
  `ProfilePic` text NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmpID`, `RoleID`, `EmpName`, `DeptID`, `Gender`, `EmailID`, `Password`, `Address`, `Contact`, `JobType`, `City`, `DateOfJoining`, `Doc`, `ProfilePic`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 2, 'aparnaaa', 5, '', 'aparna@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsd', '98765432', 'dff', 'hyd', '2022-06-14', '', '', 1, 1, '2022-06-24 06:00:42', 1, '2022-06-24 13:00:00'),
(3, 1, 'emp1', 1, 'M', 'emp1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'wewqe', '123456', 'weqwe', 'hyd', '0000-00-00', '', '', 1, 1, '2022-06-24 12:37:22', 1, '2022-06-24 12:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `fcmtokens`
--

CREATE TABLE `fcmtokens` (
  `id` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `Token` int(11) NOT NULL,
  `CreatedDate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `FID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BID` int(11) NOT NULL,
  `FloorName` varchar(200) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`FID`, `OrgID`, `BID`, `FloorName`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(2, 1, 2, 'f1', 1, 1, '2022-06-24 03:47:05', 1, '2022-06-24 03:47:05'),
(3, 1, 3, 'f2', 1, 1, '2022-06-24 03:47:29', 1, '2022-06-24 03:47:29'),
(5, 1, 3, 'f1', 1, 1, '2022-06-24 03:49:24', 0, '2022-06-27 05:54:34'),
(6, 4, 4, 'f1', 1, 1, '2022-06-24 03:52:01', 0, '2022-06-27 05:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `OrgID` int(11) NOT NULL,
  `OrgName` varchar(255) NOT NULL,
  `OrgType` int(11) NOT NULL,
  `Address` text NOT NULL,
  `Langitude` varchar(100) NOT NULL,
  `Latitude` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`OrgID`, `OrgName`, `OrgType`, `Address`, `Langitude`, `Latitude`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Apollo', 1, 'Hyderabad,500067', '12333', '321111', 1, 1, '2022-06-22 05:22:16', 1, '2022-06-27 04:49:17'),
(4, 'FirstMedic', 1, 'Hyderabad', '987', '767', 1, 1, '2022-06-22 05:26:35', 1, '2022-06-27 04:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `organization_type`
--

CREATE TABLE `organization_type` (
  `TypeID` int(11) NOT NULL,
  `OrganizationType` varchar(250) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization_type`
--

INSERT INTO `organization_type` (`TypeID`, `OrganizationType`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Hospital', 1, 1, '2022-06-20 05:36:20', 1, '2022-06-27 04:09:30'),
(3, 'Hotels', 1, 1, '2022-06-20 05:42:55', 1, '2022-06-27 04:09:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `Priority` int(11) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` tinyint(4) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`, `Priority`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'admin', 1, 1, 0, '2021-07-01 20:54:40', 0, '2022-06-17 05:46:53'),
(2, 'employee', 2, 1, 1, '2022-06-17 05:55:58', 1, '2022-06-17 05:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `ShID` int(11) NOT NULL,
  `ShType` varchar(100) NOT NULL,
  `ShCode` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`ShID`, `ShType`, `ShCode`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Morningsd', 'M', 1, 1, '2022-06-20 04:09:13', 1, '2022-06-20 05:40:50'),
(2, 'Afternoon', 'A', 1, 1, '2022-06-20 04:09:27', 0, '2022-06-20 04:19:13'),
(3, 'Night', 'N', 0, 1, '2022-06-20 04:09:36', 0, '2022-06-20 04:19:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`AttID`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`BrID`);

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`BID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DeptID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmpID`);

--
-- Indexes for table `fcmtokens`
--
ALTER TABLE `fcmtokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`FID`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`OrgID`);

--
-- Indexes for table `organization_type`
--
ALTER TABLE `organization_type`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`ShID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `AttID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `BrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `BID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DeptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fcmtokens`
--
ALTER TABLE `fcmtokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organization_type`
--
ALTER TABLE `organization_type`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `ShID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
