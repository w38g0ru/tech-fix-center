<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddServiceCenterToReferred extends Migration
{
    public function up()
    {
        // Add service_center_id column to referred table
        $fields = [
            'service_center_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'referred_to'
            ]
        ];
        
        $this->forge->addColumn('referred', $fields);
        
        // Add foreign key constraint
        $this->forge->addForeignKey('service_center_id', 'service_centers', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraint first
        $this->forge->dropForeignKey('referred', 'referred_service_center_id_foreign');
        
        // Drop the column
        $this->forge->dropColumn('referred', 'service_center_id');
    }
}
