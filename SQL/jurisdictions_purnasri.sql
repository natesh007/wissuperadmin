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
-- Table structure for table `jurisdictions`
--

CREATE TABLE `jurisdictions` (
  `JurisdictionsID` int(11) NOT NULL,
  `Jurisdictions` varchar(20) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurisdictions`
--

INSERT INTO `jurisdictions` (`JurisdictionsID`, `Jurisdictions`, `Status`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`) VALUES
(1, 'Academic', 1, 1, '2023-01-27 05:45:03', 1, '2023-01-27 05:45:03'),
(2, 'Hostels', 1, 1, '2023-01-27 05:45:09', 1, '2023-01-27 05:45:09'),
(3, 'Pavilion', 1, 1, '2023-01-27 05:45:14', 1, '2023-01-27 05:45:14'),
(4, 'Dining Hall', 1, 1, '2023-01-27 05:45:21', 1, '2023-01-27 05:45:21'),
(5, 'Residential', 1, 1, '2023-01-27 05:45:27', 1, '2023-01-27 05:45:27'),
(6, 'Sports Field', 1, 1, '2023-01-27 05:45:33', 1, '2023-01-27 05:45:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurisdictions`
--
ALTER TABLE `jurisdictions`
  ADD PRIMARY KEY (`JurisdictionsID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurisdictions`
--
ALTER TABLE `jurisdictions`
  MODIFY `JurisdictionsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
