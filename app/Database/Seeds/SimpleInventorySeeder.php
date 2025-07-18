<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SimpleInventorySeeder extends Seeder
{
    public function run()
    {
        // Simple inventory items without movements to avoid foreign key issues
        $inventoryItems = [
            [
                'device_name' => 'iPhone 13 Pro Screen',
                'brand' => 'Apple',
                'model' => 'iPhone 13 Pro',
                'total_stock' => 8,
                'purchase_price' => 15000.00,
                'selling_price' => 18000.00,
                'minimum_order_level' => 3,
                'category' => 'Screen',
                'description' => 'Original iPhone 13 Pro OLED display assembly',
                'supplier' => 'Apple Store Nepal',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'device_name' => 'Samsung Galaxy S22 Battery',
                'brand' => 'Samsung',
                'model' => 'Galaxy S22',
                'total_stock' => 12,
                'purchase_price' => 2500.00,
                'selling_price' => 3500.00,
                'minimum_order_level' => 5,
                'category' => 'Battery',
                'description' => 'Original Samsung Galaxy S22 battery 3700mAh',
                'supplier' => 'Samsung Nepal',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-8 days'))
            ],
            [
                'device_name' => 'Xiaomi Redmi Note 11 Charging Port',
                'brand' => 'Xiaomi',
                'model' => 'Redmi Note 11',
                'total_stock' => 15,
                'purchase_price' => 800.00,
                'selling_price' => 1200.00,
                'minimum_order_level' => 8,
                'category' => 'Charging Port',
                'description' => 'USB-C charging port assembly for Redmi Note 11',
                'supplier' => 'Xiaomi Nepal',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
            ],
            [
                'device_name' => 'Oppo A76 Back Cover',
                'brand' => 'Oppo',
                'model' => 'A76',
                'total_stock' => 20,
                'purchase_price' => 1500.00,
                'selling_price' => 2200.00,
                'minimum_order_level' => 10,
                'category' => 'Back Cover',
                'description' => 'Original Oppo A76 back cover glass panel',
                'supplier' => 'Oppo Nepal',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
            ],
            [
                'device_name' => 'Vivo Y33s Camera Module',
                'brand' => 'Vivo',
                'model' => 'Y33s',
                'total_stock' => 6,
                'purchase_price' => 3500.00,
                'selling_price' => 4800.00,
                'minimum_order_level' => 3,
                'category' => 'Camera',
                'description' => '50MP main camera module for Vivo Y33s',
                'supplier' => 'Vivo Nepal',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'device_name' => 'Generic Tempered Glass',
                'brand' => 'Generic',
                'model' => 'Universal',
                'total_stock' => 50,
                'purchase_price' => 150.00,
                'selling_price' => 300.00,
                'minimum_order_level' => 20,
                'category' => 'Screen Protection',
                'description' => '9H tempered glass screen protector - universal sizes',
                'supplier' => 'Local Supplier',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'device_name' => 'Phone Case Silicone',
                'brand' => 'Generic',
                'model' => 'Universal',
                'total_stock' => 35,
                'purchase_price' => 200.00,
                'selling_price' => 400.00,
                'minimum_order_level' => 15,
                'category' => 'Accessories',
                'description' => 'Soft silicone phone cases - various colors and sizes',
                'supplier' => 'Local Supplier',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'device_name' => 'Power Button Flex Cable',
                'brand' => 'Generic',
                'model' => 'Universal',
                'total_stock' => 2,
                'purchase_price' => 500.00,
                'selling_price' => 800.00,
                'minimum_order_level' => 5,
                'category' => 'Flex Cable',
                'description' => 'Power button flex cable - compatible with multiple models',
                'supplier' => 'Local Supplier',
                'status' => 'Active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert inventory items
        $this->db->table('inventory_items')->insertBatch($inventoryItems);

        echo "Simple inventory data seeded successfully!\n";
        echo "Added 8 new inventory items with realistic Nepali pricing.\n";
        echo "Items include: iPhone parts, Samsung parts, Xiaomi parts, Oppo parts, Vivo parts, and generic accessories.\n";
    }
}
