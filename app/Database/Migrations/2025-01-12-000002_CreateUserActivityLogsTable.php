<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserActivityLogsTable extends Migration
{
    public function up()
    {
        // Create user_activity_logs table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'null' => false
            ],
            'activity_type' => [
                'type' => 'ENUM',
                'constraint' => ['login', 'logout', 'post'],
                'null' => false
            ],
            'details' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        // Set primary key
        $this->forge->addPrimaryKey('id');

        // Add indexes for performance
        $this->forge->addKey('user_id');
        $this->forge->addKey('activity_type');
        $this->forge->addKey('created_at');
        $this->forge->addKey(['user_id', 'activity_type'], false, false, 'idx_user_activity');

        // Create table
        $this->forge->createTable('user_activity_logs');

        // Insert sample data for testing
        $this->insertSampleData();
    }

    public function down()
    {
        $this->forge->dropTable('user_activity_logs');
    }

    private function insertSampleData()
    {
        $data = [
            [
                'user_id' => 1,
                'activity_type' => 'login',
                'details' => 'User logged in successfully',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'user_id' => 1,
                'activity_type' => 'post',
                'details' => 'Created new job for customer John Doe',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
            ],
            [
                'user_id' => 1,
                'activity_type' => 'post',
                'details' => 'Updated inventory item (ID: 15)',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
            ],
            [
                'user_id' => 1,
                'activity_type' => 'logout',
                'details' => 'User logged out',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 minutes'))
            ]
        ];

        $this->db->table('user_activity_logs')->insertBatch($data);
    }
}
