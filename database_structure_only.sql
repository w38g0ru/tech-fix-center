-- =============================================
-- Tech Fix Center Database Structure Only
-- Generated: 2025-07-09
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =============================================
-- Database: tech_fix_center
-- =============================================

-- Drop tables if they exist (in reverse order due to foreign keys)
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
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jobs_ibfk_3` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  CONSTRAINT `inventory_movements_ibfk_1` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_movements_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  CONSTRAINT `parts_requests_ibfk_1` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parts_requests_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `parts_requests_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

COMMIT;
