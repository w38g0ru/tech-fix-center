-- User Activity Logs Table
-- This table stores user activity logs for login, logout, and data post activities

-- Drop table if exists (for clean reinstall)
-- DROP TABLE IF EXISTS user_activity_logs;

CREATE TABLE IF NOT EXISTS user_activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_type ENUM('login','logout','post') NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at),
    INDEX idx_user_activity (user_id, activity_type)
    -- Note: Foreign key constraint removed to avoid issues if admin_users table structure differs
    -- Add this back if needed: FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE CASCADE
);

-- Sample data for testing (optional)
-- INSERT INTO user_activity_logs (user_id, activity_type, details, ip_address, user_agent) VALUES
-- (1, 'login', 'User logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'),
-- (1, 'post', 'Created new job for customer John Doe', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'),
-- (1, 'logout', 'User logged out', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
