-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2022 at 05:59 AM
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
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `BKID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BID` int(11) NOT NULL,
  `BlockName` varchar(100) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`BKID`, `OrgID`, `BID`, `BlockName`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 1, 2, 'block11', 1, 1, '2022-07-16 11:32:19', 1, '2022-07-16 11:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `BrID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `CityID` int(11) NOT NULL,
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

INSERT INTO `branches` (`BrID`, `OrgID`, `CityID`, `BrName`, `Address`, `BrLangitude`, `BrLatitude`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 1, 1, 'Kukatpally', 'Hyderabad', '213123333', '4324324444', 1, 1, '2022-06-22 06:45:00', 1, '2022-06-28 05:31:31'),
(2, 1, 1, 'Kompally', 'Hyderabad', '234324', '3424', 1, 1, '2022-06-22 06:46:07', 1, '2022-06-28 05:31:40'),
(4, 4, 1, 'hyderbad', 'test', '1.2', '1.3', 1, 1, '2022-07-06 10:12:53', 1, '2022-07-06 10:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `BID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BrID` int(11) NOT NULL,
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

INSERT INTO `building` (`BID`, `OrgID`, `BrID`, `BuildingName`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(2, 1, 1, 'Yuvanava', 1, 1, '2022-06-24 01:20:27', 1, '2022-06-27 05:01:45'),
(3, 1, 1, 'Jain', 1, 1, '2022-06-24 03:14:14', 1, '2022-07-15 13:53:02'),
(4, 4, 1, 'Srinivasa', 1, 1, '2022-06-24 03:14:21', 1, '2022-06-27 05:02:29'),
(5, 1, 1, 'building block1', 1, 1, '2022-07-14 10:33:59', 1, '2022-07-15 13:18:16'),
(6, 1, 1, 'asasa', 1, 1, '2022-07-14 10:40:24', 1, '2022-07-14 10:40:24'),
(9, 4, 4, 'SDSAD', 1, 1, '2022-07-15 13:36:27', 1, '2022-07-15 13:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `CityID` int(11) NOT NULL,
  `CityName` varchar(255) NOT NULL,
  `Langitude` varchar(255) NOT NULL,
  `Latitude` varchar(100) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`CityID`, `CityName`, `Langitude`, `Latitude`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Hyderabad', '1.2', '1.3', 1, 1, '2022-06-28 02:40:12', 1, '2022-06-28 02:43:28'),
(2, 'Chennai', '1.2', '1.3', 1, 1, '2022-06-28 02:40:30', 1, '2022-06-28 02:40:30'),
(3, 'Delhi', '1.3', '1.2', 1, 1, '2022-06-28 02:40:44', 1, '2022-06-28 02:40:44'),
(4, 'Mumbai', '1.3', '2.3', 1, 1, '2022-06-28 02:41:02', 1, '2022-06-28 02:41:02'),
(5, 'Kolakata', '1.3', '1.7', 1, 1, '2022-06-28 02:41:17', 1, '2022-06-28 02:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `complaintcategory`
--

CREATE TABLE `complaintcategory` (
  `ComCatID` int(11) NOT NULL,
  `CategoryName` varchar(200) NOT NULL,
  `CategoryIcon` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaintcategory`
--

INSERT INTO `complaintcategory` (`ComCatID`, `CategoryName`, `CategoryIcon`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Heating/ Cooling', 'writable/uploads/category/SzvhOaWb-1658070668.png', 1, 1, '2022-07-17 08:34:26', 1, '2022-07-17 10:11:28'),
(2, 'Cleanliness', 'writable/uploads/category/JaIyetPd-1658065000.png', 1, 1, '2022-07-17 08:36:40', 1, '2022-07-17 08:36:40'),
(3, 'Water', 'writable/uploads/category/aI5fw7G3-1658065038.png', 1, 1, '2022-07-17 08:37:18', 1, '2022-07-17 08:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `complaintcategoryorganizations`
--

CREATE TABLE `complaintcategoryorganizations` (
  `ComCatOrgID` int(11) NOT NULL,
  `ComCatID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaintcategoryorganizations`
--

INSERT INTO `complaintcategoryorganizations` (`ComCatOrgID`, `ComCatID`, `OrgID`, `CreatedDate`) VALUES
(3, 2, 1, '2022-07-17 08:36:40'),
(4, 2, 13, '2022-07-17 08:36:40'),
(5, 3, 4, '2022-07-17 08:37:18'),
(12, 1, 1, '2022-07-17 10:11:29'),
(13, 1, 4, '2022-07-17 10:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `complaintnature`
--

CREATE TABLE `complaintnature` (
  `ComNatID` int(11) NOT NULL,
  `ComplaintNature` varchar(200) NOT NULL,
  `ComCatID` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaintnature`
--

INSERT INTO `complaintnature` (`ComNatID`, `ComplaintNature`, `ComCatID`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Temperature Too Hot', 1, 1, 1, '2022-07-17 11:33:39', 1, '2022-07-17 11:33:39'),
(2, 'water problem', 3, 1, 1, '2022-07-17 11:40:14', 1, '2022-07-17 11:40:25');

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
(7, 0, 1, 1, 'Supervisor', 1, 1, '2022-06-27 04:47:02', 1, '2022-07-14 15:42:29'),
(9, 1, 1, 1, 'Senior Electrician', 1, 1, '2022-06-27 06:04:24', 1, '2022-07-14 14:34:14'),
(10, 1, 1, 1, 'Junior Electrician', 1, 1, '2022-06-27 06:04:54', 1, '2022-06-27 06:04:54'),
(11, 1, 1, 1, 'DG Operator', 1, 1, '2022-06-27 06:05:34', 1, '2022-06-27 06:05:34'),
(19, 7, 1, 1, 'Senior Supervisor', 1, 1, '2022-06-27 07:36:34', 1, '2022-06-27 07:36:34'),
(20, 7, 1, 1, 'Junior Supervisor', 1, 1, '2022-06-27 07:36:50', 1, '2022-06-27 07:36:50'),
(21, 0, 1, 1, 'Admin', 1, 1, '2022-06-30 05:24:27', 1, '2022-06-30 05:24:27'),
(22, 21, 1, 1, 'ITAdmin', 1, 1, '2022-06-30 05:24:48', 1, '2022-06-30 05:24:48'),
(24, 0, 4, 4, 'test', 1, 1, '2022-07-06 11:35:04', 1, '2022-07-06 11:35:04'),
(25, 0, 1, 1, 'Plumber', 1, 1, '2022-07-06 11:35:18', 1, '2022-07-13 16:26:42'),
(26, 0, 1, 1, 'Janitor ', 1, 1, '2022-07-13 11:40:38', 1, '2022-07-13 11:40:38'),
(27, 0, 1, 1, 'test', 1, 1, '2022-06-30 05:24:48', 1, '2022-06-30 05:24:48'),
(28, 27, 1, 1, 'test12346', 1, 1, '2022-07-14 15:42:54', 1, '2022-07-14 16:42:39'),
(29, 7, 1, 2, 'Testing L1', 1, 1, '2022-07-14 15:44:14', 1, '2022-07-14 15:44:14'),
(30, 0, 1, 1, 'test', 1, 1, '2022-07-14 15:48:34', 1, '2022-07-14 15:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `employeebranches`
--

CREATE TABLE `employeebranches` (
  `EmpBrID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `BrID` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employeebranches`
--

INSERT INTO `employeebranches` (`EmpBrID`, `EmpID`, `BrID`, `CreatedDate`) VALUES
(5, 2, 1, '2022-07-08 10:46:25'),
(6, 2, 2, '2022-07-08 10:46:25'),
(32, 15, 2, '2022-07-08 18:53:22'),
(39, 22, 1, '2022-07-12 12:20:05'),
(40, 22, 2, '2022-07-12 12:20:05'),
(41, 23, 1, '2022-07-12 12:20:30'),
(42, 23, 2, '2022-07-12 12:20:30'),
(43, 24, 1, '2022-07-12 12:22:46'),
(44, 24, 2, '2022-07-12 12:22:46'),
(61, 25, 1, '2022-07-12 15:36:05'),
(62, 25, 2, '2022-07-12 15:36:05'),
(65, 26, 1, '2022-07-12 15:40:39'),
(66, 26, 2, '2022-07-12 15:40:39'),
(69, 1, 1, '2022-07-13 19:09:52'),
(70, 14, 1, '2022-07-13 19:41:33'),
(71, 14, 2, '2022-07-13 19:41:33'),
(72, 27, 1, '2022-07-13 19:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmpID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `EmpName` varchar(100) NOT NULL,
  `DeptID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `JobTID` int(11) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `EmailID` varchar(100) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Address` text NOT NULL,
  `Contact` varchar(15) NOT NULL,
  `JobType` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `DateOfJoining` date NOT NULL,
  `PreviousExp` varchar(100) NOT NULL,
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

INSERT INTO `employees` (`EmpID`, `RoleID`, `EmpName`, `DeptID`, `OrgID`, `JobTID`, `Gender`, `EmailID`, `Password`, `Address`, `Contact`, `JobType`, `City`, `DateOfJoining`, `PreviousExp`, `Doc`, `ProfilePic`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 0, 'aparna', 20, 1, 2, 'F', 'aparna@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsad', '76544367', 'Permanent', '', '2022-06-07', '', '', '', 1, 1, '2022-07-07 08:50:24', 1, '2022-07-13 19:09:52'),
(2, 0, 'emp1', 10, 1, 4, 'F', 'emp1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'dfdf', '98765432', 'permanent', '', '2022-03-11', '', '', '', 1, 1, '2022-07-07 09:08:05', 1, '2022-07-07 09:13:37'),
(14, 0, 'Lakshmi', 22, 1, 4, 'F', 'lakshmi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lakhsmi', '7878787878', 'JH', '', '2021-07-08', '2', '', '', 1, 0, '2022-07-08 18:25:50', 1, '2022-07-13 19:41:33'),
(15, 0, 'Lakshmi Bonthu', 9, 1, 4, '', 'lakshmi123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '8978675645', '', '', '2021-03-14', '', '', '', 1, 0, '2022-07-08 18:53:22', 0, '2022-07-08 18:53:22'),
(20, 0, 'test123', 11, 1, 7, 'M', 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'test', '12345678', 'permanent', '', '2022-07-01', '', '', '', 1, 1, '2022-07-11 18:22:24', 1, '2022-07-11 18:22:24'),
(21, 0, 'dsds', 19, 1, 7, 'M', 'sdsdsd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'test', '324324', 'permanent', '', '2022-07-01', '', '', '', 1, 1, '2022-07-11 19:02:44', 1, '2022-07-11 19:02:44'),
(22, 0, 'emp2', 20, 1, 2, 'F', 'a44@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsad', '76544367', 'Permanent', '', '2022-06-07', '', '', '', 1, 1, '2022-07-12 12:20:05', 1, '2022-07-12 12:20:05'),
(23, 0, 'emp2', 20, 1, 2, 'F', 'a444@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsad', '76544367', 'Permanent', '', '2022-06-07', '', '', '', 1, 1, '2022-07-12 12:20:30', 1, '2022-07-12 12:20:30'),
(24, 0, 'emp2', 26, 1, 2, 'F', 'emp4@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsad', '76544367', 'Permanent', '', '2022-06-07', '1', '', '', 1, 1, '2022-07-12 12:22:46', 1, '2022-07-12 12:22:46'),
(25, 0, 'emp2', 25, 1, 2, 'F', 'a44@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsad', '76544367', 'Permanent', '', '2022-06-07', '2', '', '', 1, 1, '2022-07-12 14:24:15', 1, '2022-07-12 15:36:05'),
(26, 0, 'Lakkhsmi', 19, 1, 4, 'F', 'lakshmi1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'lAKHSMI', '677', 'jhjh', '', '2022-07-13', '', '', '', 1, 1, '2022-07-12 14:55:49', 1, '2022-07-12 15:40:39'),
(27, 0, 'aparna', 20, 1, 2, 'F', 'aparna123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'sadsad', '76544367', 'Permanent', '', '2022-06-07', '2', '', '', 1, 1, '2022-07-13 19:48:58', 1, '2022-07-13 19:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `ExeID` int(11) NOT NULL,
  `Experience` float NOT NULL,
  `Exp_Desc` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`ExeID`, `Experience`, `Exp_Desc`) VALUES
(1, 0, '0 Year'),
(2, 0.5, '6 Months'),
(3, 1, '1 Year'),
(4, 2, '2 Years'),
(5, 3, '3 Years'),
(6, 4, '4 Years'),
(7, 5, '5 Years'),
(8, 6, '6 Years'),
(9, 7, '7 Years'),
(10, 8, '8 Years'),
(11, 8, '9 Years');

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
(6, 4, 4, 'f1', 1, 1, '2022-06-24 03:52:01', 0, '2022-06-27 05:54:41'),
(10, 1, 7, 'floor2', 1, 1, '2022-07-15 13:10:31', 1, '2022-07-15 13:10:31'),
(31, 4, 9, 'SADSAD', 1, 1, '2022-07-15 13:40:26', 1, '2022-07-15 13:40:26'),
(32, 1, 3, 'f2', 1, 1, '2022-07-15 13:53:02', 1, '2022-07-15 13:53:02'),
(33, 1, 3, 'f1', 1, 1, '2022-07-15 13:53:03', 1, '2022-07-15 13:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobtitle`
--

CREATE TABLE `jobtitle` (
  `JobTID` int(11) NOT NULL,
  `JobTitle` varchar(200) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobtitle`
--

INSERT INTO `jobtitle` (`JobTID`, `JobTitle`, `OrgID`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(2, 'ITAdmin', 1, 1, 1, '2022-07-07 06:10:20', 1, '2022-07-07 06:14:08'),
(3, 'CEO', 1, 1, 1, '2022-07-07 06:10:30', 1, '2022-07-07 06:10:30'),
(4, 'CTO', 1, 1, 1, '2022-07-07 06:10:38', 1, '2022-07-07 06:10:38'),
(5, 'Accountant', 1, 1, 1, '2022-07-07 06:10:46', 1, '2022-07-07 06:10:46'),
(6, 'Receptionist', 1, 1, 1, '2022-07-07 06:10:59', 1, '2022-07-07 06:10:59'),
(7, 'Supervisor', 1, 1, 1, '2022-07-07 06:11:06', 1, '2022-07-07 06:11:06'),
(9, 'ITAdmin', 4, 1, 1, '2022-07-07 06:29:09', 1, '2022-07-07 06:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `OrgID` int(11) NOT NULL,
  `OrgName` varchar(255) NOT NULL,
  `OrgType` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`OrgID`, `OrgName`, `OrgType`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Apollo', 1, 1, 1, '2022-06-22 05:22:16', 1, '2022-06-27 04:49:17'),
(4, 'FirstMedic', 1, 1, 1, '2022-06-22 05:26:35', 1, '2022-06-27 04:49:32'),
(13, 'MedPlus', 1, 1, 1, '2022-06-28 03:50:01', 1, '2022-06-28 04:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `organizationcities`
--

CREATE TABLE `organizationcities` (
  `OcID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `CityID` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizationcities`
--

INSERT INTO `organizationcities` (`OcID`, `OrgID`, `CityID`, `CreatedDate`) VALUES
(15, 13, 1, '2022-06-28 04:36:45'),
(16, 13, 3, '2022-06-28 04:36:45');

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
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BID` int(11) NOT NULL,
  `FID` int(11) NOT NULL,
  `RoomName` varchar(200) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`RID`, `OrgID`, `BID`, `FID`, `RoomName`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 1, 2, 2, 'room1', 1, 1, '2022-06-27 07:23:07', 1, '2022-06-27 07:23:07'),
(13, 1, 7, 10, '201', 1, 1, '2022-07-15 13:10:31', 1, '2022-07-15 13:10:31'),
(14, 1, 7, 10, '202', 1, 1, '2022-07-15 13:10:32', 1, '2022-07-15 13:10:32'),
(15, 1, 7, 10, '203', 1, 1, '2022-07-15 13:10:32', 1, '2022-07-15 13:10:32'),
(60, 4, 9, 31, 'SADSA', 1, 1, '2022-07-15 13:40:26', 1, '2022-07-15 13:40:26'),
(61, 4, 9, 31, 'aaaaaaaaa', 1, 1, '2022-07-15 13:40:26', 1, '2022-07-15 13:40:26'),
(62, 1, 3, 32, 'room2', 1, 1, '2022-07-15 13:53:02', 1, '2022-07-15 13:53:02');

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
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`BKID`);

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
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`CityID`);

--
-- Indexes for table `complaintcategory`
--
ALTER TABLE `complaintcategory`
  ADD PRIMARY KEY (`ComCatID`);

--
-- Indexes for table `complaintcategoryorganizations`
--
ALTER TABLE `complaintcategoryorganizations`
  ADD PRIMARY KEY (`ComCatOrgID`);

--
-- Indexes for table `complaintnature`
--
ALTER TABLE `complaintnature`
  ADD PRIMARY KEY (`ComNatID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DeptID`);

--
-- Indexes for table `employeebranches`
--
ALTER TABLE `employeebranches`
  ADD PRIMARY KEY (`EmpBrID`);

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
-- Indexes for table `jobtitle`
--
ALTER TABLE `jobtitle`
  ADD PRIMARY KEY (`JobTID`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`OrgID`);

--
-- Indexes for table `organizationcities`
--
ALTER TABLE `organizationcities`
  ADD PRIMARY KEY (`OcID`);

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
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`RID`);

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
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `BKID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `BrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `BID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaintcategory`
--
ALTER TABLE `complaintcategory`
  MODIFY `ComCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaintcategoryorganizations`
--
ALTER TABLE `complaintcategoryorganizations`
  MODIFY `ComCatOrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `complaintnature`
--
ALTER TABLE `complaintnature`
  MODIFY `ComNatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DeptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `employeebranches`
--
ALTER TABLE `employeebranches`
  MODIFY `EmpBrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `fcmtokens`
--
ALTER TABLE `fcmtokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `jobtitle`
--
ALTER TABLE `jobtitle`
  MODIFY `JobTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `organizationcities`
--
ALTER TABLE `organizationcities`
  MODIFY `OcID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `ShID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
