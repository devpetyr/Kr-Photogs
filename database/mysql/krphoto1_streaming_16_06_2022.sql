-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2022 at 07:46 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `krphoto1_streaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `competition_date` date DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `url` text,
  `iframe` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `soft_delete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `title`, `competition_date`, `amount`, `status`, `url`, `iframe`, `created_at`, `updated_at`, `soft_delete`) VALUES
(34, 'Boston-Day1', '2022-06-16', 1, 1, NULL, '<div style=\"padding:56.25% 0 0 0;position:relative;\"><iframe src=\"https://vimeo.com/event/2205239/embed/50f178bc13\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen style=\"position:absolute;top:0;left:0;width:100%;height:100%;\"></iframe></div>', '2022-06-09 23:36:09', '2022-06-15 05:28:02', NULL),
(35, 'test', '2022-06-15', 1, 0, NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/hOWUxl6swO4\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-06-15 05:41:55', '2022-06-15 05:42:11', '2022-06-15 05:42:11'),
(37, 'Gaming Day 1', '2022-06-16', 1, 1, NULL, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/YZBE3tQDWv8\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2022-06-15 17:47:30', '2022-06-16 11:49:08', NULL),
(38, 'TOI 2022 - Wednesday', '2022-06-22', 10, 1, NULL, '<div style=\"padding:56.25% 0 0 0;position:relative;\"><iframe src=\"https://vimeo.com/event/2205239/embed/50f178bc13\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen style=\"position:absolute;top:0;left:0;width:100%;height:100%;\"></iframe></div>', '2022-06-15 20:40:31', '2022-06-15 20:40:53', NULL),
(39, 'TOI 2022 - Thursday', '2022-06-23', 10, 1, NULL, '<div style=\"padding:56.25% 0 0 0;position:relative;\"><iframe src=\"https://vimeo.com/event/2205239/embed/50f178bc13\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen style=\"position:absolute;top:0;left:0;width:100%;height:100%;\"></iframe></div>', '2022-06-15 20:41:22', '2022-06-15 20:41:22', NULL),
(40, 'TOI 2022 - Friday', '2022-06-24', 10, 1, NULL, '<div style=\"padding:56.25% 0 0 0;position:relative;\"><iframe src=\"https://vimeo.com/event/2205239/embed/50f178bc13\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen style=\"position:absolute;top:0;left:0;width:100%;height:100%;\"></iframe></div>', '2022-06-15 20:41:46', '2022-06-15 20:41:46', NULL),
(41, 'TOI 2022 - Saturday', '2022-06-25', 10, 1, NULL, '<div style=\"padding:56.25% 0 0 0;position:relative;\"><iframe src=\"https://vimeo.com/event/2205239/embed/50f178bc13\" frameborder=\"0\" allow=\"autoplay; fullscreen; picture-in-picture\" allowfullscreen style=\"position:absolute;top:0;left:0;width:100%;height:100%;\"></iframe></div>', '2022-06-15 20:42:14', '2022-06-15 20:42:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

CREATE TABLE `coupon_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `soft_delete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coupon_codes`
--

INSERT INTO `coupon_codes` (`id`, `code`, `discount`, `competition_id`, `quantity`, `status`, `created_at`, `updated_at`, `soft_delete`) VALUES
(42, 'mycoupon', '100', 34, 8, 1, '2022-06-15 11:43:44', '2022-06-15 13:36:24', NULL),
(43, 'Gaming', '100', 37, 9, 1, '2022-06-15 11:47:55', '2022-06-15 11:48:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_details`
--

CREATE TABLE `coupon_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coupon_details`
--

INSERT INTO `coupon_details` (`id`, `user_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(50, 136, 43, '2022-06-15 17:48:42', '2022-06-15 17:48:42'),
(51, 134, 42, '2022-06-15 19:36:24', '2022-06-15 19:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `forget_pass`
--

CREATE TABLE `forget_pass` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forget_pass`
--

INSERT INTO `forget_pass` (`id`, `user_id`, `code`, `status`, `created_at`, `updated_at`) VALUES
(10, 136, '202206161655387178146', 0, '2022-06-16 12:46:18', '2022-06-16 12:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `competition_name` varchar(255) DEFAULT NULL,
  `competition_date` date DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `redeem_code` varchar(255) DEFAULT NULL,
  `receipt_url` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `soft_delete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `competition_name`, `competition_date`, `user_id`, `price`, `payer_id`, `status`, `redeem_code`, `receipt_url`, `payment_method`, `url`, `created_at`, `updated_at`, `soft_delete`) VALUES
(156, '34', '2022-06-14', '136', '1.00', 'PAYID-MKUOC5Y5E3849330X135105S', 'approved', '202206141655235086501296', NULL, 'paypal', 'https://vimeo.com/event/2205239/embed/50f178bc13', '2022-06-14 12:31:26', '2022-06-14 12:31:26', NULL),
(160, '34', '2022-06-15', '136', '0.00', NULL, 'free', '202206151655318713843939', NULL, 'free coupon', NULL, '2022-06-15 17:45:13', '2022-06-15 17:45:13', NULL),
(161, '37', '2022-06-15', '136', '0.00', NULL, 'free', '202206151655318922925167', NULL, 'free coupon', NULL, '2022-06-15 17:48:42', '2022-06-15 17:48:42', NULL),
(162, '34', '2022-06-15', '134', '0.00', NULL, 'free', '202206151655325384687320', NULL, 'free coupon', NULL, '2022-06-15 19:36:24', '2022-06-15 19:36:24', NULL),
(163, '34', '2022-06-15', '139', '1.00', 'PAYID-MKVEIQA3K508463FV3658146', 'approved', '202206151655325789232031', NULL, 'paypal', NULL, '2022-06-15 19:43:09', '2022-06-15 19:43:09', NULL),
(164, '34', '2022-06-15', '140', '1.00', 'PAYID-MKVFYMI99295891VV597993M', 'approved', '202206151655331917964894', NULL, 'paypal', NULL, '2022-06-15 21:25:17', '2022-06-15 21:25:17', NULL),
(165, '34', '2022-06-15', '141', '1.00', 'PAYID-MKVH7EQ92N99365VT903154H', 'approved', '202206151655340985830758', NULL, 'paypal', NULL, '2022-06-15 23:56:25', '2022-06-15 23:56:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(55) NOT NULL,
  `email` varchar(550) NOT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(555) DEFAULT NULL,
  `user_role` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `server_IP` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `soft_delete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `provider_id`, `avatar`, `password`, `user_role`, `status`, `server_IP`, `created_at`, `updated_at`, `soft_delete`) VALUES
(1, 'admins', 'kevin@krphotogs.com', NULL, NULL, '$2y$10$AFOVyDyzngRmzEmusLH2vutx0Wj4Fax3usD4k9zMw5eoeWPhPGoIG', 1, 1, NULL, '2022-05-25 14:11:10', '2022-06-16 11:39:19', NULL),
(130, 'testuser', 'testuser@mail.com', NULL, NULL, '$2y$10$6ojKOpnHK.sRYdphnM0nUukXkL34DjNAgg89vKNU.WnvjmnyWRBeW', 0, 1, NULL, '2022-06-06 17:49:41', '2022-06-06 17:49:41', NULL),
(131, 'Sam', 'sam@elitedesignhub.com', NULL, NULL, '$2y$10$skjGQRHVhiiwtD2XsvCCdeyp17CN6/KfW0S1eylflxQvSt9FoAIbG', 0, 1, NULL, '2022-06-06 19:27:50', '2022-06-06 19:27:50', NULL),
(132, 'Sam', 'samaustinpm@gmail.com', NULL, NULL, '$2y$10$BNv74nu7ad4MxKd0/CPAXOIreJWzMt54LAv.6C51N8mi0MQCRlMaG', 0, 1, NULL, '2022-06-09 16:43:18', '2022-06-09 23:11:52', NULL),
(134, 'Kevin', 'Kevin@krphotogs.com', NULL, NULL, '$2y$10$abkABvSpHx7f6KZPw.xXjOlcROeKoHBlmbguLA8V9THOmdIbaiBOK', 0, 1, NULL, '2022-06-09 22:56:46', '2022-06-16 11:52:09', NULL),
(136, 'Dev Petyr', 'devpetyr911@gmail.com', NULL, NULL, '$2y$10$66o58gscDBSUo2V2ym3k9ucH8IxEy4LjZYDr3G50mteLN5bIUjds.', 0, 1, NULL, '2022-06-15 09:41:40', '2022-06-16 12:46:40', NULL),
(139, 'SandiStream', 'phelansan@gmail.com', NULL, NULL, '$2y$10$Tf00rAnBi2PEWJbOxNMkXe92wZcvpNzhaTS9HhJ297tsm.yobICPq', 0, 1, NULL, '2022-06-15 19:42:11', '2022-06-15 22:26:38', NULL),
(140, 'mdnorris', 'mdnorris485@gmail.com', NULL, NULL, '$2y$10$nqH18wYRcBiCrfnD/8SaS.HbhJYHYDeDei9rXZK71Tl50wpm0zDVG', 0, 1, NULL, '2022-06-15 21:22:10', '2022-06-15 21:29:33', NULL),
(141, 'Phelanro', 'sk8ndance@comcast.net', NULL, NULL, '$2y$10$VS7t5syrOGjyCpiZedi0belQs2irj6QznmjVrzjG/YXUxtAkpgsqq', 0, 1, NULL, '2022-06-15 23:55:22', '2022-06-15 23:55:22', NULL),
(142, 'kevin', 'kevin4@gmail.com', NULL, NULL, '$2y$10$P1bm0LdA5XyzZ9G6B2tSQ.sGMImuZlmRHX0mzz02lZpQ0TmgwJvFW', 0, 1, NULL, '2022-06-16 11:22:26', '2022-06-16 11:22:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_details`
--
ALTER TABLE `coupon_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`),
  ADD KEY `coupon` (`coupon_id`);

--
-- Indexes for table `forget_pass`
--
ALTER TABLE `forget_pass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `coupon_details`
--
ALTER TABLE `coupon_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `forget_pass`
--
ALTER TABLE `forget_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupon_details`
--
ALTER TABLE `coupon_details`
  ADD CONSTRAINT `coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupon_codes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
