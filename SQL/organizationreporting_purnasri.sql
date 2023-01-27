-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 01:01 PM
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
(1, 'Single Reporting', 1, 1, '2023-01-27 05:15:38', 1, '2023-01-27 05:15:38'),
(2, 'Dual Reporting', 1, 1, '2023-01-27 05:16:03', 1, '2023-01-27 05:16:03'),
(3, 'Multi Reporting', 1, 1, '2023-01-27 05:16:17', 1, '2023-01-27 05:16:17');

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
  MODIFY `OrgReportingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
