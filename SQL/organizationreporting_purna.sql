-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2023 at 02:17 PM
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
-- Table structure for table `organizationreporting`
--

CREATE TABLE `organizationreporting` (
  `OrgReportingID` int(11) NOT NULL,
  `Reporting` varchar(20) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizationreporting`
--

INSERT INTO `organizationreporting` (`OrgReportingID`, `Reporting`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'testing123', 1, 1, '2023-01-25 07:09:26', 0, '2023-01-25 07:09:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizationreporting`
--
ALTER TABLE `organizationreporting`
  ADD PRIMARY KEY (`OrgReportingID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizationreporting`
--
ALTER TABLE `organizationreporting`
  MODIFY `OrgReportingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
