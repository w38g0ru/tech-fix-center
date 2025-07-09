-- =============================================
-- Tech Fix Center Complete Database Dump
-- Structure + Data
-- Generated: 2025-07-09
-- Database: tech_fix_center
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =============================================
-- Database: `tech_fix_center`
-- =============================================

-- =============================================
-- Drop existing tables (in reverse order due to foreign keys)
-- =============================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `dispatch_photos`;
DROP TABLE IF EXISTS `inventory_photos`;
DROP TABLE IF EXISTS `job_photos`;
DROP TABLE IF EXISTS `parts_requests`;
DROP TABLE IF EXISTS `inventory_movements`;
DROP TABLE IF EXISTS `inventory_items`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `service_centers`;
DROP TABLE IF EXISTS `technicians`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- =============================================
-- Table structure for table `users`
-- =============================================

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','manager','technician','customer') NOT NULL DEFAULT 'customer',
  `user_type` varchar(50) DEFAULT 'Customer',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_role` (`role`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `users`
-- =============================================

INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `password`, `role`, `user_type`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@techfixcenter.com', '9841234567', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'superadmin', 'Admin', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(2, 'Admin User', 'admin2@techfixcenter.com', '9841234568', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'admin', 'Admin', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(3, 'Manager User', 'manager@techfixcenter.com', '9841234569', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'manager', 'Manager', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(4, 'रमेश श्रेष्ठ', 'ramesh@example.com', '9851234567', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'customer', 'Customer', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(5, 'सुनिता गुरुङ', 'sunita@example.com', '9861234567', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'customer', 'Customer', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(6, 'बिमल पौडेल', 'bimal@example.com', '9871234567', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'customer', 'Customer', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(7, 'कमला शर्मा', 'kamala@example.com', '9881234567', '$2y$12$QiVH3iEK8r9r/po81pDNlONHP3wHTyHbiuN2rx3VTRRt0R0CW.Yqm', 'customer', 'Customer', 'active', '2025-07-09 10:00:00', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00');

-- =============================================
-- Table structure for table `technicians`
-- =============================================

CREATE TABLE `technicians` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_specialization` (`specialization`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `technicians`
-- =============================================

INSERT INTO `technicians` (`id`, `name`, `email`, `mobile_number`, `specialization`, `experience_years`, `status`, `created_at`, `updated_at`) VALUES
(1, 'अनिल तामाङ', 'anil@techfixcenter.com', '9841111111', 'Mobile Phone Repair', 5, 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(2, 'प्रिया शर्मा', 'priya@techfixcenter.com', '9841111112', 'Laptop Repair', 3, 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(3, 'राजेश थापा', 'rajesh@techfixcenter.com', '9841111113', 'Computer Hardware', 7, 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(4, 'सुमन राई', 'suman@techfixcenter.com', '9841111114', 'Tablet Repair', 4, 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(5, 'गीता लामा', 'geeta@techfixcenter.com', '9841111115', 'Gaming Console Repair', 6, 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00');

-- =============================================
-- Table structure for table `service_centers`
-- =============================================

CREATE TABLE `service_centers` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `service_centers`
-- =============================================

INSERT INTO `service_centers` (`id`, `name`, `address`, `contact_number`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'काठमाडौं सर्भिस सेन्टर', 'न्यू रोड, काठमाडौं', '01-4567890', 'ktm@servicecenter.com', 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(2, 'पोखरा सर्भिस सेन्टर', 'लेकसाइड, पोखरा', '061-567890', 'pokhara@servicecenter.com', 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(3, 'चितवन सर्भिस सेन्टर', 'भरतपुर, चितवन', '056-567890', 'chitwan@servicecenter.com', 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(4, 'बुटवल सर्भिस सेन्टर', 'ट्राफिक चोक, बुटवल', '071-567890', 'butwal@servicecenter.com', 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(5, 'धरान सर्भिस सेन्टर', 'भानु चोक, धरान', '025-567890', 'dharan@servicecenter.com', 'active', '2025-07-09 10:00:00', '2025-07-09 10:00:00');

-- =============================================
-- Table structure for table `jobs`
-- =============================================

CREATE TABLE `jobs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `walk_in_customer_name` varchar(100) DEFAULT NULL,
  `walk_in_customer_mobile` varchar(20) DEFAULT NULL,
  `device_name` varchar(100) NOT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `problem` text NOT NULL,
  `technician_id` int(11) UNSIGNED DEFAULT NULL,
  `status` enum('pending','in_progress','completed','cancelled','dispatched','returned') NOT NULL DEFAULT 'pending',
  `charge` decimal(10,2) DEFAULT NULL,
  `dispatch_type` enum('internal','external') DEFAULT NULL,
  `service_center_id` int(11) UNSIGNED DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `nepali_date` varchar(20) DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `dispatch_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `technician_id` (`technician_id`),
  KEY `service_center_id` (`service_center_id`),
  KEY `idx_status` (`status`),
  KEY `idx_dispatch_date` (`dispatch_date`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jobs_ibfk_3` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `jobs`
-- =============================================

INSERT INTO `jobs` (`id`, `user_id`, `walk_in_customer_name`, `walk_in_customer_mobile`, `device_name`, `serial_number`, `problem`, `technician_id`, `status`, `charge`, `dispatch_type`, `service_center_id`, `dispatch_date`, `nepali_date`, `expected_return_date`, `actual_return_date`, `dispatch_notes`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, NULL, 'iPhone 12', 'IP12001', 'Screen cracked, touch not working properly', 1, 'in_progress', 18000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(2, NULL, 'बिनोद पौडेल', '9876543210', 'Samsung Galaxy A54', 'SGA54002', 'Battery draining very fast, phone heating up', 2, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(3, 5, NULL, NULL, 'MacBook Pro', 'MBP2023003', 'Keyboard keys not working, some keys stuck', 2, 'dispatched', 10000.00, 'external', 1, '2025-07-08', '२०८२/०३/२३', '2025-07-15', NULL, 'Sent to Kathmandu service center for keyboard replacement', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(4, NULL, 'सरिता राई', NULL, 'Dell Laptop', 'DL2023004', 'Laptop won\'t turn on, no power indicator', 3, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(5, 6, NULL, NULL, 'iPad Air', 'IPA2023005', 'Screen flickering, display issues', 1, 'in_progress', 15000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(6, NULL, 'मनोज खड्का', '9812345678', 'Samsung TV', 'STV2023006', 'No display, sound working fine', 4, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(7, 7, NULL, NULL, 'HP Printer', 'HPP2023007', 'Paper jam, not printing properly', 5, 'completed', 2500.00, NULL, NULL, NULL, NULL, NULL, '2025-07-09', NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(8, NULL, 'राम बहादुर', '9823456789', 'PlayStation 5', 'PS52023008', 'Controller not connecting, console overheating', 5, 'dispatched', 8000.00, 'external', 2, '2025-07-07', '२०८२/०३/२२', '2025-07-14', NULL, 'Sent to Pokhara service center for specialized gaming console repair', '2025-07-09 10:00:00', '2025-07-09 10:00:00');

-- =============================================
-- Table structure for table `inventory_items`
-- =============================================

CREATE TABLE `inventory_items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `total_stock` int(11) NOT NULL DEFAULT 0,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `minimum_order_level` int(11) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive','Discontinued') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_device_name` (`device_name`),
  KEY `idx_brand` (`brand`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`),
  KEY `idx_stock_level` (`total_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `inventory_items`
-- =============================================

INSERT INTO `inventory_items` (`id`, `device_name`, `brand`, `model`, `category`, `total_stock`, `purchase_price`, `selling_price`, `minimum_order_level`, `supplier`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'iPhone Screen', 'Apple', 'iPhone 14 Pro', 'Mobile Parts', 25, 15000.00, 18000.00, 5, 'Apple Store Nepal', 'Original iPhone 14 Pro screen replacement with touch functionality', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(2, 'Samsung Battery', 'Samsung', 'Galaxy S23', 'Mobile Parts', 30, 2500.00, 3000.00, 10, 'Samsung Nepal', 'Original Samsung Galaxy S23 battery 3900mAh', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(3, 'MacBook Keyboard', 'Apple', 'MacBook Air M2', 'Laptop Parts', 15, 8000.00, 10000.00, 3, 'Apple Store Nepal', 'MacBook Air M2 keyboard replacement with backlight', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(4, 'Dell RAM', 'Dell', 'Inspiron 15', 'Computer Parts', 20, 3500.00, 4200.00, 5, 'Dell Nepal', '8GB DDR4 RAM module 2666MHz', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(5, 'Charging Cable', 'Generic', 'USB-C', 'Accessories', 50, 200.00, 350.00, 15, 'Local Supplier', 'USB-C charging cable 1 meter length', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(6, 'iPad Screen', 'Apple', 'iPad Air 5th Gen', 'Tablet Parts', 12, 12000.00, 15000.00, 3, 'Apple Store Nepal', 'iPad Air 5th generation screen replacement', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(7, 'HP Ink Cartridge', 'HP', 'HP 678', 'Printer Parts', 40, 800.00, 1200.00, 10, 'HP Nepal', 'HP 678 black ink cartridge', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(8, 'PlayStation Controller', 'Sony', 'DualSense', 'Gaming Parts', 8, 6000.00, 8000.00, 2, 'Sony Nepal', 'PlayStation 5 DualSense wireless controller', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(9, 'Samsung TV Panel', 'Samsung', '55 inch QLED', 'TV Parts', 3, 45000.00, 55000.00, 1, 'Samsung Nepal', '55 inch QLED TV display panel', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(10, 'Power Adapter', 'Generic', 'Universal', 'Accessories', 25, 500.00, 800.00, 8, 'Local Supplier', 'Universal power adapter 65W', 'Active', '2025-07-09 10:00:00', '2025-07-09 10:00:00');

-- =============================================
-- Table structure for table `inventory_movements`
-- =============================================

CREATE TABLE `inventory_movements` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inventory_item_id` int(11) UNSIGNED NOT NULL,
  `movement_type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `inventory_item_id` (`inventory_item_id`),
  KEY `created_by` (`created_by`),
  KEY `idx_movement_type` (`movement_type`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `inventory_movements_ibfk_1` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_movements_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `inventory_movements`
-- =============================================

INSERT INTO `inventory_movements` (`id`, `inventory_item_id`, `movement_type`, `quantity`, `notes`, `created_by`, `created_at`) VALUES
(1, 1, 'in', 30, 'Initial stock - iPhone 14 Pro screens', 1, '2025-07-09 10:00:00'),
(2, 1, 'out', 5, 'Used for iPhone repair jobs', 1, '2025-07-09 10:30:00'),
(3, 2, 'in', 50, 'Initial stock - Samsung Galaxy S23 batteries', 1, '2025-07-09 10:00:00'),
(4, 2, 'out', 20, 'Used for Samsung repair jobs', 1, '2025-07-09 11:00:00'),
(5, 3, 'in', 20, 'Initial stock - MacBook Air M2 keyboards', 1, '2025-07-09 10:00:00'),
(6, 3, 'out', 5, 'Used for MacBook repair jobs', 1, '2025-07-09 11:30:00'),
(7, 5, 'in', 100, 'Initial stock - USB-C charging cables', 1, '2025-07-09 10:00:00'),
(8, 5, 'out', 50, 'Sold to customers', 1, '2025-07-09 12:00:00');

-- =============================================
-- Table structure for table `parts_requests`
-- =============================================

CREATE TABLE `parts_requests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `technician_id` int(11) UNSIGNED NOT NULL,
  `job_id` int(11) UNSIGNED DEFAULT NULL,
  `part_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `urgency` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
  `status` enum('pending','approved','rejected','fulfilled') NOT NULL DEFAULT 'pending',
  `requested_date` date NOT NULL,
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `technician_id` (`technician_id`),
  KEY `job_id` (`job_id`),
  KEY `approved_by` (`approved_by`),
  KEY `idx_status` (`status`),
  KEY `idx_urgency` (`urgency`),
  CONSTRAINT `parts_requests_ibfk_1` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parts_requests_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `parts_requests_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Dumping data for table `parts_requests`
-- =============================================

INSERT INTO `parts_requests` (`id`, `technician_id`, `job_id`, `part_name`, `quantity`, `description`, `urgency`, `status`, `requested_date`, `approved_by`, `approved_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'iPhone 12 Screen', 1, 'Original screen replacement for cracked display', 'high', 'approved', '2025-07-09', 1, '2025-07-09', 'Approved for immediate replacement', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(2, 2, 2, 'Samsung Galaxy A54 Battery', 1, 'Battery replacement for fast draining issue', 'medium', 'pending', '2025-07-09', NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(3, 3, 4, 'Dell Laptop Motherboard', 1, 'Motherboard replacement - laptop not turning on', 'critical', 'pending', '2025-07-09', NULL, NULL, NULL, '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(4, 1, 5, 'iPad Air Screen', 1, 'Screen replacement for flickering display', 'high', 'approved', '2025-07-09', 2, '2025-07-09', 'Approved - screen in stock', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(5, 5, 7, 'HP Printer Roller', 2, 'Paper feed roller replacement for jam issue', 'low', 'fulfilled', '2025-07-08', 1, '2025-07-08', 'Parts delivered and job completed', '2025-07-09 10:00:00', '2025-07-09 10:00:00'),
(6, 5, 8, 'PlayStation 5 Controller', 1, 'Replacement controller for connection issues', 'medium', 'approved', '2025-07-07', 3, '2025-07-07', 'Approved for external service center', '2025-07-09 10:00:00', '2025-07-09 10:00:00');

-- =============================================
-- Table structure for table `job_photos`
-- =============================================

CREATE TABLE `job_photos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` int(11) UNSIGNED NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `photo_description` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `job_photos_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `job_photos_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table structure for table `inventory_photos`
-- =============================================

CREATE TABLE `inventory_photos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inventory_item_id` int(11) UNSIGNED NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `photo_description` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `inventory_item_id` (`inventory_item_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `inventory_photos_ibfk_1` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_photos_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table structure for table `dispatch_photos`
-- =============================================

CREATE TABLE `dispatch_photos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` int(11) UNSIGNED NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `photo_description` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `dispatch_photos_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dispatch_photos_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Auto Increment Values
-- =============================================

ALTER TABLE `users` AUTO_INCREMENT = 8;
ALTER TABLE `technicians` AUTO_INCREMENT = 6;
ALTER TABLE `service_centers` AUTO_INCREMENT = 6;
ALTER TABLE `jobs` AUTO_INCREMENT = 9;
ALTER TABLE `inventory_items` AUTO_INCREMENT = 11;
ALTER TABLE `inventory_movements` AUTO_INCREMENT = 9;
ALTER TABLE `parts_requests` AUTO_INCREMENT = 7;
ALTER TABLE `job_photos` AUTO_INCREMENT = 1;
ALTER TABLE `inventory_photos` AUTO_INCREMENT = 1;
ALTER TABLE `dispatch_photos` AUTO_INCREMENT = 1;

-- =============================================
-- Indexes for better performance
-- =============================================

-- Additional indexes for common queries
ALTER TABLE `jobs` ADD INDEX `idx_created_at` (`created_at`);
ALTER TABLE `jobs` ADD INDEX `idx_customer_type` (`user_id`, `walk_in_customer_name`);
ALTER TABLE `inventory_items` ADD INDEX `idx_low_stock` (`total_stock`, `minimum_order_level`);
ALTER TABLE `inventory_movements` ADD INDEX `idx_item_date` (`inventory_item_id`, `created_at`);

-- =============================================
-- Views for common queries
-- =============================================

-- View for jobs with customer information
CREATE VIEW `jobs_with_customers` AS
SELECT
    j.*,
    u.name as customer_name,
    u.email as customer_email,
    u.mobile_number as customer_mobile,
    t.name as technician_name,
    sc.name as service_center_name
FROM jobs j
LEFT JOIN users u ON j.user_id = u.id
LEFT JOIN technicians t ON j.technician_id = t.id
LEFT JOIN service_centers sc ON j.service_center_id = sc.id;

-- View for low stock items
CREATE VIEW `low_stock_items` AS
SELECT
    *,
    (total_stock - COALESCE(minimum_order_level, 0)) as stock_difference
FROM inventory_items
WHERE total_stock <= COALESCE(minimum_order_level, 0)
AND status = 'Active';

-- View for inventory with movement summary
CREATE VIEW `inventory_with_movements` AS
SELECT
    i.*,
    COALESCE(SUM(CASE WHEN im.movement_type = 'in' THEN im.quantity ELSE 0 END), 0) as total_in,
    COALESCE(SUM(CASE WHEN im.movement_type = 'out' THEN im.quantity ELSE 0 END), 0) as total_out
FROM inventory_items i
LEFT JOIN inventory_movements im ON i.id = im.inventory_item_id
GROUP BY i.id;

-- =============================================
-- Sample configuration data
-- =============================================

-- Create a simple settings table for application configuration
CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`setting_key`, `setting_value`, `description`) VALUES
('company_name', 'Tech Fix Center', 'Company name displayed in the application'),
('company_address', 'New Road, Kathmandu, Nepal', 'Company address'),
('company_phone', '01-4567890', 'Company contact phone number'),
('company_email', 'info@techfixcenter.com', 'Company contact email'),
('currency', 'NPR', 'Default currency for pricing'),
('timezone', 'Asia/Kathmandu', 'Application timezone'),
('low_stock_threshold', '5', 'Default low stock threshold'),
('backup_frequency', 'daily', 'Database backup frequency');

-- =============================================
-- Final cleanup and commit
-- =============================================

SET FOREIGN_KEY_CHECKS = 1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;
