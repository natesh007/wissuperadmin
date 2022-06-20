-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 12:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

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
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DeptID` int(11) NOT NULL,
  `BrID` int(11) NOT NULL,
  `DeptName` varchar(255) NOT NULL,
  `DeptRoot` int(55) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `EmpID` varchar(100) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `EmpName` varchar(100) NOT NULL,
  `DeptID` int(11) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `EmailID` varchar(100) NOT NULL,
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
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `CreatedBy` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organization_type`
--

CREATE TABLE `organization_type` (
  `TypeID` int(11) NOT NULL,
  `OrganizationType` varchar(250) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(200) NOT NULL,
  `RoleCode` varchar(100) NOT NULL,
  `Status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `ShID` int(11) NOT NULL,
  `ShType` varchar(100) NOT NULL,
  `ShCode` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DeptID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `AttID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `BrID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DeptID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_type`
--
ALTER TABLE `organization_type`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
