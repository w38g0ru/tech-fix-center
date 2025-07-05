<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInventoryPhotosSupport extends Migration
{
    public function up()
    {
        // Add inventory_id column to photos table
        $this->forge->addColumn('photos', [
            'inventory_id' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'referred_id'
            ]
        ]);

        // Update photo_type enum to include 'Inventory'
        $this->db->query("ALTER TABLE photos MODIFY COLUMN photo_type ENUM('Job', 'Dispatch', 'Received', 'Inventory') NOT NULL");

        // Add foreign key constraint for inventory_id
        $this->forge->addForeignKey('inventory_id', 'inventory_items', 'id', 'CASCADE', 'CASCADE', 'fk_photos_inventory');
    }

    public function down()
    {
        // Drop foreign key constraint
        $this->forge->dropForeignKey('photos', 'fk_photos_inventory');
        
        // Remove inventory_id column
        $this->forge->dropColumn('photos', 'inventory_id');

        // Revert photo_type enum
        $this->db->query("ALTER TABLE photos MODIFY COLUMN photo_type ENUM('Job', 'Dispatch', 'Received') NOT NULL");
    }
}
