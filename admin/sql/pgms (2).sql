-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 12:31 PM
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
-- Database: `pgms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cleaning_guidelines`
--

CREATE TABLE `cleaning_guidelines` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `frequency` varchar(100) NOT NULL,
  `importance` varchar(50) NOT NULL,
  `equipment` text NOT NULL,
  `safety` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cleaning_period`
--

CREATE TABLE `cleaning_period` (
  `cleaning_id` int(11) NOT NULL,
  `cleaning_frequency` enum('once','twice','thrice','custom') NOT NULL,
  `morning_cleaning_time` time DEFAULT NULL,
  `noon_cleaning_time` time DEFAULT NULL,
  `evening_cleaning_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cleaning_period`
--

INSERT INTO `cleaning_period` (`cleaning_id`, `cleaning_frequency`, `morning_cleaning_time`, `noon_cleaning_time`, `evening_cleaning_time`, `created_at`, `updated_at`) VALUES
(3, 'once', '02:26:00', NULL, NULL, '2024-10-13 06:26:25', '2024-10-13 06:26:25'),
(4, 'once', '17:59:00', NULL, NULL, '2024-10-13 09:59:32', '2024-10-13 09:59:32'),
(5, 'once', '05:00:00', NULL, NULL, '2024-10-13 09:59:54', '2024-10-13 09:59:54');

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
(3, 'Grower', 'Feeds', 1000.00, '2024-10-11'),
(4, 'Starter', 'Feeds', 1000.00, '2024-10-14'),
(5, 'qwe', 'Feeds', 199.00, '2024-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `farrowing`
--

CREATE TABLE `farrowing` (
  `farrowingId` int(11) NOT NULL,
  `pigId` int(11) DEFAULT NULL,
  `penId` int(11) DEFAULT NULL,
  `breeding_date` date DEFAULT NULL,
  `expected_farrowing_date` date DEFAULT NULL,
  `actual_farrowing_date` date DEFAULT NULL,
  `sire` varchar(50) DEFAULT NULL,
  `pregnancy_status` varchar(150) DEFAULT NULL,
  `health_status` varchar(150) DEFAULT NULL,
  `litter_size` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feeding_guidelines`
--

CREATE TABLE `feeding_guidelines` (
  `guide_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pig_stage` enum('newborn','weaner','grower','finisher','sow','lactating','boar') NOT NULL,
  `weight_range` varchar(50) DEFAULT NULL,
  `feed_type` varchar(100) NOT NULL,
  `protein_content` decimal(5,2) NOT NULL,
  `feeding_frequency` varchar(100) DEFAULT NULL,
  `amount_per_feeding` decimal(5,2) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feeding_period`
--

CREATE TABLE `feeding_period` (
  `feeding_id` int(11) NOT NULL,
  `feeding_frequency` enum('once','twice','thrice','custom') NOT NULL,
  `morning_feeding_time` time DEFAULT NULL,
  `noon_feeding_time` time DEFAULT NULL,
  `evening_feeding_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeding_period`
--

INSERT INTO `feeding_period` (`feeding_id`, `feeding_frequency`, `morning_feeding_time`, `noon_feeding_time`, `evening_feeding_time`, `created_at`, `updated_at`) VALUES
(44, 'once', '05:59:00', NULL, NULL, '2024-10-13 09:59:19', '2024-10-13 09:59:19');

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
(6, 'qwe', 'qwe', 199.00, '2024-10-14', 199.00);

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
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `refId` int(11) DEFAULT NULL,
  `actionType` varchar(150) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `userId`, `refId`, `actionType`, `createdAt`, `updatedAt`) VALUES
(26, 'New Feeding Schedule', 'A new Feeding schedule has been added. Please check for details.', 7, 44, 'feeding', '2024-10-13 09:59:19', '2024-10-13 10:07:31'),
(27, 'New Cleaning Schedule', 'A new cleaning schedule has been added. Please check for details.', 7, 3, 'cleaning', '2024-10-13 09:59:32', '2024-10-13 10:20:34'),
(28, 'New Cleaning Schedule', 'A new cleaning schedule has been added. Please check for details.', 7, 1, 'Cleaning Schedule', '2024-10-13 09:59:54', '2024-10-13 09:59:54'),
(29, 'Slaughtering Schedule Update', 'The slaughtering schedule has been updated to: Date - 2024-10-14, Time - 04:51:00.', 7, 14, 'slaughter', '2024-10-13 10:26:02', '2024-10-13 10:27:31');

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
(5, '5', 'active', 17);

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
  `breed` varchar(50) DEFAULT NULL,
  `pig_type` varchar(150) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pigs`
--

INSERT INTO `pigs` (`pig_id`, `ear_tag_number`, `penId`, `status`, `gender`, `breed`, `pig_type`, `weight`, `age`, `notes`, `created_at`, `updated_at`) VALUES
(18, 'ETN001', 5, 'slaughtered', 'female', 'baboy ramo', 'grower', 130.00, '10', 'qwe', '2024-10-12 13:32:11', '2024-10-13 10:26:02'),
(21, 'ETN002', 5, 'slaughtered', 'male', 'baboy ramo', 'boar', 130.00, '5', 'qweqwe', '2024-10-13 07:09:10', '2024-10-13 09:05:52');

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
-- Table structure for table `slaughtering_period`
--

CREATE TABLE `slaughtering_period` (
  `slauId` int(11) NOT NULL,
  `penId` int(11) NOT NULL,
  `pigId` int(11) NOT NULL,
  `slaughtering_date` date NOT NULL,
  `slaughtering_time` time NOT NULL,
  `status` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slaughtering_period`
--

INSERT INTO `slaughtering_period` (`slauId`, `penId`, `pigId`, `slaughtering_date`, `slaughtering_time`, `status`, `created_at`, `updated_at`) VALUES
(14, 5, 18, '2024-10-14', '04:51:00', 'process', '2024-10-13 08:51:12', '2024-10-13 10:26:02'),
(15, 5, 21, '2024-10-14', '04:58:00', 'done', '2024-10-13 08:58:30', '2024-10-13 09:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `userId` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','worker') DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`userId`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '$2y$10$lHnrz8hN5vKF7vCjrkAksONVnGO53iWxgclkgpcpfJLUs.H0mU4PS', 'admin', 'active'),
(7, 'ker', '$2y$10$5sphfzO.lEVyxEmk2.ayNOmyMZpOqOuu6dcxlvzGJKcTIF88UQpI6', 'worker', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cleaning_guidelines`
--
ALTER TABLE `cleaning_guidelines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cleaning_period`
--
ALTER TABLE `cleaning_period`
  ADD PRIMARY KEY (`cleaning_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expenseId`);

--
-- Indexes for table `farrowing`
--
ALTER TABLE `farrowing`
  ADD PRIMARY KEY (`farrowingId`),
  ADD KEY `pigId` (`pigId`),
  ADD KEY `penId` (`penId`);

--
-- Indexes for table `feeding_guidelines`
--
ALTER TABLE `feeding_guidelines`
  ADD PRIMARY KEY (`guide_id`);

--
-- Indexes for table `feeding_period`
--
ALTER TABLE `feeding_period`
  ADD PRIMARY KEY (`feeding_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`userId`);

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
-- Indexes for table `slaughtering_period`
--
ALTER TABLE `slaughtering_period`
  ADD PRIMARY KEY (`slauId`),
  ADD KEY `penId` (`penId`),
  ADD KEY `pigId` (`pigId`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cleaning_guidelines`
--
ALTER TABLE `cleaning_guidelines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cleaning_period`
--
ALTER TABLE `cleaning_period`
  MODIFY `cleaning_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expenseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `farrowing`
--
ALTER TABLE `farrowing`
  MODIFY `farrowingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feeding_guidelines`
--
ALTER TABLE `feeding_guidelines`
  MODIFY `guide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feeding_period`
--
ALTER TABLE `feeding_period`
  MODIFY `feeding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `feedstock`
--
ALTER TABLE `feedstock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `healthguidelines`
--
ALTER TABLE `healthguidelines`
  MODIFY `guideId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pigpen`
--
ALTER TABLE `pigpen`
  MODIFY `penId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pigs`
--
ALTER TABLE `pigs`
  MODIFY `pig_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pigsguidelines`
--
ALTER TABLE `pigsguidelines`
  MODIFY `guideId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slaughtering_period`
--
ALTER TABLE `slaughtering_period`
  MODIFY `slauId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farrowing`
--
ALTER TABLE `farrowing`
  ADD CONSTRAINT `farrowing_ibfk_1` FOREIGN KEY (`pigId`) REFERENCES `pigs` (`pig_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `farrowing_ibfk_2` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `useraccount` (`userId`);

--
-- Constraints for table `pigs`
--
ALTER TABLE `pigs`
  ADD CONSTRAINT `pigs_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`);

--
-- Constraints for table `slaughtering_period`
--
ALTER TABLE `slaughtering_period`
  ADD CONSTRAINT `slaughtering_period_ibfk_1` FOREIGN KEY (`penId`) REFERENCES `pigpen` (`penId`),
  ADD CONSTRAINT `slaughtering_period_ibfk_2` FOREIGN KEY (`pigId`) REFERENCES `pigs` (`pig_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
