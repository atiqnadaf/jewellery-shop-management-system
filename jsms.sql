-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2026 at 01:36 PM
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
-- Database: `jsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`) VALUES
(8, 'SALMAN KHAN', '9090909090', 'salman@gmail.com', 'Bandra, Mumbai'),
(9, 'SHAHRUKH KHAN', '8080808080', 'srk@gmail.com', 'Bandra, Mumbai'),
(10, 'AMIR KHAN', '7070707070', 'amir@gmail.com', 'Bandra, Mumbai'),
(11, 'SCARLET JOHANSON', '6060606060', 'bw@gmail.com', 'NEW YORK'),
(15, 'PETER PARKER', '3030303030', 'spidy@gmail.com', 'Queens, NYC'),
(17, 'TONY STARK', '3000300001', 'stark3000@gmail.com', 'Malibu, California');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `item_name`, `category`, `weight`, `price`, `quantity`, `created_at`) VALUES
(9, 'RING (22K)', 'Gold', 5.00, 75000.00, 8, '2026-01-03 11:47:49'),
(10, 'EAR-RING (22K)', 'Gold', 6.00, 54000.00, 14, '2026-01-03 11:50:38'),
(11, 'PENDANT (22K)', 'Gold', 10.00, 126000.00, 4, '2026-01-03 11:52:23'),
(12, 'CHAIN (22K)', 'Gold', 20.00, 249000.00, 7, '2026-01-03 12:27:27'),
(13, 'NOSEPIN (22K)', 'Gold', 0.60, 12000.00, 35, '2026-01-03 12:29:00'),
(14, 'BANGLES (22K)', 'Gold', 20.00, 270000.00, 4, '2026-01-03 12:32:48'),
(15, 'NECKLACE (22K)', 'Gold', 12.00, 175000.00, 10, '2026-01-03 12:36:35'),
(16, 'BRIDAL NECKLACE (22K)', 'Gold', 40.00, 610000.00, 3, '2026-01-03 12:38:45'),
(17, 'MANGALSUTRA (22K)', 'Gold', 7.00, 85000.00, 23, '2026-01-03 12:47:41'),
(18, 'BRACELET (22K)', 'Gold', 12.00, 180000.00, 8, '2026-01-03 12:50:13'),
(19, 'BRACELET', 'Silver', 15.00, 9499.00, 39, '2026-01-03 12:57:16'),
(20, 'KADA (22K)', 'Gold', 20.00, 290000.00, 5, '2026-01-03 12:59:30'),
(21, 'KADA', 'Silver', 100.00, 35000.00, 15, '2026-01-03 12:59:59'),
(22, 'ANKLET', 'Silver', 50.00, 22000.00, 18, '2026-01-03 13:01:19'),
(23, 'KAMARBANDH (22K)', 'Gold', 221.00, 3139233.00, 1, '2026-01-03 13:16:01'),
(24, 'GOLD COIN (24K)', 'Gold', 10.00, 145339.00, 9, '2026-01-03 13:18:56'),
(25, 'SILVER BAR', 'Silver', 1000.00, 286000.00, 5, '2026-01-03 13:20:49'),
(26, 'SILVER BAR', 'Silver', 100.00, 28600.00, 25, '2026-01-03 13:22:13'),
(27, 'GOLD BISCUIT (24K)', 'Gold', 10.00, 145339.00, 29, '2026-01-03 13:26:33'),
(29, 'NOSEPIN', 'Gold', 8.60, 111000.00, 10, '2026-01-08 07:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `sold_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `product_id`, `quantity`, `total_amount`, `sold_by`, `created_at`) VALUES
(16, 8, 19, 1, 9499.00, 'admin', '2024-06-08 06:30:00'),
(17, 10, 27, 1, 145339.00, 'atiq', '2026-01-08 07:50:43'),
(18, 11, 9, 1, 75000.00, 'arif', '2026-02-16 06:51:00'),
(19, 9, 11, 1, 126000.00, 'admin', '2026-03-06 06:30:00'),
(20, 10, 10, 1, 54000.00, 'admin', '2026-03-07 06:30:00'),
(21, 11, 9, 1, 75000.00, 'atiq', '2026-03-08 10:51:26'),
(22, 15, 24, 1, 145339.00, 'arif', '2026-03-19 18:02:28'),
(23, 11, 14, 1, 270000.00, 'admin', '2026-05-31 06:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', 'admin123', 'admin', 'active'),
(7, 'atiq', 'atiqnadaf', 'staff', 'active'),
(8, 'arif', 'arifpathan', 'staff', 'active'),
(9, 'sumit', 'sumitsakhare', 'staff', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
