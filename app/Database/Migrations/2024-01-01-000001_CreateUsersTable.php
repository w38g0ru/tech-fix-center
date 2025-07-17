<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Users Table Migration
 * 
 * Creates the users table for the admin dashboard
 * with all necessary fields for user management.
 */
class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'manager', 'user'],
                'default' => 'user',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'pending'],
                'default' => 'active',
                'null' => false,
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'remember_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Set primary key
        $this->forge->addPrimaryKey('id');

        // Add indexes
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('role');
        $this->forge->addKey('status');
        $this->forge->addKey('created_at');
        $this->forge->addKey('deleted_at');

        // Create table
        $this->forge->createTable('users');

        // Insert default admin user
        $this->insertDefaultUsers();
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }

    /**
     * Insert default users for testing
     */
    private function insertDefaultUsers()
    {
        $data = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'John Manager',
                'email' => 'manager@example.com',
                'password' => password_hash('manager123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'status' => 'active',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jane User',
                'email' => 'user@example.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+1234567890',
                'address' => '123 Main St, City, State 12345',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-30 days')),
            ],
            [
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'inactive',
                'phone' => '+1234567891',
                'address' => '456 Oak Ave, City, State 12345',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
            ],
            [
                'name' => 'Test Manager',
                'email' => 'testmanager@example.com',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'status' => 'active',
                'phone' => '+1234567892',
                'address' => '789 Pine St, City, State 12345',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-20 days')),
            ],
            [
                'name' => 'Pending User',
                'email' => 'pending@example.com',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'pending',
                'phone' => '+1234567893',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            ],
            [
                'name' => 'Recent User',
                'email' => 'recent@example.com',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+1234567894',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
