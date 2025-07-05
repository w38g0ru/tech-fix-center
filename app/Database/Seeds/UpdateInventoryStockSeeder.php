<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateInventoryStockSeeder extends Seeder
{
    public function run()
    {
        // Update stock levels based on movements
        // iPhone Screen (item_id: 1) - 1 OUT movement
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock - 1 WHERE id = 1");
        
        // Samsung Display (item_id: 2) - 10 IN movement
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock + 10 WHERE id = 2");
        
        // iPhone 11 Battery (item_id: 3) - 1 OUT movement
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock - 1 WHERE id = 3");
        
        // Charging Port (item_id: 4) - 1 OUT movement
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock - 1 WHERE id = 4");
        
        // Camera Module (item_id: 6) - 1 OUT movement
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock - 1 WHERE id = 6");
        
        // Speaker (item_id: 7) - 5 IN movement
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock + 5 WHERE id = 7");

        echo "Inventory stock levels updated successfully!\n";
        echo "Stock levels now reflect the recorded movements.\n";
    }
}
