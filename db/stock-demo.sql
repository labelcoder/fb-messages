-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 28, 2024 at 03:43 AM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock-demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'กระดาษกรีนพลัส', 'กระดาษกรีนพลัส', '2024-11-26 13:09:50', '2024-11-27 12:46:14'),
(2, 'Elephant (ตราช้าง)', 'Elephant (ตราช้าง)', '2024-11-26 13:10:56', '2024-11-27 12:46:49'),
(7, 'Liquid Paper', 'Liquid Paper', '2024-11-26 14:39:27', '2024-11-27 12:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `facebook_id` varchar(150) DEFAULT NULL,
  `line_id` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `created_at`, `updated_at`, `facebook_id`, `line_id`) VALUES
(1, 'นายศรัณย์ภัทร', 'ยืนยาว', 'sarun@hotmail.com', '098 228-1182', '330 ถ.เชียงใหม่-ลำปาง ต.ป่าตัน อ.เมือง รหัสไปรษณีย์ 50300', '2024-11-26 22:22:30', '2024-11-27 12:45:28', NULL, NULL),
(2, 'นายเทพรัตน์', 'กูลรัตน', 'admin@ayaantec.com', '098 338-7682', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130', '2024-11-26 22:31:10', '2024-11-27 12:45:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facebook_comments`
--

CREATE TABLE `facebook_comments` (
  `id` bigint(20) NOT NULL,
  `comment_id` varchar(255) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_id` varchar(255) DEFAULT NULL,
  `parent_comment_id` varchar(255) DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4,
  `created_time` datetime NOT NULL,
  `updated_time` datetime DEFAULT NULL,
  `like_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facebook_fetch_history`
--

CREATE TABLE `facebook_fetch_history` (
  `id` bigint(20) NOT NULL,
  `fetch_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `post_id` varchar(255) DEFAULT NULL,
  `comments_fetched` int(11) DEFAULT '0',
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facebook_posts`
--

CREATE TABLE `facebook_posts` (
  `id` bigint(20) NOT NULL,
  `post_id` varchar(255) NOT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_id` varchar(255) DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4,
  `created_time` datetime NOT NULL,
  `updated_time` datetime DEFAULT NULL,
  `like_count` int(11) DEFAULT '0',
  `comment_count` int(11) DEFAULT '0',
  `share_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facebook_users`
--

CREATE TABLE `facebook_users` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `profile_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(100) DEFAULT NULL,
  `price_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `note` text,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `status`, `total_amount`, `created_at`, `updated_at`, `code`, `price_amount`, `discount_amount`, `note`, `address`) VALUES
(2, 1, '2024-11-27 08:11:39', 'wait', '0.00', '2024-11-27 15:11:39', NULL, '1732695099', '0.00', '0.00', 'aaa', '330 ถ.เชียงใหม่-ลำปาง ต.ป่าตัน อ.เมือง รหัสไปรษณีย์ 50300'),
(3, 1, '2024-11-27 08:13:32', 'wait', '10.00', '2024-11-27 15:13:32', '2024-11-27 15:13:32', '1732695212', '10.00', '0.00', 'ee', '330 ถ.เชียงใหม่-ลำปาง ต.ป่าตัน อ.เมือง รหัสไปรษณีย์ 50300'),
(4, 2, '2024-11-27 08:39:40', 'wait', '20.00', '2024-11-27 15:39:40', '2024-11-27 15:39:40', '1732696780', '20.00', '0.00', 'sdfsdf', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130'),
(6, 2, '2024-11-27 08:48:40', 'wait', '20.00', '2024-11-27 15:48:40', '2024-11-27 15:48:40', '1732697320', '20.00', '0.00', 'rrr', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130'),
(7, 2, '2024-11-27 08:50:52', 'wait', '8.00', '2024-11-27 15:50:52', '2024-11-27 15:50:52', '1732697452', '8.00', '0.00', 'ddfdfdfdfdfdf', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130'),
(8, 2, '2024-11-27 09:02:31', 'wait', '14.00', '2024-11-27 16:02:31', '2024-11-27 16:02:31', '1732698151', '14.00', '0.00', 'ddfdf', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130'),
(9, 2, '2024-11-28 01:21:25', 'wait', '5.00', '2024-11-28 01:21:25', '2024-11-28 01:21:25', '1732731685', '5.00', '0.00', 'aaa', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130'),
(10, 2, '2024-11-28 01:21:57', 'wait', '10.00', '2024-11-28 01:21:57', '2024-11-28 01:21:57', '1732731717', '10.00', '0.00', 'aaa', '36 หมู่ 10 ถ.เชียงใหม่-สันกำแพง ต.สันกำแพง อ.สันกำแพง รหัสไปรษณีย์ 50130');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price_at_order` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_at_order`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, '0.00', '0.00', '2024-11-27 15:11:39', NULL),
(2, 2, 2, 0, '0.00', '0.00', '2024-11-27 15:11:39', NULL),
(3, 3, 1, 1, '5.00', '0.00', '2024-11-27 15:13:32', NULL),
(4, 3, 2, 1, '5.00', '0.00', '2024-11-27 15:13:32', NULL),
(5, 4, 1, 2, '10.00', '0.00', '2024-11-27 15:39:40', NULL),
(6, 4, 2, 3, '10.00', '0.00', '2024-11-27 15:39:40', NULL),
(8, 6, 4, 7, '20.00', '0.00', '2024-11-27 15:48:40', NULL),
(9, 7, 4, 3, '8.00', '0.00', '2024-11-27 15:50:52', NULL),
(10, 8, 1, 1, '5.00', '0.00', '2024-11-27 16:02:31', NULL),
(11, 8, 3, 1, '9.00', '0.00', '2024-11-27 16:02:31', NULL),
(12, 9, 1, 1, '5.00', '0.00', '2024-11-28 01:21:25', NULL),
(13, 10, 1, 2, '10.00', '0.00', '2024-11-28 01:21:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `sku`, `price`, `stock_quantity`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'กระดาษกรีนพลัส น้ำหนักมาตรฐาน 80 กรัมต่อตารางเมตร', 'กระดาษกรีนพลัส น้ำหนักมาตรฐาน 60 กรัมต่อตารางเมตร', 'SKU-00001', '5.00', 27, '2024-11-26 15:26:53', '2024-11-28 03:53:59', 1),
(2, 'กระดาษถ่ายเอกสาร Shih-Tzu 70 gsm. ขนาด A4', 'กระดาษถ่ายเอกสาร Shih-Tzu 70 gsm. ขนาด A4', 'SKU-00021', '5.00', 6, '2024-11-26 15:30:21', '2024-11-27 15:39:40', 2),
(3, 'กระดาษถ่ายเอกสาร Alpine 70 gsm.', 'กระดาษถ่ายเอกสาร Alpine 70 gsm.', 'SKU-00031', '9.00', 14, '2024-11-26 15:40:53', '2024-11-27 16:02:31', 1),
(4, 'ปากกำลบคำผิดตรำช้ำง รุ่น Oopsy', 'ปากกำลบคำผิดตรำช้ำง รุ่น Oopsy', 'SKU-00032', '4.00', 12, '2024-11-26 15:49:10', '2024-11-28 03:53:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_promotions`
--

CREATE TABLE `product_promotions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_promotions`
--

INSERT INTO `product_promotions` (`id`, `product_id`, `promotion_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2024-11-26 22:22:30', NULL),
(2, 4, 1, '2024-11-26 22:22:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `qty` int(5) NOT NULL DEFAULT '0',
  `qty_free` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `description`, `discount_percentage`, `start_date`, `end_date`, `created_at`, `updated_at`, `qty`, `qty_free`) VALUES
(1, 'ซื้อ 2 แถม 1', 'ซื้อ 2 แถม 1', '0.00', '2024-11-26 22:22:30', '2024-12-31 23:59:59', '2024-11-27 11:33:42', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` bigint(20) NOT NULL,
  `comment_id` varchar(255) DEFAULT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `reaction_type` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_information` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Deo', 'deo@gmail.com', NULL, '$2y$10$osSRuzYY6tusWyKufF49XOYSqJmKxaFomoL0R1TJG6/kNO4.cayRO', NULL, '2024-11-24 23:22:31', '2024-11-24 23:22:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `facebook_comments`
--
ALTER TABLE `facebook_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebook_fetch_history`
--
ALTER TABLE `facebook_fetch_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebook_posts`
--
ALTER TABLE `facebook_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facebook_users`
--
ALTER TABLE `facebook_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `product_promotions`
--
ALTER TABLE `product_promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `promotion_id` (`promotion_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `facebook_comments`
--
ALTER TABLE `facebook_comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facebook_fetch_history`
--
ALTER TABLE `facebook_fetch_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facebook_posts`
--
ALTER TABLE `facebook_posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facebook_users`
--
ALTER TABLE `facebook_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_promotions`
--
ALTER TABLE `product_promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_promotions`
--
ALTER TABLE `product_promotions`
  ADD CONSTRAINT `product_promotions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_promotions_ibfk_2` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`);

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_transactions_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
