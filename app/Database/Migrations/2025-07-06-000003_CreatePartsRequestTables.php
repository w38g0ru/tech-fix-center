<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePartsRequestTables extends Migration
{
    public function up()
    {
        // Add updated_at field to inventory_items if it doesn't exist
        $fields = $this->db->getFieldData('inventory_items');
        $hasUpdatedAt = false;
        foreach ($fields as $field) {
            if ($field->name === 'updated_at') {
                $hasUpdatedAt = true;
                break;
            }
        }
        
        if (!$hasUpdatedAt) {
            $this->forge->addColumn('inventory_items', [
                'updated_at' => [
                    'type' => 'TIMESTAMP',
                    'null' => true,
                    'after' => 'created_at'
                ]
            ]);
        }

        // Create parts_requests table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'technician_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'item_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'brand' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'model' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'quantity_requested' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'urgency' => [
                'type' => 'ENUM',
                'constraint' => ['Low', 'Medium', 'High', 'Critical'],
                'default' => 'Medium',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Approved', 'Rejected', 'Ordered', 'Received', 'Cancelled'],
                'default' => 'Pending',
            ],
            'requested_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'approved_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'rejection_reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estimated_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'order_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'expected_delivery_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'actual_delivery_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('technician_id', 'technicians', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('job_id', 'jobs', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('requested_by', 'admin_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'admin_users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('parts_requests');

        // Create inventory_import_logs table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'imported_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'total_rows' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'successful_rows' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'failed_rows' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'error_log' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Processing', 'Completed', 'Failed'],
                'default' => 'Processing',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('imported_by', 'admin_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventory_import_logs');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_import_logs');
        $this->forge->dropTable('parts_requests');
        
        // Remove updated_at column if it was added
        $fields = $this->db->getFieldData('inventory_items');
        $hasUpdatedAt = false;
        foreach ($fields as $field) {
            if ($field->name === 'updated_at') {
                $hasUpdatedAt = true;
                break;
            }
        }
        
        if ($hasUpdatedAt) {
            $this->forge->dropColumn('inventory_items', 'updated_at');
        }
    }
}
