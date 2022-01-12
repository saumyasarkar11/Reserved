-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2021 at 08:22 AM
-- Server version: 8.0.27-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_id`, `username`, `email`, `password`, `type`) VALUES
(1, 'admin', 'saumyasarkar27@gmail.com', '20c9d51cad35f1a134fe31c9950a38c4', 'Master'),
(2, 'setup', 'rajeev.k.sarkar@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Setup');

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `config_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `pay_percent` int NOT NULL,
  `terms` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`config_id`, `title`, `footer`, `pay_percent`, `terms`) VALUES
(1, ' Sri Sri Balananda Ashrams', 'Sri Sri Balananda Ashrams and Trusts', 100, '1. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar. \r\n\r\n2. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar. \r\n\r\n3. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar. \r\n\r\n4. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.  \r\n\r\n5. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `guest_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `address` mediumtext NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pin` varchar(7) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`guest_id`, `name`, `email`, `phone`, `aadhaar`, `address`, `city`, `state`, `pin`, `country`) VALUES
(4, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(5, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(6, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(7, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(8, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(9, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(10, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(11, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(12, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(13, 'Rajib Sarkar', 'rks@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(14, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(15, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(16, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(17, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(18, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(19, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(20, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(21, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', '700114', 'India'),
(22, 'Arun Basu', 'tecworth@gmail.com', '9674434061', '276210019223', 'Dumdum', 'Kolkata', 'West Bengal', '700077', 'India'),
(23, 'Arghya Sadhukhan', 'tecworth@gmail.com', '9423735423', '276210019223', '199, S.N. Banerjee Road', 'Kolkata', 'West Bengal', '700120', 'India');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `status`) VALUES
(1, 'Deogarh', 'Open'),
(2, 'Durgapur', 'Open'),
(3, 'Murshidabad', 'Open'),
(4, 'Bankura', 'Open'),
(5, 'Vrindavan', 'Open'),
(6, 'Rishikesh', 'Open'),
(7, 'Haridwar', 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int NOT NULL,
  `location_id` int NOT NULL,
  `property_name` varchar(100) NOT NULL,
  `property_address` mediumtext NOT NULL,
  `check_in_time` varchar(10) NOT NULL,
  `check_out_time` varchar(10) NOT NULL,
  `mojo_api` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mojo_key` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `location_id`, `property_name`, `property_address`, `check_in_time`, `check_out_time`, `mojo_api`, `mojo_key`, `phone`, `email`, `password`, `status`) VALUES
(1, 4, 'Sree Sree Balananda Tirthashram', 'Prorap Bagan, Bankura, West Bengal, Pincode : 722101.', '12:00', '11:00', 'test_fe7418703f081514b4b71a564ef', 'test_c947bbb1b516a06632a15685418', '9830110244', 'mail@saumyasarkar.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Open'),
(3, 1, 'Sri Sri Balananda Ashram', 'P.O. Ashram Karanibad, Deogarh, Pin: 814112', '12:00', '11:00', 'test_fe7418703f081514b4b71a564ef', 'test_c947bbb1b516a06632a15685418', '6203886498', 'tecworth@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int NOT NULL,
  `reservation_number` varchar(20) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `property_id` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` int NOT NULL,
  `paid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `address` mediumtext NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pin` int NOT NULL,
  `country` varchar(50) NOT NULL,
  `payment_id` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `reservation_number`, `check_in`, `check_out`, `property_id`, `time`, `amount`, `paid`, `name`, `email`, `phone`, `aadhaar`, `address`, `city`, `state`, `pin`, `country`, `payment_id`, `status`) VALUES
(11, 'ABCD123', '2021-11-23', '2021-11-25', 1, '2021-11-23 01:52:27', 3600, 3600, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', 700114, 'India', 'MOJO1b23E05N78394768', 'Success'),
(12, 'ABCD123', '2021-11-23', '2021-11-25', 1, '2021-11-23 02:44:47', 3600, 3600, 'Arghya Sadhukhan', 'tecworth@gmail.com', '9423735423', '276210019223', '199, S.N. Banerjee Road', 'Kolkata', 'West Bengal', 700120, 'India', '-', 'Session timed out'),
(16, 'ABCD123', '2021-11-25', '2021-11-27', 1, '2021-11-25 03:44:40', 3600, 3600, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', 700114, 'India', 'cash', 'Success'),
(18, 'ABCD123', '2021-11-25', '2021-11-27', 1, '2021-11-25 03:56:50', 3600, 3600, 'Saumya Sarkar', 'saumyasarkar27@gmail.com', '9830110244', '276210019223', 'CC-2, 102, Peerless Nagar, Sodepur', 'Kolkata', 'West Bengal', 700114, 'India', 'cash', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_rooms`
--

CREATE TABLE `reserved_rooms` (
  `id` int NOT NULL,
  `reservation_id` int NOT NULL,
  `room_id` int NOT NULL,
  `qty` int NOT NULL,
  `date` date NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reserved_rooms`
--

INSERT INTO `reserved_rooms` (`id`, `reservation_id`, `room_id`, `qty`, `date`, `status`) VALUES
(34, 11, 1, 1, '2021-11-23', 'Booked'),
(35, 11, 1, 1, '2021-11-24', 'Booked'),
(36, 12, 1, 3, '2021-11-23', 'Pending'),
(37, 12, 1, 3, '2021-11-24', 'Pending'),
(42, 16, 1, 1, '2021-11-25', 'Booked'),
(43, 16, 1, 1, '2021-11-26', 'Booked'),
(44, 17, 1, 1, '2021-11-25', 'Booked'),
(45, 17, 1, 1, '2021-11-26', 'Booked'),
(46, 18, 1, 1, '2021-11-25', 'Booked'),
(47, 18, 1, 1, '2021-11-26', 'Booked'),
(48, 19, 1, 1, '2021-11-25', 'Pending'),
(49, 19, 1, 1, '2021-11-26', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int NOT NULL,
  `property_id` int NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `room_desc` mediumtext NOT NULL,
  `room_total` int NOT NULL,
  `tariff` int NOT NULL,
  `sequence` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `property_id`, `room_type`, `room_desc`, `room_total`, `tariff`, `sequence`) VALUES
(1, 1, 'AC Deluxe', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt ultricies mauris eget scelerisque.', 4, 1800, 1),
(2, 1, 'AC Suite', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt ultricies mauris eget scelerisque.', 2, 2600, 2);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int NOT NULL,
  `terms` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `terms`) VALUES
(1, '1. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.\r\n\r\n2. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.\r\n\r\n3. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.\r\n\r\n4. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.\r\n\r\n5. Cras tincidunt diam quis risus convallis, euismod pretium massa pulvinar.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `reserved_rooms`
--
ALTER TABLE `reserved_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `config_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reserved_rooms`
--
ALTER TABLE `reserved_rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
