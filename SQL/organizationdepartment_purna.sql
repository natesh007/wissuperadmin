-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 07:49 AM
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
(5, 'Dean', 1, 1, '2023-01-27 00:47:09', 1, '2023-01-27 00:47:09'),
(6, 'Accounts', 1, 1, '2023-01-27 00:47:15', 0, '2023-01-27 00:48:42'),
(7, 'HR', 1, 1, '2023-01-27 00:47:21', 1, '2023-01-27 00:47:21'),
(8, 'admin', 1, 1, '2023-01-27 00:47:27', 0, '2023-01-27 00:48:43');

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
  MODIFY `OrgDepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
