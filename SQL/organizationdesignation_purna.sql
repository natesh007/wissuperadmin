-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 07:02 AM
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
  `Designation` varchar(20) NOT NULL,
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
(5, 'Executive Engineer', 1, 1, '2023-01-27 00:01:39', 1, '2023-01-27 00:01:39'),
(6, 'Assistant Engineer', 1, 1, '2023-01-27 00:01:45', 0, '2023-01-27 00:02:15'),
(7, 'senior engineer', 1, 1, '2023-01-27 00:01:50', 1, '2023-01-27 00:01:50');

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
  MODIFY `OrgDesignationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
