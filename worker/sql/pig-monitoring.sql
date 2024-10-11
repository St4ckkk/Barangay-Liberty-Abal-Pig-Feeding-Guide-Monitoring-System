-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 04:10 PM
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
-- Database: `pig-monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `boosting`
--

CREATE TABLE `boosting` (
  `boostId` int(11) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `schedId` int(11) DEFAULT NULL,
  `status` enum('done','undone') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consumption`
--

CREATE TABLE `consumption` (
  `consumpId` int(11) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `schedId` int(11) DEFAULT NULL,
  `itemId` int(11) DEFAULT NULL,
  `Qty` int(11) NOT NULL,
  `status` enum('Good','Not Good') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disinfection`
--

CREATE TABLE `disinfection` (
  `disId` int(11) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `schedId` int(11) DEFAULT NULL,
  `status` enum('Clean','Not Clean') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disinfectionguidelines`
--

CREATE TABLE `disinfectionguidelines` (
  `guideId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `guideDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disinfectionguidelines`
--

INSERT INTO `disinfectionguidelines` (`guideId`, `title`, `description`, `guideDate`) VALUES
(7, 'hamburger', 'qwjpqjwe', '2024-10-10 00:10:05'),
(8, 'wow', 'wowo', '2024-10-10 00:11:11'),
(9, 'haloo', 'qweq', '2024-10-10 00:12:43'),
(10, 'wowo', 'wowoow', '2024-10-10 00:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expenseId` int(11) NOT NULL,
  `expenseName` varchar(150) DEFAULT NULL,
  `expenseType` varchar(150) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `expenseDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expenseId`, `expenseName`, `expenseType`, `total`, `expenseDate`) VALUES
(2, 'Starter', 'Feeds', 1000.00, NULL),
(3, 'Grower', 'Feeds', 1000.00, '2024-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `farrowing_monitoring`
--

CREATE TABLE `farrowing_monitoring` (
  `id` int(11) NOT NULL,
  `sow_id` int(11) DEFAULT NULL,
  `breeding_date` date NOT NULL,
  `expected_farrowing_date` date NOT NULL,
  `actual_farrowing_date` date DEFAULT NULL,
  `litter_size` int(11) DEFAULT NULL,
  `piglets_born_alive` int(11) DEFAULT NULL,
  `piglets_born_dead` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feeding`
--

CREATE TABLE `feeding` (
  `feedId` int(11) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `schedId` int(11) DEFAULT NULL,
  `status` enum('finish','not finish') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedingguidelines`
--

CREATE TABLE `feedingguidelines` (
  `guideId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `guideDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedingguidelines`
--

INSERT INTO `feedingguidelines` (`guideId`, `title`, `description`, `guideDate`) VALUES
(1, 'test', 'test', '2024-10-10 00:05:58'),
(2, 'hamburger', 'hamburger', '2024-10-10 00:09:40'),
(3, 'sheesh', 'qwjpoqwe', '2024-10-10 00:13:29'),
(4, 'we', 'qwe', '2024-10-10 00:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `feedstock`
--

CREATE TABLE `feedstock` (
  `id` int(11) NOT NULL,
  `feedsName` varchar(255) NOT NULL,
  `feedsDescription` text DEFAULT NULL,
  `feedsCost` decimal(10,2) DEFAULT NULL,
  `feed_purchase_date` date DEFAULT NULL,
  `QtyOFoodPerSack` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedstock`
--

INSERT INTO `feedstock` (`id`, `feedsName`, `feedsDescription`, `feedsCost`, `feed_purchase_date`, `QtyOFoodPerSack`) VALUES
(3, 'Starter', 'qweqwe', 1000.00, NULL, 1.00),
(4, 'Grower', 'qweqwe', 1000.00, '2024-10-11', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `healthguidelines`
--

CREATE TABLE `healthguidelines` (
  `guideId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `guideDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `healthguidelines`
--

INSERT INTO `healthguidelines` (`guideId`, `title`, `description`, `guideDate`) VALUES
(1, 'wowo health', 'qowjeoqjwe', '2024-10-10 00:16:07');

-- --------------------------------------------------------

--
-- Table structure for table `pigpen`
--

CREATE TABLE `pigpen` (
  `penId` int(11) NOT NULL,
  `penno` varchar(50) NOT NULL,
  `penstatus` enum('active','inactive') NOT NULL,
  `pigcount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pigpen`
--

INSERT INTO `pigpen` (`penId`, `penno`, `penstatus`, `pigcount`) VALUES
(1, '123qwe', 'active', 98),
(2, '123', 'inactive', 100),
(3, '123123', 'active', 200),
(4, '123123', 'inactive', 50);

-- --------------------------------------------------------

--
-- Table structure for table `pigs`
--

CREATE TABLE `pigs` (
  `pig_id` int(11) NOT NULL,
  `ear_tag_number` varchar(20) NOT NULL,
  `penId` int(11) NOT NULL,
  `status` varchar(150) NOT NULL DEFAULT 'none',
  `gender` enum('male','female') DEFAULT NULL,
  `health_status` enum('healthy','sick','injured') NOT NULL DEFAULT 'healthy',
  `last_health_check` date DEFAULT NULL,
  `breed` varchar(50) DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pigs`
--

INSERT INTO `pigs` (`pig_id`, `ear_tag_number`, `penId`, `status`, `gender`, `health_status`, `last_health_check`, `breed`, `acquisition_date`, `weight`, `age`, `notes`) VALUES
(16, 'ETN0005', 1, 'ready for breeding', 'female', 'healthy', NULL, 'baboy ramo', '2024-10-10', 123.00, 12, 'qwe'),
(17, 'ETN0004', 1, 'ready for slaughter', 'male', 'healthy', NULL, 'baboy ramo', '2024-10-11', 123.00, 12, 'qweqwe');

-- --------------------------------------------------------

--
-- Table structure for table `pigsguidelines`
--

CREATE TABLE `pigsguidelines` (
  `guideId` int(11) NOT NULL,
  `pigType` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pigsguidelines`
--

INSERT INTO `pigsguidelines` (`guideId`, `pigType`, `breed`, `sex`, `description`) VALUES
(1, 'qwe', 'qweq', 'Male', 'qweqweqwe'),
(2, 'qw', 'qw', 'Male', 'qwe');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedId` int(11) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `schedTime` varchar(255) NOT NULL,
  `schedDate` date DEFAULT NULL,
  `schedType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedId`, `penId`, `schedTime`, `schedDate`, `schedType`) VALUES
(26, 1, '18:40', NULL, 'Feeding'),
(27, 2, '18:40', NULL, 'Feeding'),
(28, 3, '18:40', NULL, 'Feeding'),
(29, 4, '18:40', NULL, 'Feeding'),
(34, 1, '18:25', '2024-10-11', 'Slaughtering'),
(35, NULL, '21:11', NULL, 'Cleaning');

-- --------------------------------------------------------

--
-- Table structure for table `slaughter`
--

CREATE TABLE `slaughter` (
  `slauId` int(11) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `schedId` int(11) DEFAULT NULL,
  `userStatus` enum('process','unprocess','done') NOT NULL,
  `pigId` int(11) NOT NULL,
  `slaughtering_date` date NOT NULL,
  `slaughtering_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slaughter`
--

INSERT INTO `slaughter` (`slauId`, `penId`, `schedId`, `userStatus`, `pigId`, `slaughtering_date`, `slaughtering_time`) VALUES
(10, 1, NULL, 'process', 17, '2024-10-11', '18:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `sows`
--

CREATE TABLE `sows` (
  `sow_id` int(10) NOT NULL,
  `penId` int(11) DEFAULT NULL,
  `pigId` int(11) NOT NULL,
  `status` varchar(155) DEFAULT 'Active',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sows`
--

INSERT INTO `sows` (`sow_id`, `penId`, `pigId`, `status`, `last_updated`) VALUES
(3, 1, 16, 'Active', '2024-10-10 12:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `password`, `status`) VALUES
(2, 'St4ckkk', '$2y$10$88Mv05EDOITCnaSszAHcl.xas69cFX2Oe6ldntbNg7dJPInJl87Z6', 'inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boosting`
--
ALTER TABLE `boosting`
  ADD PRIMARY KEY (`boostId`),
  ADD KEY `penId` (`penId`),
  ADD KEY `schedId` (`schedId`);

--
-- Indexes for table `consumption`
--
ALTER TABLE `consumption`
  ADD PRIMARY KEY (`consumpId`),
  ADD KEY `penId` (`penId`),
  ADD KEY `schedId` (`schedId`),
  ADD KEY `itemId` (`itemId`);

--
-- Indexes for table `disinfection`
--
ALTER TABLE `disinfection`
  ADD PRIMARY KEY (`disId`),
  ADD KEY `penId` (`penId`),
  ADD KEY `schedId` (`schedId`);

--
-- Indexes for table `disinfectionguidelines`
--
ALTER TABLE `disinfectionguidelines`
  ADD PRIMARY KEY (`guideId`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expenseId`);

--
-- Indexes for table `farrowing_monitoring`
--
ALTER TABLE `farrowing_monitoring`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sow` (`sow_id`);

--
-- Indexes for table `feeding`
--
ALTER TABLE `feeding`
  ADD PRIMARY KEY (`feedId`),
  ADD KEY `penId` (`penId`),
  ADD KEY `schedId` (`schedId`);

--
-- Indexes for table `feedingguidelines`
--
ALTER TABLE `feedingguidelines`
  ADD PRIMARY KEY (`guideId`);

--
-- Indexes for table `feedstock`
--
ALTER TABLE `feedstock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `healthguidelines`
--
ALTER TABLE `healthguidelines`
  ADD PRIMARY KEY (`guideId`);

--
-- Indexes for table `pigpen`
--
ALTER TABLE `pigpen`
  ADD PRIMARY KEY (`penId`);

--
-- Indexes for table `pigs`
--
ALTER TABLE `pigs`
  ADD PRIMARY KEY (`pig_id`),
  ADD UNIQUE KEY `ear_tag_number` (`ear_tag_number`),
  ADD KEY `penId` (`penId`);

--
-- Indexes for table `pigsguidelines`
--
ALTER TABLE `pigsguidelines`
  ADD PRIMARY KEY (`guideId`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedId`),
  ADD KEY `fk_penId` (`penId`);

--
-- Indexes for table `slaughter`
--
ALTER TABLE `slaughter`
  ADD PRIMARY KEY (`slauId`),
  ADD KEY `penId` (`penId`),
  ADD KEY `schedId` (`schedId`),
  ADD KEY `fk_pigId` (`pigId`);

--
-- Indexes for table `sows`
--
ALTER TABLE `sows`
  ADD PRIMARY KEY (`sow_id`),
  ADD KEY `fk_pen` (`penId`),
  ADD KEY `fk_sows_pigId` (`pigId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boosting`
--
ALTER TABLE `boosting`
  MODIFY `boostId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consumption`
--
ALTER TABLE `consumption`
  MODIFY `consumpId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disinfection`
--
ALTER TABLE `disinfection`
  MODIFY `disId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disinfectionguidelines`
--
ALTER TABLE `disinfectionguidelines`
  MODIFY `guideId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expenseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `farrowing_monitoring`
--
ALTER TABLE `farrowing_monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feeding`
--
ALTER TABLE `feeding`
  MODIFY `feedId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedingguidelines`
--
ALTER TABLE `feedingguidelines`
  MODIFY `guideId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedstock`
--
ALTER TABLE `feedstock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `healthguidelines`
--
ALTER TABLE `healthguidelines`
  MODIFY `guideId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pigpen`
--
ALTER TABLE `pigpen`
  MODIFY `penId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pigs`
--
ALTER TABLE `pigs`
  MODIFY `pig_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pigsguidelines`
--
ALTER TABLE `pigsguidelines`
  MODIFY `guideId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `slaughter`
--
ALTER TABLE `slaughter`
  MODIFY `slauId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sows`
--
ALTER TABLE `sows`
  MODIFY `sow_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boosting`
--
ALTER TABLE `boosting`
  ADD CONSTRAINT `boosting_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `boosting_ibfk_2` FOREIGN KEY (`schedId`) REFERENCES `schedule` (`schedId`);

--
-- Constraints for table `consumption`
--
ALTER TABLE `consumption`
  ADD CONSTRAINT `consumption_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `consumption_ibfk_2` FOREIGN KEY (`schedId`) REFERENCES `schedule` (`schedId`),
  ADD CONSTRAINT `consumption_ibfk_3` FOREIGN KEY (`itemId`) REFERENCES `items` (`itemId`);

--
-- Constraints for table `disinfection`
--
ALTER TABLE `disinfection`
  ADD CONSTRAINT `disinfection_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `disinfection_ibfk_2` FOREIGN KEY (`schedId`) REFERENCES `schedule` (`schedId`);

--
-- Constraints for table `farrowing_monitoring`
--
ALTER TABLE `farrowing_monitoring`
  ADD CONSTRAINT `fk_sow` FOREIGN KEY (`sow_id`) REFERENCES `sows` (`sow_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feeding`
--
ALTER TABLE `feeding`
  ADD CONSTRAINT `feeding_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `feeding_ibfk_2` FOREIGN KEY (`schedId`) REFERENCES `schedule` (`schedId`);

--
-- Constraints for table `pigs`
--
ALTER TABLE `pigs`
  ADD CONSTRAINT `pigs_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_penId` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`);

--
-- Constraints for table `slaughter`
--
ALTER TABLE `slaughter`
  ADD CONSTRAINT `fk_pigId` FOREIGN KEY (`pigId`) REFERENCES `pigs` (`pig_id`),
  ADD CONSTRAINT `slaughter_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `slaughter_ibfk_2` FOREIGN KEY (`schedId`) REFERENCES `schedule` (`schedId`);

--
-- Constraints for table `sows`
--
ALTER TABLE `sows`
  ADD CONSTRAINT `fk_pen` FOREIGN KEY (`penID`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `fk_sows_pigId` FOREIGN KEY (`pigId`) REFERENCES `pigs` (`pig_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
