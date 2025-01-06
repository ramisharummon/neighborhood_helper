-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 08:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neighborhoodhelper`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `EventID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `PostedBy` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `EventDate` datetime NOT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `RSVPCount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupmember`
--

CREATE TABLE `groupmember` (
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `JoinDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helpoffer`
--

CREATE TABLE `helpoffer` (
  `OfferID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Availability` varchar(50) DEFAULT NULL,
  `OfferDate` datetime DEFAULT current_timestamp(),
  `Status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `helpoffer`
--

INSERT INTO `helpoffer` (`OfferID`, `UserID`, `Title`, `Description`, `Category`, `Price`, `Availability`, `OfferDate`, `Status`) VALUES
(1, 2, 'Yard Work Assistance', 'I can help with mowing, weeding, and general yard maintenance.', 'Home Repairs', 15.00, 'Weekends', '2025-01-06 17:06:31', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `helprequest`
--

CREATE TABLE `helprequest` (
  `RequestID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `UrgencyLevel` enum('Low','Medium','High') DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `RequestDate` datetime DEFAULT current_timestamp(),
  `TimeFrame` varchar(50) DEFAULT NULL,
  `Status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `helprequest`
--

INSERT INTO `helprequest` (`RequestID`, `UserID`, `Title`, `Description`, `Category`, `UrgencyLevel`, `Location`, `RequestDate`, `TimeFrame`, `Status`) VALUES
(3, 1, 'Looking for someone to pick up groceries', 'I need someone to pick up groceries for me, including fruits, vegetables, and canned goods.', 'Errands', 'Medium', '123 Main St, Springfield', '2025-01-06 17:11:02', 'Morning', 'Pending'),
(5, 3, 'Babysitter for 2 hours', 'Looking for a responsible babysitter to look after my 5-year-old for 2 hours in the evening.', 'Childcare', 'Low', '789 Oak St, Springfield', '2025-01-06 17:11:02', 'Evening', 'Pending'),
(6, 4, 'Looking for someone to help with yard work', 'I need assistance with mowing the lawn and trimming the bushes this weekend.', 'Home Repairs', 'Medium', '101 Maple St, Springfield', '2025-01-06 17:11:02', 'Weekend', 'Pending'),
(7, 5, 'Help needed with dog walking', 'I need help walking my dog for about 30 minutes, ideally in the late afternoon.', 'Pet Care', 'Low', '202 Pine St, Springfield', '2025-01-06 17:11:02', 'Late Afternoon', 'Pending'),
(8, 6, 'Tutoring for high school math', 'Looking for someone to tutor my son in high school algebra and geometry.', 'Teaching', 'Medium', '303 Cedar St, Springfield', '2025-01-06 17:11:02', 'Weekends', 'Pending'),
(9, 7, 'Help needed for moving furniture', 'Need help lifting and moving furniture for a small apartment move this weekend.', 'Moving Assistance', 'High', '404 Birch St, Springfield', '2025-01-06 17:11:02', 'Weekend', 'Pending'),
(10, 8, 'Need help setting up a home theater system', 'Looking for someone to help me set up my new home theater system this weekend.', 'Home Repairs', 'Medium', '505 Walnut St, Springfield', '2025-01-06 17:11:02', 'Weekend', 'Pending'),
(11, 9, 'Help cleaning garage', 'Looking for assistance to clean and organize my garage. Some heavy lifting required.', 'Errands', 'Low', '606 Cherry St, Springfield', '2025-01-06 17:11:02', 'Evening', 'Pending'),
(12, 10, 'Help needed with cooking dinner', 'I need assistance preparing dinner for a small family gathering. Must have cooking experience.', 'Cooking', 'Medium', '707 Poplar St, Springfield', '2025-01-06 17:11:02', 'Evening', 'Pending'),
(13, 1, '', '', '', '', '', '2025-01-06 19:24:09', '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ItemID` int(11) NOT NULL,
  `OwnerID` int(11) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `AvailabilityStatus` enum('Available','Borrowed') DEFAULT 'Available',
  `BorrowedBy` int(11) DEFAULT NULL,
  `BorrowDate` datetime DEFAULT NULL,
  `ReturnDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `ReviewedUserID` int(11) NOT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `Comment` text DEFAULT NULL,
  `Timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Location` varchar(100) NOT NULL,
  `Bio` text DEFAULT NULL,
  `Interests` longtext DEFAULT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Phone`, `Password`, `Location`, `Bio`, `Interests`, `ProfilePicture`) VALUES
(1, 'John Doe', 'john.doe@example.com', '123-456-7890', 'password123', '123 Main St, Springfield', 'Hellow', '[\"gardening\", \"tutoring\", \"Spending Money\"]', NULL),
(2, 'Jane Smith', 'jane.smith@example.com', '234-567-8901', 'securepassword', '456 Elm St, Springfield', 'Passionate about animal care and teaching.', '[\"pet care\", \"teaching\"]', NULL),
(3, 'Michael Johnson', 'michael.j@example.com', '345-678-9012', 'mypassword', '789 Oak St, Springfield', 'Enjoys DIY projects and woodworking.', '[\"home repairs\", \"woodworking\"]', NULL),
(4, 'Emily Davis', 'emily.davis@example.com', '456-789-0123', 'emilypass', '101 Maple St, Springfield', 'Loves to organize events and meet new people.', '[\"event planning\", \"volunteering\"]', NULL),
(5, 'Chris Brown', 'chris.brown@example.com', '567-890-1234', 'chrisrocks', '202 Pine St, Springfield', 'Tech-savvy and enjoys helping others with tech issues.', '[\"technology assistance\", \"coding\"]', NULL),
(6, 'Sarah Wilson', 'sarah.wilson@example.com', '678-901-2345', 'sarahsecure', '303 Cedar St, Springfield', 'Avid reader and loves to tutor kids.', '[\"reading\", \"childcare\"]', NULL),
(7, 'David Lee', 'david.lee@example.com', '789-012-3456', 'leesecret', '404 Birch St, Springfield', 'Enjoys working on cars and helping neighbors.', '[\"car repairs\", \"errands\"]', NULL),
(8, 'Sophia Martinez', 'sophia.martinez@example.com', '890-123-4567', 'sophiapass', '505 Walnut St, Springfield', 'Loves pets and volunteering at shelters.', '[\"pet care\", \"volunteering\"]', NULL),
(9, 'Daniel Anderson', 'daniel.anderson@example.com', '901-234-5678', 'danpass', '606 Cherry St, Springfield', 'Hobbyist cook who enjoys teaching others.', '[\"cooking\", \"teaching\"]', NULL),
(10, 'Emma Thompson', 'emma.thompson@example.com', '012-345-6789', 'emmapass', '707 Poplar St, Springfield', 'Fitness enthusiast who offers personal training.', '[\"fitness\", \"personal training\"]', NULL),
(11, 'Shakil Ahmed', 'shakilofficial0@gmail.com', '01627523107', 'demo123', 'Dhaka, Bangladesh', 'Checking', 'Multiple Topics', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `GroupID` (`GroupID`),
  ADD KEY `PostedBy` (`PostedBy`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`GroupID`),
  ADD KEY `CreatedBy` (`CreatedBy`);

--
-- Indexes for table `groupmember`
--
ALTER TABLE `groupmember`
  ADD PRIMARY KEY (`GroupID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `helpoffer`
--
ALTER TABLE `helpoffer`
  ADD PRIMARY KEY (`OfferID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `helprequest`
--
ALTER TABLE `helprequest`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `OwnerID` (`OwnerID`),
  ADD KEY `BorrowedBy` (`BorrowedBy`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `ReviewerID` (`ReviewerID`),
  ADD KEY `ReviewedUserID` (`ReviewedUserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helpoffer`
--
ALTER TABLE `helpoffer`
  MODIFY `OfferID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `helprequest`
--
ALTER TABLE `helprequest`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `group` (`GroupID`) ON DELETE SET NULL,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`PostedBy`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `groupmember`
--
ALTER TABLE `groupmember`
  ADD CONSTRAINT `groupmember_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `group` (`GroupID`) ON DELETE CASCADE,
  ADD CONSTRAINT `groupmember_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `helpoffer`
--
ALTER TABLE `helpoffer`
  ADD CONSTRAINT `helpoffer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `helprequest`
--
ALTER TABLE `helprequest`
  ADD CONSTRAINT `helprequest_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`OwnerID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`BorrowedBy`) REFERENCES `user` (`UserID`) ON DELETE SET NULL;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`ReviewerID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`ReviewedUserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
