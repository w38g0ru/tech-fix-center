<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateInventoryForEnhancements extends Migration
{
    public function up()
    {
        // Add new fields to inventory_items table
        $fields = [
            'purchase_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'total_stock'
            ],
            'selling_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'purchase_price'
            ],
            'minimum_order_level' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'default' => 0,
                'after' => 'selling_price'
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'minimum_order_level'
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'category'
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'description'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'Inactive', 'Discontinued'],
                'default' => 'Active',
                'after' => 'supplier'
            ]
        ];

        $this->forge->addColumn('inventory_items', $fields);

        // Add timestamp fields to inventory_items
        $timestampFields = [
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'created_at'
            ]
        ];

        $this->forge->addColumn('inventory_items', $timestampFields);

        // Modify existing created_at field
        $this->forge->modifyColumn('inventory_items', [
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);

        // Create parts_requests table for the parts order system
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

        // Create inventory_import_logs table for tracking bulk imports
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
        // Drop foreign keys and tables
        $this->forge->dropTable('inventory_import_logs');
        $this->forge->dropTable('parts_requests');

        // Remove added columns from inventory_items table
        $this->forge->dropColumn('inventory_items', [
            'purchase_price',
            'selling_price',
            'minimum_order_level',
            'category',
            'description',
            'supplier',
            'status'
        ]);

        // Disable timestamps for inventory_items
        $this->forge->modifyColumn('inventory_items', [
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);
    }
}
