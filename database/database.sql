CREATE TABLE `bug_reports` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  
  `url` VARCHAR(500) NOT NULL,
  `feedback` TEXT NOT NULL,
  `steps_to_reproduce` VARCHAR(1000) DEFAULT NULL,

  `bug_type` ENUM('UI', 'Functional', 'Crash', 'Typo', 'Other') DEFAULT 'Other',
  `severity` ENUM('Low', 'Medium', 'High', 'Critical') DEFAULT 'Medium',

  `screenshot` VARCHAR(255) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  
  `email` VARCHAR(255) DEFAULT NULL,
  `can_contact` TINYINT(1) DEFAULT 0,

  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
)