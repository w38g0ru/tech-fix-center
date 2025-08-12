-- =========================================
-- ENHANCED DATABASE SCHEMA WITH IMPROVED INDEXES AND CONSTRAINTS
-- =========================================

-- =========================================
-- Table: admin_users (Enhanced)
-- =========================================
CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('superadmin','admin','technician','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `google_id` (`google_id`),
  KEY `idx_role` (`role`),
  KEY `idx_status` (`status`),
  KEY `idx_role_status` (`role`, `status`),
  KEY `idx_last_login` (`last_login`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: users (Enhanced)
-- =========================================
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `user_type` enum('Registered','Walk-in') NOT NULL DEFAULT 'Walk-in',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_type` (`user_type`),
  KEY `idx_mobile_number` (`mobile_number`),
  KEY `idx_name` (`name`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_name_mobile` (`name`, `mobile_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: service_centers (Enhanced)
-- =========================================
CREATE TABLE `service_centers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_name` (`name`),
  KEY `idx_phone` (`phone`),
  KEY `idx_email` (`email`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: jobs (Enhanced)
-- =========================================
CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `walk_in_customer_name` varchar(100) DEFAULT NULL,
  `walk_in_customer_mobile` varchar(20) DEFAULT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `technician_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('Pending','In Progress','Parts Pending','Referred to Service Center','Ready to Dispatch to Customer','Returned','Completed') DEFAULT 'Pending',
  `charge` decimal(10,2) DEFAULT 0.00,
  `dispatch_type` enum('Customer','Service Center','Other') DEFAULT NULL,
  `service_center_id` int(10) UNSIGNED DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `nepali_date` varchar(20) DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `dispatch_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `jobs_user_id_foreign` (`user_id`),
  KEY `jobs_technician_id_foreign` (`technician_id`),
  KEY `jobs_service_center_id_fk` (`service_center_id`),
  KEY `idx_status` (`status`),
  KEY `idx_device_name` (`device_name`),
  KEY `idx_serial_number` (`serial_number`),
  KEY `idx_dispatch_date` (`dispatch_date`),
  KEY `idx_expected_return_date` (`expected_return_date`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_status_technician` (`status`, `technician_id`),
  KEY `idx_status_created` (`status`, `created_at`),
  KEY `idx_walk_in_mobile` (`walk_in_customer_mobile`),
  CONSTRAINT `fk_jobs_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jobs_service_center_id_fk` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jobs_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: inventory_items (Enhanced)
-- =========================================
CREATE TABLE `inventory_items` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_name` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `total_stock` int(11) NOT NULL DEFAULT 0,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `minimum_order_level` int(10) UNSIGNED DEFAULT 0,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive','Discontinued') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_device_name` (`device_name`),
  KEY `idx_brand` (`brand`),
  KEY `idx_model` (`model`),
  KEY `idx_category` (`category`),
  KEY `idx_status` (`status`),
  KEY `idx_supplier` (`supplier`),
  KEY `idx_total_stock` (`total_stock`),
  KEY `idx_minimum_order_level` (`minimum_order_level`),
  KEY `idx_brand_model` (`brand`, `model`),
  KEY `idx_status_category` (`status`, `category`),
  KEY `idx_low_stock` (`total_stock`, `minimum_order_level`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: inventory_movements (Enhanced)
-- =========================================
CREATE TABLE `inventory_movements` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(10) UNSIGNED NOT NULL,
  `movement_type` enum('IN','OUT') NOT NULL,
  `quantity` int(11) NOT NULL,
  `job_id` int(10) UNSIGNED DEFAULT NULL,
  `moved_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `inventory_movements_item_id_foreign` (`item_id`),
  KEY `inventory_movements_job_id_foreign` (`job_id`),
  KEY `idx_movement_type` (`movement_type`),
  KEY `idx_moved_at` (`moved_at`),
  KEY `idx_item_movement_type` (`item_id`, `movement_type`),
  KEY `idx_moved_at_type` (`moved_at`, `movement_type`),
  CONSTRAINT `inventory_movements_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inventory_movements_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: parts_requests (Enhanced)
-- =========================================
CREATE TABLE `parts_requests` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `technician_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `quantity_requested` int(10) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `urgency` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `status` enum('Pending','Approved','Rejected','Ordered','Received','Cancelled') DEFAULT 'Pending',
  `requested_by` int(10) UNSIGNED NOT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `estimated_cost` decimal(10,2) DEFAULT NULL,
  `actual_cost` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `technician_id` (`technician_id`),
  KEY `job_id` (`job_id`),
  KEY `requested_by` (`requested_by`),
  KEY `approved_by` (`approved_by`),
  KEY `idx_status` (`status`),
  KEY `idx_urgency` (`urgency`),
  KEY `idx_item_name` (`item_name`),
  KEY `idx_brand` (`brand`),
  KEY `idx_order_date` (`order_date`),
  KEY `idx_expected_delivery` (`expected_delivery_date`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_status_urgency` (`status`, `urgency`),
  KEY `idx_technician_status` (`technician_id`, `status`),
  CONSTRAINT `parts_requests_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `parts_requests_ibfk_3` FOREIGN KEY (`requested_by`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `parts_requests_ibfk_4` FOREIGN KEY (`approved_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `parts_requests_technician_fk` FOREIGN KEY (`technician_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: referred (Enhanced)
-- =========================================
CREATE TABLE `referred` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `problem_description` text DEFAULT NULL,
  `referred_to` varchar(100) DEFAULT NULL,
  `service_center_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('Pending','Dispatched','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `referred_service_center_id_fk` (`service_center_id`),
  KEY `idx_status` (`status`),
  KEY `idx_customer_name` (`customer_name`),
  KEY `idx_customer_phone` (`customer_phone`),
  KEY `idx_device_name` (`device_name`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_status_created` (`status`, `created_at`),
  CONSTRAINT `referred_service_center_id_fk` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: photos (Enhanced)
-- =========================================
CREATE TABLE `photos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` int(10) UNSIGNED DEFAULT NULL,
  `referred_id` int(10) UNSIGNED DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `photo_type` enum('Job','Dispatch','Received','Inventory') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `photos_job_id_foreign` (`job_id`),
  KEY `photos_referred_id_foreign` (`referred_id`),
  KEY `photos_inventory_id_foreign` (`inventory_id`),
  KEY `idx_photo_type` (`photo_type`),
  KEY `idx_file_name` (`file_name`),
  KEY `idx_uploaded_at` (`uploaded_at`),
  KEY `idx_type_uploaded` (`photo_type`, `uploaded_at`),
  CONSTRAINT `photos_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `photos_referred_id_foreign` FOREIGN KEY (`referred_id`) REFERENCES `referred` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `photos_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventory_items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: bug_reports (Enhanced)
-- =========================================
CREATE TABLE `bug_reports` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL,
  `feedback` text NOT NULL,
  `steps_to_reproduce` varchar(1000) DEFAULT NULL,
  `bug_type` enum('UI','Functional','Crash','Typo','Other') DEFAULT 'Other',
  `severity` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `screenshot` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `can_contact` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_bug_type` (`bug_type`),
  KEY `idx_severity` (`severity`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_email` (`email`),
  KEY `idx_type_severity` (`bug_type`, `severity`),
  KEY `idx_severity_created` (`severity`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: inventory_import_logs (Enhanced)
-- =========================================
CREATE TABLE `inventory_import_logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `imported_by` int(10) UNSIGNED NOT NULL,
  `total_rows` int(10) UNSIGNED NOT NULL,
  `successful_rows` int(10) UNSIGNED NOT NULL,
  `failed_rows` int(10) UNSIGNED NOT NULL,
  `error_log` text DEFAULT NULL,
  `status` enum('Processing','Completed','Failed') DEFAULT 'Processing',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `imported_by` (`imported_by`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_filename` (`filename`),
  KEY `idx_status_created` (`status`, `created_at`),
  CONSTRAINT `inventory_import_logs_ibfk_1` FOREIGN KEY (`imported_by`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Table: user_activity_logs (Enhanced)
-- =========================================
CREATE TABLE `user_activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_type` enum('login','logout','post') NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_activity_type` (`activity_type`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_user_activity` (`user_id`,`activity_type`),
  KEY `idx_activity_created` (`activity_type`, `created_at`),
  KEY `idx_ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- PERFORMANCE OPTIMIZATION INDEXES
-- =========================================

-- Composite indexes for common queries
ALTER TABLE `jobs` ADD INDEX `idx_user_status_created` (`user_id`, `status`, `created_at`);
ALTER TABLE `jobs` ADD INDEX `idx_technician_status_created` (`technician_id`, `status`, `created_at`);
ALTER TABLE `inventory_items` ADD INDEX `idx_status_stock_level` (`status`, `total_stock`, `minimum_order_level`);
ALTER TABLE `parts_requests` ADD INDEX `idx_status_urgency_created` (`status`, `urgency`, `created_at`);

-- Full-text search indexes for better search performance
ALTER TABLE `jobs` ADD FULLTEXT(`device_name`, `serial_number`, `problem`);
ALTER TABLE `inventory_items` ADD FULLTEXT(`device_name`, `brand`, `model`, `description`);
ALTER TABLE `service_centers` ADD FULLTEXT(`name`, `contact_person`, `address`);
ALTER TABLE `users` ADD FULLTEXT(`name`);

-- =========================================
-- ADDITIONAL CONSTRAINTS FOR DATA INTEGRITY
-- =========================================

-- Ensure positive values
ALTER TABLE `inventory_items` ADD CONSTRAINT `chk_positive_stock` CHECK (`total_stock` >= 0);
ALTER TABLE `inventory_items` ADD CONSTRAINT `chk_positive_prices` CHECK (`purchase_price` >= 0 AND `selling_price` >= 0);
ALTER TABLE `inventory_movements` ADD CONSTRAINT `chk_positive_quantity` CHECK (`quantity` > 0);
ALTER TABLE `jobs` ADD CONSTRAINT `chk_positive_charge` CHECK (`charge` >= 0);
ALTER TABLE `parts_requests` ADD CONSTRAINT `chk_positive_quantity_requested` CHECK (`quantity_requested` > 0);
ALTER TABLE `parts_requests` ADD CONSTRAINT `chk_positive_costs` CHECK (`estimated_cost` >= 0 AND `actual_cost` >= 0);

-- Date constraints
ALTER TABLE `jobs` ADD CONSTRAINT `chk_return_dates` CHECK (`actual_return_date` >= `dispatch_date` OR `actual_return_date` IS NULL);
ALTER TABLE `parts_requests` ADD CONSTRAINT `chk_delivery_dates` CHECK (`actual_delivery_date` >= `order_date` OR `actual_delivery_date` IS NULL);
