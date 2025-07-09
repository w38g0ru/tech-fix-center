<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetupDatabase extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:setup';
    protected $description = 'Setup Tech Fix Center database with proper structure and default users';

    public function run(array $params)
    {
        CLI::write('=== Tech Fix Center Database Setup ===', 'yellow');
        CLI::newLine();

        $db = \Config\Database::connect();

        // Check database connection
        try {
            $db->query("SELECT 1");
            CLI::write('✓ Database connection successful', 'green');
        } catch (\Exception $e) {
            CLI::write('✗ Database connection failed: ' . $e->getMessage(), 'red');
            return;
        }

        // Check if users table exists
        try {
            $query = $db->query("SHOW TABLES LIKE 'users'");
            if ($query->getNumRows() > 0) {
                CLI::write('✓ Users table exists', 'green');
                
                // Check table structure
                $structure = $db->query("DESCRIBE users")->getResultArray();
                CLI::write('✓ Users table structure:', 'green');
                foreach ($structure as $column) {
                    CLI::write("  - {$column['Field']} ({$column['Type']})", 'white');
                }
                
                // Check if we have any users
                $userCount = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count;
                CLI::write("✓ Users in database: {$userCount}", 'green');
                
                if ($userCount == 0) {
                    CLI::write('⚠ No users found. Creating default admin users...', 'yellow');
                    $this->createDefaultUsers($db);
                } else {
                    CLI::write('Updating existing user passwords...', 'yellow');
                    $this->updateUserPasswords($db);
                }
                
            } else {
                CLI::write('✗ Users table does not exist. Creating database structure...', 'red');
                $this->createDatabaseStructure($db);
            }
        } catch (\Exception $e) {
            CLI::write('✗ Error checking users table: ' . $e->getMessage(), 'red');
            CLI::write('Creating database structure...', 'yellow');
            $this->createDatabaseStructure($db);
        }

        CLI::newLine();
        CLI::write('=== Database Setup Complete ===', 'green');
        CLI::newLine();
        CLI::write('You can now login with:', 'yellow');
        CLI::write('- admin@techfixcenter.com / password (Super Admin)', 'white');
        CLI::write('- admin2@techfixcenter.com / password (Admin)', 'white');
        CLI::write('- manager@techfixcenter.com / password (Manager)', 'white');
    }

    private function createDatabaseStructure($db)
    {
        CLI::write('Creating users table...', 'yellow');
        
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
            CLI::write('✓ Users table created successfully', 'green');
            
            // Create default admin users
            $this->createDefaultUsers($db);
            
        } catch (\Exception $e) {
            CLI::write('✗ Error creating users table: ' . $e->getMessage(), 'red');
        }
    }

    private function createDefaultUsers($db)
    {
        $password = password_hash('password', PASSWORD_DEFAULT);
        
        $users = [
            ['Super Admin', 'admin@techfixcenter.com', '9841234567', 'superadmin', 'Admin'],
            ['Admin User', 'admin2@techfixcenter.com', '9841234568', 'admin', 'Admin'],
            ['Manager User', 'manager@techfixcenter.com', '9841234569', 'manager', 'Manager'],
            ['रमेश श्रेष्ठ', 'ramesh@example.com', '9851234567', 'customer', 'Customer'],
            ['सुनिता गुरुङ', 'sunita@example.com', '9861234567', 'customer', 'Customer']
        ];
        
        foreach ($users as $user) {
            $sql = "
            INSERT INTO `users` (`name`, `email`, `mobile_number`, `password`, `role`, `user_type`, `status`, `email_verified_at`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, ?, ?, ?, 'active', NOW(), NOW(), NOW())
            ON DUPLICATE KEY UPDATE 
            `password` = VALUES(`password`),
            `updated_at` = NOW()
            ";
            
            try {
                $db->query($sql, [$user[0], $user[1], $user[2], $password, $user[3], $user[4]]);
                CLI::write("✓ User created/updated: {$user[1]}", 'green');
            } catch (\Exception $e) {
                CLI::write("✗ Error creating user {$user[1]}: " . $e->getMessage(), 'red');
            }
        }
    }

    private function updateUserPasswords($db)
    {
        $password = password_hash('password', PASSWORD_DEFAULT);
        
        $sql = "UPDATE users SET password = ? WHERE email IN (
            'admin@techfixcenter.com', 
            'admin2@techfixcenter.com', 
            'manager@techfixcenter.com',
            'ramesh@example.com',
            'sunita@example.com'
        )";
        
        try {
            $db->query($sql, [$password]);
            CLI::write('✓ User passwords updated successfully', 'green');
        } catch (\Exception $e) {
            CLI::write('✗ Error updating passwords: ' . $e->getMessage(), 'red');
        }
    }
}
