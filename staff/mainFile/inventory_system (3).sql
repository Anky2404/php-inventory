-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 01:50 PM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `id` int(12) NOT NULL,
  `product_id` varchar(40) NOT NULL,
  `vendor_id` varchar(40) NOT NULL,
  `qty` varchar(140) NOT NULL,
  `address` longtext DEFAULT NULL,
  `assigned_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`id`, `product_id`, `vendor_id`, `qty`, `address`, `assigned_at`) VALUES
(1, '4', '15', '1', '2203 Musgrave Street Chandler, OK 74834', '2024-09-14 17:14:43'),
(2, '1', '16', '1', '76 Fox Lane, BODDAM ZE2 0FQ', '2024-09-14 17:18:46'),
(3, '1', '16', '3', '34 Walden Road GREAT WENHAM CO7 5SH', '2024-09-14 17:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(12) NOT NULL,
  `name` varchar(155) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'Archie Craven', 'ArchieCraven@armyspy.com', '0158730126', 'I’m interested in learning more about your cloud-based data solutions. Specifically, I would like to know about your platform’s integration capabilities, scalability, analytics features, security measures, and pricing.\r\n\r\nCould you please provide more details or arrange a brief call to discuss further?', '2024-08-13 12:09:08'),
(2, 'James I. Berg', 'JamesIBerg@armyspy.com', '6183282270', 'An electronic product refers to a device that utilizes electronic science and technology, such as microelectronics and electronic computers, to process information, convert energy, and perform various functions like storage, computation, and control.', '2024-09-16 15:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(12) NOT NULL,
  `order_no` varchar(100) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `product_id` varchar(40) NOT NULL,
  `email` varchar(200) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` datetime NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(50) NOT NULL,
  `address` longtext DEFAULT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `customer_name`, `product_id`, `email`, `qty`, `status`, `created_by`, `phone`, `address`, `user_id`) VALUES
(1, '#ORD28634', 'Melvin K. Hollins', '1', 'MelvinKHollins@dayrep.com', '3', 1, '2024-09-16 17:06:23', '402-444-5234', '3235 Centennial Farm Road\r\nOmaha, NE 68102', '18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(12) NOT NULL,
  `product_name` varchar(155) NOT NULL,
  `image` varchar(100) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` longtext DEFAULT NULL,
  `storage_level` varchar(60) NOT NULL,
  `status` int(12) NOT NULL DEFAULT 1,
  `product_quantity` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `image`, `product_price`, `product_description`, `storage_level`, `status`, `product_quantity`, `created_at`) VALUES
(1, 'SuperFlex Insulation Tape', '1725258924.png', 30.00, 'A high-performance insulation tape designed to withstand extreme temperatures, ensuring durability and reliability in demanding environments', 'High-Temperature Storage', 1, '200', '2024-09-02 12:05:24'),
(4, 'Precision Air Filter', '1725264665.png', 545.00, 'A high-efficiency air filter that maintains optimal air quality by removing fine particulate matter, ideal for sensitive environments', 'Climate Controlled Rack', 1, '60', '2024-09-02 13:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(12) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `product_name` varchar(155) NOT NULL,
  `customer_phone` varchar(80) NOT NULL,
  `review` longtext DEFAULT NULL,
  `created_by` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `customer_name`, `product_name`, `customer_phone`, `review`, `created_by`) VALUES
(1, 'Connor Marsh', 'SuperFlex Insulation Tape', '092 851 536', 'SuperFlex Insulation Tape works great for keeping things insulated and is easy to apply. It sticks well and performs as advertised. My only gripe is that it’s a bit pricey and sometimes doesn’t stick to rough surfaces. Overall, a solid choice for insulation needs.', '2024-09-14 14:05:11'),
(2, 'Max Leonard', 'Precision Air Filter', '05 3833 6132', 'The Precision Air Filter does an excellent job of capturing dust and allergens, significantly improving air quality. It fits perfectly and is easy to install. My only issue is that it’s a bit more expensive than other filters, but the performance makes it worth the extra cost. Overall, it’s a great choice for anyone looking to enhance their indoor air quality.', '2024-09-14 14:07:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('1','2','3','4') NOT NULL COMMENT '1=Admin,2=User,3=staff,4=vendor\r\n',
  `name` varchar(80) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` int(12) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `contact`, `email`, `password`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'Manager', '07 3803 6136', 'Manager@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Address', 2, '2024-04-14 20:10:42', '2024-09-02 08:56:34'),
(2, '2', 'Connor Marsh', '092 851 536', 'ConnorMarsh@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '52 Cheriton Rd, WEST STONESDALE DL11 6PE', 1, '2024-04-15 19:41:08', '2024-09-03 05:24:10'),
(3, '2', 'Jayden Young', '078 349 066', 'JaydenYoung@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '76 Fox Lane, BODDAM ZE2 0FQ', 1, '2024-04-15 19:42:45', '2024-09-02 05:28:32'),
(5, '2', 'Noah Dean', '07 3803 6139', 'NoahDean@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '34 Walden Road GREAT WENHAM CO7 5SH', 1, '2024-08-12 03:17:44', '2024-09-02 05:24:01'),
(6, '2', 'Max Leonard', '05 3833 6132', 'MaxLeonard@jourrapid0.com', '25d55ad283aa400af464c76d713c07ad', '2203 Musgrave Street\nChandler, OK 74834', 1, '2024-08-12 03:28:01', '2024-09-02 05:24:18'),
(8, '2', 'Venessa G. Conner', '09 3803 6136', 'VenessaGConner@teleworm.us', '25d55ad283aa400af464c76d713c07ad', '766 Davis Place Lima, OH 45801', 1, '2024-08-12 04:32:21', '2024-09-02 05:24:29'),
(9, '2', 'Archie Craven', '03 3853 6139', 'ArchieCraven@armyspy.com', '25d55ad283aa400af464c76d713c07ad', '92 Ross Street NATURAL BRIDGE QLD 4211', 1, '2024-08-12 06:59:30', '2024-09-03 05:21:40'),
(10, '3', 'Cornelius G Tripp', '636-299-5837', 'CorneliusGTripp@dayrep.com', '25d55ad283aa400af464c76d713c07ad', '922 Ross Street NATURAL BRIDGE QLD 4211', 1, '2024-09-02 07:25:15', '2024-09-03 05:12:11'),
(11, '3', 'Riley Seekamp', '586-771-1774', 'RileySeekamp@dayrep.com', '25d55ad283aa400af464c76d713c07ad', '2265 Ritter Avenue Roseville, MI 48066', 1, '2024-09-02 08:08:02', '2024-09-02 08:08:59'),
(12, '3', 'Joel Forro', '915-873-0126', 'JoelForro@teleworm.us', '25d55ad283aa400af464c76d713c07ad', '4352 Frederick Street\r\nEl Paso, TX 79906', 1, '2024-09-02 08:09:38', '2024-09-02 10:51:11'),
(15, '4', 'Isabel Shea', '(02) 6111 1170', 'IsabelOShea@armyspy.com', '25d55ad283aa400af464c76d713c07ad', '68 Scenic Road\r\nPRIMROSE VALLEY NSW 2621', 1, '2024-09-14 06:40:02', '2024-09-14 09:57:03'),
(16, '4', 'Claire Levvy', '(03) 5305 8657', 'ClaireLevvy@jourrapide.com', '25d55ad283aa400af464c76d713c07ad', '36 Bourke Crescent\r\nVASEY VIC 3407', 1, '2024-09-14 11:47:51', '2024-09-14 11:47:51'),
(17, '2', 'Eun Hunter', '2294206117', 'EunTHunter@jourrapide.com', '25d55ad283aa400af464c76d713c07ad', '3959 Duck Creek Road San Francisco, CA 94108', 1, '2024-09-16 05:55:24', '2024-09-16 06:07:41'),
(18, '2', 'Jennifer Creasey', '7062867508', 'JenniferLCreasey@rhyta.com', '25d55ad283aa400af464c76d713c07ad', '4659 Holly Street Athens, GA 30608', 1, '2024-09-16 06:03:43', '2024-09-16 06:03:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned`
--
ALTER TABLE `assigned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
-- AUTO_INCREMENT for table `assigned`
--
ALTER TABLE `assigned`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
