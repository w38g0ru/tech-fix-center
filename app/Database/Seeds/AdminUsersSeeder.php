<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUsersSeeder extends Seeder
{
    public function run()
    {
        // Sample admin users for the system
        $users = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@tfc.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'full_name' => 'सुपर एडमिन',
                'role' => 'superadmin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'admin',
                'email' => 'admin@tfc.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'full_name' => 'एडमिन यूजर',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'technician',
                'email' => 'technician@tfc.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'full_name' => 'टेक्निशियन यूजर',
                'role' => 'technician',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user',
                'email' => 'user@tfc.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'full_name' => 'सामान्य यूजर',
                'role' => 'user',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'anish.bhattarai',
                'email' => 'anish@tfc.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'full_name' => 'अनिश भट्टराई',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('admin_users')->insertBatch($users);

        echo "Admin users seeded successfully!\n";
        echo "Created users:\n";
        echo "- superadmin / password123 (Super Admin)\n";
        echo "- admin / password123 (Admin)\n";
        echo "- technician / password123 (Technician)\n";
        echo "- user / password123 (User)\n";
        echo "- anish.bhattarai / password123 (Admin)\n";
    }
}
