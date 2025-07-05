<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdditionalNepaliDataSeeder extends Seeder
{
    public function run()
    {
        // Additional customers from different regions of Nepal
        $additionalUsers = [
            [
                'name' => 'हरि प्रसाद अधिकारी',
                'mobile_number' => '9821234575',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'name' => 'गीता कुमारी मगर',
                'mobile_number' => '9831234576',
                'user_type' => 'Walk-in',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'name' => 'नारायण बहादुर थापा',
                'mobile_number' => '9841234577',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-12 hours'))
            ],
            [
                'name' => 'सरस्वती न्यौपाने',
                'mobile_number' => '9851234578',
                'user_type' => 'Walk-in',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 hours'))
            ]
        ];

        $this->db->table('users')->insertBatch($additionalUsers);

        // More inventory items commonly used in Nepal
        $additionalInventory = [
            [
                'device_name' => 'Tempered Glass',
                'brand' => 'Generic',
                'model' => 'Universal',
                'total_stock' => 50,
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'device_name' => 'Phone Case',
                'brand' => 'Generic',
                'model' => 'Silicone',
                'total_stock' => 30,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'device_name' => 'Charging Cable',
                'brand' => 'Generic',
                'model' => 'Type-C',
                'total_stock' => 25,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'device_name' => 'Power Button',
                'brand' => 'Generic',
                'model' => 'Universal',
                'total_stock' => 15,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];

        $this->db->table('inventory_items')->insertBatch($additionalInventory);

        // More realistic repair jobs
        $additionalJobs = [
            [
                'user_id' => 9,
                'device_name' => 'Samsung Galaxy M32',
                'serial_number' => 'SM456789123',
                'problem' => 'फोन ह्याङ हुन्छ। रिस्टार्ट गर्नुपर्छ। सफ्टवेयर अपडेट चाहिन्छ।',
                'technician_id' => 2,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
            ],
            [
                'user_id' => 10,
                'device_name' => 'iPhone 13',
                'serial_number' => 'F2LW48XHFG9L',
                'problem' => 'फेस आईडी काम गर्दैन। कैमेरा सेन्सर बिग्रिएको जस्तो लाग्छ।',
                'technician_id' => 1,
                'status' => 'In Progress',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'user_id' => 11,
                'device_name' => 'Xiaomi Mi 11',
                'serial_number' => 'XM111222333',
                'problem' => 'वाइफाइ कनेक्ट हुँदैन। नेटवर्क सेटिङ रिसेट गर्नुपर्छ।',
                'technician_id' => 3,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
            ],
            [
                'user_id' => 12,
                'device_name' => 'OnePlus 9',
                'serial_number' => 'OP987654321',
                'problem' => 'तेम्पर्ड ग्लास फुटेको। नयाँ स्क्रिन प्रोटेक्टर लगाउनुपर्छ।',
                'technician_id' => 4,
                'status' => 'Completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
            ]
        ];

        $this->db->table('jobs')->insertBatch($additionalJobs);

        // Additional inventory movements
        $additionalMovements = [
            [
                'item_id' => 9, // Tempered Glass
                'movement_type' => 'OUT',
                'quantity' => 1,
                'job_id' => 12,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-25 minutes'))
            ],
            [
                'item_id' => 10, // Phone Case
                'movement_type' => 'IN',
                'quantity' => 15,
                'job_id' => null,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'item_id' => 11, // Charging Cable
                'movement_type' => 'OUT',
                'quantity' => 2,
                'job_id' => null,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];

        $this->db->table('inventory_movements')->insertBatch($additionalMovements);

        // Update stock for new movements
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock - 1 WHERE id = 9"); // Tempered Glass
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock + 15 WHERE id = 10"); // Phone Case
        $this->db->query("UPDATE inventory_items SET total_stock = total_stock - 2 WHERE id = 11"); // Charging Cable

        echo "Additional Nepali sample data added successfully!\n";
        echo "Added:\n";
        echo "- 4 more customers\n";
        echo "- 4 more inventory items (accessories)\n";
        echo "- 4 more repair jobs\n";
        echo "- 3 more inventory movements\n";
        echo "- Updated stock levels\n";
    }
}
