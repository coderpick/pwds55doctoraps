-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2025 at 06:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwds_doctor_appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'Patient user id',
  `schedule_id` int NOT NULL,
  `appointment_number` varchar(15) COLLATE utf8mb3_unicode_ci NOT NULL,
  `appointment_reason` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('Pending','Booked','In_Process','Completed','Cancel') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Pending',
  `doctor_comment` text COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `user_id`, `schedule_id`, `appointment_number`, `appointment_reason`, `status`, `doctor_comment`, `created_at`) VALUES
(1, 1, 22, 6, '653733', 'Sick', 'Pending', NULL, '2025-04-19 06:07:51'),
(2, 2, 22, 2, '859602', 'afafaf', 'Pending', NULL, '2025-04-19 06:11:23'),
(3, 1, 23, 6, '273304', 'Fiver', 'Pending', NULL, '2025-04-19 06:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `dob` date NOT NULL,
  `expert_in` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `degree` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `name`, `phone`, `image`, `address`, `dob`, `expert_in`, `degree`, `gender`, `status`, `created_at`) VALUES
(1, 5, 'Monir hossain', '01939981172', 'uploads/174435233567f8b44f5291a.png', 'Dhaka', '1990-04-16', 'Cardiologist', 'MBBS', 'Male', 1, NULL),
(2, 6, 'Ginger Bell', '01755554550', 'uploads/174443533567f9f88767283.jpg', 'Recusandae Laudanti', '1985-04-07', 'Laboriosam nihil im', 'Perferendis in sunt', 'Male', 1, NULL),
(4, 21, 'Dr. Md. Kabir khan', '01756987412', 'uploads/17449518736801da41861d1.png', 'Dhaka', '2025-04-18', 'Gynologist', 'MBBS', 'Male', 1, '2025-04-18 04:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `marital_status` enum('Single','Married') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `name`, `phone`, `address`, `gender`, `dob`, `marital_status`, `created_at`) VALUES
(1, 16, 'Hall Leon', '01725697440', 'Dhaka', 'Male', '1986-05-09', 'Single', '2025-04-16 02:59:39'),
(2, 17, 'Caryn Hayden', '01755555444', 'Repudiandae laborum', 'Female', '1970-08-14', 'Married', '2025-04-16 03:00:17'),
(3, 19, 'Brody Graham', '01923569874', 'Natore', 'Male', '1988-10-11', 'Married', '2025-04-16 03:14:32'),
(4, 20, 'Connor Patel', '01723659874', 'Dhka', 'Female', '1980-05-22', 'Married', '2025-04-17 22:32:49'),
(5, 22, 'Mr. Jamal', '01756123654', 'Natore', 'Male', '1990-02-17', 'Married', '2025-04-19 04:32:01'),
(6, 23, 'Sabina', '01723659874', 'Rajshahi', 'Female', '1984-05-26', 'Married', '2025-04-19 06:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_day` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `start_time` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `end_time` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `consulting_time` int NOT NULL,
  `maximum_appointment` int NOT NULL,
  `status` enum('Available','Cancel') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Available',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `doctor_id`, `schedule_date`, `schedule_day`, `start_time`, `end_time`, `consulting_time`, `maximum_appointment`, `status`, `created_at`) VALUES
(2, 2, '2025-04-23', 'Wednesday', '10:00 AM', '01:00 PM', 15, 20, 'Available', '2025-04-16 06:15:42'),
(3, 1, '2025-04-18', 'Saturday', '03:00 PM', '06:00 PM', 15, 15, 'Available', '2025-04-18 05:06:39'),
(4, 4, '2025-04-19', 'Saturday', '07:00 AM', '10:00 AM', 15, 15, 'Available', '2025-04-18 05:10:50'),
(6, 1, '2025-04-21', 'Monday', '08:00 AM', '10:00 AM', 15, 10, 'Available', '2025-04-18 06:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('Active','Inacitve') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Active',
  `type` enum('admin','doctor','patient') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `type`) VALUES
(1, 'Mr. Admin', 'admin@gmail.com', '$2y$10$Nw.qJbsJw4Py8qswWTS55ut4G/kH9Cjy9bbB6kMoBNPP5ep4IpejG', 'Active', 'admin'),
(2, 'Rubel', 'rubel@gmail.com', '$2y$10$9.cAAv6rFG.olsoax5ceC.Q3z41jvbo.VugDPxae2y./YQtQBszNu', 'Active', 'patient'),
(5, 'Monir hossain', 'hafizur@gmail.com', '$2y$10$DGj8LVHa9zcVY1XjxuRQueZY5STGMxuVKIW9xy2NcOtcDcTP/VV3m', 'Active', 'doctor'),
(6, 'Ginger Bell', 'wynohaboxy@mailinator.com', '$2y$10$yaKmZpzV17YFjdsOCXuln.07HJ0ibGQsnhPHXfVhnNpEStRjFI9G2', 'Active', 'doctor'),
(16, 'Hall Leon', 'hexequ@mailinator.com', '$2y$10$7AUAu1VG7FRybp7LSAiBeuXsPuX1kMP2UnSKHEH4efHAyqQwAX.Ty', 'Active', 'patient'),
(17, 'Caryn Hayden', 'fuqyq@mailinator.com', '$2y$10$DwJqeyVd1flqvad/oxbOVOztY6AEiYJlwOSOP3Vkge6CcAzuNHrky', 'Active', 'patient'),
(19, 'Brody Graham', 'kamyqulo@mailinator.com', '$2y$10$lGpeCRO6nP6gbpKGIaQO4uJH91ZcheHF.NfkKFH1zKG.XTcT5ihKO', 'Active', 'patient'),
(20, 'Connor Patel', 'tipiryfuqy@mailinator.com', '$2y$10$I3bs3oDJ/iSdbAr.wkG3QOw51cZak4HAs1NoO2GexHFtQkDpfxyD6', 'Active', 'patient'),
(21, 'Dr. Md. Kabir khan', 'kabir@gmail.com', '$2y$10$QLpv9ubJIehldNyKQQLE7ORDx2w/gQ/eQW4gH/g6GQS.U1Lc2cXjK', 'Active', 'doctor'),
(22, 'Mr. Jamal', 'jamal@gmail.com', '$2y$10$F41WVyoMmQku6p7UKlnf3.e5BUNh9xhea/74nHi7onlC.fkN1Rbxm', 'Active', 'patient'),
(23, 'Sabina', 'sabina@gmail.com', '$2y$10$Z.Uj.YlQ74XcTAR4VBXM..CBuI51jGJH8JhOHHu16IBptecBYqzSe', 'Active', 'patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_doctor_id_index` (`doctor_id`),
  ADD KEY `appointments_user_id_index` (`user_id`),
  ADD KEY `appointments_schedule_id_index` (`schedule_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_index` (`user_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_index` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_doctor_id_index` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
