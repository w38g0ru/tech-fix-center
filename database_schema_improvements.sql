-- TeknoPhix Database Schema Improvements
-- Based on actual database dump analysis
-- Date: 2025-01-24

-- Add missing foreign key constraints
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Add missing foreign key for jobs.technician_id -> admin_users.id
ALTER TABLE `jobs` 
ADD CONSTRAINT `fk_jobs_technician` 
FOREIGN KEY (`technician_id`) REFERENCES `admin_users` (`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- 2. Add missing foreign key for jobs.service_center_id -> service_centers.id
ALTER TABLE `jobs` 
ADD CONSTRAINT `fk_jobs_service_center` 
FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- 3. Add missing foreign key for referred.service_center_id -> service_centers.id
ALTER TABLE `referred` 
ADD CONSTRAINT `fk_referred_service_center` 
FOREIGN KEY (`service_center_id`) REFERENCES `service_centers` (`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- 4. Add missing foreign key for photos.inventory_id -> inventory_items.id
ALTER TABLE `photos` 
ADD CONSTRAINT `fk_photos_inventory` 
FOREIGN KEY (`inventory_id`) REFERENCES `inventory_items` (`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- 5. Add missing foreign key for user_activity_logs.user_id -> admin_users.id
ALTER TABLE `user_activity_logs` 
ADD CONSTRAINT `fk_user_activity_logs_user` 
FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- 6. Fix parts_requests foreign key for technician_id (if missing)
ALTER TABLE `parts_requests` 
ADD CONSTRAINT `fk_parts_requests_technician` 
FOREIGN KEY (`technician_id`) REFERENCES `admin_users` (`id`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Add missing indexes for better performance
ALTER TABLE `jobs` ADD INDEX `idx_status` (`status`);
ALTER TABLE `jobs` ADD INDEX `idx_created_at` (`created_at`);
ALTER TABLE `jobs` ADD INDEX `idx_service_center_id` (`service_center_id`);

ALTER TABLE `inventory_items` ADD INDEX `idx_status` (`status`);
ALTER TABLE `inventory_items` ADD INDEX `idx_total_stock` (`total_stock`);
ALTER TABLE `inventory_items` ADD INDEX `idx_category` (`category`);

ALTER TABLE `service_centers` ADD INDEX `idx_status` (`status`);
ALTER TABLE `service_centers` ADD INDEX `idx_name` (`name`);

ALTER TABLE `photos` ADD INDEX `idx_photo_type` (`photo_type`);
ALTER TABLE `photos` ADD INDEX `idx_uploaded_at` (`uploaded_at`);

ALTER TABLE `parts_requests` ADD INDEX `idx_status` (`status`);
ALTER TABLE `parts_requests` ADD INDEX `idx_urgency` (`urgency`);

ALTER TABLE `referred` ADD INDEX `idx_status` (`status`);
ALTER TABLE `referred` ADD INDEX `idx_service_center_id` (`service_center_id`);

-- Update jobs table to make expected_return_date NOT NULL (as per model requirements)
ALTER TABLE `jobs` MODIFY COLUMN `expected_return_date` DATE NOT NULL;

-- Remove nepali_date column (as per previous requirements)
ALTER TABLE `jobs` DROP COLUMN `nepali_date`;

SET FOREIGN_KEY_CHECKS = 1;

-- Verify foreign key constraints
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = DATABASE() 
AND REFERENCED_TABLE_NAME IS NOT NULL
ORDER BY TABLE_NAME, COLUMN_NAME;
