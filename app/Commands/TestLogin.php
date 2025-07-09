<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AdminUserModel;

class TestLogin extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:login';
    protected $description = 'Test login functionality and database connectivity';

    public function run(array $params)
    {
        CLI::write('=== Login System Test ===', 'yellow');
        CLI::newLine();

        $db = \Config\Database::connect();

        // Test database connection
        try {
            $db->query("SELECT 1");
            CLI::write('✓ Database connection successful', 'green');
        } catch (\Exception $e) {
            CLI::write('✗ Database connection failed: ' . $e->getMessage(), 'red');
            return;
        }

        // Test AdminUserModel
        try {
            $adminUserModel = new AdminUserModel();
            CLI::write('✓ AdminUserModel loaded successfully', 'green');
            
            // Test finding a user
            $user = $adminUserModel->where('email', 'admin@techfixcenter.com')->first();
            if ($user) {
                CLI::write('✓ Found admin user: ' . $user['full_name'] . ' (' . $user['email'] . ')', 'green');
                CLI::write('  - Username: ' . $user['username'], 'white');
                CLI::write('  - Role: ' . $user['role'], 'white');
                CLI::write('  - Status: ' . $user['status'], 'white');
                
                // Test password verification
                if (password_verify('password', $user['password'])) {
                    CLI::write('✓ Password verification successful', 'green');
                } else {
                    CLI::write('✗ Password verification failed', 'red');
                }
                
                // Test verifyCredentials method
                $verifiedUser = $adminUserModel->verifyCredentials('admin@techfixcenter.com', 'password');
                if ($verifiedUser) {
                    CLI::write('✓ verifyCredentials method working', 'green');
                    CLI::write('  - Mapped name: ' . ($verifiedUser['name'] ?? 'NOT SET'), 'white');
                    CLI::write('  - User type: ' . ($verifiedUser['user_type'] ?? 'NOT SET'), 'white');
                    CLI::write('  - Full name: ' . ($verifiedUser['full_name'] ?? 'NOT SET'), 'white');
                } else {
                    CLI::write('✗ verifyCredentials method failed', 'red');
                }
                
            } else {
                CLI::write('✗ Admin user not found', 'red');
            }
            
        } catch (\Exception $e) {
            CLI::write('✗ AdminUserModel error: ' . $e->getMessage(), 'red');
        }

        // Test session helper
        try {
            helper('session');
            CLI::write('✓ Session helper loaded successfully', 'green');
            
        } catch (\Exception $e) {
            CLI::write('✗ Session helper error: ' . $e->getMessage(), 'red');
        }

        // Test all demo accounts
        CLI::newLine();
        CLI::write('Testing all demo accounts:', 'yellow');
        
        $demoAccounts = [
            'admin@techfixcenter.com',
            'admin2@techfixcenter.com',
            'manager@techfixcenter.com'
        ];
        
        foreach ($demoAccounts as $email) {
            try {
                $user = $adminUserModel->verifyCredentials($email, 'password');
                if ($user) {
                    CLI::write("✓ {$email} - Login successful", 'green');
                    CLI::write("  Name: " . ($user['name'] ?? 'NOT SET'), 'white');
                    CLI::write("  Role: " . $user['role'], 'white');
                } else {
                    CLI::write("✗ {$email} - Login failed", 'red');
                }
            } catch (\Exception $e) {
                CLI::write("✗ {$email} - Error: " . $e->getMessage(), 'red');
            }
        }

        CLI::newLine();
        CLI::write('=== Test Complete ===', 'green');
        CLI::newLine();
        CLI::write('If all tests passed, you can now login at: http://tfc.local/auth/login', 'yellow');
    }
}
