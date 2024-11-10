-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 03:24 AM
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
-- Database: `hotelbookingweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_pass`) VALUES
(1, 'khoa', '123');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `checked` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `feature_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `feature_name`) VALUES
(53, 'Bedroom'),
(54, 'Baclcony'),
(56, 'Sofa');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `area`, `price`, `quantity`, `adult`, `children`, `image`, `description`, `status`) VALUES
(31, 'Premium King Room', 30, 4000000, 4, 4, 2, 'IMG_27464.jpg', 'abc', 1),
(32, 'Deluxe room', 15, 2500000, 5, 3, 2, 'IMG_93669.jpg', 'abc', 1),
(33, 'Double room', 18, 3000000, 9, 3, 2, 'IMG_15355.jpg', 'abc', 1),
(34, 'Luxury room', 14, 4500000, 7, 2, 1, 'IMG_79171.jpg', 'abc', 1),
(35, 'Room With View', 19, 2000000, 10, 4, 2, 'IMG_77432.jpg', 'abc', 1),
(37, 'Room With View', 19, 2000000, 10, 4, 2, 'IMG_92325.jpg', 'abac', 1),
(38, 'Room With View', 19, 2000000, 10, 4, 2, 'IMG_18453.jpg', 'avc', 1),
(39, 'Room With View', 19, 2000000, 10, 4, 2, 'IMG_58610.jpg', 'ádd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_features`
--

CREATE TABLE `rooms_features` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms_features`
--

INSERT INTO `rooms_features` (`id`, `room_id`, `feature_id`) VALUES
(63, 32, 53),
(64, 32, 56),
(65, 33, 53),
(66, 33, 54),
(67, 34, 53),
(68, 34, 54),
(69, 34, 56),
(70, 35, 54),
(75, 37, 54),
(76, 38, 54),
(83, 39, 54),
(84, 39, 56),
(85, 31, 53),
(86, 31, 54),
(87, 31, 56);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_services`
--

CREATE TABLE `rooms_services` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms_services`
--

INSERT INTO `rooms_services` (`id`, `room_id`, `service_id`) VALUES
(88, 32, 46),
(89, 32, 49),
(90, 32, 50),
(91, 33, 46),
(92, 33, 47),
(93, 33, 49),
(94, 33, 50),
(95, 34, 45),
(96, 34, 46),
(97, 34, 47),
(98, 34, 48),
(99, 34, 49),
(100, 34, 50),
(101, 35, 46),
(102, 35, 47),
(103, 35, 50),
(108, 37, 46),
(109, 38, 45),
(110, 38, 50),
(117, 39, 45),
(118, 39, 46),
(119, 31, 45),
(120, 31, 46),
(121, 31, 49);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `image`, `description`) VALUES
(45, 'Bar & Drink', 'IMG_17365.png', 'abc'),
(46, 'Travel Plan', 'IMG_78913.png', 'abc'),
(47, 'Babysitting', 'IMG_99718.png', 'abc'),
(48, 'Catering', 'IMG_29340.png', 'abc'),
(49, 'Laundry', 'IMG_41607.png', 'abc'),
(50, 'Hire Driver', 'IMG_26353.png', 'abc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `rooms_features`
--
ALTER TABLE `rooms_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feature id` (`feature_id`),
  ADD KEY `rooms id` (`room_id`);

--
-- Indexes for table `rooms_services`
--
ALTER TABLE `rooms_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room id` (`room_id`),
  ADD KEY `service id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `rooms_features`
--
ALTER TABLE `rooms_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `rooms_services`
--
ALTER TABLE `rooms_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms_features`
--
ALTER TABLE `rooms_features`
  ADD CONSTRAINT `feature id` FOREIGN KEY (`feature_id`) REFERENCES `features` (`feature_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rooms id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `rooms_services`
--
ALTER TABLE `rooms_services`
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `service id` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
