<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateJobsTableForEnhancements extends Migration
{
    public function up()
    {
        // Add new fields to jobs table
        $fields = [
            'walk_in_customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'user_id'
            ],
            'dispatch_type' => [
                'type' => 'ENUM',
                'constraint' => ['Customer', 'Service Center', 'Other'],
                'null' => true,
                'after' => 'charge'
            ],
            'service_center_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'dispatch_type'
            ],
            'dispatch_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'service_center_id'
            ],
            'nepali_date' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'dispatch_date'
            ],
            'expected_return_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'nepali_date'
            ],
            'actual_return_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'expected_return_date'
            ],
            'dispatch_notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'actual_return_date'
            ]
        ];

        $this->forge->addColumn('jobs', $fields);

        // Modify status enum to include new statuses
        $this->forge->modifyColumn('jobs', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => [
                    'Pending', 
                    'In Progress', 
                    'Parts Pending', 
                    'Referred to Service Center', 
                    'Ready to Dispatch to Customer',
                    'Returned',
                    'Completed'
                ],
                'default' => 'Pending'
            ]
        ]);

        // Create service centers table
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
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'contact_person' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
                'default' => 'Active',
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
        $this->forge->createTable('service_centers');

        // Add foreign key constraint
        $this->forge->addForeignKey('service_center_id', 'service_centers', 'id', 'SET NULL', 'SET NULL');

        // Insert default service centers
        $data = [
            [
                'name' => 'मुख्य सर्भिस सेन्टर',
                'address' => 'काठमाडौं, नेपाल',
                'contact_person' => 'सर्भिस म्यानेजर',
                'phone' => '01-4444444',
                'email' => 'service@mainservice.com',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'द्वितीयक सर्भिस सेन्टर',
                'address' => 'पोखरा, नेपाल',
                'contact_person' => 'सहायक म्यानेजर',
                'phone' => '061-555555',
                'email' => 'service@secondary.com',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('service_centers')->insertBatch($data);
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('jobs', 'jobs_service_center_id_foreign');
        
        // Drop service centers table
        $this->forge->dropTable('service_centers');

        // Remove added columns from jobs table
        $this->forge->dropColumn('jobs', [
            'walk_in_customer_name',
            'dispatch_type',
            'service_center_id',
            'dispatch_date',
            'nepali_date',
            'expected_return_date',
            'actual_return_date',
            'dispatch_notes'
        ]);

        // Revert status enum to original values
        $this->forge->modifyColumn('jobs', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'In Progress', 'Completed'],
                'default' => 'Pending'
            ]
        ]);
    }
}
