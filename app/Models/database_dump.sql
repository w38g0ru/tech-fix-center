-- =============================================
-- Tech Fix Center Database Dump
-- Generated: 2025-07-09
-- =============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- =============================================
-- Database: tech_fix_center
-- =============================================

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

-- =============================================
-- Sample Data Inserts
-- =============================================

-- Insert default admin user
INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `password`, `role`, `user_type`, `status`) VALUES
(1, 'Super Admin', 'admin@techfixcenter.com', '9841234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', 'Admin', 'active'),
(2, 'रमेश श्रेष्ठ', 'ramesh@example.com', '9851234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 'Customer', 'active'),
(3, 'सुनिता गुरुङ', 'sunita@example.com', '9861234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 'Customer', 'active');

-- Insert sample technicians
INSERT INTO `technicians` (`id`, `name`, `email`, `mobile_number`, `specialization`, `experience_years`, `status`) VALUES
(1, 'अनिल तामाङ', 'anil@techfixcenter.com', '9841111111', 'Mobile Phone Repair', 5, 'active'),
(2, 'प्रिया शर्मा', 'priya@techfixcenter.com', '9841111112', 'Laptop Repair', 3, 'active'),
(3, 'राजेश थापा', 'rajesh@techfixcenter.com', '9841111113', 'Computer Hardware', 7, 'active');

-- Insert sample service centers
INSERT INTO `service_centers` (`id`, `name`, `address`, `contact_number`, `email`, `status`) VALUES
(1, 'काठमाडौं सर्भिस सेन्टर', 'न्यू रोड, काठमाडौं', '01-4567890', 'ktm@servicecenter.com', 'active'),
(2, 'पोखरा सर्भिस सेन्टर', 'लेकसाइड, पोखरा', '061-567890', 'pokhara@servicecenter.com', 'active'),
(3, 'चितवन सर्भिस सेन्टर', 'भरतपुर, चितवन', '056-567890', 'chitwan@servicecenter.com', 'active');

-- Insert sample inventory items with pricing
INSERT INTO `inventory_items` (`id`, `device_name`, `brand`, `model`, `category`, `total_stock`, `purchase_price`, `selling_price`, `minimum_order_level`, `supplier`, `description`, `status`) VALUES
(1, 'iPhone Screen', 'Apple', 'iPhone 14 Pro', 'Mobile Parts', 25, 15000.00, 18000.00, 5, 'Apple Store Nepal', 'Original iPhone 14 Pro screen replacement', 'Active'),
(2, 'Samsung Battery', 'Samsung', 'Galaxy S23', 'Mobile Parts', 30, 2500.00, 3000.00, 10, 'Samsung Nepal', 'Original Samsung Galaxy S23 battery', 'Active'),
(3, 'MacBook Keyboard', 'Apple', 'MacBook Air M2', 'Laptop Parts', 15, 8000.00, 10000.00, 3, 'Apple Store Nepal', 'MacBook Air M2 keyboard replacement', 'Active'),
(4, 'Dell RAM', 'Dell', 'Inspiron 15', 'Computer Parts', 20, 3500.00, 4200.00, 5, 'Dell Nepal', '8GB DDR4 RAM module', 'Active'),
(5, 'Charging Cable', 'Generic', 'USB-C', 'Accessories', 50, 200.00, 350.00, 15, 'Local Supplier', 'USB-C charging cable', 'Active');

-- Insert sample jobs with walk-in customers
INSERT INTO `jobs` (`id`, `user_id`, `walk_in_customer_name`, `walk_in_customer_mobile`, `device_name`, `serial_number`, `problem`, `technician_id`, `status`, `charge`, `dispatch_type`, `service_center_id`, `dispatch_date`, `nepali_date`, `expected_return_date`) VALUES
(1, 2, NULL, NULL, 'iPhone 12', 'IP12001', 'Screen cracked, touch not working', 1, 'in_progress', 18000.00, NULL, NULL, NULL, NULL, NULL),
(2, NULL, 'बिनोद पौडेल', '9876543210', 'Samsung Galaxy A54', 'SGA54002', 'Battery draining fast', 2, 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, 'MacBook Pro', 'MBP2023003', 'Keyboard keys not working', 2, 'dispatched', 10000.00, 'external', 1, '2025-07-08', '२०८२/०३/२३', '2025-07-15'),
(4, NULL, 'सरिता राई', NULL, 'Dell Laptop', 'DL2023004', 'Won\'t turn on', 3, 'pending', NULL, NULL, NULL, NULL, NULL, NULL);

-- Insert sample parts requests
INSERT INTO `parts_requests` (`id`, `technician_id`, `job_id`, `part_name`, `quantity`, `description`, `urgency`, `status`, `requested_date`) VALUES
(1, 1, 1, 'iPhone 12 Screen', 1, 'Original screen replacement for cracked display', 'high', 'approved', '2025-07-09'),
(2, 2, 2, 'Samsung Galaxy A54 Battery', 1, 'Battery replacement for fast draining issue', 'medium', 'pending', '2025-07-09'),
(3, 3, 4, 'Dell Laptop Motherboard', 1, 'Motherboard replacement - laptop not turning on', 'critical', 'pending', '2025-07-09');

-- =============================================
-- Auto Increment Values
-- =============================================

ALTER TABLE `users` AUTO_INCREMENT = 4;
ALTER TABLE `technicians` AUTO_INCREMENT = 4;
ALTER TABLE `service_centers` AUTO_INCREMENT = 4;
ALTER TABLE `jobs` AUTO_INCREMENT = 5;
ALTER TABLE `inventory_items` AUTO_INCREMENT = 6;
ALTER TABLE `inventory_movements` AUTO_INCREMENT = 1;
ALTER TABLE `parts_requests` AUTO_INCREMENT = 4;
ALTER TABLE `job_photos` AUTO_INCREMENT = 1;
ALTER TABLE `inventory_photos` AUTO_INCREMENT = 1;
ALTER TABLE `dispatch_photos` AUTO_INCREMENT = 1;

COMMIT;
