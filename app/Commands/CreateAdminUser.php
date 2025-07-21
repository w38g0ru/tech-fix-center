<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateAdminUser extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'create:admin';
    protected $description = 'Create admin user for TeknoPhix login';

    public function run(array $params)
    {
        CLI::write('=== Creating Admin User for TeknoPhix ===', 'yellow');
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

        // Check if admin_users table exists
        $tables = $db->listTables();
        if (!in_array('admin_users', $tables)) {
            CLI::write('⚠ admin_users table does not exist. Creating it...', 'yellow');
            $this->createAdminUsersTable($db);
        }

        // Create the admin users
        $this->createAdminUsers($db);

        CLI::newLine();
        CLI::write('=== Admin User Creation Complete ===', 'green');
        CLI::newLine();
        CLI::write('You can now login at http://tfc.local/auth/login with:', 'yellow');
        CLI::write('- admin2@techfixcenter.com / password (Admin)', 'white');
        CLI::write('- admin@techfixcenter.com / password (Super Admin)', 'white');
        CLI::write('- manager@techfixcenter.com / password (Manager)', 'white');
    }

    private function createAdminUsersTable($db)
    {
        $sql = "
        CREATE TABLE `admin_users` (
          `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          `username` varchar(50) NOT NULL,
          `email` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `full_name` varchar(255) NOT NULL,
          `role` enum('superadmin','admin','technician','user') NOT NULL DEFAULT 'user',
          `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
          `google_id` varchar(100) DEFAULT NULL,
          `profile_picture` varchar(255) DEFAULT NULL,
          `phone` varchar(20) DEFAULT NULL,
          `address` varchar(500) DEFAULT NULL,
          `last_login` timestamp NULL DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`),
          UNIQUE KEY `username` (`username`),
          UNIQUE KEY `email` (`email`),
          KEY `idx_role` (`role`),
          KEY `idx_status` (`status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        try {
            $db->query($sql);
            CLI::write('✓ admin_users table created successfully', 'green');
        } catch (\Exception $e) {
            CLI::write('✗ Error creating admin_users table: ' . $e->getMessage(), 'red');
            return;
        }
    }

    private function createAdminUsers($db)
    {
        $password = password_hash('password', PASSWORD_DEFAULT);
        
        $users = [
            [
                'username' => 'admin2',
                'email' => 'admin2@techfixcenter.com',
                'password' => $password,
                'full_name' => 'Admin User',
                'role' => 'admin',
                'status' => 'active'
            ],
            [
                'username' => 'admin',
                'email' => 'admin@techfixcenter.com',
                'password' => $password,
                'full_name' => 'Super Administrator',
                'role' => 'superadmin',
                'status' => 'active'
            ],
            [
                'username' => 'manager',
                'email' => 'manager@techfixcenter.com',
                'password' => $password,
                'full_name' => 'Manager User',
                'role' => 'admin',
                'status' => 'active'
            ]
        ];
        
        foreach ($users as $user) {
            $sql = "
            INSERT INTO `admin_users` (`username`, `email`, `password`, `full_name`, `role`, `status`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE 
            `password` = VALUES(`password`),
            `full_name` = VALUES(`full_name`),
            `role` = VALUES(`role`),
            `status` = VALUES(`status`),
            `updated_at` = NOW()
            ";
            
            try {
                $db->query($sql, [
                    $user['username'],
                    $user['email'], 
                    $user['password'],
                    $user['full_name'],
                    $user['role'],
                    $user['status']
                ]);
                CLI::write("✓ User created/updated: {$user['email']} ({$user['role']})", 'green');
            } catch (\Exception $e) {
                CLI::write("✗ Error creating user {$user['email']}: " . $e->getMessage(), 'red');
            }
        }
    }
}
