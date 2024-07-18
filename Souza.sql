-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2024 at 11:32 AM
-- Server version: 8.0.37-0ubuntu0.22.04.3
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Souza`
--

-- --------------------------------------------------------

--
-- Table structure for table `ims_itemcodes`
--

CREATE TABLE `ims_itemcodes` (
  `id` int NOT NULL,
  `cat` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sunits` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ims_itemcodes`
--

INSERT INTO `ims_itemcodes` (`id`, `cat`, `code`, `description`, `sunits`) VALUES
(1, 'Clothing', 'CLOTH001', 'T-shirt', 'pcs'),
(2, 'Clothing', 'CLOTH002', 'Jeans', 'pcs'),
(3, 'Electronics', 'ELEC001', 'Smartphone', 'pcs'),
(4, 'Electronics', 'ELEC002', 'Laptop', 'pcs'),
(5, 'Grocery', 'GROC001', 'Apple', 'kg'),
(6, 'Grocery', 'GROC002', 'Milk', 'litres');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `invoice_number` int NOT NULL,
  `items` text,
  `basic_amount` float DEFAULT NULL,
  `discount_type` varchar(50) DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `total_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`invoice_number`, `items`, `basic_amount`, `discount_type`, `discount`, `total_price`) VALUES
(1, '[{\"cat\":\"Electronics\",\"item_code\":\"ELEC002\",\"description\":\"Laptop\",\"units\":\"pcs\",\"quantity\":\"10\",\"price\":\"50\",\"vat_code\":\"2\"}]', 510, 'percentage', 10, 459);

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

CREATE TABLE `vat` (
  `id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `vatper` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vat`
--

INSERT INTO `vat` (`id`, `code`, `vatper`) VALUES
(1, 'vat1', 2),
(2, 'vat2', 3),
(3, 'vat3', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ims_itemcodes`
--
ALTER TABLE `ims_itemcodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`invoice_number`);

--
-- Indexes for table `vat`
--
ALTER TABLE `vat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ims_itemcodes`
--
ALTER TABLE `ims_itemcodes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `invoice_number` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vat`
--
ALTER TABLE `vat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
