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
-- Table structure for table `organizationdesignation`
--

CREATE TABLE `organizationdesignation` (
  `OrgDesignationID` int(11) NOT NULL,
  `Designation` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizationdesignation`
--

INSERT INTO `organizationdesignation` (`OrgDesignationID`, `Designation`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Superintending Engineer', 1, 1, '2023-01-27 05:23:37', 1, '2023-01-27 05:33:13'),
(2, 'Executive Engineer', 1, 1, '2023-01-27 05:23:51', 1, '2023-01-27 05:23:51'),
(3, 'Assistant Engineer', 1, 1, '2023-01-27 05:23:59', 1, '2023-01-27 05:23:59'),
(4, 'section Officer', 1, 1, '2023-01-27 05:24:17', 1, '2023-01-27 05:24:17'),
(5, 'Junior Engineer', 1, 1, '2023-01-27 05:24:41', 1, '2023-01-27 05:24:41'),
(6, 'Junior Assistant', 1, 1, '2023-01-27 05:37:23', 1, '2023-01-27 05:37:23'),
(7, 'Senior Technician', 1, 1, '2023-01-27 05:37:44', 1, '2023-01-27 05:37:44'),
(8, 'Junior Technician', 1, 1, '2023-01-27 05:38:11', 1, '2023-01-27 05:38:11'),
(9, 'Senior Accountant', 1, 1, '2023-01-27 05:38:39', 1, '2023-01-27 05:38:39'),
(10, 'Junior Accountant', 1, 1, '2023-01-27 05:38:54', 1, '2023-01-27 05:38:54'),
(11, 'Vice President', 1, 1, '2023-01-27 05:39:09', 1, '2023-01-27 05:39:09'),
(12, 'HR', 1, 1, '2023-01-27 05:39:18', 1, '2023-01-27 05:39:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizationdesignation`
--
ALTER TABLE `organizationdesignation`
  ADD PRIMARY KEY (`OrgDesignationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizationdesignation`
--
ALTER TABLE `organizationdesignation`
  MODIFY `OrgDesignationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
