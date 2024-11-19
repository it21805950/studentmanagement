-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 05:52 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_diploma_institute`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepartmentID` int(11) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepartmentID`, `DepartmentName`) VALUES
(1, 'Computer Science'),
(4, 'Management');

-- --------------------------------------------------------

--
-- Table structure for table `diploma`
--

CREATE TABLE `diploma` (
  `DiplomaID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `DepartmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diploma`
--

INSERT INTO `diploma` (`DiplomaID`, `Title`, `DepartmentID`) VALUES
(1, 'mm', 1),
(2, 'Information Technology', 1),
(3, 'Software Engineering', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `EnrollmentID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `ModuleCode` varchar(10) DEFAULT NULL,
  `ExamResult` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`EnrollmentID`, `StudentID`, `ModuleCode`, `ExamResult`) VALUES
(1, 1, 'CS101', '85.50');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `LecturerID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`LecturerID`, `Name`) VALUES
(1, 'Dr.Prasannajith'),
(2, 'Prof. Ajith');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `ModuleCode` varchar(10) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `CreditValue` int(11) NOT NULL,
  `CoordinatorID` int(11) DEFAULT NULL,
  `DiplomaID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`ModuleCode`, `Title`, `CreditValue`, `CoordinatorID`, `DiplomaID`, `DepartmentID`) VALUES
('CS101', 'Introduction to Computer Science', 3, 1, 1, 1),
('IT201', 'Advanced Information Technology', 4, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modulecoordinator`
--

CREATE TABLE `modulecoordinator` (
  `CoordinatorID` int(11) NOT NULL,
  `ModuleCode` varchar(10) NOT NULL,
  `LecturerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `modulecoordinator`
--

INSERT INTO `modulecoordinator` (`CoordinatorID`, `ModuleCode`, `LecturerID`) VALUES
(1, 'CS101', 1),
(2, 'IT201', 2);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` text DEFAULT NULL,
  `DiplomaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `Name`, `Address`, `DiplomaID`) VALUES
(1, 'sanjula', 'galle', 1),
(4, 'vishara', 'mathale', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentID`);

--
-- Indexes for table `diploma`
--
ALTER TABLE `diploma`
  ADD PRIMARY KEY (`DiplomaID`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `ModuleCode` (`ModuleCode`),
  ADD KEY `fk_student` (`StudentID`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`LecturerID`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`ModuleCode`),
  ADD KEY `CoordinatorID` (`CoordinatorID`),
  ADD KEY `DiplomaID` (`DiplomaID`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- Indexes for table `modulecoordinator`
--
ALTER TABLE `modulecoordinator`
  ADD PRIMARY KEY (`CoordinatorID`,`ModuleCode`,`LecturerID`),
  ADD KEY `ModuleCode` (`ModuleCode`),
  ADD KEY `LecturerID` (`LecturerID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`),
  ADD KEY `DiplomaID` (`DiplomaID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `diploma`
--
ALTER TABLE `diploma`
  MODIFY `DiplomaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `LecturerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diploma`
--
ALTER TABLE `diploma`
  ADD CONSTRAINT `diploma_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`ModuleCode`) REFERENCES `module` (`ModuleCode`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE;

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`CoordinatorID`) REFERENCES `lecturer` (`LecturerID`),
  ADD CONSTRAINT `module_ibfk_2` FOREIGN KEY (`DiplomaID`) REFERENCES `diploma` (`DiplomaID`),
  ADD CONSTRAINT `module_ibfk_3` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`);

--
-- Constraints for table `modulecoordinator`
--
ALTER TABLE `modulecoordinator`
  ADD CONSTRAINT `modulecoordinator_ibfk_1` FOREIGN KEY (`ModuleCode`) REFERENCES `module` (`ModuleCode`),
  ADD CONSTRAINT `modulecoordinator_ibfk_2` FOREIGN KEY (`LecturerID`) REFERENCES `lecturer` (`LecturerID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`DiplomaID`) REFERENCES `diploma` (`DiplomaID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
