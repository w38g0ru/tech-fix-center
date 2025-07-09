<?php

/**
 * Database Setup Script for Tech Fix Center
 * Run this script to ensure the database is properly configured
 */

require_once __DIR__ . '/../../vendor/autoload.php';

// Load CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Get database connection
$db = \Config\Database::connect();

echo "=== Tech Fix Center Database Setup ===\n\n";

// Check if database exists and is accessible
try {
    $db->query("SELECT 1");
    echo "✓ Database connection successful\n";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Check if users table exists
try {
    $query = $db->query("SHOW TABLES LIKE 'users'");
    if ($query->getNumRows() > 0) {
        echo "✓ Users table exists\n";
        
        // Check table structure
        $structure = $db->query("DESCRIBE users")->getResultArray();
        echo "✓ Users table structure:\n";
        foreach ($structure as $column) {
            echo "  - {$column['Field']} ({$column['Type']})\n";
        }
        
        // Check if we have any users
        $userCount = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count;
        echo "✓ Users in database: {$userCount}\n";
        
        if ($userCount == 0) {
            echo "\n⚠ No users found. Creating default admin user...\n";
            createDefaultUser($db);
        }
        
    } else {
        echo "✗ Users table does not exist. Creating database structure...\n";
        createDatabaseStructure($db);
    }
} catch (Exception $e) {
    echo "✗ Error checking users table: " . $e->getMessage() . "\n";
    echo "Creating database structure...\n";
    createDatabaseStructure($db);
}

echo "\n=== Database Setup Complete ===\n";

function createDatabaseStructure($db) {
    echo "Creating users table...\n";
    
    $sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `mobile_number` varchar(20) DEFAULT NULL,
        `password` varchar(255) NOT NULL,
        `role` enum('superadmin','admin','manager','technician','customer') NOT NULL DEFAULT 'customer',
        `user_type` varchar(50) DEFAULT 'Customer',
        `status` enum('active','inactive') NOT NULL DEFAULT 'active',
        `email_verified_at` timestamp NULL DEFAULT NULL,
        `remember_token` varchar(100) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`),
        KEY `idx_role` (`role`),
        KEY `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    try {
        $db->query($sql);
        echo "✓ Users table created successfully\n";
        
        // Create default admin user
        createDefaultUser($db);
        
    } catch (Exception $e) {
        echo "✗ Error creating users table: " . $e->getMessage() . "\n";
    }
}

function createDefaultUser($db) {
    $password = password_hash('password', PASSWORD_DEFAULT);
    
    $sql = "
    INSERT INTO `users` (`name`, `email`, `mobile_number`, `password`, `role`, `user_type`, `status`, `email_verified_at`, `created_at`, `updated_at`) 
    VALUES 
    ('Super Admin', 'admin@techfixcenter.com', '9841234567', ?, 'superadmin', 'Admin', 'active', NOW(), NOW(), NOW()),
    ('Admin User', 'admin2@techfixcenter.com', '9841234568', ?, 'admin', 'Admin', 'active', NOW(), NOW(), NOW()),
    ('Manager User', 'manager@techfixcenter.com', '9841234569', ?, 'manager', 'Manager', 'active', NOW(), NOW(), NOW())
    ON DUPLICATE KEY UPDATE 
    `password` = VALUES(`password`),
    `updated_at` = NOW()
    ";
    
    try {
        $db->query($sql, [$password, $password, $password]);
        echo "✓ Default admin users created/updated\n";
        echo "  - admin@techfixcenter.com / password (Super Admin)\n";
        echo "  - admin2@techfixcenter.com / password (Admin)\n";
        echo "  - manager@techfixcenter.com / password (Manager)\n";
    } catch (Exception $e) {
        echo "✗ Error creating default users: " . $e->getMessage() . "\n";
    }
}

?>
