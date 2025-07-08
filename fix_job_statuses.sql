-- Fix for TFC Production Database - Job Status Updates
-- Run this SQL on your production database to fix the "Whoops!" error
-- This adds the new job statuses that were added in Phase 1

-- First, check if the jobs table has the correct structure
DESCRIBE jobs;

-- Update the jobs table to allow new status values
-- Remove any existing enum constraint and add new one
ALTER TABLE jobs MODIFY COLUMN status ENUM(
    'Pending',
    'In Progress', 
    'Parts Pending',
    'Referred to Service Center',
    'Ready to Dispatch to Customer',
    'Returned',
    'Completed'
) NOT NULL DEFAULT 'Pending';

-- Add new columns if they don't exist
-- Check and add dispatch_type column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'dispatch_type';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN dispatch_type ENUM("Customer", "Service Center", "Other") NULL AFTER charge',
    'SELECT "dispatch_type column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and add service_center_id column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'service_center_id';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN service_center_id INT(11) UNSIGNED NULL AFTER dispatch_type',
    'SELECT "service_center_id column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and add dispatch_date column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'dispatch_date';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN dispatch_date DATE NULL AFTER service_center_id',
    'SELECT "dispatch_date column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and add expected_return_date column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'expected_return_date';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN expected_return_date DATE NULL AFTER dispatch_date',
    'SELECT "expected_return_date column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and add actual_return_date column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'actual_return_date';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN actual_return_date DATE NULL AFTER expected_return_date',
    'SELECT "actual_return_date column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and add nepali_date column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'nepali_date';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN nepali_date VARCHAR(20) NULL AFTER actual_return_date',
    'SELECT "nepali_date column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and add walk_in_customer_name column
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'walk_in_customer_name';

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE jobs ADD COLUMN walk_in_customer_name VARCHAR(100) NULL AFTER nepali_date',
    'SELECT "walk_in_customer_name column already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Create service_centers table if it doesn't exist
CREATE TABLE IF NOT EXISTS service_centers (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100) NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(100) NULL,
    address TEXT NULL,
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Add foreign key constraint for service_center_id if it doesn't exist
SET @fk_exists = 0;
SELECT COUNT(*) INTO @fk_exists 
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND CONSTRAINT_NAME = 'fk_jobs_service_center';

SET @sql = IF(@fk_exists = 0, 
    'ALTER TABLE jobs ADD CONSTRAINT fk_jobs_service_center FOREIGN KEY (service_center_id) REFERENCES service_centers(id) ON DELETE SET NULL ON UPDATE CASCADE',
    'SELECT "Foreign key constraint already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Insert some default service centers if table is empty
INSERT IGNORE INTO service_centers (name, contact_person, phone, status) VALUES
('Tech Service Center Kathmandu', 'Ram Sharma', '01-4567890', 'Active'),
('Mobile Repair Hub Pokhara', 'Sita Gurung', '061-123456', 'Active'),
('Digital Fix Center Chitwan', 'Hari Thapa', '056-789012', 'Active');

-- Show final structure
SELECT 'Jobs table structure after updates:' as message;
DESCRIBE jobs;

SELECT 'Service centers table:' as message;
SELECT COUNT(*) as service_center_count FROM service_centers;

SELECT 'Update completed successfully!' as message;
