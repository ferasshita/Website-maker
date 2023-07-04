-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2023 at 01:26 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forg_pass`
--

CREATE TABLE `forg_pass` (
  `id` int(8) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numi` bigint(100) NOT NULL,
  `time` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `type` int(11) NOT NULL,
  `message` text NOT NULL,
  `read` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `next_pay` varchar(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(8) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `access` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `type`, `value`, `access`) VALUES
(2, 788883262375222, '', 'LYD', 'boss'),
(4, 12, 'main_currency', 'LYD', 'boss'),
(7, 788883262375222, 'main_currency', 'LYD', 'boss'),
(8, 312433213849836, 'main_currency', 'USD', 'boss');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` bigint(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `Password` varchar(100) NOT NULL,
  `account_type` varchar(100) DEFAULT NULL,
  `mode` varchar(100) NOT NULL,
  `login_attempts` bigint(100) DEFAULT NULL,
  `online` int(100) NOT NULL,
  `aSetup` int(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `account_setup` varchar(100) DEFAULT NULL,
  `sus` int(100) NOT NULL,
  `user_activation_code` varchar(250) NOT NULL,
  `phone_activation_code` varchar(100) DEFAULT NULL,
  `user_email_status` enum('not verified','verified') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `username`, `email`, `phone`, `Password`, `account_type`, `mode`, `login_attempts`, `online`, `aSetup`, `language`, `account_setup`, `sus`, `user_activation_code`, `phone_activation_code`, `user_email_status`) VALUES
(164343360248736, 'ferassh', 'shitah@gmal.com', '+218914938468', '$2y$12$ct7PGxJFg6S2jVRdouJAx.S9oTFP4pXLnMxFaLLU6fXtp1SYvpXRW', 'user', 'auto', 2, 0, 0, 'العربية', '29/03/2023', 1, 'f3c2539b0399bbeaf8afc9bd65f17dd7', '747352', 'verified'),
(472543312381240, 'dgdfg', 'sgds@jkf.com', '+21843534', '$2y$12$wmry4irObuyoXTAgp.NU8.IoJrXjHGoFhyAf6R5ugz/BF3Ap6PRjy', 'user', 'auto', NULL, 0, 0, 'العربية', '25-06-2022', 0, 'e67325e2b70b9bf4cb77508d0e4c31cf', '993148', 'not verified'),
(788883262375222, 'feras', 'Shitaras195@gmail.com', '+21809182828', '$2y$12$dx65dRWrnKW8L1h1dSAd0e83YASQyEtPMCB37xS/8wreMzjiyfKWy', 'admin', 'night', 0, 0, 0, 'العربية', '12-09-2021', 0, '1b14b68d50ae75300cfc6e31261d87c0', NULL, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `test` varchar(100) DEFAULT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forg_pass`
--
ALTER TABLE `forg_pass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `forg_pass`
--
ALTER TABLE `forg_pass`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete forgot password` ON SCHEDULE EVERY 10 MINUTE STARTS '2023-04-08 17:27:19' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM `forg_pass`
WHERE time < DATE_SUB(NOW(), INTERVAL 30 MINUTE)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
