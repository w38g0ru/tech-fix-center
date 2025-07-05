-- ---------------------------------------------
-- REPAIR SHOP DATABASE SCHEMA
-- Created: 04 July 2025
-- Author: ChatGPT for Bhupal Raut
-- ---------------------------------------------

-- Drop existing tables if needed
DROP TABLE IF EXISTS inventory_movements, jobs, inventory_items, users, technicians;

-- -------------------------
-- USERS TABLE (Registered + Walk-in Customers)
-- -------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(20),
    user_type ENUM('Registered', 'Walk-in') DEFAULT 'Walk-in',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -------------------------
-- TECHNICIANS TABLE
-- -------------------------
CREATE TABLE technicians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -------------------------
-- JOBS TABLE
-- -------------------------
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    device_name VARCHAR(100),
    serial_number VARCHAR(100),
    problem TEXT,
    technician_id INT,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (technician_id) REFERENCES technicians(id)
);

-- -------------------------
-- INVENTORY ITEMS TABLE (Device Types/Stock)
-- -------------------------
CREATE TABLE inventory_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_name VARCHAR(100),
    brand VARCHAR(100),
    model VARCHAR(100),
    total_stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -------------------------
-- INVENTORY MOVEMENTS TABLE (Stock IN/OUT)
-- -------------------------
CREATE TABLE inventory_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT,
    movement_type ENUM('IN', 'OUT'),
    quantity INT,
    job_id INT DEFAULT NULL,
    moved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES inventory_items(id),
    FOREIGN KEY (job_id) REFERENCES jobs(id)
);

-- -------------------------
-- OPTIONAL: JOB STATUS VIEW
-- -------------------------
CREATE VIEW job_status_list AS
SELECT 
    j.id AS job_id,
    u.name AS customer_name,
    u.mobile_number,
    j.device_name,
    j.serial_number,
    j.problem,
    t.name AS technician_name,
    j.status,
    j.created_at
FROM jobs j
LEFT JOIN users u ON j.user_id = u.id
LEFT JOIN technicians t ON j.technician_id = t.id;

ALTER TABLE technicians
ADD COLUMN role ENUM('superadmin', 'admin', 'technician', 'user') DEFAULT 'technician' AFTER contact_number;

ALTER TABLE jobs
ADD COLUMN charge DECIMAL(10,2) DEFAULT 0.00 AFTER status;

CREATE TABLE photos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    job_id INT DEFAULT NULL,
    referred_id INT DEFAULT NULL,

    photo_type ENUM('Job', 'Dispatch', 'Received') NOT NULL,

    file_name VARCHAR(255) NOT NULL,
    description VARCHAR(255),

    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE SET NULL,
    FOREIGN KEY (referred_id) REFERENCES referred(id) ON DELETE SET NULL
);

ALTER TABLE jobs
ADD COLUMN job_id VARCHAR(100) NOT NULL AFTER id;