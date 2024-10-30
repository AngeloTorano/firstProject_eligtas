-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 04:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eligtas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admininfo`
--

CREATE TABLE `admininfo` (
  `adminID` int(11) NOT NULL,
  `srCode` varchar(10) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position` varchar(100) NOT NULL,
  `contactNumber` varchar(15) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `srCodeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admininfo`
--

INSERT INTO `admininfo` (`adminID`, `srCode`, `fName`, `lName`, `age`, `gender`, `position`, `contactNumber`, `pass`, `srCodeID`) VALUES
(1, '22-33880', 'admin', 'admin', 22, 'NA', 'none', '09123456789', 'Admin_12345', 1),
(2, '22-11111', 'admin', 'admin', 22, 'NA', 'none', '09123456789', '$2y$10$93QdybkP7adS7w6HapKeQ.DGHQvqBVxFqYTWcaPV6c0eRThRPtdli', 6),
(3, '22-12345', 'admin', 'admin', 22, 'NA', 'none', 'NA', '1X0tyENL6NBInVx3yJXYw084VDJqTUJTMDR4VTd2ZDVvaXFocWc9PQ==', 7);

-- --------------------------------------------------------

--
-- Table structure for table `hotline`
--

CREATE TABLE `hotline` (
  `hotlineID` int(11) NOT NULL,
  `municipality` varchar(50) DEFAULT NULL,
  `agency` varchar(100) DEFAULT NULL,
  `hotlineNumber` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotline`
--

INSERT INTO `hotline` (`hotlineID`, `municipality`, `agency`, `hotlineNumber`) VALUES
(1, 'LIPA CITY', 'EMERGENCY NATIONAL OFFICE', '911, (02) 925-9111, (02) 928-7281 [TELEFAX], +63966-5000-299 [GLOBE], +63932-318-0440 [SMART]'),
(2, 'LIPA CITY', 'BATSTATEU INCIDENT COMMANDER OFFICE/EXECUTIVE DIRECTOR\'S OFFICE', '(043) 778 2170 LOC 118'),
(3, 'LIPA CITY', 'LIPA CAMPUS EMERGENCY OPERATIONS CENTER', '(043) 774 2526'),
(4, 'LIPA CITY', 'CDRRMO', '(043) 757 5164, (043) 756 0127'),
(5, 'LIPA CITY', 'BATANGAS PDRRMO', '(043) 723 9350'),
(6, 'LIPA CITY', 'POLICE STATION (PNP)', '(043) 702 3832, 09777449692'),
(7, 'LIPA CITY', 'FIRE STATION (BFP)', '(043) 757 4618, 09275758065, 09156022011'),
(8, 'LIPA CITY', 'COAST GUARD BATANGAS', '0917 842 6633'),
(9, 'LIPA CITY', 'PHILIPPINE RED CROSS DISTRICT 4 & 6', '09171429378'),
(10, 'LIPA CITY', 'LIPA MEDIX MEDICAL CENTER', '(043) 756 2342, (043) 756 2372, 0928 526 1578'),
(11, 'LIPA CITY', 'MARY MEDIATRIX MEDICAL CENTER', '(043) 773 6800 LOCAL 1119'),
(12, 'LIPA CITY', 'LIPA CITY DISTRICT HOSPITAL', '(043) 404 8617'),
(13, 'LIPA CITY', 'METRO LIPA MEDICAL CENTER', '(043) 702 5561, (043) 702 8198, (043) 702 5443'),
(14, 'AGONCILLO', 'POLICE STATION (PNP)', '09152619656, 727-1005, 980-0911'),
(15, 'AGONCILLO', 'FIRE STATION (BFP)', '09156016791, 727-1140'),
(16, 'AGONCILLO', 'MDRRMO', '09757325274'),
(17, 'AGONCILLO', 'MDRRMC', '727-2362, 09178377608'),
(18, 'AGONCILLO', 'MEDICARE', '727-4124'),
(19, 'ALITAGTAG', 'MDRRMO', '(043) 772-0005'),
(20, 'ALITAGTAG', 'FIRE STATION (BFP)', '(043) 774-0331, 0981-685-4771'),
(21, 'ALITAGTAG', 'BATELEC II', '(043) 772-0079, 0923-735-1278'),
(22, 'ALITAGTAG', 'RHU', '(043) 727-4716, 0929-378-0472'),
(23, 'ALITAGTAG', 'POLICE STATION (PNP)', '(043) 772-3058'),
(24, 'ALITAGTAG', 'WATER DISTRICT', '(043) 772-0116'),
(25, 'BALAYAN', 'MDRRMO', '(043) 211 3755, 0915 602 2053'),
(26, 'BALAYAN', 'FIRE STATION (BFP)', '0915 602 2053'),
(27, 'BALAYAN', 'POLICE STATION (PNP)', '(043) 211 3637, 0927 434 8008'),
(28, 'BALAYAN', 'COAST GUARD', '0917-842-8047, 0998-585-5844'),
(29, 'BALAYAN', 'PHILIPPINE RED CROSS DISTRICT 1 (NASUGBU)', '09171331427'),
(30, 'BALAYAN', 'DR. MANUEL LOPEZ DISTRICT MEMORIAL HOSPITAL', '(043) 211 4169'),
(31, 'BALAYAN', 'MEDICAL CENTER WESTERN BATANGAS', '(043) 407 1103, 0915 784 6521, 0908 242 6971'),
(32, 'BALAYAN', 'BAYVIEW HOSPITAL', '(043) 211 6734, 0936 585 2893'),
(33, 'BALAYAN', 'METRO BALAYAN MEDICAL CENTER', '(043) 740 1350, (043) 211 6633'),
(34, 'BALAYAN', 'BATELEC I', '(043) 211 4619, 0917 992 0192'),
(35, 'BATANGAS CITY', 'POLICE STATION (PNP)', '(043) 723 2476, (043) 723 2030, 09164291515, 09989673414'),
(36, 'BATANGAS CITY', 'FIRE STATION (BFP)', '(043) 301 7996'),
(37, 'BALETE', 'POLICE STATION (PNP)', '781.2326, 09154672095'),
(38, 'BALETE', 'AMBULANCE', '706.9757, 09293619066, 09296285482'),
(39, 'BALETE', 'MDRRMO', '740.9638, 09205922480'),
(40, 'BALETE', 'FIRE STATION (BFP)', '09667462560'),
(41, 'CUENCA', 'MDRRMO', '(043) 774-3376, 09178342607'),
(42, 'CUENCA', 'POLICE STATION (PNP)', '(043) 542-1887, 09159547571'),
(43, 'CUENCA', 'FIRE STATION (BFP)', '(043) 740-6367, 09666934161'),
(44, 'LEMERY', 'MDRRMO', '726-3223, 09156761424, 09391463726'),
(45, 'LEMERY', 'POLICE STATION (PNP)', '740-0094, 09083527183, 09277071191'),
(46, 'LEMERY', 'FIRE STATION (BFP)', '(043) 740-2987'),
(47, 'LEMERY', 'COAST GUARD', '0917-836-7552, 0998-585-585'),
(48, 'LEMERY', 'METRO LEMERY MEDICAL CENTER', '(043) 409 0480'),
(49, 'LEMERY', 'OUR LADY OF CAYSASAY MEDICAL CENTER', '(043) 409 1888'),
(50, 'MALVAR', 'POLICE STATION (PNP)', '09498339974, 09985985695'),
(51, 'MALVAR', 'FIRE STATION (BFP)', '09455676548'),
(52, 'MALVAR', 'AMBULANCE (MALVAR HEALTH CENTER)', '09178267634, 043 778 5101'),
(53, 'PADRE GARCIA', 'MDRRMO', '(043) 515-7424, 09778011557, 09196116180'),
(54, 'PADRE GARCIA', 'POLICE STATION (PNP)', '(043) 515-9209/116, 0905-292-4038, 0928-663-7762'),
(55, 'PADRE GARCIA', 'FIRE STATION (BFP)', '(043) 515-1177, 09668715388'),
(56, 'ROSARIO', 'POLICE STATION (PNP)', '09152542577, 09237281366'),
(57, 'ROSARIO', 'FIRE STATION (BFP)', '09156024435, 043 312 1102'),
(58, 'SAN PASCUAL', 'RESCUE', '09399107681, 09285215113, (043) 984-3629, (043) 702-7115'),
(59, 'SAN PASCUAL', 'POLICE STATION (PNP)', '09985985704, 09155348889, (043) 456-9032'),
(60, 'SAN PASCUAL', 'FIRE STATION (BFP)', '09478937133, (043) 726-0264'),
(61, 'SAN JUAN', 'MDRRMO', '09985905102, 09096237425, 09458412692'),
(62, 'SAN JUAN', 'FIRE STATION (BFP)', '575-3111, 09156022026, 09397139474'),
(63, 'SAN JUAN', 'POLICE STATION (PNP)', '09153850205, 09989673439'),
(64, 'TAAL', 'POLICE STATION (PNP)', '2142-167'),
(65, 'TAAL', 'FIRE STATION (BFP)', '411-1550');

-- --------------------------------------------------------

--
-- Table structure for table `srcode`
--

CREATE TABLE `srcode` (
  `srCodeID` int(11) NOT NULL,
  `srCode` varchar(10) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `srcode`
--

INSERT INTO `srcode` (`srCodeID`, `srCode`, `role`) VALUES
(1, '22-33880', 'admin'),
(2, '22-33882', 'student'),
(3, '22-33881', 'student'),
(4, '22-37101', 'student'),
(5, '22-37600', 'student'),
(6, '22-11111', 'admin'),
(7, '22-12345', 'admin'),
(9, '22-54321', 'student'),
(10, '22-67890', 'admin'),
(11, '22-09876', 'student'),
(12, '22-13579', 'admin'),
(13, '22-24680', 'student'),
(14, '22-31415', 'admin'),
(15, '22-27182', 'student'),
(16, '22-16171', 'admin'),
(17, '22-41324', 'student'),
(18, '22-44444', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `statusreport`
--

CREATE TABLE `statusreport` (
  `statusID` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `studentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentinfo`
--

CREATE TABLE `studentinfo` (
  `studentID` int(11) NOT NULL,
  `srCode` varchar(10) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `srCodeID` int(11) NOT NULL,
  `contactNumber` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentinfo`
--

INSERT INTO `studentinfo` (`studentID`, `srCode`, `firstName`, `lastName`, `address`, `age`, `gender`, `pass`, `srCodeID`, `contactNumber`) VALUES
(1, '22-33882', 'Angelo', 'Torano', 'Rosario, Batangas', 22, 'male', '$2y$10$6yUSu5K0QwcGhg9nBc8DEe9c93brSR7AR8KDDRAof6YSSr5X4Dafm', 2, '09123456789'),
(2, '22-37101', 'Rusette Shekinah Marie', 'Araneta', 'Tadlac Alitagtag Batangas', 20, 'Female', '$2y$10$LYidIczAtarNS5PSCGz8LOqkU3AvwDVb8aZHPCwOap3YEj/nwk25C', 4, '09102351029'),
(8, '22-33881', 'user', 'user', 'NA', 22, 'NA', 't0YogsGV+ABG2RToSN1l13hBZS9TNGlSYjZYN3RFVEhjeEdFRkE9PQ==', 3, 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `studentreport`
--

CREATE TABLE `studentreport` (
  `reportID` int(11) NOT NULL,
  `studentID` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `disasterType` varchar(50) NOT NULL,
  `contactNumber` varchar(15) NOT NULL,
  `location` varchar(150) NOT NULL,
  `situation` text NOT NULL,
  `date_reported` date NOT NULL DEFAULT curdate(),
  `date_action` date DEFAULT NULL,
  `action` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentreport`
--

INSERT INTO `studentreport` (`reportID`, `studentID`, `name`, `disasterType`, `contactNumber`, `location`, `situation`, `date_reported`, `date_action`, `action`) VALUES
(1, 1, 'Alice Johnson', 'Earthquake', '555-123-4567', '789 Pine St, Anycity, USA', 'Evacuated with minor injuries.', '2024-10-26', '2024-10-16', 'angelo'),
(2, 2, 'John Johnson', 'Tsunami', '555-123-4567', '789 Pine St, Anycity, USA', 'Evacuated with minor injuries.', '2024-10-26', '2024-09-04', 'asdsadadasdasdawdadawdadwadwada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `srCodeID` (`srCodeID`);

--
-- Indexes for table `hotline`
--
ALTER TABLE `hotline`
  ADD PRIMARY KEY (`hotlineID`);

--
-- Indexes for table `srcode`
--
ALTER TABLE `srcode`
  ADD PRIMARY KEY (`srCodeID`);

--
-- Indexes for table `statusreport`
--
ALTER TABLE `statusreport`
  ADD PRIMARY KEY (`statusID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `srCodeID` (`srCodeID`);

--
-- Indexes for table `studentreport`
--
ALTER TABLE `studentreport`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `studentID` (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admininfo`
--
ALTER TABLE `admininfo`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hotline`
--
ALTER TABLE `hotline`
  MODIFY `hotlineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `srcode`
--
ALTER TABLE `srcode`
  MODIFY `srCodeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `statusreport`
--
ALTER TABLE `statusreport`
  MODIFY `statusID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentinfo`
--
ALTER TABLE `studentinfo`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `studentreport`
--
ALTER TABLE `studentreport`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD CONSTRAINT `admininfo_ibfk_1` FOREIGN KEY (`srCodeID`) REFERENCES `srcode` (`srCodeID`);

--
-- Constraints for table `statusreport`
--
ALTER TABLE `statusreport`
  ADD CONSTRAINT `statusreport_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `studentinfo` (`studentID`);

--
-- Constraints for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD CONSTRAINT `studentinfo_ibfk_1` FOREIGN KEY (`srCodeID`) REFERENCES `srcode` (`srCodeID`);

--
-- Constraints for table `studentreport`
--
ALTER TABLE `studentreport`
  ADD CONSTRAINT `studentreport_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `studentinfo` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
