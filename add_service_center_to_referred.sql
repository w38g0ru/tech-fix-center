-- Add service_center_id column to referred table
-- Run this SQL if you need to manually update the database

-- Add the column
ALTER TABLE referred 
ADD COLUMN service_center_id INT(11) UNSIGNED NULL 
AFTER referred_to;

-- Add foreign key constraint (optional, only if service_centers table exists)
-- ALTER TABLE referred 
-- ADD CONSTRAINT fk_referred_service_center 
-- FOREIGN KEY (service_center_id) REFERENCES service_centers(id) 
-- ON DELETE SET NULL ON UPDATE CASCADE;

-- Verify the change
DESCRIBE referred;
