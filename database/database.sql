-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2020 at 04:08 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chicks`
--
CREATE DATABASE IF NOT EXISTS `chicks` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chicks`;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--
-- Creation: Jun 04, 2020 at 02:20 AM
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `contact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `bill`:
--   `contact_id`
--       `contact` -> `id`
--

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `name`, `address`, `description`, `created_at`, `updated_at`, `contact_id`) VALUES
(22, 'Subash Niroula', 'Calle Juan De La Cueva, 10, Flat:-6B', '', '2020-07-10 06:56:39', '2020-07-10 06:56:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--
-- Creation: May 17, 2020 at 05:59 AM
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `contact`:
--

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `address`, `phone`, `email`, `description`, `created_at`) VALUES
(1, 'Subash Niroula', 'Calle Juan De La Cueva, 10, Flat:-6B', '655849885', 'subash.niroula4455@gmail.com', '', '2020-06-17 02:14:57'),
(32, 'Sunam Niroula', 'Bkt', '9854321789', 'sunamniroula@gmail.com', 'Test sunam accout', '2020-07-09 06:08:46'),
(33, 'Oskar Niroula', 'Ratuwamai 9 itahara', '9800923375', 'oscaroscar184458@gmail.com', 'good not bad', '2020-07-10 06:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `transistion`
--
-- Error reading structure for table chicks.transistion: #1932 - Table 'chicks.transistion' doesn't exist in engine
-- Error reading data for table chicks.transistion: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `chicks`.`transistion`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `transistions`
--
-- Creation: Jul 09, 2020 at 05:07 AM
-- Last update: Jul 11, 2020 at 01:52 PM
--

DROP TABLE IF EXISTS `transistions`;
CREATE TABLE `transistions` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` double NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `transistions`:
--   `bill_id`
--       `bill` -> `id`
--   `contact_id`
--       `contact` -> `id`
--   `contact_id`
--       `contact` -> `id`
--

--
-- Dumping data for table `transistions`
--

INSERT INTO `transistions` (`id`, `type`, `title`, `name`, `address`, `quantity`, `rate`, `contact_id`, `bill_id`, `description`, `created_at`, `updated_at`) VALUES
(21, 'Sell', 'veg chicken 2', 'Oskar Niroula', 'Ratuwamai 9 itahara', 6, 9, 33, 22, 'malai aaudaina', '2020-07-08 06:53:36', '2020-07-11 13:48:51'),
(23, 'Sell', 'Egg', 'Subash Niroula', 'Calle Juan De La Cueva, 10, Flat:-6B', 4, 30, 1, NULL, 'Egg of local chicken for hatching', '2020-06-05 18:15:00', '2020-07-11 13:52:51'),
(24, 'Buy', 'Chicken Feed B2', 'Sunam Niroula', 'Bkt', 1, 2500, 32, NULL, '1 bora, 25kg', '2020-07-11 03:09:28', '2020-07-11 03:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `website_info`
--
-- Creation: May 03, 2020 at 06:39 AM
--

DROP TABLE IF EXISTS `website_info`;
CREATE TABLE `website_info` (
  `id` int(11) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `val` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `website_info`:
--

--
-- Dumping data for table `website_info`
--

INSERT INTO `website_info` (`id`, `attribute`, `val`, `created_at`, `updated_at`) VALUES
(1, 'name', 'Local Chicken EGG Hatchery', '2020-05-03 06:34:42', '2020-05-17 06:56:25'),
(2, 'short_name', 'LCEH', '2020-05-03 06:34:42', '2020-05-18 06:08:23'),
(3, 'phone', '9842391055', '2020-05-03 06:44:00', '2020-05-03 06:44:00'),
(4, 'address', 'Ratuwamai-9, Morang, Province No 1, Nepal ', '2020-05-03 06:44:00', '2020-05-03 06:44:00'),
(5, 'email', '', '2020-05-03 06:44:24', '2020-05-18 02:51:57'),
(6, 'password', '$2y$10$9NsJjUqbZAUL5NVjrk03M.STK2zksZbr.Jv8Q7i/ISGhEVNOgnGiy', '2020-05-03 07:15:24', '2020-07-09 13:51:17'),
(7, 'reset_email', 'subash.niroula4455@gmail.com', '2020-05-03 07:15:24', '2020-05-03 07:15:24'),
(8, 'reset_email', 'subashn015339@nec.edu.np', '2020-05-03 07:15:51', '2020-05-03 07:15:51'),
(9, 'username', 'Manaslu', '2020-05-03 08:00:22', '2020-05-16 09:11:37'),
(24, 'profile_pic', '_profile_pic_1589620297_5ebfae4950fa0_.png', '2020-05-13 02:21:23', '2020-05-16 09:11:37'),
(36, 'carousel_image', '_slideshow_20_05_16_Saturday_11_12_30_am_1589620350_5ebfae7e74702.jpg', '2020-05-16 09:12:30', '2020-05-16 09:12:30'),
(37, 'carousel_image', '_slideshow_20_05_17_Sunday_10_55_14_am_1589705714_5ec0fbf277f32.jpg', '2020-05-17 08:55:14', '2020-05-17 08:55:14'),
(39, 'carousel_image', '_slideshow_20_07_10_Friday_08_59_44_am_1594364384_5f0811e0ecf25.jpg', '2020-07-10 06:59:45', '2020-07-10 06:59:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contact_id` (`contact_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transistions`
--
ALTER TABLE `transistions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bill_id` (`bill_id`),
  ADD KEY `fk_contact_id_ref` (`contact_id`);

--
-- Indexes for table `website_info`
--
ALTER TABLE `website_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `transistions`
--
ALTER TABLE `transistions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `website_info`
--
ALTER TABLE `website_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_contact_id` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`);

--
-- Constraints for table `transistions`
--
ALTER TABLE `transistions`
  ADD CONSTRAINT `fk_bill_id` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contact_id_ref` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contact_id_ref_contact_table` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
