-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2022 at 07:16 AM
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
(15, 20, 1, 'Kukatpally', 'Hyderabad', '78.3871934', '17.4891957', 1, 1, '2022-08-18 23:22:26', 1, '2022-08-18 23:22:26'),
(16, 20, 1, 'Jubilee Hills', 'Hyderabad', '78.392219', '17.4310624', 1, 1, '2022-08-18 23:23:43', 1, '2022-08-18 23:23:43'),
(17, 20, 3, 'Dwaraka Sector 11', 'Delhi', '77.0456569', '28.5906064', 1, 1, '2022-08-18 23:25:20', 1, '2022-08-18 23:25:20'),
(18, 20, 4, 'Worli', 'Mumbai', '72.8037475', '19.0039292', 1, 1, '2022-08-18 23:26:23', 1, '2022-08-18 23:26:23'),
(19, 20, 4, 'Bandra', 'Mumbai', '72.8208781', '19.0544788', 1, 1, '2022-08-18 23:27:23', 1, '2022-08-18 23:27:23');

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
(12, 20, 15, 'Cancer Block', 1, 1, '2022-08-19 02:16:11', 1, '2022-08-19 06:54:45'),
(13, 20, 15, 'International Block ', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(14, 20, 15, 'Main Block', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28');

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
(1, 'Hyderabad', '1.2', '1.3', 1, 1, '2022-06-28 02:40:12', 0, '2022-08-17 06:51:43'),
(2, 'Chennai', '1.2', '1.3', 1, 1, '2022-06-28 02:40:30', 0, '2022-08-17 06:51:43'),
(3, 'Delhi', '1.3', '1.2', 1, 1, '2022-06-28 02:40:44', 0, '2022-08-17 06:51:43'),
(4, 'Mumbai', '1.3', '2.3', 1, 1, '2022-06-28 02:41:02', 0, '2022-08-17 06:51:43'),
(5, 'Kolkatta', '1.3', '1.7', 1, 1, '2022-06-28 02:41:17', 0, '2022-08-17 06:51:43'),
(6, 'Vijayawada ', '80°38\'52.86\"E', '16°30\'22.23\"N ', 1, 1, '2022-08-10 00:05:05', 0, '2022-08-17 06:51:43'),
(7, 'visakhapatnam', '83°19\'22.16', '17°43\'27.33', 1, 1, '2022-08-10 01:45:15', 0, '2022-08-17 06:51:43');

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
(19, 'Electrical', 'writable/uploads/category/6JkNIClA-1660893473.svg', 1, 1, '2022-08-19 00:49:32', 1, '2022-08-19 02:17:53'),
(20, 'Air Conditioning', 'writable/uploads/category/8UH34EgD-1660893511.svg', 1, 1, '2022-08-19 00:50:19', 1, '2022-08-19 02:18:31'),
(21, 'Carpentry', 'writable/uploads/category/cpTW74Py-1660893541.svg', 1, 1, '2022-08-19 00:51:00', 1, '2022-08-19 02:19:01'),
(22, 'Plumbing', 'writable/uploads/category/rSJvkPLs-1660893553.svg', 1, 1, '2022-08-19 00:51:30', 1, '2022-08-19 02:19:13'),
(24, 'House Keeping', 'writable/uploads/category/5wlUXRh8-1660893564.svg', 1, 1, '2022-08-19 01:07:54', 1, '2022-08-19 02:19:24'),
(25, 'Ceiling', 'writable/uploads/category/t30E7LAB-1660893575.svg', 1, 1, '2022-08-19 01:08:51', 1, '2022-08-19 02:19:36'),
(26, 'Civil', 'writable/uploads/category/Rqs6S2P4-1660893588.svg', 1, 1, '2022-08-19 01:09:24', 1, '2022-08-19 02:19:48'),
(27, 'Others', 'writable/uploads/category/WyGoBsX3-1660893600.svg', 1, 1, '2022-08-19 01:10:11', 1, '2022-08-19 02:20:00');

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
(20, 3, 4, '2022-07-18 01:56:51'),
(25, 6, 1, '2022-07-29 00:40:32'),
(26, 6, 4, '2022-07-29 00:40:32'),
(27, 6, 13, '2022-07-29 00:40:32'),
(31, 8, 1, '2022-07-29 00:41:51'),
(32, 8, 4, '2022-07-29 00:41:51'),
(33, 8, 13, '2022-07-29 00:41:51'),
(34, 9, 1, '2022-07-29 00:42:23'),
(35, 9, 4, '2022-07-29 00:42:24'),
(36, 9, 13, '2022-07-29 00:42:24'),
(37, 10, 1, '2022-07-29 00:42:54'),
(38, 10, 4, '2022-07-29 00:42:54'),
(39, 10, 13, '2022-07-29 00:42:54'),
(48, 7, 1, '2022-08-09 23:29:07'),
(49, 7, 4, '2022-08-09 23:29:07'),
(50, 7, 13, '2022-08-09 23:29:07'),
(51, 5, 1, '2022-08-10 00:58:10'),
(52, 5, 4, '2022-08-10 00:58:10'),
(53, 5, 13, '2022-08-10 00:58:10'),
(54, 5, 14, '2022-08-10 00:58:10'),
(72, 14, 1, '2022-08-10 02:14:07'),
(73, 15, 13, '2022-08-10 02:15:16'),
(77, 2, 1, '2022-08-10 02:16:35'),
(78, 2, 13, '2022-08-10 02:16:35'),
(79, 2, 14, '2022-08-10 02:16:35'),
(80, 2, 15, '2022-08-10 02:16:35'),
(81, 16, 1, '2022-08-10 02:17:34'),
(82, 1, 1, '2022-08-17 01:43:53'),
(83, 1, 4, '2022-08-17 01:43:53'),
(84, 17, 1, '2022-08-17 06:09:03'),
(85, 17, 4, '2022-08-17 06:09:03'),
(86, 17, 13, '2022-08-17 06:09:03'),
(87, 17, 14, '2022-08-17 06:09:03'),
(88, 17, 16, '2022-08-17 06:09:03'),
(89, 17, 19, '2022-08-17 06:09:03'),
(90, 18, 1, '2022-08-17 06:10:21'),
(91, 18, 4, '2022-08-17 06:10:21'),
(92, 18, 13, '2022-08-17 06:10:21'),
(93, 18, 14, '2022-08-17 06:10:21'),
(94, 18, 16, '2022-08-17 06:10:21'),
(95, 18, 19, '2022-08-17 06:10:21'),
(106, 19, 20, '2022-08-19 02:17:54'),
(107, 20, 20, '2022-08-19 02:18:32'),
(108, 21, 20, '2022-08-19 02:19:01'),
(109, 22, 20, '2022-08-19 02:19:13'),
(110, 24, 20, '2022-08-19 02:19:24'),
(111, 25, 20, '2022-08-19 02:19:36'),
(112, 26, 20, '2022-08-19 02:19:48'),
(113, 27, 20, '2022-08-19 02:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `complaintimages`
--

CREATE TABLE `complaintimages` (
  `ImgID` int(11) NOT NULL,
  `ComCatID` int(11) NOT NULL,
  `Image` text NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaintimages`
--

INSERT INTO `complaintimages` (`ImgID`, `ComCatID`, `Image`, `CreatedDate`, `CreatedBy`, `UpdatedDate`, `UpdatedBy`) VALUES
(1, 3, 'writable/uploads/category/qKLXWn6v-1660984396.png', '2022-08-20 14:03:16', 62, '2022-08-20 14:03:16', 0),
(2, 4, 'writable/uploads/category/BfiXtrJU-1661256554.svg', '2022-08-23 17:39:14', 63, '2022-08-23 17:39:14', 0),
(3, 4, 'writable/uploads/category/Z4FrJcnx-1661256554.svg', '2022-08-23 17:39:14', 63, '2022-08-23 17:39:14', 0),
(4, 7, 'writable/uploads/category/PDEzpaeN-1661322019.jpg', '2022-08-24 11:50:21', 63, '2022-08-24 11:50:21', 0);

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
(13, 'Switch Board not working', 19, 1, 1, '2022-08-19 01:10:50', 1, '2022-08-19 01:10:50'),
(14, 'Socket Not Working', 19, 1, 1, '2022-08-19 01:11:09', 1, '2022-08-19 01:11:09'),
(15, 'Tube Light Not Working', 19, 1, 1, '2022-08-19 01:11:24', 1, '2022-08-19 01:11:24'),
(16, 'Fan Not Working', 19, 1, 1, '2022-08-19 01:11:44', 1, '2022-08-19 01:11:44'),
(17, 'Fan Regulator Not working', 19, 1, 1, '2022-08-19 01:12:02', 1, '2022-08-19 01:12:02'),
(18, 'Fan Making Noise', 19, 1, 1, '2022-08-19 01:12:19', 1, '2022-08-19 01:12:19'),
(19, 'Loose Wires', 19, 1, 1, '2022-08-19 01:12:38', 1, '2022-08-19 01:12:38'),
(20, 'Bed Light Not Working/Missing', 19, 1, 1, '2022-08-19 01:12:54', 1, '2022-08-19 01:12:54'),
(21, 'Wash room light not working', 19, 1, 1, '2022-08-19 01:13:13', 1, '2022-08-19 01:13:13'),
(22, 'Wash room Exhaust not working', 19, 1, 1, '2022-08-19 01:13:36', 1, '2022-08-19 01:13:36'),
(23, 'Hand drier not working', 19, 1, 1, '2022-08-19 01:13:52', 1, '2022-08-19 01:13:52'),
(24, 'Exhaust fan not working', 19, 1, 1, '2022-08-19 01:14:08', 1, '2022-08-19 01:14:08'),
(25, 'AC Noise', 20, 1, 1, '2022-08-19 01:14:35', 1, '2022-08-19 01:14:35'),
(26, 'AC Water leakage', 20, 1, 1, '2022-08-19 01:14:56', 1, '2022-08-19 01:14:56'),
(27, 'Ceiling water leaking', 20, 1, 1, '2022-08-19 01:15:50', 1, '2022-08-19 01:15:50'),
(28, 'AC not working', 20, 1, 1, '2022-08-19 01:16:09', 1, '2022-08-19 01:16:09'),
(29, 'AC not effective', 20, 1, 1, '2022-08-19 01:30:29', 1, '2022-08-19 01:30:29'),
(30, 'AC Remote Missing', 20, 1, 1, '2022-08-19 01:30:46', 1, '2022-08-19 01:30:46'),
(31, 'AC Remote Not Working', 20, 1, 1, '2022-08-19 01:31:02', 1, '2022-08-19 01:31:02'),
(32, 'AC Control Not Working', 20, 1, 1, '2022-08-19 01:31:19', 1, '2022-08-19 01:31:19'),
(33, 'Too Cold', 20, 1, 1, '2022-08-19 01:31:38', 1, '2022-08-19 01:31:38'),
(34, 'Door Closing Problem', 21, 1, 1, '2022-08-19 01:31:57', 1, '2022-08-19 01:31:57'),
(35, 'Cup Board needs fixing', 21, 1, 1, '2022-08-19 01:32:18', 1, '2022-08-19 01:32:18'),
(36, 'Door Handle needs to be tightened', 21, 1, 1, '2022-08-19 01:32:39', 1, '2022-08-19 01:32:39'),
(37, 'Door Handle needs to be replaced', 21, 1, 1, '2022-08-19 01:32:56', 1, '2022-08-19 01:32:56'),
(38, 'Mirror need to be replaced', 21, 1, 1, '2022-08-19 01:33:12', 1, '2022-08-19 01:33:12'),
(39, 'Soap Dispencer & Kimberly stand to be fixed', 21, 1, 1, '2022-08-19 01:33:27', 1, '2022-08-19 01:33:27'),
(40, 'Bath room Mirror to be fixed & Mesh to be fixed', 21, 1, 1, '2022-08-19 01:33:51', 1, '2022-08-19 01:33:51'),
(41, 'Main door Lock Replacement', 21, 1, 1, '2022-08-19 01:34:08', 1, '2022-08-19 01:34:08'),
(42, 'Cupboard Lock Replacement', 21, 1, 1, '2022-08-19 01:34:29', 1, '2022-08-19 01:34:29'),
(43, 'Doors making noise', 21, 1, 1, '2022-08-19 01:34:44', 1, '2022-08-19 01:34:44'),
(44, 'Ceiling Sheets to be adjusted', 21, 1, 1, '2022-08-19 01:35:03', 1, '2022-08-19 01:35:03'),
(45, 'Tap Water Leakage', 22, 1, 1, '2022-08-19 01:35:28', 1, '2022-08-19 01:35:28'),
(46, 'Faucet Water Leakage', 22, 1, 1, '2022-08-19 01:35:48', 1, '2022-08-19 01:35:48'),
(47, 'Flush Water Leakage', 22, 1, 1, '2022-08-19 01:36:59', 1, '2022-08-19 01:36:59'),
(48, 'Washbasin Broken', 22, 1, 1, '2022-08-19 01:37:22', 1, '2022-08-19 01:37:22'),
(49, 'Urinal Blocked', 22, 1, 1, '2022-08-19 01:37:42', 1, '2022-08-19 01:37:42'),
(50, 'Washroom Blocked', 22, 1, 1, '2022-08-19 01:37:56', 1, '2022-08-19 01:37:56'),
(51, 'Flush not Working', 22, 1, 1, '2022-08-19 01:38:11', 1, '2022-08-19 01:38:11'),
(52, 'Faucet Missing', 22, 1, 1, '2022-08-19 01:38:26', 1, '2022-08-19 01:38:26'),
(53, 'Hot Water Not Coming', 22, 1, 1, '2022-08-19 01:38:43', 1, '2022-08-19 01:38:43'),
(54, 'Soap Stand Misisng', 22, 1, 1, '2022-08-19 01:38:59', 1, '2022-08-19 01:38:59'),
(55, 'WC Seat cover to be fixed', 22, 1, 1, '2022-08-19 01:39:16', 1, '2022-08-19 01:39:16'),
(56, 'Commode to be fixed', 22, 1, 1, '2022-08-19 01:39:32', 1, '2022-08-19 01:39:32'),
(57, 'Dirty Floor', 24, 1, 1, '2022-08-19 01:39:48', 1, '2022-08-19 01:39:48'),
(58, 'Dirty Washroom', 24, 1, 1, '2022-08-19 01:40:03', 1, '2022-08-19 01:40:03'),
(59, 'Dirty Linen', 24, 1, 1, '2022-08-19 01:40:21', 1, '2022-08-19 01:40:21'),
(60, 'Floor Mats not available', 24, 1, 1, '2022-08-19 01:40:37', 1, '2022-08-19 01:40:37'),
(61, 'Wet Floor', 24, 1, 1, '2022-08-19 01:40:56', 1, '2022-08-19 01:40:56'),
(62, 'Foul Smell in the Room', 24, 1, 1, '2022-08-19 01:41:12', 1, '2022-08-19 01:41:12'),
(63, 'Ceiling Repairs', 25, 1, 1, '2022-08-19 01:41:33', 1, '2022-08-19 01:41:33'),
(64, 'Tiles Replacement', 26, 1, 1, '2022-08-19 01:42:11', 1, '2022-08-19 01:42:11'),
(65, 'Grab Bar to be replaced', 26, 1, 1, '2022-08-19 01:43:31', 1, '2022-08-19 01:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `complaintpriority`
--

CREATE TABLE `complaintpriority` (
  `PriorityID` int(11) NOT NULL,
  `Priority` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaintpriority`
--

INSERT INTO `complaintpriority` (`PriorityID`, `Priority`) VALUES
(1, 'High'),
(2, 'Medium'),
(3, 'Low');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `ComID` int(11) NOT NULL,
  `OrgID` int(11) NOT NULL,
  `BID` int(11) NOT NULL,
  `FID` int(11) NOT NULL,
  `RID` int(11) NOT NULL,
  `ComCatID` int(11) NOT NULL,
  `ComNatID` int(11) NOT NULL,
  `CustomComplaint` varchar(255) NOT NULL,
  `ComplaintPriority` tinyint(4) NOT NULL,
  `ComplaintRemarks` text NOT NULL,
  `ComplaintStatus` tinyint(4) NOT NULL,
  `DeptID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Mobile` varchar(15) NOT NULL,
  `AssignedNote` text NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL COMMENT 'AssignTo',
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`ComID`, `OrgID`, `BID`, `FID`, `RID`, `ComCatID`, `ComNatID`, `CustomComplaint`, `ComplaintPriority`, `ComplaintRemarks`, `ComplaintStatus`, `DeptID`, `Name`, `Mobile`, `AssignedNote`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 20, 12, 19, 31, 20, 27, '', 0, 'Please resolve', 3, 77, '', '', 'repaired', 62, '2022-08-19 16:10:20', 64, '2022-08-19 16:17:21'),
(2, 20, 11, 18, 27, 19, 14, '', 0, 'fast', 3, 66, '', '', 'done', 63, '2022-08-19 16:18:26', 62, '2022-08-20 12:10:51'),
(3, 20, 13, 27, 95, 19, 16, '', 0, 'please resolve', 3, 66, '', '', 'completed', 62, '2022-08-20 14:03:16', 62, '2022-08-20 14:06:36'),
(4, 20, 13, 28, 101, 19, 18, '', 0, 'please resolve', 3, 66, 'krishna', '9959451265', 'done', 63, '2022-08-23 17:39:14', 62, '2022-08-23 17:49:45'),
(5, 20, 12, 43, 218, 19, 15, '', 0, 'test', 2, 66, '', '', '', 63, '2022-08-23 17:51:10', 62, '2022-08-23 17:51:32'),
(6, 20, 13, 27, 95, 19, 13, '', 0, 'tt', 2, 66, '', '', '', 63, '2022-08-24 11:17:07', 62, '2022-08-24 11:20:22'),
(7, 20, 13, 29, 117, 19, 14, '', 0, 'small change', 1, 0, '', '', '', 63, '2022-08-24 11:50:21', 0, '2022-08-24 11:50:21'),
(8, 20, 12, 43, 218, 19, 13, '', 0, 'test', 2, 66, '', '', '', 63, '2022-08-24 12:03:26', 62, '2022-08-24 12:05:22'),
(9, 20, 12, 42, 213, 19, 0, 'Custom Always', 0, '', 1, 0, '', '', '', 63, '2022-08-24 14:59:53', 0, '2022-08-24 14:59:53'),
(10, 20, 12, 42, 213, 19, 0, 'Custom Always', 0, '', 1, 0, '', '', '', 63, '2022-08-24 15:00:02', 0, '2022-08-24 15:00:02'),
(11, 20, 12, 42, 213, 19, 0, 'Custom Always', 0, '', 1, 0, '', '', '', 63, '2022-08-24 15:00:10', 0, '2022-08-24 15:00:10'),
(12, 20, 12, 42, 213, 19, 13, '', 0, '', 1, 0, '', '', '', 63, '2022-08-24 16:53:22', 0, '2022-08-24 16:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `complaintstatus`
--

CREATE TABLE `complaintstatus` (
  `StatusID` int(11) NOT NULL,
  `StausName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaintstatus`
--

INSERT INTO `complaintstatus` (`StatusID`, `StausName`) VALUES
(1, 'Registered'),
(2, 'In Progress\r\n'),
(3, 'Completed');

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
(64, 0, 20, 15, 'Electrical', 1, 1, '2022-08-18 23:29:11', 1, '2022-08-18 23:29:11'),
(65, 64, 20, 15, 'Junior Electrician', 1, 1, '2022-08-18 23:40:10', 1, '2022-08-18 23:40:10'),
(66, 64, 20, 15, 'Senior Electrician', 1, 1, '2022-08-18 23:44:10', 1, '2022-08-18 23:44:10'),
(67, 0, 20, 15, 'Admin', 1, 1, '2022-08-19 04:57:09', 1, '2022-08-19 04:57:09'),
(68, 0, 20, 15, 'HVAC', 1, 1, '2022-08-19 05:25:16', 1, '2022-08-19 05:25:16'),
(69, 68, 20, 15, 'Junior HVAC', 1, 1, '2022-08-19 05:25:40', 1, '2022-08-19 05:25:40'),
(70, 0, 20, 15, 'Plumbing', 1, 1, '2022-08-19 05:27:04', 1, '2022-08-19 05:27:04'),
(71, 70, 20, 15, 'Junior Plumber', 1, 1, '2022-08-19 05:27:27', 1, '2022-08-19 05:27:27'),
(72, 0, 20, 15, 'Civil', 1, 1, '2022-08-19 05:28:01', 1, '2022-08-19 05:28:01'),
(73, 72, 20, 15, 'Construction Manager', 1, 1, '2022-08-19 05:31:10', 1, '2022-08-19 05:31:10'),
(74, 0, 20, 15, 'Housekeeping', 1, 1, '2022-08-19 05:35:30', 1, '2022-08-19 05:35:30'),
(75, 74, 20, 15, 'Housekeeping Executive', 1, 1, '2022-08-19 05:35:46', 1, '2022-08-19 05:35:46'),
(76, 0, 20, 15, 'Air Conditioning', 1, 1, '2022-08-19 05:38:23', 1, '2022-08-19 05:38:23'),
(77, 76, 20, 15, 'Heating Air Conditioning Technician', 1, 1, '2022-08-19 05:38:47', 1, '2022-08-19 05:38:47');

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
(72, 27, 1, '2022-07-13 19:48:58'),
(73, 28, 6, '2022-07-18 05:37:09'),
(74, 29, 5, '2022-07-18 05:42:16'),
(75, 30, 1, '2022-07-26 14:01:12'),
(76, 30, 2, '2022-07-26 14:01:12'),
(77, 31, 1, '2022-07-26 14:02:39'),
(78, 31, 2, '2022-07-26 14:02:39'),
(79, 32, 2, '2022-08-09 14:31:34'),
(81, 33, 2, '2022-08-09 14:41:37'),
(82, 34, 7, '2022-08-09 08:14:03'),
(83, 35, 7, '2022-08-09 18:49:11'),
(84, 14, 1, '2022-08-10 03:54:33'),
(85, 14, 2, '2022-08-10 03:54:33'),
(86, 36, 2, '2022-08-11 11:35:18'),
(87, 1, 1, '2022-08-11 11:39:59'),
(88, 37, 2, '2022-08-11 11:45:47'),
(89, 38, 1, '2022-08-11 12:07:26'),
(95, 2, 1, '2022-08-11 14:07:01'),
(96, 2, 2, '2022-08-11 14:07:01'),
(101, 44, 1, '2022-08-11 18:07:02'),
(104, 47, 1, '2022-08-11 18:13:17'),
(105, 48, 2, '2022-08-11 18:18:25'),
(106, 49, 2, '2022-08-12 10:15:59'),
(107, 50, 1, '2022-08-12 10:20:05'),
(108, 51, 2, '2022-08-12 00:26:54'),
(109, 52, 12, '2022-08-12 00:31:11'),
(110, 45, 1, '2022-08-12 00:34:49'),
(111, 53, 1, '2022-08-12 11:44:51'),
(112, 54, 7, '2022-08-12 11:49:04'),
(113, 46, 2, '2022-08-12 16:34:36'),
(114, 43, 1, '2022-08-16 16:31:20'),
(115, 55, 2, '2022-08-17 02:37:43'),
(116, 56, 2, '2022-08-17 16:58:01'),
(117, 57, 1, '2022-08-17 17:08:23'),
(118, 58, 1, '2022-08-17 17:10:57'),
(119, 59, 2, '2022-08-17 18:03:51'),
(120, 60, 2, '2022-08-18 09:50:51'),
(121, 61, 2, '2022-08-18 10:04:52'),
(122, 62, 15, '2022-08-18 23:47:47'),
(124, 63, 15, '2022-08-19 04:58:00'),
(125, 64, 15, '2022-08-19 05:45:36'),
(126, 65, 15, '2022-08-23 16:53:15');

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
  `Shift` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmpID`, `RoleID`, `EmpName`, `DeptID`, `OrgID`, `JobTID`, `Gender`, `EmailID`, `Password`, `Address`, `Contact`, `JobType`, `City`, `DateOfJoining`, `PreviousExp`, `Doc`, `ProfilePic`, `Status`, `Shift`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(62, 0, 'krishna', 66, 20, 13, 'M', 'krishna@wenalytics.com', 'e10adc3949ba59abbe56e057f20f883e', 'Hyderabad', '9959451265', '', '', '2022-03-01', '', '', 'writable/uploads/ProfilePics/man.png', 1, 1, 1, '2022-08-18 23:47:47', 1, '2022-08-18 23:47:47'),
(63, 0, 'sunil', 67, 20, 14, 'M', 'sunil@wenalytics.com', 'e10adc3949ba59abbe56e057f20f883e', '', '9878765678', '', '', '2021-11-10', '', '', 'writable/uploads/ProfilePics/man.png', 1, 0, 1, '2022-08-18 23:52:33', 1, '2022-08-19 04:58:00'),
(64, 0, 'Naidu', 77, 20, 15, 'M', 'naidu@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '8767898789', '', '', '0000-00-00', '', '', 'writable/uploads/ProfilePics/man.png', 1, 0, 1, '2022-08-19 05:45:36', 1, '2022-08-19 05:45:36'),
(65, 0, 'Lakshmi', 77, 20, 15, 'F', 'lakshmi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', '9392422565', '', '', '0000-00-00', '', '', 'writable/uploads/ProfilePics/woman.png', 1, 2, 63, '2022-08-23 16:53:15', 63, '2022-08-23 16:53:15');

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
(1, 1, 2, 'Floor1', 1, 1, '2022-08-03 03:49:42', 1, '2022-08-03 03:49:42'),
(5, 1, 3, 'Floor01', 1, 1, '2022-08-03 06:06:48', 1, '2022-08-03 06:06:48'),
(6, 16, 4, 'g floor', 1, 1, '2022-08-10 03:18:16', 1, '2022-08-10 03:18:16'),
(7, 16, 5, 'gv floor', 1, 1, '2022-08-10 04:15:38', 1, '2022-08-10 04:15:38'),
(8, 16, 5, 'gv florr', 1, 1, '2022-08-10 04:15:38', 1, '2022-08-10 04:15:38'),
(10, 1, 6, 'apolo floor', 1, 1, '2022-08-10 04:19:17', 1, '2022-08-10 04:19:17'),
(11, 17, 7, 'pharmacy floor', 1, 1, '2022-08-10 04:22:02', 1, '2022-08-10 04:22:02'),
(12, 17, 7, 'doctors floor', 1, 1, '2022-08-10 04:22:02', 1, '2022-08-10 04:22:02'),
(13, 15, 8, 'doe', 1, 1, '2022-08-10 04:29:43', 1, '2022-08-10 04:29:43'),
(14, 1, 9, 'aaaa', 1, 1, '2022-08-10 05:00:55', 1, '2022-08-10 05:00:55'),
(15, 1, 9, 'eere', 1, 1, '2022-08-10 05:00:55', 1, '2022-08-10 05:00:55'),
(16, 1, 10, '2nf floor', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(17, 1, 10, '3rd floor', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(26, 20, 13, 'Ground Floor', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(27, 20, 13, 'Basement 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(28, 20, 13, 'Basement 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(29, 20, 13, 'Floor 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(30, 20, 13, 'Floor 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(31, 20, 13, 'Floor 3', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(32, 20, 13, 'Floor 4', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(33, 20, 13, 'Floor 5', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(34, 20, 14, 'Ground Floor', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(35, 20, 14, 'Basement 2', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(36, 20, 14, 'Basement 1', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(37, 20, 14, 'Floor 1', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(38, 20, 14, 'Floor 2', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(39, 20, 14, 'Floor 3', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(40, 20, 14, 'Floor 4', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(41, 20, 14, 'Floor 5', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(42, 20, 12, 'Basement 2', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(43, 20, 12, 'Basement 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(44, 20, 12, 'Floor 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(45, 20, 12, 'Floor 2', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(46, 20, 12, 'Floor 3', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(47, 20, 12, 'Floor 4', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(48, 20, 12, 'Floor 5', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(49, 20, 12, 'Ground Floor', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46');

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
(13, 'Electrical', 20, 1, 1, '2022-08-18 23:46:18', 1, '2022-08-18 23:46:18'),
(14, 'Admin', 20, 1, 1, '2022-08-18 23:51:28', 1, '2022-08-19 00:17:28'),
(15, 'Air Conditioning', 20, 1, 1, '2022-08-19 05:43:34', 1, '2022-08-19 05:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `OrgID` int(11) NOT NULL,
  `OrgName` varchar(255) NOT NULL,
  `OrgType` int(11) NOT NULL,
  `Logo` text NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`OrgID`, `OrgName`, `OrgType`, `Logo`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Apollo', 1, 'writable/uploads/organization/rdujRgb8-1660218221.png', 1, 1, '2022-06-22 05:22:16', 1, '2022-08-11 06:43:41'),
(20, 'First Serve Hospitals', 1, 'writable/uploads/organization/Ywfjeopx-1660882550.png', 1, 1, '2022-08-18 23:15:50', 1, '2022-08-18 23:15:50');

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
(16, 13, 3, '2022-06-28 04:36:45'),
(17, 14, 1, '2022-07-15 08:00:07'),
(18, 14, 2, '2022-07-15 08:00:07'),
(19, 14, 3, '2022-07-15 08:00:07'),
(20, 14, 4, '2022-07-15 08:00:07'),
(21, 15, 1, '2022-07-16 06:25:25'),
(22, 15, 2, '2022-07-16 06:25:25'),
(23, 15, 3, '2022-07-16 06:25:25'),
(24, 15, 1, '2022-08-09 08:02:06'),
(41, 17, 4, '2022-08-10 03:11:25'),
(42, 17, 7, '2022-08-10 03:11:25'),
(43, 16, 1, '2022-08-10 03:15:13'),
(44, 16, 2, '2022-08-10 03:15:13'),
(45, 16, 3, '2022-08-10 03:15:13'),
(46, 16, 4, '2022-08-10 03:15:13'),
(47, 16, 5, '2022-08-10 03:15:13'),
(48, 16, 6, '2022-08-10 03:15:13'),
(49, 16, 7, '2022-08-10 03:15:13'),
(50, 18, 1, '2022-08-11 06:38:18'),
(51, 1, 1, '2022-08-11 06:43:41'),
(52, 1, 2, '2022-08-11 06:43:41'),
(55, 19, 1, '2022-08-12 05:54:17'),
(56, 19, 6, '2022-08-12 05:54:17'),
(57, 20, 1, '2022-08-18 23:15:50'),
(58, 20, 3, '2022-08-18 23:15:50'),
(59, 20, 4, '2022-08-18 23:15:50');

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
(1, 'Hospital', 1, 1, '2022-06-20 05:36:20', 0, '2022-08-17 06:06:24'),
(3, 'Hotels', 1, 1, '2022-06-20 05:42:55', 0, '2022-08-10 01:20:28');

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
(1, 'admin', 1, 1, 0, '2021-07-01 20:54:40', 1, '2022-08-12 00:11:55'),
(2, 'employee', 9, 1, 1, '2022-06-17 05:55:58', 1, '2022-08-12 00:16:10'),
(4, 'office manager cum employ', 2, 1, 1, '2022-08-12 00:14:09', 1, '2022-08-12 00:14:28'),
(5, 'priority with number', 90, 1, 1, '2022-08-12 00:14:57', 1, '2022-08-12 00:15:12');

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
(1, 1, 2, 4, '201', 1, 1, '2022-08-03 03:49:42', 1, '2022-08-03 03:49:42'),
(7, 1, 2, 4, '235', 1, 1, '2022-08-03 03:49:42', 1, '2022-08-03 03:49:42'),
(8, 1, 2, 4, '241', 1, 1, '2022-08-03 03:49:42', 1, '2022-08-03 03:49:42'),
(9, 1, 3, 5, 'New GW', 1, 1, '2022-08-03 06:06:48', 1, '2022-08-03 06:06:48'),
(10, 1, 3, 5, '201', 1, 1, '2022-08-03 06:06:48', 1, '2022-08-03 06:06:48'),
(11, 16, 4, 6, 'g room', 1, 1, '2022-08-10 03:18:16', 1, '2022-08-10 03:18:16'),
(12, 16, 5, 7, 'gv floor', 1, 1, '2022-08-10 04:15:38', 1, '2022-08-10 04:15:38'),
(13, 16, 5, 8, 'gv floor', 1, 1, '2022-08-10 04:15:38', 1, '2022-08-10 04:15:38'),
(15, 1, 6, 10, '101', 1, 1, '2022-08-10 04:19:17', 1, '2022-08-10 04:19:17'),
(16, 17, 7, 11, '123', 1, 1, '2022-08-10 04:22:02', 1, '2022-08-10 04:22:02'),
(17, 17, 7, 12, '123', 1, 1, '2022-08-10 04:22:02', 1, '2022-08-10 04:22:02'),
(18, 15, 8, 13, '234', 1, 1, '2022-08-10 04:29:43', 1, '2022-08-10 04:29:43'),
(19, 1, 9, 14, '8549', 1, 1, '2022-08-10 05:00:55', 1, '2022-08-10 05:00:55'),
(20, 1, 9, 15, '23429', 1, 1, '2022-08-10 05:00:55', 1, '2022-08-10 05:00:55'),
(21, 1, 10, 16, '123', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(22, 1, 10, 16, '124', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(23, 1, 10, 16, '125', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(24, 1, 10, 17, '126', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(25, 1, 10, 17, '127', 1, 1, '2022-08-10 06:07:43', 1, '2022-08-10 06:07:43'),
(83, 20, 13, 26, 'Reception', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(84, 20, 13, 26, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(85, 20, 13, 26, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(86, 20, 13, 26, 'Pharmacy', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(87, 20, 13, 26, 'Waiting Area', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(88, 20, 13, 26, 'Consultation ROOM 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(89, 20, 13, 26, 'Consultation ROOM 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(90, 20, 13, 26, 'Consultation ROOM 3', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(91, 20, 13, 26, 'Consultation ROOM 4', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(92, 20, 13, 26, 'Consultation ROOM 5', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(93, 20, 13, 26, 'Consultation ROOM 6', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(94, 20, 13, 26, 'ROOM6', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(95, 20, 13, 27, 'Paking Zone 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(96, 20, 13, 27, 'Paking Zone 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(97, 20, 13, 27, 'Paking Zone 3', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(98, 20, 13, 27, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(99, 20, 13, 27, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(100, 20, 13, 28, 'Paking Zone 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(101, 20, 13, 28, 'Electrical ROOM', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(102, 20, 13, 28, 'STP', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(103, 20, 13, 28, 'UPS ROOM', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(104, 20, 13, 28, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(105, 20, 13, 28, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(106, 20, 13, 29, 'Nursing Station 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(107, 20, 13, 29, 'Room No 101', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(108, 20, 13, 29, 'Room No 102', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(109, 20, 13, 29, 'Room No 103', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(110, 20, 13, 29, 'Room No 104', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(111, 20, 13, 29, 'Room No 105', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(112, 20, 13, 29, 'Room No 106', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(113, 20, 13, 29, 'Room No 107', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(114, 20, 13, 29, 'Room No 108', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(115, 20, 13, 29, 'Room No 109', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(116, 20, 13, 29, 'Room No 110', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(117, 20, 13, 29, 'Room No 111', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(118, 20, 13, 29, 'Room No 112', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(119, 20, 13, 29, 'Room No 113', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(120, 20, 13, 29, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(121, 20, 13, 29, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(122, 20, 13, 30, 'Nursing Station 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(123, 20, 13, 30, 'Nursing Station 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(124, 20, 13, 30, 'Room no 201', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(125, 20, 13, 30, 'Room no 202', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(126, 20, 13, 30, 'Room no 203', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(127, 20, 13, 30, 'Room no 204', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(128, 20, 13, 30, 'Room no 205', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(129, 20, 13, 30, 'Room no 206', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(130, 20, 13, 31, 'ICU 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(131, 20, 13, 31, 'ICU 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(132, 20, 13, 31, 'ICU 3', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(133, 20, 13, 31, 'ICU 4', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(134, 20, 13, 31, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(135, 20, 13, 31, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(136, 20, 13, 32, 'OT 1', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(137, 20, 13, 32, 'OT 2', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(138, 20, 13, 32, 'OT 3', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(139, 20, 13, 32, 'OT 4', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(140, 20, 13, 32, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(141, 20, 13, 32, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(142, 20, 13, 33, 'ONCOLOGY', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(143, 20, 13, 33, 'TOMOTHERAPY', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(144, 20, 13, 33, 'X-RAY', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(145, 20, 13, 33, 'CT-SCAN', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(146, 20, 13, 33, 'Male Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(147, 20, 13, 33, 'Female Washroom', 1, 1, '2022-08-19 06:41:23', 1, '2022-08-19 06:41:23'),
(148, 20, 14, 34, 'Reception', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(149, 20, 14, 34, 'Male Washroom', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(150, 20, 14, 34, 'Female Washroom', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(151, 20, 14, 34, 'Pharmacy', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(152, 20, 14, 34, 'Waiting Area', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(153, 20, 14, 34, 'Consultation ROOM 1', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(154, 20, 14, 34, 'Consultation ROOM 2', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(155, 20, 14, 34, 'Consultation ROOM 3', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(156, 20, 14, 34, 'Consultation ROOM 4', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(157, 20, 14, 34, 'Consultation ROOM 5', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(158, 20, 14, 34, 'Consultation ROOM 6', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(159, 20, 14, 34, 'ROOM6', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(160, 20, 14, 35, 'Paking Zone 1', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(161, 20, 14, 35, 'Paking Zone 2', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(162, 20, 14, 35, 'Paking Zone 3', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(163, 20, 14, 35, 'Male Washroom', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(164, 20, 14, 35, 'Female Washroom', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(165, 20, 14, 36, 'Paking Zone 1', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(166, 20, 14, 36, 'Electrical ROOM', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(167, 20, 14, 36, 'STP', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(168, 20, 14, 36, 'UPS ROOM', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(169, 20, 14, 36, 'Male Washroom', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(170, 20, 14, 36, 'Female Washroom', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(171, 20, 14, 37, 'Nursing Station 1', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(172, 20, 14, 37, 'Room No 101', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(173, 20, 14, 37, 'Room No 102', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(174, 20, 14, 37, 'Room No 103', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(175, 20, 14, 37, 'Room No 104', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(176, 20, 14, 37, 'Room No 105', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(177, 20, 14, 37, 'Room No 106', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(178, 20, 14, 37, 'Room No 107', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(179, 20, 14, 37, 'Room No 108', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(180, 20, 14, 37, 'Room No 109', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(181, 20, 14, 37, 'Room No 110', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(182, 20, 14, 37, 'Room No 111', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(183, 20, 14, 37, 'Room No 112', 1, 1, '2022-08-19 06:52:28', 1, '2022-08-19 06:52:28'),
(184, 20, 14, 37, 'Room No 113', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(185, 20, 14, 37, 'Male Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(186, 20, 14, 37, 'Female Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(187, 20, 14, 38, 'Nursing Station 1', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(188, 20, 14, 38, 'Nursing Station 2', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(189, 20, 14, 38, 'Room no 201', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(190, 20, 14, 38, 'Room no 202', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(191, 20, 14, 38, 'Room no 203', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(192, 20, 14, 38, 'Room no 204', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(193, 20, 14, 38, 'Room no 205', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(194, 20, 14, 38, 'Room no 206', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(195, 20, 14, 39, 'ICU 1', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(196, 20, 14, 39, 'ICU 2', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(197, 20, 14, 39, 'ICU 3', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(198, 20, 14, 39, 'ICU 4', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(199, 20, 14, 39, 'Male Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(200, 20, 14, 39, 'Female Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(201, 20, 14, 40, 'OT 1', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(202, 20, 14, 40, 'OT 2', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(203, 20, 14, 40, 'OT 3', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(204, 20, 14, 40, 'OT 4', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(205, 20, 14, 40, 'Male Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(206, 20, 14, 40, 'Female Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(207, 20, 14, 41, 'ONCOLOGY', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(208, 20, 14, 41, 'TOMOTHERAPY', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(209, 20, 14, 41, 'X-RAY', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(210, 20, 14, 41, 'CT-SCAN', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(211, 20, 14, 41, 'Male Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(212, 20, 14, 41, 'Female Washroom', 1, 1, '2022-08-19 06:52:29', 1, '2022-08-19 06:52:29'),
(213, 20, 12, 42, 'Paking Zone 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(214, 20, 12, 42, 'Paking Zone 2	Paking Zone 3', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(215, 20, 12, 42, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(216, 20, 12, 42, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(217, 20, 12, 43, 'Paking Zone 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(218, 20, 12, 43, 'Electrical ROOM', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(219, 20, 12, 43, 'STP', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(220, 20, 12, 43, 'UPS ROOM', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(221, 20, 12, 43, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(222, 20, 12, 43, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(223, 20, 12, 44, 'Nursing Station 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(224, 20, 12, 44, 'Room No 101', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(225, 20, 12, 44, 'Room No 102', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(226, 20, 12, 44, 'Room No 103', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(227, 20, 12, 44, 'Room No 104', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(228, 20, 12, 44, 'Room No 105', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(229, 20, 12, 44, 'Room No 106', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(230, 20, 12, 44, 'Room No 107', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(231, 20, 12, 44, 'Room No 108', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(232, 20, 12, 44, 'Room No 109', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(233, 20, 12, 44, 'Room No 110', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(234, 20, 12, 44, 'Room No 111', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(235, 20, 12, 44, 'Room No 112', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(236, 20, 12, 44, 'Room No 113', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(237, 20, 12, 44, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(238, 20, 12, 44, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(239, 20, 12, 45, 'Nursing Station 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(240, 20, 12, 45, 'Nursing Station 2', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(241, 20, 12, 45, 'Room no 201', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(242, 20, 12, 45, 'Room no 202', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(243, 20, 12, 45, 'Room no 203', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(244, 20, 12, 45, 'Room no 204', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(245, 20, 12, 45, 'Room no 205', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(246, 20, 12, 45, 'Room no 206', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(247, 20, 12, 46, 'ICU 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(248, 20, 12, 46, 'ICU 2', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(249, 20, 12, 46, 'ICU 3', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(250, 20, 12, 46, 'ICU 4', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(251, 20, 12, 46, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(252, 20, 12, 46, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(253, 20, 12, 47, 'OT 1', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(254, 20, 12, 47, 'OT 2', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(255, 20, 12, 47, 'OT 3', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(256, 20, 12, 47, 'OT 4', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(257, 20, 12, 47, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(258, 20, 12, 47, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(259, 20, 12, 48, 'ONCOLOGY', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(260, 20, 12, 48, 'TOMOTHERAPY', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(261, 20, 12, 48, 'X-RAY', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(262, 20, 12, 48, 'CT-SCAN', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(263, 20, 12, 48, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(264, 20, 12, 48, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(265, 20, 12, 49, 'Reception', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(266, 20, 12, 49, 'Male Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(267, 20, 12, 49, 'Female Washroom', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(268, 20, 12, 49, 'Pharmacy', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46'),
(269, 20, 12, 49, 'Waiting Area', 1, 1, '2022-08-19 06:54:46', 1, '2022-08-19 06:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `ShID` int(11) NOT NULL,
  `ShiftName` varchar(100) NOT NULL,
  `ShiftDesc` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`ShID`, `ShiftName`, `ShiftDesc`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Morningsd', 'Mor 9am to 1pm', 1, 1, '2022-06-20 04:09:13', 0, '2022-08-17 05:58:08'),
(2, 'Afternoon', '1pm to 6pm', 1, 1, '2022-06-20 04:09:27', 0, '2022-08-17 05:58:08'),
(3, 'Night', '6pm to 11pm', 1, 1, '2022-06-20 04:09:36', 0, '2022-08-17 05:58:08');

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
-- Indexes for table `complaintimages`
--
ALTER TABLE `complaintimages`
  ADD PRIMARY KEY (`ImgID`);

--
-- Indexes for table `complaintnature`
--
ALTER TABLE `complaintnature`
  ADD PRIMARY KEY (`ComNatID`);

--
-- Indexes for table `complaintpriority`
--
ALTER TABLE `complaintpriority`
  ADD PRIMARY KEY (`PriorityID`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`ComID`);

--
-- Indexes for table `complaintstatus`
--
ALTER TABLE `complaintstatus`
  ADD PRIMARY KEY (`StatusID`);

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
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `AttID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `BrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `BID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `complaintcategory`
--
ALTER TABLE `complaintcategory`
  MODIFY `ComCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `complaintcategoryorganizations`
--
ALTER TABLE `complaintcategoryorganizations`
  MODIFY `ComCatOrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `complaintimages`
--
ALTER TABLE `complaintimages`
  MODIFY `ImgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `complaintnature`
--
ALTER TABLE `complaintnature`
  MODIFY `ComNatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `complaintpriority`
--
ALTER TABLE `complaintpriority`
  MODIFY `PriorityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `ComID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `complaintstatus`
--
ALTER TABLE `complaintstatus`
  MODIFY `StatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DeptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `employeebranches`
--
ALTER TABLE `employeebranches`
  MODIFY `EmpBrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `fcmtokens`
--
ALTER TABLE `fcmtokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `jobtitle`
--
ALTER TABLE `jobtitle`
  MODIFY `JobTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `organizationcities`
--
ALTER TABLE `organizationcities`
  MODIFY `OcID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `organization_type`
--
ALTER TABLE `organization_type`
  MODIFY `TypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `ShID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
