<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleBasedFeatures extends Migration
{
    public function up()
    {
        // Add role column to technicians table
        $this->forge->addColumn('technicians', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['superadmin', 'admin', 'technician', 'user'],
                'default' => 'technician',
                'after' => 'contact_number'
            ]
        ]);

        // Add charge column to jobs table
        $this->forge->addColumn('jobs', [
            'charge' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
                'after' => 'status'
            ]
        ]);

        // Create referred table (for dispatch/referral system)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'customer_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'device_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'problem_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'referred_to' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Dispatched', 'Completed'],
                'default' => 'Pending',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('referred');

        // Create photos table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'referred_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'photo_type' => [
                'type' => 'ENUM',
                'constraint' => ['Job', 'Dispatch', 'Received'],
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'uploaded_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('job_id', 'jobs', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('referred_id', 'referred', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('photos');
    }

    public function down()
    {
        // Drop photos table
        $this->forge->dropTable('photos', true);
        
        // Drop referred table
        $this->forge->dropTable('referred', true);
        
        // Remove charge column from jobs
        $this->forge->dropColumn('jobs', 'charge');
        
        // Remove role column from technicians
        $this->forge->dropColumn('technicians', 'role');
    }
}
