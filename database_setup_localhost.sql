-- TeknoPhix Localhost Database Setup
-- Run this script to create the localhost database with proper configuration
-- 
-- Instructions:
-- 1. Open MySQL command line or phpMyAdmin
-- 2. Run this script as root user
-- 3. This will create the database and set up proper permissions

-- Create the database for localhost
CREATE DATABASE IF NOT EXISTS `tfc` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `tfc`;

-- Grant privileges to root user (if needed)
GRANT ALL PRIVILEGES ON `tfc`.* TO 'root'@'localhost';
FLUSH PRIVILEGES;

-- Show database information
SELECT 'Database created successfully!' as Status;
SELECT DATABASE() as 'Current Database';
SHOW TABLES;

-- Display connection information
SELECT 
    'localhost' as Hostname,
    'root' as Username,
    'Ab*2525125' as Password,
    'tfc' as Database_Name,
    'Configuration matches your .env settings' as Note;
