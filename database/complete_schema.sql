-- TeknoPhix Complete Database Schema
-- This file contains all the necessary tables for the TeknoPhix application

SET FOREIGN_KEY_CHECKS = 0;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS `user_activity_logs`;
DROP TABLE IF EXISTS `inventory_import_logs`;
DROP TABLE IF EXISTS `parts_requests`;
DROP TABLE IF EXISTS `photos`;
DROP TABLE IF EXISTS `inventory_movements`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `referred`;
DROP TABLE IF EXISTS `service_centers`;
DROP TABLE IF EXISTS `inventory_items`;
DROP TABLE IF EXISTS `technicians`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `admin_users`;
DROP TABLE IF EXISTS `bug_reports`;

-- Create admin_users table for system authentication
CREATE TABLE `admin_users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','technician','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `google_id` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_role` (`role`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create users table for customers
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('superadmin','admin','manager','technician','customer') NOT NULL DEFAULT 'customer',
  `user_type` enum('Registered','Walk-in') NOT NULL DEFAULT 'Walk-in',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_role` (`role`),
  KEY `idx_status` (`status`),
  KEY `idx_user_type` (`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create technicians table
CREATE TABLE `technicians` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create service_centers table
CREATE TABLE `service_centers` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create inventory_items table
CREATE TABLE `inventory_items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_name` varchar(100) DEFAULT NULL,
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
  KEY `idx_status` (`status`),
  KEY `idx_category` (`category`),
  KEY `idx_brand` (`brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create jobs table
CREATE TABLE `jobs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `walk_in_customer_name` varchar(100) DEFAULT NULL,
  `walk_in_customer_mobile` varchar(20) DEFAULT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `device_model` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `technician_id` int(11) UNSIGNED DEFAULT NULL,
  `status` enum('Pending','In Progress','Parts Pending','Referred to Service Center','Ready to Dispatch to Customer','Returned','Completed') NOT NULL DEFAULT 'Pending',
  `charge` decimal(10,2) DEFAULT NULL,
  `dispatch_type` enum('Customer','Service Center','Other') DEFAULT NULL,
  `service_center_id` int(11) UNSIGNED DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `nepali_date` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_technician_id` (`technician_id`),
  KEY `idx_service_center_id` (`service_center_id`),
  KEY `idx_status` (`status`),
  KEY `idx_dispatch_date` (`dispatch_date`),
  CONSTRAINT `fk_jobs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jobs_technician` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jobs_service_center` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create referred table
CREATE TABLE `referred` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `problem_description` text DEFAULT NULL,
  `referred_to` varchar(100) DEFAULT NULL,
  `service_center_id` int(11) UNSIGNED DEFAULT NULL,
  `status` enum('Pending','Dispatched','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_service_center_id` (`service_center_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_referred_service_center` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create inventory_movements table
CREATE TABLE `inventory_movements` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(11) UNSIGNED NOT NULL,
  `movement_type` enum('IN','OUT') NOT NULL,
  `quantity` int(11) NOT NULL,
  `job_id` int(11) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `moved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_item_id` (`item_id`),
  KEY `idx_job_id` (`job_id`),
  KEY `idx_movement_type` (`movement_type`),
  KEY `idx_moved_at` (`moved_at`),
  CONSTRAINT `fk_movements_item` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_movements_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create parts_requests table
CREATE TABLE `parts_requests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `technician_id` int(11) UNSIGNED NOT NULL,
  `job_id` int(11) UNSIGNED DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `quantity_requested` int(11) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `urgency` enum('Low','Medium','High','Critical') NOT NULL DEFAULT 'Medium',
  `status` enum('Pending','Approved','Rejected','Ordered','Received','Cancelled') NOT NULL DEFAULT 'Pending',
  `requested_by` int(11) UNSIGNED DEFAULT NULL,
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `estimated_cost` decimal(10,2) DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_technician_id` (`technician_id`),
  KEY `idx_job_id` (`job_id`),
  KEY `idx_status` (`status`),
  KEY `idx_urgency` (`urgency`),
  CONSTRAINT `fk_parts_requests_technician` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_parts_requests_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create photos table
CREATE TABLE `photos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `related_type` enum('job','inventory','dispatch','referred') NOT NULL,
  `related_id` int(11) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_related` (`related_type`, `related_id`),
  KEY `idx_uploaded_by` (`uploaded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create inventory_import_logs table
CREATE TABLE `inventory_import_logs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `imported_by` int(11) UNSIGNED NOT NULL,
  `total_rows` int(11) NOT NULL DEFAULT 0,
  `successful_rows` int(11) NOT NULL DEFAULT 0,
  `failed_rows` int(11) NOT NULL DEFAULT 0,
  `error_log` text DEFAULT NULL,
  `status` enum('Processing','Completed','Failed') NOT NULL DEFAULT 'Processing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_imported_by` (`imported_by`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_import_logs_user` FOREIGN KEY (`imported_by`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create user_activity_logs table
CREATE TABLE `user_activity_logs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `activity_type` enum('login','logout','post') NOT NULL,
  `description` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_activity_type` (`activity_type`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create bug_reports table
CREATE TABLE `bug_reports` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL,
  `feedback` text NOT NULL,
  `steps_to_reproduce` varchar(1000) DEFAULT NULL,
  `bug_type` enum('UI','Functional','Crash','Typo','Other') NOT NULL DEFAULT 'Other',
  `severity` enum('Low','Medium','High','Critical') NOT NULL DEFAULT 'Medium',
  `screenshot` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `can_contact` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_bug_type` (`bug_type`),
  KEY `idx_severity` (`severity`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: 'password')
INSERT INTO `admin_users` (`username`, `email`, `password`, `full_name`, `role`, `status`) VALUES
('admin', 'admin@teknophix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'superadmin', 'active');

-- Insert default service centers
INSERT INTO `service_centers` (`name`, `address`, `contact_person`, `phone`, `email`, `status`) VALUES
('मुख्य सर्भिस सेन्टर', 'काठमाडौं, नेपाल', 'सर्भिस म्यानेजर', '01-4444444', 'service@mainservice.com', 'Active'),
('पोखरा सर्भिस सेन्टर', 'पोखरा, नेपाल', 'तकनिकी व्यक्ति', '061-555555', 'pokhara@service.com', 'Active'),
('चितवन सर्भिस सेन्टर', 'भरतपुर, चितवन', 'सर्भिस इन्जिनियर', '056-666666', 'chitwan@service.com', 'Active');

-- Insert sample technicians
INSERT INTO `technicians` (`name`, `email`, `contact_number`, `specialization`, `status`) VALUES
('राम बहादुर श्रेष्ठ', 'ram@teknophix.com', '9841234567', 'Mobile Phone Repair', 'Active'),
('सीता देवी पौडेल', 'sita@teknophix.com', '9851234567', 'Laptop Repair', 'Active'),
('हरि प्रसाद गुरुङ', 'hari@teknophix.com', '9861234567', 'Electronics Repair', 'Active');

-- Insert sample inventory items
INSERT INTO `inventory_items` (`device_name`, `brand`, `model`, `category`, `total_stock`, `purchase_price`, `selling_price`, `minimum_order_level`, `supplier`, `description`, `status`) VALUES
('iPhone Screen', 'Apple', 'iPhone 14 Pro', 'Mobile Parts', 25, 12000.00, 15000.00, 5, 'Apple Store Nepal', 'Original iPhone 14 Pro screen replacement', 'Active'),
('Samsung Battery', 'Samsung', 'Galaxy S23', 'Mobile Parts', 30, 3500.00, 4500.00, 10, 'Samsung Nepal', 'Original Samsung Galaxy S23 battery', 'Active'),
('MacBook Keyboard', 'Apple', 'MacBook Air M2', 'Laptop Parts', 15, 8000.00, 12000.00, 3, 'Apple Store Nepal', 'MacBook Air M2 keyboard replacement', 'Active'),
('Charging Cable', 'Generic', 'USB-C', 'Accessories', 100, 500.00, 800.00, 20, 'Local Supplier', 'USB-C charging cable', 'Active');

SET FOREIGN_KEY_CHECKS = 1;
