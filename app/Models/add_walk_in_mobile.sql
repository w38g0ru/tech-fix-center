-- Add walk_in_customer_mobile column to jobs table
-- Run this SQL to manually update the database

-- Add the column
ALTER TABLE jobs 
ADD COLUMN walk_in_customer_mobile VARCHAR(20) NULL 
AFTER walk_in_customer_name;

-- Verify the change
DESCRIBE jobs;
