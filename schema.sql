SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ========================
-- admin_users
-- ========================
CREATE TABLE `admin_users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `google_id` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `role` ENUM('superadmin','admin','technician','user') NOT NULL DEFAULT 'user',
  `status` ENUM('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- bug_reports
-- ========================
CREATE TABLE `bug_reports` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(500) NOT NULL,
  `feedback` TEXT NOT NULL,
  `steps_to_reproduce` VARCHAR(1000) DEFAULT NULL,
  `bug_type` ENUM('UI','Functional','Crash','Typo','Other') DEFAULT 'Other',
  `severity` ENUM('Low','Medium','High','Critical') DEFAULT 'Medium',
  `screenshot` VARCHAR(255) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `can_contact` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- inventory_items
-- ========================
CREATE TABLE `inventory_items` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_name` VARCHAR(100) DEFAULT NULL,
  `brand` VARCHAR(100) DEFAULT NULL,
  `model` VARCHAR(100) DEFAULT NULL,
  `total_stock` INT(11) NOT NULL DEFAULT 0,
  `purchase_price` DECIMAL(10,2) DEFAULT NULL,
  `selling_price` DECIMAL(10,2) DEFAULT NULL,
  `minimum_order_level` INT(10) UNSIGNED DEFAULT 0,
  `category` VARCHAR(100) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `supplier` VARCHAR(100) DEFAULT NULL,
  `status` ENUM('Active','Inactive','Discontinued') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- inventory_movements
-- ========================
CREATE TABLE `inventory_movements` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` INT(10) UNSIGNED NOT NULL,
  `movement_type` ENUM('IN','OUT') NOT NULL,
  `quantity` INT(11) NOT NULL,
  `job_id` INT(10) UNSIGNED DEFAULT NULL,
  `moved_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_item_id` (`item_id`),
  KEY `idx_job_id` (`job_id`),
  CONSTRAINT `fk_inventory_movements_item` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_inventory_movements_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- jobs
-- ========================
CREATE TABLE `jobs` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED DEFAULT NULL,
  `walk_in_customer_name` VARCHAR(100) DEFAULT NULL,
  `walk_in_customer_mobile` VARCHAR(20) DEFAULT NULL,
  `device_name` VARCHAR(100) DEFAULT NULL,
  `serial_number` VARCHAR(100) DEFAULT NULL,
  `problem` TEXT DEFAULT NULL,
  `technician_id` INT(10) UNSIGNED DEFAULT NULL,
  `status` ENUM('Pending','In Progress','Parts Pending','Referred to Service Center','Ready to Dispatch to Customer','Returned','Completed') DEFAULT 'Pending',
  `charge` DECIMAL(10,2) DEFAULT 0.00,
  `dispatch_type` ENUM('Customer','Service Center','Other') DEFAULT NULL,
  `service_center_id` INT(10) UNSIGNED DEFAULT NULL,
  `dispatch_date` DATE DEFAULT NULL,
  `nepali_date` VARCHAR(20) DEFAULT NULL,
  `expected_return_date` DATE DEFAULT NULL,
  `actual_return_date` DATE DEFAULT NULL,
  `dispatch_notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_technician_id` (`technician_id`),
  KEY `idx_service_center_id` (`service_center_id`),
  CONSTRAINT `fk_jobs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jobs_technician` FOREIGN KEY (`technician_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_jobs_service_center` FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ========================
-- parts_requests
-- ========================
CREATE TABLE `parts_requests` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` INT(10) UNSIGNED NOT NULL,
  `item_id` INT(10) UNSIGNED NOT NULL,
  `requested_quantity` INT(11) NOT NULL,
  `approved_quantity` INT(11) DEFAULT NULL,
  `status` ENUM('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `requested_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `approved_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_job_id` (`job_id`),
  KEY `idx_item_id` (`item_id`),
  CONSTRAINT `fk_parts_requests_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_parts_requests_item` FOREIGN KEY (`item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- photos
-- ========================
CREATE TABLE `photos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` INT(10) UNSIGNED NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_job_id` (`job_id`),
  CONSTRAINT `fk_photos_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- referred
-- ========================
CREATE TABLE `referred` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` INT(10) UNSIGNED NOT NULL,
  `referred_to` INT(10) UNSIGNED NOT NULL,
  `referred_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_job_id` (`job_id`),
  KEY `idx_referred_to` (`referred_to`),
  CONSTRAINT `fk_referred_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_referred_admin` FOREIGN KEY (`referred_to`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- service_centers
-- ========================
CREATE TABLE `service_centers` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `address` VARCHAR(500) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `contact_person` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- users
-- ========================
CREATE TABLE `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(150) DEFAULT NULL,
  `mobile` VARCHAR(20) DEFAULT NULL,
  `status` ENUM('active','inactive','suspended') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================
-- user_activity_logs
-- ========================
CREATE TABLE `user_activity_logs` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `activity` VARCHAR(255) NOT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `logged_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_user_activity_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
