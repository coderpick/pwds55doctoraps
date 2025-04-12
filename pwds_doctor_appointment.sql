-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2025 at 06:52 AM
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
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `phone` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` mediumtext COLLATE utf8mb3_unicode_ci,
  `dob` date NOT NULL,
  `expert_in` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `degree` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `phone`, `image`, `address`, `dob`, `expert_in`, `degree`, `gender`, `status`, `created_at`) VALUES
(1, 5, '01739981172', 'uploads/174435233567f8b44f5291a.png', 'Dhaka', '1990-04-16', 'Cardiologist', 'MBBS', 'Male', 'Active', NULL),
(2, 6, '01755554550', 'uploads/174435257567f8b53fb525f.png', 'Recusandae Laudanti', '1985-04-07', 'Laboriosam nihil im', 'Perferendis in sunt', 'Male', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` enum('Active','Inacitve') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Active',
  `type` enum('admin','doctor','patient') COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `type`) VALUES
(1, 'Mr. Admin', 'admin@gmail.com', '$2y$10$Nw.qJbsJw4Py8qswWTS55ut4G/kH9Cjy9bbB6kMoBNPP5ep4IpejG', 'Active', 'admin'),
(2, 'Rubel', 'rubel@gmail.com', '$2y$10$9.cAAv6rFG.olsoax5ceC.Q3z41jvbo.VugDPxae2y./YQtQBszNu', 'Active', 'patient'),
(5, 'Hafizur Rahman', 'hafizur@gmail.com', '$2y$10$DGj8LVHa9zcVY1XjxuRQueZY5STGMxuVKIW9xy2NcOtcDcTP/VV3m', 'Active', 'doctor'),
(6, 'Ginger Bell', 'wynohaboxy@mailinator.com', '$2y$10$yaKmZpzV17YFjdsOCXuln.07HJ0ibGQsnhPHXfVhnNpEStRjFI9G2', 'Active', 'doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
