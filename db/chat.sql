-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2024 at 10:54 PM
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
-- Database: `Chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE DATABASE `users` IF NOT EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` varchar(65) NOT NULL,
  `picture` varchar(65) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `picture`, `created_date`) VALUES
(1, 'Martian', '$2y$10$9wV50CLZkTqacT/.szuD0uPNLjBiXWmXwYNexuUqCH1ZhdjMOtuVS', '65d0c79aaf8dagithub_nitro.gif', '2024-02-17 14:50:02'),
(2, 'Billy', '$2y$10$mgAtbOiUeEk/XSofOL5QnujwtakHFiFbsCJdMXxT6vgUxrRHcbQ0m', '65d0c938875bf_47-businessman-png-image.png', '2024-02-17 14:56:56'),
(3, 'Goblin', '$2y$10$2w975TDtCMTsh9QKTXgu0ek.87M4Sl47NuEIN9uIAsQV4ui7.VVEm', '65d0ca7ef03f3_20231007_162126_mfnr.jpg', '2024-02-17 15:02:23'),
(4, 'Layem', '$2y$10$X6VaICJy6WAJMRTv0ATLV.Mz/tng/Y4jQ1l3ws715EKI2U17/1e.q', '65d25c91c08a9_Screenshot_20240215-190346.png', '2024-02-18 19:37:53'),
(5, 'Leo', '$2y$10$B8WE72G5NJWkZqGjdgFGWez12rhqtcdUzMbKf.boaY4APM9aDBTqm', '65d271f9332e2_20231229_211722.jpg', '2024-02-18 21:09:13'),
(6, 'Edward-San', '$2y$10$KIMrVpji8yhpSrE8T8e7V.zl9ugN6N7RvDB1Mlk13pEC4kZ0PFXe2', '65d2ab41ae11a_olajide.jpg', '2024-02-19 01:13:37'),
(7, 'Olayemi', '$2y$10$NExVaW7ohVIOrz0U5l.y0.1XS7NrC5Ld8HFMyL7CEfId5M2IlrhgK', '65d8fa74964e5_Screenshot_20240221-211852.png', '2024-02-23 20:05:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
