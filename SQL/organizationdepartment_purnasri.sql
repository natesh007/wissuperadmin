-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 01:02 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `organizationdepartment`
--

CREATE TABLE `organizationdepartment` (
  `OrgDepartmentID` int(11) NOT NULL,
  `Department` varchar(20) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizationdepartment`
--

INSERT INTO `organizationdepartment` (`OrgDepartmentID`, `Department`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Dean', 1, 1, '2023-01-27 05:41:20', 1, '2023-01-27 05:41:20'),
(2, 'Accounts', 1, 1, '2023-01-27 05:41:28', 1, '2023-01-27 05:41:28'),
(3, 'HR', 1, 1, '2023-01-27 05:41:35', 1, '2023-01-27 05:41:35'),
(4, 'CMD', 1, 1, '2023-01-27 05:41:46', 1, '2023-01-27 05:41:46'),
(5, 'Civil', 1, 1, '2023-01-27 05:42:00', 1, '2023-01-27 05:42:00'),
(6, 'Electrical', 1, 1, '2023-01-27 05:42:14', 1, '2023-01-27 05:42:14'),
(7, 'Admin', 1, 1, '2023-01-27 05:42:27', 1, '2023-01-27 05:42:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizationdepartment`
--
ALTER TABLE `organizationdepartment`
  ADD PRIMARY KEY (`OrgDepartmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizationdepartment`
--
ALTER TABLE `organizationdepartment`
  MODIFY `OrgDepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
