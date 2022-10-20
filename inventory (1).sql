-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2022 at 09:43 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender` int(12) UNSIGNED NOT NULL,
  `receiver` int(12) UNSIGNED NOT NULL,
  `msg` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `product_id` int(12) UNSIGNED NOT NULL,
  `actual_price` bigint(20) UNSIGNED NOT NULL COMMENT 'actual cost of the product ',
  `is_for_sale` tinyint(1) NOT NULL COMMENT '0 -> not for sale\r\n1 -> for sale',
  `sale_cost` bigint(20) UNSIGNED NOT NULL COMMENT 'default seller cost',
  `status` int(11) UNSIGNED NOT NULL,
  `repaire_cost` bigint(20) UNSIGNED NOT NULL,
  `last_repaired_on` datetime NOT NULL,
  `uprade_cost` bigint(20) UNSIGNED NOT NULL,
  `last_upgraded_on` datetime NOT NULL,
  `damaged_on` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `maintainer` int(12) UNSIGNED NOT NULL,
  `assigned_to` int(10) UNSIGNED NOT NULL,
  `assigned_on` datetime DEFAULT NULL,
  `sell-by` int(11) UNSIGNED NOT NULL,
  `created_on` datetime NOT NULL COMMENT 'product entry date',
  `bought_on` datetime NOT NULL COMMENT 'product buyied date',
  `expired_on` datetime NOT NULL COMMENT 'expire date',
  `sold_on` datetime NOT NULL COMMENT 'product sold on date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `inventory`
--
DELIMITER $$
CREATE TRIGGER `INSERT_PRO_CODE` BEFORE INSERT ON `inventory` FOR EACH ROW SET new.code=CONCAT('INV-',(SELECT AUTO_INCREMENT
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = "inventory"
AND TABLE_NAME = "inventory"))
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inventory_after_insert` AFTER INSERT ON `inventory` FOR EACH ROW BEGIN
 insert into timeline(assert_id,status,action,cost,comment,created_on,created_by) values(new.id,new.status,'INSERT',new.actual_price,'',new.created_on,new.created_by);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_status`
--

CREATE TABLE `inventory_status` (
  `id` int(11) UNSIGNED NOT NULL,
  `status_name` varchar(255) NOT NULL,
  `in_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_status`
--

INSERT INTO `inventory_status` (`id`, `status_name`, `in_active`, `created_on`) VALUES
(1, 'Usable', '0', '2022-06-29 06:35:51'),
(2, 'Damaged', '0', '2022-06-29 06:35:51'),
(3, 'Repaired', '0', '2022-06-29 06:35:51'),
(4, 'Upgrade', '0', '2022-06-29 06:35:51'),
(5, 'Sold', '0', '2022-06-29 06:35:51'),
(6, 'Completed Repair', '0', '2022-06-29 06:35:51'),
(7, 'Completed Upgrade', '0', '2022-06-29 06:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(12) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(12) UNSIGNED NOT NULL,
  `category` int(12) UNSIGNED NOT NULL,
  `sub_category` int(12) UNSIGNED NOT NULL,
  `default_price` bigint(20) UNSIGNED NOT NULL,
  `tags` mediumtext NOT NULL,
  `is_upgrable` enum('0','1') NOT NULL DEFAULT '0',
  `is_repairable` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `updated_on` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(12) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `type`, `category`, `sub_category`, `default_price`, `tags`, `is_upgrable`, `is_repairable`, `status`, `updated_on`, `created_on`, `created_by`) VALUES
(1, 'Samsung s21', 8, 1, 9, 120000, 'kk,io,op,\'jkjk', '0', '0', '0', '2022-06-21 17:37:03', '2022-06-21 17:37:03', 1),
(2, ' 3 - pin', 8, 1, 12, 120, 'pin holder,electrical ,diy', '0', '0', '0', '2022-06-21 17:42:47', '2022-06-21 17:42:47', 1),
(3, 'Pin holder', 8, 1, 12, 100, 'pin,samsung,op', '0', '0', '0', '2022-06-23 13:02:31', '2022-06-23 13:02:31', 1),
(4, 'sam watch', 13, 3, 14, 1000, 'i watch, apple watch,op', '0', '1', '1', '2022-06-29 11:38:26', '2022-06-29 11:38:26', 1),
(5, 'Sam h234 head band', 13, 8, 21, 2000, 'earphones,headband,samsung,op', '0', '0', '1', '2022-06-29 11:46:22', '2022-06-29 11:46:22', 1),
(7, 'Samsung S420', 13, 2, 22, 200000, 'Samsung phone,Under 30000,above 199999', '0', '0', '1', '2022-06-29 11:58:45', '2022-06-29 11:58:45', 1),
(8, 'Samsung E2', 8, 1, 9, 1000, 'op', '1', '1', '1', '2022-06-29 12:02:19', '2022-06-29 12:02:19', 1),
(9, 'Samsung E1', 8, 1, 9, 1000, 'op', '0', '1', '1', '2022-06-29 12:02:42', '2022-06-29 12:02:42', 1),
(11, 'Samsung E', 8, 1, 9, 1000, 'op', '0', '0', '1', '2022-06-29 12:03:24', '2022-06-29 12:03:24', 1),
(12, 'Polo shirts', 20, 22, 23, 400, 'tshirts,clothings,mens', '1', '1', '1', '2022-08-21 11:32:31', '2022-08-21 11:32:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(12) UNSIGNED NOT NULL,
  `type` int(12) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  `created_by` int(12) UNSIGNED NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `type`, `category`, `status`, `created_on`, `created_by`, `updated_on`) VALUES
(1, 8, 'Samsung', '1', '2022-06-18 20:20:24', 1, '2022-06-18 20:20:24'),
(2, 13, 'Smart phones', '1', '2022-06-18 20:28:24', 1, '2022-06-18 20:28:24'),
(3, 13, 'Tablet', '1', '2022-06-18 20:34:09', 1, '2022-06-18 20:34:09'),
(4, 13, 'Gaming', '1', '2022-06-19 10:45:20', 1, '2022-06-19 10:45:20'),
(5, 8, 'Processer', '1', '2022-06-19 10:49:28', 1, '2022-06-19 10:49:28'),
(6, 13, 'Components', '1', '2022-06-19 10:59:02', 1, '2022-06-19 10:59:02'),
(7, 13, 'Components', '1', '2022-06-19 10:59:41', 1, '2022-06-19 10:59:41'),
(8, 13, 'earphones', '1', '2022-06-19 11:26:57', 1, '2022-06-19 11:26:57'),
(9, 8, 'chip', '1', '2022-06-19 11:27:59', 1, '2022-06-19 11:27:59'),
(10, 8, 'Micro controller', '1', '2022-06-19 12:18:10', 1, '2022-06-19 12:18:10'),
(11, 8, 'Micro controller', '1', '2022-06-19 12:18:52', 1, '2022-06-19 12:18:52'),
(12, 8, 'text', '1', '2022-06-19 12:20:56', 1, '2022-06-19 12:20:56'),
(13, 8, 'Testing', '1', '2022-06-19 12:22:38', 1, '2022-06-19 12:22:38'),
(14, 8, 'hh', '1', '2022-06-19 12:23:01', 1, '2022-06-19 12:23:01'),
(15, 8, 'Help', '1', '2022-06-19 12:30:14', 1, '2022-06-19 12:30:14'),
(16, 8, 'zzzz', '1', '2022-06-19 12:33:03', 1, '2022-06-19 12:33:03'),
(17, 8, 'ioip', '1', '2022-06-19 12:34:05', 1, '2022-06-19 12:34:05'),
(18, 8, 'zzz', '1', '2022-06-19 12:34:40', 1, '2022-06-19 12:34:40'),
(19, 14, 'Mac book', '1', '2022-06-20 11:52:35', 1, '2022-06-20 11:52:35'),
(20, 13, 'Samsung', '1', '2022-06-20 12:10:56', 1, '2022-06-20 12:10:56'),
(21, 19, 'hi', '1', '2022-06-20 12:54:59', 1, '2022-06-20 12:54:59'),
(22, 20, 'Mens', '1', '2022-08-21 11:23:15', 1, '2022-08-21 11:23:15'),
(23, 20, 'Womens', '1', '2022-08-21 11:23:51', 1, '2022-08-21 11:23:51'),
(24, 16, 'op', '1', '2022-08-21 11:25:27', 1, '2022-08-21 11:25:27'),
(25, 16, 'op', '1', '2022-08-21 11:27:37', 1, '2022-08-21 11:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_category`
--

CREATE TABLE `product_sub_category` (
  `id` int(12) UNSIGNED NOT NULL,
  `type_id` int(12) UNSIGNED NOT NULL,
  `category_id` int(12) UNSIGNED NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_by` int(12) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_sub_category`
--

INSERT INTO `product_sub_category` (`id`, `type_id`, `category_id`, `sub_category_name`, `status`, `created_on`, `updated_on`, `created_by`) VALUES
(9, 8, 1, 'Smart phones', '1', '2022-06-20 12:08:05', '2022-06-20 12:08:05', 1),
(10, 8, 5, 'Intel', '1', '2022-06-20 12:09:50', '2022-06-20 12:09:50', 1),
(11, 8, 10, 'Rasberry', '1', '2022-06-20 12:37:48', '2022-06-20 12:37:48', 1),
(12, 8, 1, 'plug', '1', '2022-06-20 12:46:54', '2022-06-20 12:46:54', 1),
(13, 13, 4, 'op', '1', '2022-06-20 12:47:34', '2022-06-20 12:47:34', 1),
(14, 13, 3, 'Apple', '1', '2022-06-20 12:50:09', '2022-06-20 12:50:09', 1),
(15, 13, 3, 'Apple', '1', '2022-06-20 12:50:59', '2022-06-20 12:50:59', 1),
(16, 8, 5, 'op', '1', '2022-06-20 12:51:17', '2022-06-20 12:51:17', 1),
(17, 8, 1, 'help', '1', '2022-06-20 12:52:00', '2022-06-20 12:52:00', 1),
(18, 8, 1, 'op', '1', '2022-06-20 12:54:10', '2022-06-20 12:54:10', 1),
(19, 19, 21, 'bye', '1', '2022-06-20 12:55:12', '2022-06-20 12:55:12', 1),
(20, 19, 21, 'tata', '1', '2022-06-20 12:55:54', '2022-06-20 12:55:54', 1),
(21, 13, 8, 'head band', '1', '2022-06-29 11:45:01', '2022-06-29 11:45:01', 1),
(22, 13, 2, 'Samsung', '1', '2022-06-29 11:55:05', '2022-06-29 11:55:05', 1),
(23, 20, 22, 't shirts', '1', '2022-08-21 11:28:58', '2022-08-21 11:28:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(12) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` int(12) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `type`, `status`, `created_by`, `created_on`, `updated_on`) VALUES
(8, 'Hardware ', '1', 1, '2022-06-18 12:00:17', '2022-06-18 12:00:17'),
(12, 'Fashion', '1', 1, '2022-06-18 12:36:00', '2022-06-18 12:36:00'),
(13, 'Electronics', '1', 1, '2022-06-18 18:53:09', '2022-06-18 18:53:09'),
(14, 'Computer & accessories', '1', 1, '2022-06-20 09:56:56', '2022-06-20 09:56:56'),
(15, 'Furniture', '1', 1, '2022-06-20 12:11:37', '2022-06-20 12:11:37'),
(16, 'help', '1', 1, '2022-06-20 12:12:23', '2022-06-20 12:12:23'),
(17, 'kk', '1', 1, '2022-06-20 12:33:01', '2022-06-20 12:33:01'),
(18, 'Refurbish', '1', 1, '2022-06-20 12:37:19', '2022-06-20 12:37:19'),
(19, 'hello', '1', 1, '2022-06-20 12:54:48', '2022-06-20 12:54:48'),
(20, 'Clothing', '1', 1, '2022-08-21 11:22:49', '2022-08-21 11:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `remix_icons`
--

CREATE TABLE `remix_icons` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(100) NOT NULL,
  `icon_class` varchar(100) NOT NULL,
  `hints` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `remix_icons`
--

INSERT INTO `remix_icons` (`id`, `category`, `icon_class`, `hints`, `status`, `created_on`, `updated_on`) VALUES
(1, 'Buildings', 'home', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(2, 'Buildings', 'home-2', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(3, 'Buildings', 'home-3', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(4, 'Buildings', 'home-4', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(5, 'Buildings', 'home-5', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(6, 'Buildings', 'home-6', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(7, 'Buildings', 'home-7', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(8, 'Buildings', 'home-8', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(9, 'Buildings', 'home-gear', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(10, 'Buildings', 'home-wifi', 'smart home', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(11, 'Buildings', 'home-smile', 'house,smart home,smile', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(12, 'Buildings', 'home-smile-2', 'house,smart home,smile', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(13, 'Buildings', 'home-heart', 'house', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(14, 'Buildings', 'building', 'city,office,enterprise', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(15, 'Buildings', 'building-2', 'city,office,construction,enterprise', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(16, 'Buildings', 'building-3', 'factory,plant,enterprise', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(17, 'Buildings', 'building-4', 'city,office,enterprise', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(18, 'Buildings', 'hotel', 'building,hotel,office,enterprise,tavern', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(19, 'Buildings', 'community', 'building,hotel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(20, 'Buildings', 'government', 'building', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(21, 'Buildings', 'bank', 'bank,finance,savings,banking', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(22, 'Buildings', 'store', 'shop,mall,supermarket', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(23, 'Buildings', 'store-2', 'shop,mall,supermarket', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(24, 'Buildings', 'store-3', 'shop,mall,supermarket', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(25, 'Buildings', 'hospital', 'medical,health', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(26, 'Buildings', 'ancient-gate', 'historical,genre,scenic,trip,travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(27, 'Buildings', 'ancient-pavilion', 'historical,genre,scenic,trip,travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(28, 'Business', 'mail', 'envelope,email,inbox', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(29, 'Business', 'mail-open', 'envelope,email,inbox', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(30, 'Business', 'mail-send', 'envelope,email,inbox', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(31, 'Business', 'mail-unread', 'envelope,email,inbox', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(32, 'Business', 'mail-add', 'envelope,email,inbox,add', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(33, 'Business', 'mail-check', 'envelope,email,inbox,read', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(34, 'Business', 'mail-close', 'envelope,email,inbox,failed,x', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(35, 'Business', 'mail-download', 'envelope,email,inbox,download', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(36, 'Business', 'mail-forbid', 'envelope,email,inbox,privacy', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(37, 'Business', 'mail-lock', 'envelope,email,inbox,lock', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(38, 'Business', 'mail-settings', 'envelope,email,inbox,settings', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(39, 'Business', 'mail-star', 'envelope,email,inbox,favorite', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(40, 'Business', 'mail-volume', 'envelope,email,inbox,promotional email,email campaign,subscription', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(41, 'Business', 'inbox', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(42, 'Business', 'inbox-archive', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(43, 'Business', 'inbox-unarchive', 'unzip,unpack,extract', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(44, 'Business', 'cloud', 'weather', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(45, 'Business', 'cloud-off', 'offline-mode,connection-fail,slash,weather', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(46, 'Business', 'attachment', 'annex,paperclip', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(47, 'Business', 'profile', 'id', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(48, 'Business', 'archive', 'box', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(49, 'Business', 'archive-drawer', 'night table', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(50, 'Business', 'at', 'mention', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(51, 'Business', 'award', 'medal,achievement,badge', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(52, 'Business', 'medal', 'award,achievement,badge', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(53, 'Business', 'medal-2', 'award,achievement,badge', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(54, 'Business', 'bar-chart', 'statistics,rhythm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(55, 'Business', 'bar-chart-horizontal', 'statistics,rhythm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(56, 'Business', 'bar-chart-2', 'statistics,rhythm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(57, 'Business', 'bar-chart-box', 'statistics,rhythm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(58, 'Business', 'bar-chart-grouped', 'statistics,rhythm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(59, 'Business', 'bubble-chart', 'data,analysis,statistics', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(60, 'Business', 'pie-chart', 'data,analysis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(61, 'Business', 'pie-chart-2', 'data,analysis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(62, 'Business', 'pie-chart-box', 'data,analysis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(63, 'Business', 'donut-chart', 'data,analysis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(64, 'Business', 'line-chart', 'data,analysis,stats', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(65, 'Business', 'bookmark', 'tag', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(66, 'Business', 'bookmark-2', 'tag', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(67, 'Business', 'bookmark-3', 'tag', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(68, 'Business', 'briefcase', 'bag,baggage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(69, 'Business', 'briefcase-2', 'bag,baggage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(70, 'Business', 'briefcase-3', 'bag,baggage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(71, 'Business', 'briefcase-4', 'bag,baggage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(72, 'Business', 'briefcase-5', 'bag,baggage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(73, 'Business', 'calculator', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(74, 'Business', 'calendar', 'date,plan,schedule,agenda', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(75, 'Business', 'calendar-2', 'date,plan,schedule,agenda', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(76, 'Business', 'calendar-event', 'date,plan,schedule,agenda', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(77, 'Business', 'calendar-todo', 'date,plan,schedule,agenda', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(78, 'Business', 'calendar-check', 'date,plan,schedule,agenda,check-in,punch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(79, 'Business', 'customer-service', 'headset', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(80, 'Business', 'customer-service-2', 'headset', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(81, 'Business', 'flag', 'banner,pin', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(82, 'Business', 'flag-2', 'banner,pin', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(83, 'Business', 'global', 'earth,union,world,language', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(84, 'Business', 'honour', 'honor,glory', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(85, 'Business', 'links', 'connection,address', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(86, 'Business', 'printer', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(87, 'Business', 'printer-cloud', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(88, 'Business', 'record-mail', 'voice mail,tape', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(89, 'Business', 'reply', 'forward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(90, 'Business', 'reply-all', 'forward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(91, 'Business', 'send-plane', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(92, 'Business', 'send-plane-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(93, 'Business', 'projector', 'projection,meeting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(94, 'Business', 'projector-2', 'projection,meeting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(95, 'Business', 'slideshow', 'presentation,meeting,PPT,keynote', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(96, 'Business', 'slideshow-2', 'presentation,meeting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(97, 'Business', 'slideshow-3', 'presentation,meeting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(98, 'Business', 'slideshow-4', 'presentation,meeting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(99, 'Business', 'window', 'browser,program,web', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(100, 'Business', 'window-2', 'browser,program,web', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(101, 'Business', 'stack', 'layers', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(102, 'Business', 'service', 'heart,handshake,cooperation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(103, 'Business', 'registered', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(104, 'Business', 'trademark', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(105, 'Business', 'advertisement', 'ad', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(106, 'Business', 'copyleft', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(107, 'Business', 'copyright', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(108, 'Business', 'creative-commons', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(109, 'Business', 'creative-commons-by', 'attribution,copyright', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(110, 'Business', 'creative-commons-nc', 'noncommercial,copyright', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(111, 'Business', 'creative-commons-nd', 'no derivative works,copyright', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(112, 'Business', 'creative-commons-sa', 'share alike,copyright', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(113, 'Business', 'creative-commons-zero', 'cc0,copyright', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(114, 'Communication', 'chat-1', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(115, 'Communication', 'chat-2', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(116, 'Communication', 'chat-3', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(117, 'Communication', 'chat-4', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(118, 'Communication', 'message', 'chat,comment,reply', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(119, 'Communication', 'message-2', 'chat,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(120, 'Communication', 'message-3', 'chat,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(121, 'Communication', 'chat-check', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(122, 'Communication', 'chat-delete', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(123, 'Communication', 'chat-forward', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(124, 'Communication', 'chat-upload', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(125, 'Communication', 'chat-download', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(126, 'Communication', 'chat-new', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(127, 'Communication', 'chat-settings', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(128, 'Communication', 'chat-smile', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(129, 'Communication', 'chat-smile-2', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(130, 'Communication', 'chat-smile-3', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(131, 'Communication', 'chat-heart', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(132, 'Communication', 'chat-off', 'message,reply,comment,slash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(133, 'Communication', 'feedback', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(134, 'Communication', 'discuss', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(135, 'Communication', 'question-answer', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(136, 'Communication', 'questionnaire', 'message,comment,help', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(137, 'Communication', 'video-chat', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(138, 'Communication', 'chat-voice', 'message,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(139, 'Communication', 'chat-quote', 'message,reply,comment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(140, 'Communication', 'chat-follow-up', 'message,reply,comment,+1', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(141, 'Communication', 'chat-poll', 'message,vote,questionnaire', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(142, 'Communication', 'chat-history', 'message', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(143, 'Communication', 'chat-private', 'message', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(144, 'Design', 'pencil', 'edit', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(145, 'Design', 'edit', 'pencil', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(146, 'Design', 'edit-2', 'pencil', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(147, 'Design', 'ball-pen', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(148, 'Design', 'quill-pen', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(149, 'Design', 'pen-nib', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(150, 'Design', 'ink-bottle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(151, 'Design', 'mark-pen', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(152, 'Design', 'markup', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(153, 'Design', 'edit-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(154, 'Design', 'edit-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(155, 'Design', 'sip', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(156, 'Design', 'brush', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(157, 'Design', 'brush-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(158, 'Design', 'brush-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(159, 'Design', 'brush-4', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(160, 'Design', 'paint-brush', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(161, 'Design', 'contrast', 'brightness,tonalit', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(162, 'Design', 'contrast-2', 'moon,dark,brightness,tonalit', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(163, 'Design', 'drop', 'water,blur', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(164, 'Design', 'blur-off', 'water,drop,slash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(165, 'Design', 'contrast-drop', 'water,brightness,tonalit', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(166, 'Design', 'contrast-drop-2', 'water,brightness,tonalit', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(167, 'Design', 'compasses', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(168, 'Design', 'compasses-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(169, 'Design', 'scissors', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(170, 'Design', 'scissors-cut', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(171, 'Design', 'scissors-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(172, 'Design', 'slice', 'knife', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(173, 'Design', 'eraser', 'remove formatting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(174, 'Design', 'ruler', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(175, 'Design', 'ruler-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(176, 'Design', 'pencil-ruler', 'design', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(177, 'Design', 'pencil-ruler-2', 'design', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(178, 'Design', 't-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(179, 'Design', 'input-method', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(180, 'Design', 'artboard', 'grid,crop', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(181, 'Design', 'artboard-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(182, 'Design', 'crop', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(183, 'Design', 'crop-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(184, 'Design', 'screenshot', 'capture', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(185, 'Design', 'screenshot-2', 'capture', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(186, 'Design', 'drag-move', 'arrow', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(187, 'Design', 'drag-move-2', 'arrow', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(188, 'Design', 'focus', 'aim,target', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(189, 'Design', 'focus-2', 'aim,target,bullseye', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(190, 'Design', 'focus-3', 'aim,target,bullseye', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(191, 'Design', 'paint', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(192, 'Design', 'palette', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(193, 'Design', 'pantone', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(194, 'Design', 'shape', 'border', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(195, 'Design', 'shape-2', 'border', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(196, 'Design', 'magic', 'fantasy,magic stick,beautify', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(197, 'Design', 'anticlockwise', 'rotate,left', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(198, 'Design', 'anticlockwise-2', 'rotate,left', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(199, 'Design', 'clockwise', 'rotate,right', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(200, 'Design', 'clockwise-2', 'rotate,right', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(201, 'Design', 'hammer', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(202, 'Design', 'tools', 'settings', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(203, 'Design', 'drag-drop', 'drag and drop,mouse', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(204, 'Design', 'table', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(205, 'Design', 'table-alt', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(206, 'Design', 'layout', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(207, 'Design', 'layout-2', 'collage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(208, 'Design', 'layout-3', 'collage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(209, 'Design', 'layout-4', 'collage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(210, 'Design', 'layout-5', 'collage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(211, 'Design', 'layout-6', 'collage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(212, 'Design', 'layout-column', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(213, 'Design', 'layout-row', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(214, 'Design', 'layout-top', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(215, 'Design', 'layout-right', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(216, 'Design', 'layout-bottom', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(217, 'Design', 'layout-left', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(218, 'Design', 'layout-top-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(219, 'Design', 'layout-right-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(220, 'Design', 'layout-bottom-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(221, 'Design', 'layout-left-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(222, 'Design', 'layout-grid', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(223, 'Design', 'layout-masonry', 'collage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(224, 'Design', 'collage', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(225, 'Design', 'grid', 'table', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(226, 'Development', 'bug', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(227, 'Development', 'bug-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(228, 'Development', 'code', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(229, 'Development', 'code-s', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(230, 'Development', 'code-s-slash', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(231, 'Development', 'code-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(232, 'Development', 'terminal-box', 'code,command line', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(233, 'Development', 'terminal', 'code,command line', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(234, 'Development', 'terminal-window', 'code,command line', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(235, 'Development', 'parentheses', 'code,math', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(236, 'Development', 'brackets', 'code,math', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(237, 'Development', 'braces', 'code,math', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(238, 'Development', 'command', 'apple key', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(239, 'Development', 'cursor', 'mouse', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(240, 'Development', 'git-commit', 'node', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(241, 'Development', 'git-pull-request', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(242, 'Development', 'git-merge', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(243, 'Development', 'git-branch', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(244, 'Development', 'git-repository', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(245, 'Development', 'git-repository-commits', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(246, 'Development', 'git-repository-private', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(247, 'Development', 'html5', 'html,h5', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(248, 'Development', 'css3', 'css', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(249, 'Device', 'tv', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(250, 'Device', 'tv-2', 'monitor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(251, 'Device', 'computer', 'monitor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(252, 'Device', 'mac', 'monitor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(253, 'Device', 'macbook', 'laptop', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(254, 'Device', 'cellphone', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(255, 'Device', 'smartphone', 'mobile', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(256, 'Device', 'tablet', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(257, 'Device', 'device', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(258, 'Device', 'phone', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(259, 'Device', 'database', 'storage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(260, 'Device', 'database-2', 'storage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(261, 'Device', 'server', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(262, 'Device', 'hard-drive', 'disc,storage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(263, 'Device', 'hard-drive-2', 'disc,server,storage', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(264, 'Device', 'install', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(265, 'Device', 'uninstall', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(266, 'Device', 'save', 'floppy', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(267, 'Device', 'save-2', 'floppy', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(268, 'Device', 'save-3', 'floppy', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(269, 'Device', 'sd-card', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(270, 'Device', 'sd-card-mini', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(271, 'Device', 'sim-card', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(272, 'Device', 'sim-card-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(273, 'Device', 'dual-sim-1', 'sim card', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(274, 'Device', 'dual-sim-2', 'sim card', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(275, 'Device', 'u-disk', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(276, 'Device', 'battery', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(277, 'Device', 'battery-charge', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(278, 'Device', 'battery-low', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(279, 'Device', 'battery-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(280, 'Device', 'battery-2-charge', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(281, 'Device', 'battery-saver', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(282, 'Device', 'battery-share', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(283, 'Device', 'cast', 'mirroring', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(284, 'Device', 'airplay', 'mirroring', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(285, 'Device', 'cpu', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(286, 'Device', 'gradienter', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(287, 'Device', 'keyboard', 'input', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(288, 'Device', 'keyboard-box', 'input', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(289, 'Device', 'mouse', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(290, 'Device', 'sensor', 'capacitor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(291, 'Device', 'router', 'wifi,signal tower,radio,station', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(292, 'Device', 'radar', 'satellite receiver', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(293, 'Device', 'gamepad', 'consoles,controller', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(294, 'Device', 'remote-control', 'controller', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(295, 'Device', 'remote-control-2', 'controller', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(296, 'Device', 'device-recover', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(297, 'Device', 'hotspot', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(298, 'Device', 'phone-find', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(299, 'Device', 'phone-lock', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(300, 'Device', 'rotate-lock', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(301, 'Device', 'restart', 'reload,refresh', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(302, 'Device', 'shut-down', 'power off', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(303, 'Device', 'fingerprint', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(304, 'Device', 'fingerprint-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(305, 'Device', 'barcode', 'scan', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(306, 'Device', 'barcode-box', 'scan', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(307, 'Device', 'qr-code', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(308, 'Device', 'qr-scan', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(309, 'Device', 'qr-scan-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(310, 'Device', 'scan', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(311, 'Device', 'scan-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(312, 'Device', 'rss', 'feed,subscribe', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(313, 'Device', 'gps', 'signal', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(314, 'Device', 'base-station', 'wifi,signal tower,router,cast', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(315, 'Device', 'bluetooth', 'wireless', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(316, 'Device', 'bluetooth-connect', 'wireless', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(317, 'Device', 'wifi', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(318, 'Device', 'wifi-off', 'slash,offline,connection-fail', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(319, 'Device', 'signal-wifi', 'cellular,strength', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(320, 'Device', 'signal-wifi-1', 'cellular,strength', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(321, 'Device', 'signal-wifi-2', 'cellular,strength', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(322, 'Device', 'signal-wifi-3', 'cellular,strength', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(323, 'Device', 'signal-wifi-error', 'cellular,offline,connection-fail', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(324, 'Device', 'signal-wifi-off', 'cellular,slash,offline,connection-fail', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(325, 'Device', 'wireless-charging', 'power,flash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(326, 'Device', 'dashboard-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(327, 'Device', 'dashboard-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(328, 'Device', 'usb', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(329, 'Document', 'file', 'new,paper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(330, 'Document', 'file-2', 'new,paper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(331, 'Document', 'file-3', 'new,paper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(332, 'Document', 'file-4', 'new,paper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(333, 'Document', 'sticky-note', 'new,paper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(334, 'Document', 'sticky-note-2', 'new,paper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(335, 'Document', 'file-edit', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(336, 'Document', 'draft', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(337, 'Document', 'file-paper', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(338, 'Document', 'file-paper-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(339, 'Document', 'file-text', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(340, 'Document', 'file-list', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(341, 'Document', 'file-list-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(342, 'Document', 'file-list-3', 'newspaper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(343, 'Document', 'bill', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(344, 'Document', 'file-copy', 'duplicate,clone', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(345, 'Document', 'file-copy-2', 'duplicate,clone', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(346, 'Document', 'clipboard', 'copy', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(347, 'Document', 'survey', 'research,questionnaire', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(348, 'Document', 'article', 'newspaper', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(349, 'Document', 'newspaper', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(350, 'Document', 'file-zip', '7z,rar', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(351, 'Document', 'file-mark', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(352, 'Document', 'task', 'todo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(353, 'Document', 'todo', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(354, 'Document', 'book', 'read,dictionary,booklet', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(355, 'Document', 'book-mark', 'read,dictionary,booklet', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(356, 'Document', 'book-2', 'read,dictionary,booklet', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(357, 'Document', 'book-3', 'read,dictionary,booklet', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(358, 'Document', 'book-open', 'read,booklet,magazine', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(359, 'Document', 'book-read', 'booklet,magazine', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(360, 'Document', 'contacts-book', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(361, 'Document', 'contacts-book-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(362, 'Document', 'contacts-book-upload', 'upload', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(363, 'Document', 'booklet', 'notebook', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(364, 'Document', 'file-code', 'config', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(365, 'Document', 'file-pdf', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(366, 'Document', 'file-word', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(367, 'Document', 'file-ppt', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(368, 'Document', 'file-excel', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(369, 'Document', 'file-word-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(370, 'Document', 'file-ppt-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(371, 'Document', 'file-excel-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(372, 'Document', 'file-hwp', 'hangul word processor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(373, 'Document', 'keynote', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(374, 'Document', 'numbers', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(375, 'Document', 'pages', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(376, 'Document', 'file-search', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(377, 'Document', 'file-add', 'new', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(378, 'Document', 'file-reduce', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(379, 'Document', 'file-settings', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(380, 'Document', 'file-upload', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(381, 'Document', 'file-transfer', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(382, 'Document', 'file-download', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(383, 'Document', 'file-lock', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(384, 'Document', 'file-chart', 'report', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(385, 'Document', 'file-chart-2', 'report', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(386, 'Document', 'file-music', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(387, 'Document', 'file-gif', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(388, 'Document', 'file-forbid', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(389, 'Document', 'file-info', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(390, 'Document', 'file-warning', 'alert', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(391, 'Document', 'file-unknow', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(392, 'Document', 'file-user', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(393, 'Document', 'file-shield', 'protected,secured', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(394, 'Document', 'file-shield-2', 'protected,secured', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(395, 'Document', 'file-damage', 'breakdown,broken', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(396, 'Document', 'file-history', 'record', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(397, 'Document', 'file-shred', 'shredder,shred,destroy,cut', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(398, 'Document', 'file-cloud', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(399, 'Document', 'folder', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(400, 'Document', 'folder-2', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(401, 'Document', 'folder-3', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(402, 'Document', 'folder-4', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(403, 'Document', 'folder-5', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(404, 'Document', 'folders', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(405, 'Document', 'folder-add', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(406, 'Document', 'folder-reduce', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(407, 'Document', 'folder-settings', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(408, 'Document', 'folder-upload', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(409, 'Document', 'folder-transfer', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(410, 'Document', 'folder-download', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(411, 'Document', 'folder-lock', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(412, 'Document', 'folder-chart', 'report', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(413, 'Document', 'folder-chart-2', 'report', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(414, 'Document', 'folder-music', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(415, 'Document', 'folder-forbid', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(416, 'Document', 'folder-info', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(417, 'Document', 'folder-warning', 'alert,directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(418, 'Document', 'folder-unknow', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(419, 'Document', 'folder-user', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(420, 'Document', 'folder-shield', 'directory,file,protected,secured', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(421, 'Document', 'folder-shield-2', 'directory,file,protected,secured', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(422, 'Document', 'folder-shared', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(423, 'Document', 'folder-received', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(424, 'Document', 'folder-open', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(425, 'Document', 'folder-keyhole', 'directory,encryption,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(426, 'Document', 'folder-zip', 'directory,file', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(427, 'Document', 'folder-history', 'directory,file,record', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(428, 'Document', 'markdown', 'arrow', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(429, 'Editor', 'bold', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(430, 'Editor', 'italic', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(431, 'Editor', 'heading', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(432, 'Editor', 'text', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(433, 'Editor', 'font-color', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(434, 'Editor', 'font-size', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(435, 'Editor', 'font-size-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(436, 'Editor', 'underline', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(437, 'Editor', 'emphasis', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(438, 'Editor', 'emphasis-cn', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(439, 'Editor', 'strikethrough', 'remove formatting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(440, 'Editor', 'strikethrough-2', 'remove formatting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(441, 'Editor', 'format-clear', 'remove formatting', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(442, 'Editor', 'align-left', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(443, 'Editor', 'align-center', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(444, 'Editor', 'align-right', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(445, 'Editor', 'align-justify', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(446, 'Editor', 'align-top', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(447, 'Editor', 'align-vertically', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(448, 'Editor', 'align-bottom', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(449, 'Editor', 'list-check', 'check list', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(450, 'Editor', 'list-check-2', 'check list', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(451, 'Editor', 'list-ordered', 'number list', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(452, 'Editor', 'list-unordered', 'bullet list', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(453, 'Editor', 'indent-decrease', 'indent more', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(454, 'Editor', 'indent-increase', 'indent less', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(455, 'Editor', 'line-height', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(456, 'Editor', 'text-spacing', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(457, 'Editor', 'text-wrap', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(458, 'Editor', 'attachment-2', 'annex,paperclip', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(459, 'Editor', 'link', 'connection,address', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(460, 'Editor', 'link-unlink', 'connection,remove address', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(461, 'Editor', 'link-m', 'connection,address', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(462, 'Editor', 'link-unlink-m', 'connection,remove address', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(463, 'Editor', 'separator', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(464, 'Editor', 'space', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(465, 'Editor', 'page-separator', 'insert', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(466, 'Editor', 'code-view', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(467, 'Editor', 'double-quotes-l', 'left,quotaion marks', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(468, 'Editor', 'double-quotes-r', 'right,quotaion marks', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(469, 'Editor', 'single-quotes-l', 'left,quotaion marks', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(470, 'Editor', 'single-quotes-r', 'right,quotaion marks', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(471, 'Editor', 'table-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(472, 'Editor', 'subscript', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(473, 'Editor', 'subscript-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(474, 'Editor', 'superscript', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(475, 'Editor', 'superscript-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(476, 'Editor', 'paragraph', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(477, 'Editor', 'text-direction-l', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(478, 'Editor', 'text-direction-r', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(479, 'Editor', 'functions', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(480, 'Editor', 'omega', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(481, 'Editor', 'hashtag', '#', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(482, 'Editor', 'asterisk', '*', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(483, 'Editor', 'question-mark', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(484, 'Editor', 'translate', 'translator', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(485, 'Editor', 'translate-2', 'translator', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(486, 'Editor', 'a-b', 'ab testing', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(487, 'Editor', 'english-input', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(488, 'Editor', 'pinyin-input', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(489, 'Editor', 'wubi-input', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(490, 'Editor', 'input-cursor-move', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(491, 'Editor', 'number-1', '1', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(492, 'Editor', 'number-2', '2', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(493, 'Editor', 'number-3', '3', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(494, 'Editor', 'number-4', '4', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(495, 'Editor', 'number-5', '5', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(496, 'Editor', 'number-6', '6', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(497, 'Editor', 'number-7', '7', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(498, 'Editor', 'number-8', '8', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(499, 'Editor', 'number-9', '9', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(500, 'Editor', 'number-0', '0', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(501, 'Editor', 'sort-asc', 'ranking,ordering,sorting,ascending,descending', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(502, 'Editor', 'sort-desc', 'ranking,ordering', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(503, 'Editor', 'bring-forward', 'arrange', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(504, 'Editor', 'send-backward', 'arrange', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(505, 'Editor', 'bring-to-front', 'arrange', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(506, 'Editor', 'send-to-back', 'arrange', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(507, 'Editor', 'h-1', 'heading', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(508, 'Editor', 'h-2', 'heading', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(509, 'Editor', 'h-3', 'heading', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(510, 'Editor', 'h-4', 'heading', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(511, 'Editor', 'h-5', 'heading', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(512, 'Editor', 'h-6', 'heading', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(513, 'Editor', 'insert-column-left', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(514, 'Editor', 'insert-column-right', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(515, 'Editor', 'insert-row-top', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(516, 'Editor', 'insert-row-bottom', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(517, 'Editor', 'delete-column', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(518, 'Editor', 'delete-row', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(519, 'Editor', 'merge-cells-horizontal', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(520, 'Editor', 'merge-cells-vertical', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(521, 'Editor', 'split-cells-horizontal', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(522, 'Editor', 'split-cells-vertical', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(523, 'Editor', 'flow-chart', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(524, 'Editor', 'mind-map', 'mindmap', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(525, 'Editor', 'node-tree', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(526, 'Editor', 'organization-chart', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(527, 'Editor', 'rounded-corner', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(528, 'Finance', 'wallet', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(529, 'Finance', 'wallet-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(530, 'Finance', 'wallet-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(531, 'Finance', 'bank-card', 'credit,purchase,payment,cc', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53');
INSERT INTO `remix_icons` (`id`, `category`, `icon_class`, `hints`, `status`, `created_on`, `updated_on`) VALUES
(532, 'Finance', 'bank-card-2', 'credit,purchase,payment,cc', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(533, 'Finance', 'secure-payment', 'credit,purchase,payment,cc', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(534, 'Finance', 'refund', 'credit card,repayment,cc', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(535, 'Finance', 'refund-2', 'credit card,repayment,cc', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(536, 'Finance', 'safe', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(537, 'Finance', 'safe-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(538, 'Finance', 'price-tag', 'label', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(539, 'Finance', 'price-tag-2', 'label', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(540, 'Finance', 'price-tag-3', 'label', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(541, 'Finance', 'ticket', 'coupon', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(542, 'Finance', 'ticket-2', 'coupon', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(543, 'Finance', 'coupon', 'ticket', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(544, 'Finance', 'coupon-2', 'ticket', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(545, 'Finance', 'coupon-3', 'ticket', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(546, 'Finance', 'coupon-4', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(547, 'Finance', 'coupon-5', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(548, 'Finance', 'shopping-bag', 'purse', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(549, 'Finance', 'shopping-bag-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(550, 'Finance', 'shopping-bag-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(551, 'Finance', 'shopping-basket', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(552, 'Finance', 'shopping-basket-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(553, 'Finance', 'shopping-cart', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(554, 'Finance', 'shopping-cart-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(555, 'Finance', 'vip', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(556, 'Finance', 'vip-crown', 'king,queen', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(557, 'Finance', 'vip-crown-2', 'king,queen', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(558, 'Finance', 'vip-diamond', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(559, 'Finance', 'trophy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(560, 'Finance', 'exchange', 'swap', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(561, 'Finance', 'exchange-box', 'swap', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(562, 'Finance', 'swap', 'exchange', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(563, 'Finance', 'swap-box', 'exchange', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(564, 'Finance', 'exchange-dollar', 'swap,transfer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(565, 'Finance', 'exchange-cny', 'swap,transfer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(566, 'Finance', 'exchange-funds', 'swap,transfer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(567, 'Finance', 'increase-decrease', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(568, 'Finance', 'percent', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(569, 'Finance', 'copper-coin', 'currency,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(570, 'Finance', 'copper-diamond', 'currency,coins', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(571, 'Finance', 'money-cny-box', 'currency,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(572, 'Finance', 'money-cny-circle', 'currency,coins,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(573, 'Finance', 'money-dollar-box', 'currency,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(574, 'Finance', 'money-dollar-circle', 'currency,coins,payment,cent,penny', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(575, 'Finance', 'money-euro-box', 'currency,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(576, 'Finance', 'money-euro-circle', 'currency,coins,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(577, 'Finance', 'money-pound-box', 'currency,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(578, 'Finance', 'money-pound-circle', 'currency,coins,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(579, 'Finance', 'bit-coin', 'currency,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(580, 'Finance', 'coin', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(581, 'Finance', 'coins', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(582, 'Finance', 'currency', 'cash,payment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(583, 'Finance', 'funds', 'foundation,stock', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(584, 'Finance', 'funds-box', 'foundation,stock', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(585, 'Finance', 'red-packet', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(586, 'Finance', 'water-flash', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(587, 'Finance', 'stock', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(588, 'Finance', 'auction', 'hammer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(589, 'Finance', 'gift', 'present', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(590, 'Finance', 'gift-2', 'present', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(591, 'Finance', 'hand-coin', 'donate,business', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(592, 'Finance', 'hand-heart', 'help,donate,volunteer,welfare', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(593, 'Finance', '24-hours', 'last', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(594, 'Health & Medical', 'heart', 'like,love,favorite', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(595, 'Health & Medical', 'heart-2', 'like,love,favorite', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(596, 'Health & Medical', 'heart-3', 'like,love,favorite', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(597, 'Health & Medical', 'heart-add', 'like,love,favorite', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(598, 'Health & Medical', 'dislike', 'like,love,remove favorite', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(599, 'Health & Medical', 'hearts', 'romance', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(600, 'Health & Medical', 'heart-pulse', 'heart rate', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(601, 'Health & Medical', 'pulse', 'wave,heart rate', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(602, 'Health & Medical', 'empathize', 'care,heart', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(603, 'Health & Medical', 'nurse', 'doctors', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(604, 'Health & Medical', 'dossier', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(605, 'Health & Medical', 'health-book', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(606, 'Health & Medical', 'first-aid-kit', 'case', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(607, 'Health & Medical', 'capsule', 'medicine', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(608, 'Health & Medical', 'medicine-bottle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(609, 'Health & Medical', 'flask', 'testing,experimental,experiment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(610, 'Health & Medical', 'test-tube', 'testing,experimental,experiment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(611, 'Health & Medical', 'microscope', 'testing,experimental,experiment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(612, 'Health & Medical', 'hand-sanitizer', 'alcohol', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(613, 'Health & Medical', 'mental-health', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(614, 'Health & Medical', 'psychotherapy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(615, 'Health & Medical', 'stethoscope', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(616, 'Health & Medical', 'syringe', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(617, 'Health & Medical', 'thermometer', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(618, 'Health & Medical', 'infrared-thermometer', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(619, 'Health & Medical', 'surgical-mask', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(620, 'Health & Medical', 'virus', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(621, 'Health & Medical', 'lungs', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(622, 'Health & Medical', 'rest-time', 'close', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(623, 'Health & Medical', 'zzz', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(624, 'Logos', 'alipay', 'zhifubao', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(625, 'Logos', 'amazon', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(626, 'Logos', 'android', 'applications', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(627, 'Logos', 'angularjs', 'angular,programing framework', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(628, 'Logos', 'app-store', 'applications', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(629, 'Logos', 'apple', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(630, 'Logos', 'baidu', 'du,claw', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(631, 'Logos', 'behance', 'behance', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(632, 'Logos', 'bilibili', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(633, 'Logos', 'centos', 'linux,system', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(634, 'Logos', 'chrome', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(635, 'Logos', 'codepen', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(636, 'Logos', 'coreos', 'linux,system', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(637, 'Logos', 'dingding', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(638, 'Logos', 'discord', 'game,chat', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(639, 'Logos', 'disqus', 'comments', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(640, 'Logos', 'douban', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(641, 'Logos', 'dribbble', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(642, 'Logos', 'drive', 'google drive', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(643, 'Logos', 'dropbox', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(644, 'Logos', 'edge', 'microsoft edge', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(645, 'Logos', 'evernote', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(646, 'Logos', 'facebook', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(647, 'Logos', 'facebook-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(648, 'Logos', 'facebook-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(649, 'Logos', 'finder', 'macintosh', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(650, 'Logos', 'firefox', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(651, 'Logos', 'flutter', 'google', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(652, 'Logos', 'gatsby', 'gatsby', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(653, 'Logos', 'github', 'github', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(654, 'Logos', 'gitlab', 'gitlab', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(655, 'Logos', 'google', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(656, 'Logos', 'google-play', 'applications', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(657, 'Logos', 'honor-of-kings', 'game', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(658, 'Logos', 'ie', 'internet explorer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(659, 'Logos', 'instagram', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(660, 'Logos', 'invision', 'invision', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(661, 'Logos', 'kakao-talk', 'kakao talk,chat', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(662, 'Logos', 'line', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(663, 'Logos', 'linkedin', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(664, 'Logos', 'linkedin-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(665, 'Logos', 'mastercard', 'bank card', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(666, 'Logos', 'mastodon', 'mastodon', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(667, 'Logos', 'medium', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(668, 'Logos', 'messenger', 'facebook', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(669, 'Logos', 'microsoft', 'windows', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(670, 'Logos', 'mini-program', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(671, 'Logos', 'netease-cloud-music', 'netease cloud music', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(672, 'Logos', 'netflix', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(673, 'Logos', 'npmjs', 'npm,nodejs', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(674, 'Logos', 'open-source', 'opensource', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(675, 'Logos', 'opera', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(676, 'Logos', 'patreon', 'donate,money', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(677, 'Logos', 'paypal', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(678, 'Logos', 'pinterest', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(679, 'Logos', 'pixelfed', 'photography,pixelfed', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(680, 'Logos', 'playstation', 'ps', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(681, 'Logos', 'product-hunt', 'product hunt', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(682, 'Logos', 'qq', 'penguin,tencent', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(683, 'Logos', 'reactjs', 'react,programing framework,facebook', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(684, 'Logos', 'reddit', 'reddit', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(685, 'Logos', 'remixicon', 'remix icon', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(686, 'Logos', 'safari', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(687, 'Logos', 'skype', 'skype', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(688, 'Logos', 'slack', 'slack', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(689, 'Logos', 'snapchat', 'ghost', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(690, 'Logos', 'soundcloud', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(691, 'Logos', 'spectrum', 'spectrum', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(692, 'Logos', 'spotify', 'music', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(693, 'Logos', 'stack-overflow', 'stack overflow', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(694, 'Logos', 'stackshare', 'share', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(695, 'Logos', 'steam', 'game,store', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(696, 'Logos', 'switch', 'nintendo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(697, 'Logos', 'taobao', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(698, 'Logos', 'telegram', 'telegram', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(699, 'Logos', 'trello', 'trello', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(700, 'Logos', 'tumblr', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(701, 'Logos', 'twitch', 'twitch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(702, 'Logos', 'twitter', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(703, 'Logos', 'ubuntu', 'linux,system', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(704, 'Logos', 'unsplash', 'photos', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(705, 'Logos', 'vimeo', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(706, 'Logos', 'visa', 'bank card', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(707, 'Logos', 'vuejs', 'vue,programing framework', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(708, 'Logos', 'wechat', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(709, 'Logos', 'wechat-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(710, 'Logos', 'wechat-pay', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(711, 'Logos', 'weibo', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(712, 'Logos', 'whatsapp', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(713, 'Logos', 'windows', 'microsoft', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(714, 'Logos', 'xbox', 'xbox', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(715, 'Logos', 'xing', 'xing', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(716, 'Logos', 'youtube', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(717, 'Logos', 'zcool', 'zcool', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(718, 'Logos', 'zhihu', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(719, 'Map', 'map-pin', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(720, 'Map', 'map-pin-2', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(721, 'Map', 'map-pin-3', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(722, 'Map', 'map-pin-4', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(723, 'Map', 'map-pin-5', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(724, 'Map', 'map-pin-add', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(725, 'Map', 'map-pin-range', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(726, 'Map', 'map-pin-time', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(727, 'Map', 'map-pin-user', 'location,navigation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(728, 'Map', 'pin-distance', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(729, 'Map', 'pushpin', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(730, 'Map', 'pushpin-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(731, 'Map', 'compass', 'navigation,safari,direction,discover', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(732, 'Map', 'compass-2', 'navigation,direction,discover', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(733, 'Map', 'compass-3', 'navigation,safari,direction,discover', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(734, 'Map', 'compass-4', 'navigation,direction,discover', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(735, 'Map', 'compass-discover', 'navigation,direction', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(736, 'Map', 'anchor', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(737, 'Map', 'china-railway', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(738, 'Map', 'space-ship', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(739, 'Map', 'rocket', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(740, 'Map', 'rocket-2', 'space ship', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(741, 'Map', 'map', 'navigation,travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(742, 'Map', 'map-2', 'location,navigation,travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(743, 'Map', 'treasure-map', 'thriller,adventure', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(744, 'Map', 'road-map', 'navigation,travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(745, 'Map', 'earth', 'global,union,world,language', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(746, 'Map', 'globe', 'earth', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(747, 'Map', 'parking', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(748, 'Map', 'parking-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(749, 'Map', 'route', 'path', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(750, 'Map', 'guide', 'path', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(751, 'Map', 'gas-station', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(752, 'Map', 'charging-pile', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(753, 'Map', 'charging-pile-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(754, 'Map', 'car', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(755, 'Map', 'car-washing', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(756, 'Map', 'roadster', 'car', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(757, 'Map', 'taxi', 'car', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(758, 'Map', 'taxi-wifi', 'car', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(759, 'Map', 'police-car', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(760, 'Map', 'bus', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(761, 'Map', 'bus-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(762, 'Map', 'bus-wifi', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(763, 'Map', 'truck', 'van,delivery', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(764, 'Map', 'train', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(765, 'Map', 'train-wifi', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(766, 'Map', 'subway', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(767, 'Map', 'subway-wifi', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(768, 'Map', 'flight-takeoff', 'airplane,plane,origin', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(769, 'Map', 'flight-land', 'airplane,plane,destination', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(770, 'Map', 'plane', 'fight', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(771, 'Map', 'sailboat', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(772, 'Map', 'ship', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(773, 'Map', 'ship-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(774, 'Map', 'bike', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(775, 'Map', 'e-bike', 'take out,takeaway', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(776, 'Map', 'e-bike-2', 'take out,takeaway', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(777, 'Map', 'takeaway', 'take out,takeaway', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(778, 'Map', 'motorbike', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(779, 'Map', 'caravan', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(780, 'Map', 'walk', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(781, 'Map', 'run', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(782, 'Map', 'riding', 'bike', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(783, 'Map', 'barricade', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(784, 'Map', 'footprint', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(785, 'Map', 'traffic-light', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(786, 'Map', 'signal-tower', 'base station,antenna', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(787, 'Map', 'restaurant', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(788, 'Map', 'restaurant-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(789, 'Map', 'cup', 'tea,coffee', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(790, 'Map', 'goblet', 'cup,wine glass', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(791, 'Map', 'hotel-bed', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(792, 'Map', 'navigation', 'gps', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(793, 'Map', 'oil', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(794, 'Map', 'direction', 'right', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(795, 'Map', 'steering', 'drive', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(796, 'Map', 'steering-2', 'drive', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(797, 'Map', 'lifebuoy', 'life ring', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(798, 'Map', 'passport', 'passports', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(799, 'Map', 'suitcase', 'travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(800, 'Map', 'suitcase-2', 'travel', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(801, 'Map', 'suitcase-3', 'travel,boarding case', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(802, 'Map', 'luggage-deposit', 'consignment', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(803, 'Map', 'luggage-cart', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(804, 'Media', 'image', 'picture,photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(805, 'Media', 'image-2', 'picture,photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(806, 'Media', 'image-add', 'picture,photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(807, 'Media', 'image-edit', 'picture,photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(808, 'Media', 'landscape', 'picture,image,photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(809, 'Media', 'gallery', 'picture,image', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(810, 'Media', 'gallery-upload', 'picture,image', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(811, 'Media', 'video', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(812, 'Media', 'movie', 'film,video', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(813, 'Media', 'movie-2', 'film,video', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(814, 'Media', 'film', 'movie,video', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(815, 'Media', 'clapperboard', 'movie,film', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(816, 'Media', 'vidicon', 'video,camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(817, 'Media', 'vidicon-2', 'camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(818, 'Media', 'live', 'video,camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(819, 'Media', 'video-add', 'camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(820, 'Media', 'video-upload', 'camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(821, 'Media', 'video-download', 'camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(822, 'Media', 'dv', 'vidicon,camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(823, 'Media', 'camera', 'photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(824, 'Media', 'camera-off', 'photo,slash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(825, 'Media', 'camera-2', 'photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(826, 'Media', 'camera-3', 'photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(827, 'Media', 'camera-lens', 'aperture,photo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(828, 'Media', 'camera-switch', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(829, 'Media', 'polaroid', 'camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(830, 'Media', 'polaroid-2', 'camera', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(831, 'Media', 'phone-camera', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(832, 'Media', 'webcam', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(833, 'Media', 'mv', 'music video', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(834, 'Media', 'music', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(835, 'Media', 'music-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(836, 'Media', 'disc', 'music,album', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(837, 'Media', 'album', 'music', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(838, 'Media', 'dvd', 'cd,dvd,record', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(839, 'Media', 'headphone', 'music,headset', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(840, 'Media', 'radio', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(841, 'Media', 'radio-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(842, 'Media', 'tape', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(843, 'Media', 'mic', 'record,voice', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(844, 'Media', 'mic-2', 'record,voice', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(845, 'Media', 'mic-off', 'record,voice,slash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(846, 'Media', 'volume-down', 'trumpet,sound,speaker', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(847, 'Media', 'volume-mute', 'trumpet,sound,off', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(848, 'Media', 'volume-up', 'trumpet,sound,speaker', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(849, 'Media', 'volume-vibrate', 'trumpet,sound,speaker', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(850, 'Media', 'volume-off-vibrate', 'trumpet,sound,speaker', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(851, 'Media', 'speaker', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(852, 'Media', 'speaker-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(853, 'Media', 'speaker-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(854, 'Media', 'surround-sound', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(855, 'Media', 'broadcast', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(856, 'Media', 'notification', 'bell,alarm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(857, 'Media', 'notification-2', 'bell,alarm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(858, 'Media', 'notification-3', 'bell,alarm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(859, 'Media', 'notification-4', 'bell,alarm', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(860, 'Media', 'notification-off', 'bell,alarm,silent,slash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(861, 'Media', 'play-circle', 'start', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(862, 'Media', 'pause-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(863, 'Media', 'record-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(864, 'Media', 'stop-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(865, 'Media', 'eject', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(866, 'Media', 'play', 'start', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(867, 'Media', 'pause', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(868, 'Media', 'stop', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(869, 'Media', 'rewind', 'fast', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(870, 'Media', 'speed', 'fast', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(871, 'Media', 'skip-back', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(872, 'Media', 'skip-forward', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(873, 'Media', 'play-mini', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(874, 'Media', 'pause-mini', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(875, 'Media', 'stop-mini', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(876, 'Media', 'rewind-mini', 'fast', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(877, 'Media', 'speed-mini', 'fast', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(878, 'Media', 'skip-back-mini', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(879, 'Media', 'skip-forward-mini', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(880, 'Media', 'repeat', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(881, 'Media', 'repeat-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(882, 'Media', 'repeat-one', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(883, 'Media', 'order-play', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(884, 'Media', 'shuffle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(885, 'Media', 'play-list', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(886, 'Media', 'play-list-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(887, 'Media', 'play-list-add', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(888, 'Media', 'fullscreen', 'maximize', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(889, 'Media', 'fullscreen-exit', 'minimize', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(890, 'Media', 'equalizer', 'sliders,controls,settings,filter', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(891, 'Media', 'sound-module', 'sliders,controls,settings,filter', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(892, 'Media', 'rhythm', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(893, 'Media', 'voiceprint', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(894, 'Media', 'hq', 'high quality', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(895, 'Media', 'hd', 'high definition', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(896, 'Media', '4k', 'high definition,high quality', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(897, 'Media', 'closed-captioning', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(898, 'Media', 'aspect-ratio', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(899, 'Media', 'picture-in-picture', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(900, 'Media', 'picture-in-picture-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(901, 'Media', 'picture-in-picture-exit', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(902, 'System', 'apps', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(903, 'System', 'apps-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(904, 'System', 'function', 'layout', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(905, 'System', 'dashboard', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(906, 'System', 'menu', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(907, 'System', 'menu-2', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(908, 'System', 'menu-3', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(909, 'System', 'menu-4', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(910, 'System', 'menu-5', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(911, 'System', 'menu-add', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(912, 'System', 'menu-fold', 'navigation,hamburger', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(913, 'System', 'more', 'ellipsis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(914, 'System', 'more-2', 'ellipsis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(915, 'System', 'star', 'favorite,like,mark', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(916, 'System', 'star-s', 'favorite,like,mark', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(917, 'System', 'star-half', 'favorite,like,mark', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(918, 'System', 'star-half-s', 'favorite,like,mark', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(919, 'System', 'settings', 'edit,gear,preferences', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(920, 'System', 'settings-2', 'edit,gear,preferences', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(921, 'System', 'settings-3', 'edit,gear,preferences', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(922, 'System', 'settings-4', 'edit,gear,preferences', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(923, 'System', 'settings-5', 'edit,gear,preferences', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(924, 'System', 'settings-6', 'edit,gear,preferences', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(925, 'System', 'list-settings', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(926, 'System', 'forbid', 'slash,ban', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(927, 'System', 'forbid-2', 'slash,ban', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(928, 'System', 'information', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(929, 'System', 'error-warning', 'alert', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(930, 'System', 'question', 'help', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(931, 'System', 'alert', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(932, 'System', 'spam', 'alert', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(933, 'System', 'spam-2', 'alert', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(934, 'System', 'spam-3', 'alert', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(935, 'System', 'checkbox-blank', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(936, 'System', 'checkbox', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(937, 'System', 'checkbox-indeterminate', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(938, 'System', 'add-box', 'plus,new', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(939, 'System', 'checkbox-blank-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(940, 'System', 'checkbox-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(941, 'System', 'indeterminate-circle', 'slash,ban', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(942, 'System', 'add-circle', 'plus,new', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(943, 'System', 'close-circle', 'cancel,remove,delete,empty,x', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(944, 'System', 'radio-button', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(945, 'System', 'checkbox-multiple-blank', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(946, 'System', 'checkbox-multiple', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(947, 'System', 'check', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(948, 'System', 'check-double', 'read,done,double-tick', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(949, 'System', 'close', 'cancel,remove,delete,empty,x', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(950, 'System', 'add', 'plus,new', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(951, 'System', 'subtract', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(952, 'System', 'divide', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(953, 'System', 'arrow-left-up', 'corner', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(954, 'System', 'arrow-up', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(955, 'System', 'arrow-right-up', 'corner', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(956, 'System', 'arrow-right', 'forward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(957, 'System', 'arrow-right-down', 'corner', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(958, 'System', 'arrow-down', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(959, 'System', 'arrow-left-down', 'corner', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(960, 'System', 'arrow-left', 'backward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(961, 'System', 'arrow-up-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(962, 'System', 'arrow-right-circle', 'forward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(963, 'System', 'arrow-down-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(964, 'System', 'arrow-left-circle', 'backward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(965, 'System', 'arrow-up-s', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(966, 'System', 'arrow-down-s', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(967, 'System', 'arrow-right-s', 'forward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(968, 'System', 'arrow-left-s', 'backward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(969, 'System', 'arrow-drop-up', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(970, 'System', 'arrow-drop-right', 'forward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(971, 'System', 'arrow-drop-down', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(972, 'System', 'arrow-drop-left', 'backward', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(973, 'System', 'arrow-left-right', 'exchange,swap', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(974, 'System', 'arrow-up-down', 'exchange,swap', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(975, 'System', 'arrow-go-back', 'undo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(976, 'System', 'arrow-go-forward', 'redo', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(977, 'System', 'download', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(978, 'System', 'upload', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(979, 'System', 'download-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(980, 'System', 'upload-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(981, 'System', 'download-cloud', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(982, 'System', 'download-cloud-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(983, 'System', 'upload-cloud', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(984, 'System', 'upload-cloud-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(985, 'System', 'login-box', 'sign in', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(986, 'System', 'logout-box', 'sign out', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(987, 'System', 'logout-box-r', 'sign out', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(988, 'System', 'login-circle', 'sign in', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(989, 'System', 'logout-circle', 'sign out', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(990, 'System', 'logout-circle-r', 'sign out', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(991, 'System', 'refresh', 'synchronization,reload,restart,spinner,loader,ajax,update', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(992, 'System', 'shield', 'safety,protect', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(993, 'System', 'shield-cross', 'safety,protect', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(994, 'System', 'shield-flash', 'safety,protect', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(995, 'System', 'shield-star', 'safety,protect', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(996, 'System', 'shield-user', 'safety,protect,user protected,guarantor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(997, 'System', 'shield-keyhole', 'safety,protect,guarantor', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(998, 'System', 'shield-check', 'safety,protect', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(999, 'System', 'delete-back', 'backspace', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1000, 'System', 'delete-back-2', 'backspace', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1001, 'System', 'delete-bin', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1002, 'System', 'delete-bin-2', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1003, 'System', 'delete-bin-3', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1004, 'System', 'delete-bin-4', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1005, 'System', 'delete-bin-5', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1006, 'System', 'delete-bin-6', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1007, 'System', 'delete-bin-7', 'trash,remove,ash-bin,garbage,dustbin,uninstall', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1008, 'System', 'lock', 'security,password', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1009, 'System', 'lock-2', 'security,password', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1010, 'System', 'lock-password', 'security', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1011, 'System', 'lock-unlock', 'security,password', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1012, 'System', 'eye', 'watch,view', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1013, 'System', 'eye-off', 'slash', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1014, 'System', 'eye-2', 'watch,view', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1015, 'System', 'eye-close', 'x', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1016, 'System', 'search', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1017, 'System', 'search-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1018, 'System', 'search-eye', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1019, 'System', 'zoom-in', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1020, 'System', 'zoom-out', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1021, 'System', 'find-replace', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1022, 'System', 'share', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1023, 'System', 'share-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1024, 'System', 'share-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1025, 'System', 'share-forward', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1026, 'System', 'share-forward-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1027, 'System', 'share-forward-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1028, 'System', 'side-bar', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1029, 'System', 'time', 'clock', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1030, 'System', 'timer', 'chronograph,stopwatch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1031, 'System', 'timer-2', 'chronograph,stopwatch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1032, 'System', 'timer-flash', 'chronograph,stopwatch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1033, 'System', 'alarm', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1034, 'System', 'history', 'record,recent,time machine', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1035, 'System', 'thumb-down', 'dislike,bad', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1036, 'System', 'thumb-up', 'like,good', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1037, 'System', 'alarm-warning', 'alert,report,police light', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1038, 'System', 'notification-badge', 'red dot', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1039, 'System', 'toggle', 'switch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1040, 'System', 'filter', 'filtration', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1041, 'System', 'filter-2', 'filtration', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1042, 'System', 'filter-3', 'filtration', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1043, 'System', 'filter-off', 'filtration,clear-filter', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1044, 'System', 'loader', 'loader,spinner,ajax,waiting,delay', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1045, 'System', 'loader-2', 'loader,spinner,ajax,waiting,delay', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1046, 'System', 'loader-3', 'loader,spinner,ajax,waiting,delay', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1047, 'System', 'loader-4', 'loader,spinner,ajax,waiting,delay', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1048, 'System', 'loader-5', 'loader,spinner,ajax,waiting,delay', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1049, 'System', 'external-link', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1050, 'User&Faces', 'user', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1051, 'User&Faces', 'user-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1052, 'User&Faces', 'user-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1053, 'User&Faces', 'user-4', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1054, 'User&Faces', 'user-5', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1055, 'User&Faces', 'user-6', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1056, 'User&Faces', 'user-smile', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1057, 'User&Faces', 'account-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1058, 'User&Faces', 'account-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1059, 'User&Faces', 'account-pin-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1060, 'User&Faces', 'account-pin-circle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1061, 'User&Faces', 'user-add', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1062, 'User&Faces', 'user-follow', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1063, 'User&Faces', 'user-unfollow', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1064, 'User&Faces', 'user-shared', 'transfer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1065, 'User&Faces', 'user-shared-2', 'transfer', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1066, 'User&Faces', 'user-received', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1067, 'User&Faces', 'user-received-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1068, 'User&Faces', 'user-location', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1069, 'User&Faces', 'user-search', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1070, 'User&Faces', 'user-settings', 'admin', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1071, 'User&Faces', 'user-star', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1072, 'User&Faces', 'user-heart', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1073, 'User&Faces', 'admin', 'admin', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1074, 'User&Faces', 'contacts', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1075, 'User&Faces', 'group', 'team', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1076, 'User&Faces', 'group-2', 'team', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53');
INSERT INTO `remix_icons` (`id`, `category`, `icon_class`, `hints`, `status`, `created_on`, `updated_on`) VALUES
(1077, 'User&Faces', 'team', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1078, 'User&Faces', 'user-voice', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1079, 'User&Faces', 'emotion', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1080, 'User&Faces', 'emotion-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1081, 'User&Faces', 'emotion-happy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1082, 'User&Faces', 'emotion-normal', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1083, 'User&Faces', 'emotion-unhappy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1084, 'User&Faces', 'emotion-laugh', 'comedy,happy', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1085, 'User&Faces', 'emotion-sad', 'drama,tears', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1086, 'User&Faces', 'skull', 'ghost', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1087, 'User&Faces', 'skull-2', 'ghost,horror,thriller', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1088, 'User&Faces', 'men', 'gender,man,male', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1089, 'User&Faces', 'women', 'gender,woman,female', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1090, 'User&Faces', 'travesti', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1091, 'User&Faces', 'genderless', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1092, 'User&Faces', 'open-arm', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1093, 'User&Faces', 'body-scan', 'gesture recognition,body', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1094, 'User&Faces', 'parent', 'patriarch', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1095, 'User&Faces', 'robot', 'mechanic', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1096, 'User&Faces', 'aliens', 'science fiction,ET', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1097, 'User&Faces', 'bear-smile', 'cartoon,anime,cartoon', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1098, 'User&Faces', 'mickey', 'cartoon,disney', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1099, 'User&Faces', 'criminal', 'horror,thriller', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1100, 'User&Faces', 'ghost', 'horror,thriller', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1101, 'User&Faces', 'ghost-2', 'horror', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1102, 'User&Faces', 'ghost-smile', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1103, 'User&Faces', 'star-smile', 'animation', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1104, 'User&Faces', 'spy', 'incognito mode,detective,secret', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1105, 'Weather', 'sun', 'light mode,sunny', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1106, 'Weather', 'moon', 'dark mode,night', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1107, 'Weather', 'flashlight', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1108, 'Weather', 'cloudy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1109, 'Weather', 'cloudy-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1110, 'Weather', 'mist', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1111, 'Weather', 'foggy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1112, 'Weather', 'cloud-windy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1113, 'Weather', 'windy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1114, 'Weather', 'rainy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1115, 'Weather', 'drizzle', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1116, 'Weather', 'showers', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1117, 'Weather', 'heavy-showers', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1118, 'Weather', 'thunderstorms', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1119, 'Weather', 'hail', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1120, 'Weather', 'snowy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1121, 'Weather', 'sun-cloudy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1122, 'Weather', 'moon-cloudy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1123, 'Weather', 'tornado', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1124, 'Weather', 'typhoon', 'cyclone,tornado', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1125, 'Weather', 'haze', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1126, 'Weather', 'haze-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1127, 'Weather', 'sun-foggy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1128, 'Weather', 'moon-foggy', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1129, 'Weather', 'moon-clear', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1130, 'Weather', 'temp-hot', 'temperature', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1131, 'Weather', 'temp-cold', 'temperature', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1132, 'Weather', 'celsius', 'temperature', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1133, 'Weather', 'fahrenheit', 'temperature', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1134, 'Weather', 'fire', 'hot', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1135, 'Weather', 'blaze', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1136, 'Weather', 'earthquake', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1137, 'Weather', 'flood', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1138, 'Weather', 'meteor', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1139, 'Weather', 'rainbow', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1140, 'Others', 'basketball', 'sports', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1141, 'Others', 'bell', 'cartoon,anime,doraemon', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1142, 'Others', 'billiards', 'sports,8', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1143, 'Others', 'boxing', 'sports', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1144, 'Others', 'cake', 'anniversary', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1145, 'Others', 'cake-2', 'anniversary', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1146, 'Others', 'cake-3', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1147, 'Others', 'door-lock', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1148, 'Others', 'door-lock-box', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1149, 'Others', 'football', 'sports', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1150, 'Others', 'game', 'pac man', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1151, 'Others', 'handbag', 'fashion', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1152, 'Others', 'key', 'password', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1153, 'Others', 'key-2', 'password', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1154, 'Others', 'knife', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1155, 'Others', 'knife-blood', 'crime', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1156, 'Others', 'lightbulb', 'energy,creativity', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1157, 'Others', 'lightbulb-flash', 'energy,creativity', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1158, 'Others', 'outlet', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1159, 'Others', 'outlet-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1160, 'Others', 'ping-pong', 'sports,table tennis', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1161, 'Others', 'plug', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1162, 'Others', 'plug-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1163, 'Others', 'reserved', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1164, 'Others', 'shirt', 'clothes', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1165, 'Others', 'sword', 'war', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1166, 'Others', 't-shirt', 'skin,theme', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1167, 'Others', 't-shirt-2', 'skin,theme', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1168, 'Others', 't-shirt-air', 'dry', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1169, 'Others', 'umbrella', 'protect', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1170, 'Others', 'character-recognition', 'ocr', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1171, 'Others', 'voice-recognition', 'asr', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1172, 'Others', 'leaf', 'energy,ecology', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1173, 'Others', 'plant', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1174, 'Others', 'seedling', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1175, 'Others', 'recycle', 'recyclable', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1176, 'Others', 'scales', 'balance', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1177, 'Others', 'scales-2', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1178, 'Others', 'scales-3', 'balance', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1179, 'Others', 'fridge', 'refrigerator', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1180, 'Others', 'wheelchair', 'accessbility', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1181, 'Others', 'cactus', 'desertr', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1182, 'Others', 'door', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1183, 'Others', 'door-open', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53'),
(1184, 'Others', 'door-closed', '', '1', '2022-06-22 12:05:53', '2022-06-22 12:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assert_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `title_id` int(11) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `maintainer` int(10) UNSIGNED NOT NULL,
  `created_on` datetime NOT NULL,
  `code` varchar(255) NOT NULL,
  `finished_on` datetime DEFAULT NULL,
  `maintainer_comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `ticket`
--
DELIMITER $$
CREATE TRIGGER `ticket_code` BEFORE INSERT ON `ticket` FOR EACH ROW SET new.code=CONCAT('TICK-',(SELECT AUTO_INCREMENT
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = "inventory"
AND TABLE_NAME = "ticket"))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_title`
--

CREATE TABLE `ticket_title` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_title`
--

INSERT INTO `ticket_title` (`id`, `title`, `status`, `created_on`, `created_by`) VALUES
(1, 'Others', 1, '2022-07-25 12:56:23', 1),
(2, 'DAMAGE-ISSUES', 1, '2022-07-25 12:57:49', 1),
(3, 'REPAIR ISSUES', 1, '2022-07-25 13:00:01', 1),
(4, 'NEED UPGRADE', 1, '2022-07-25 13:00:23', 1),
(5, 'Unknown', 1, '2022-08-21 11:29:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assert_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` int(12) NOT NULL,
  `is_logged` int(1) NOT NULL DEFAULT 0,
  `updated_on` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `token` text DEFAULT NULL,
  `conn_id` text DEFAULT NULL,
  `in_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `user_role`, `is_logged`, `updated_on`, `created_on`, `token`, `conn_id`, `in_active`) VALUES
(1, 'admin', 'Harry', 'Potter', 'admin@123.com', 'admin123', 1, 1, '2022-10-20 13:12:09', '2022-05-17 09:25:00', 'f1892ceb3be179f0baded5a09750a1b5', '', 0),
(2, 'employee', 'kgf', 'Dun', 'kgf@123.com', 'kgf123', 2, 1, '2022-08-19 12:36:15', '2022-05-17 09:25:00', '4a566567d5a8390f0463523d10249974', '', 0),
(3, 'Yash', 'Yash', 'P', 'pro_kgf@123.com', 'kgf123', 2, 0, '2022-10-19 12:14:58', '2022-05-17 09:25:00', '', '222', 0),
(4, 'Staff1', 'Staff1', 'kk', 'Staff1@123.com', 'Staff1', 3, 0, '2022-08-26 10:30:44', '2022-05-17 09:25:00', '', '294', 0),
(5, 'Arjun', 'Arjun', 'Reddy', 'Arjun@123.co', 'Arjun', 2, 1, '2022-08-29 15:30:02', '2022-08-26 12:45:44', '86369c25c50477e771fb47617b60480c', '', 0),
(6, 'salar', 'prabhas', 'p', 'salar@123.com', 'salar@123', 3, 0, '2022-08-26 14:03:09', '2022-08-26 14:03:09', NULL, NULL, 0),
(7, 'Theory', 'Theory', 'Grey', 'theiry@123.co', 'Theory', 3, 0, '2022-10-19 12:19:39', '2022-10-19 12:19:39', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(12) NOT NULL,
  `role` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `updated_on` datetime NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`, `role_name`, `description`, `updated_on`, `created_on`) VALUES
(1, 1, 'Admin', 'Admin-master', '2022-05-17 09:20:40', '2022-05-17 09:20:40'),
(2, 2, 'Maintainer', 'Assert in-charge', '2022-05-17 09:20:40', '2022-05-17 09:20:40'),
(3, 3, 'Staff', 'Assert users', '2022-05-17 09:20:40', '2022-05-17 09:20:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`,`receiver`,`created_on`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `created_on` (`created_on`),
  ADD KEY `bought_on` (`bought_on`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `status` (`status`),
  ADD KEY `created_by` (`created_by`,`maintainer`),
  ADD KEY `maintainer` (`maintainer`);

--
-- Indexes for table `inventory_status`
--
ALTER TABLE `inventory_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_2` (`name`),
  ADD KEY `name` (`name`),
  ADD KEY `tags` (`tags`(768)),
  ADD KEY `type` (`type`,`category`,`sub_category`),
  ADD KEY `sub_category` (`sub_category`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `remix_icons`
--
ALTER TABLE `remix_icons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icon_class` (`icon_class`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `code_3` (`code`),
  ADD KEY `code_2` (`code`),
  ADD KEY `title_id` (`title_id`),
  ADD KEY `assert_id` (`assert_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `ticket_title`
--
ALTER TABLE `ticket_title`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assert_id` (`assert_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `email` (`email`,`password`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `inventory_status`
--
ALTER TABLE `inventory_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `remix_icons`
--
ALTER TABLE `remix_icons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1185;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ticket_title`
--
ALTER TABLE `ticket_title`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `users` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`status`) REFERENCES `inventory_status` (`id`),
  ADD CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`maintainer`) REFERENCES `users` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`sub_category`) REFERENCES `product_sub_category` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`type`) REFERENCES `product_type` (`id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`category`) REFERENCES `product_category` (`id`);

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`type`) REFERENCES `product_type` (`id`);

--
-- Constraints for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD CONSTRAINT `product_sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `ticket_title` (`id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`assert_id`) REFERENCES `inventory` (`id`);

--
-- Constraints for table `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`assert_id`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `timeline_ibfk_2` FOREIGN KEY (`status`) REFERENCES `inventory_status` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role`) REFERENCES `user_role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
