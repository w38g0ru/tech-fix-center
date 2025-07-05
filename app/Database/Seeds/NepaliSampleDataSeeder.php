<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NepaliSampleDataSeeder extends Seeder
{
    public function run()
    {
        // Sample Users (Customers) - Nepali names and context
        $users = [
            [
                'name' => 'राम बहादुर श्रेष्ठ',
                'mobile_number' => '9841234567',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'name' => 'सीता देवी पौडेल',
                'mobile_number' => '9851234568',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'name' => 'अनिल गुरुङ',
                'mobile_number' => '9861234569',
                'user_type' => 'Walk-in',
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'name' => 'प्रिया तामाङ',
                'mobile_number' => '9871234570',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            [
                'name' => 'विकास खड्का',
                'mobile_number' => '9881234571',
                'user_type' => 'Walk-in',
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'name' => 'सुनिता राई',
                'mobile_number' => '9891234572',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-8 days'))
            ],
            [
                'name' => 'दीपक लामा',
                'mobile_number' => '9801234573',
                'user_type' => 'Walk-in',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'name' => 'कमला भट्टराई',
                'mobile_number' => '9811234574',
                'user_type' => 'Registered',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ]
        ];

        $this->db->table('users')->insertBatch($users);

        // Sample Technicians - Nepali names
        $technicians = [
            [
                'name' => 'सुरेश महर्जन',
                'contact_number' => '9841111111',
                'created_at' => date('Y-m-d H:i:s', strtotime('-60 days'))
            ],
            [
                'name' => 'राजेश श्रेष्ठ',
                'contact_number' => '9851111112',
                'created_at' => date('Y-m-d H:i:s', strtotime('-45 days'))
            ],
            [
                'name' => 'प्रकाश तुलाधर',
                'contact_number' => '9861111113',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'name' => 'अमित मानन्धर',
                'contact_number' => '9871111114',
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ]
        ];

        $this->db->table('technicians')->insertBatch($technicians);

        // Sample Inventory Items - Common mobile parts in Nepal
        $inventoryItems = [
            [
                'device_name' => 'iPhone Screen',
                'brand' => 'Apple',
                'model' => 'iPhone 12',
                'total_stock' => 15,
                'created_at' => date('Y-m-d H:i:s', strtotime('-40 days'))
            ],
            [
                'device_name' => 'Samsung Display',
                'brand' => 'Samsung',
                'model' => 'Galaxy A52',
                'total_stock' => 25,
                'created_at' => date('Y-m-d H:i:s', strtotime('-35 days'))
            ],
            [
                'device_name' => 'Battery',
                'brand' => 'Apple',
                'model' => 'iPhone 11',
                'total_stock' => 8,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'device_name' => 'Charging Port',
                'brand' => 'Xiaomi',
                'model' => 'Redmi Note 10',
                'total_stock' => 20,
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'device_name' => 'Back Cover',
                'brand' => 'Oppo',
                'model' => 'A74',
                'total_stock' => 12,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'device_name' => 'Camera Module',
                'brand' => 'Vivo',
                'model' => 'Y20',
                'total_stock' => 6,
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            [
                'device_name' => 'Speaker',
                'brand' => 'Realme',
                'model' => 'C25',
                'total_stock' => 18,
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'device_name' => 'Touch IC',
                'brand' => 'Generic',
                'model' => 'Universal',
                'total_stock' => 5,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ]
        ];

        $this->db->table('inventory_items')->insertBatch($inventoryItems);

        // Sample Jobs - Common repair issues in Nepal
        $jobs = [
            [
                'user_id' => 1,
                'device_name' => 'iPhone 12',
                'serial_number' => 'F2LW48XHFG7J',
                'problem' => 'स्क्रिन फुटेको छ। टच काम गर्दैन। स्क्रिन रिप्लेसमेन्ट चाहिन्छ।',
                'technician_id' => 1,
                'status' => 'In Progress',
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'user_id' => 2,
                'device_name' => 'Samsung Galaxy A52',
                'serial_number' => 'R58M123456789',
                'problem' => 'ब्याट्री छिट्टै सकिन्छ। चार्जिङ पोर्ट ढिलो छ।',
                'technician_id' => 2,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'user_id' => 3,
                'device_name' => 'Xiaomi Redmi Note 10',
                'serial_number' => 'XM987654321',
                'problem' => 'पानी परेको छ। फोन अन हुँदैन। डाटा रिकभर गर्नुपर्छ।',
                'technician_id' => 1,
                'status' => 'Completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'user_id' => 4,
                'device_name' => 'Oppo A74',
                'serial_number' => 'OP741852963',
                'problem' => 'क्यामेरा काम गर्दैन। ब्लर आउँछ। फोकस मिल्दैन।',
                'technician_id' => 3,
                'status' => 'In Progress',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'user_id' => 5,
                'device_name' => 'Vivo Y20',
                'serial_number' => 'VV159753468',
                'problem' => 'स्पिकर काम गर्दैन। आवाज आउँदैन। रिङटोन सुनिँदैन।',
                'technician_id' => 2,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'user_id' => 6,
                'device_name' => 'iPhone 11',
                'serial_number' => 'F2LW48XHFG8K',
                'problem' => 'ब्याट्री हेल्थ ७५% छ। छिट्टै डिस्चार्ज हुन्छ।',
                'technician_id' => 4,
                'status' => 'Completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'user_id' => 7,
                'device_name' => 'Realme C25',
                'serial_number' => 'RM753951486',
                'problem' => 'चार्जिङ पोर्ट बिग्रिएको। केबल जोड्दा चार्ज हुँदैन।',
                'technician_id' => 3,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 hours'))
            ],
            [
                'user_id' => 8,
                'device_name' => 'Samsung Galaxy S21',
                'serial_number' => 'SM987456123',
                'problem' => 'बैक कभर फुटेको। वाटरप्रूफिङ गुमेको। रिप्लेसमेन्ट चाहिन्छ।',
                'technician_id' => 1,
                'status' => 'In Progress',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ]
        ];

        $this->db->table('jobs')->insertBatch($jobs);

        // Sample Inventory Movements
        $movements = [
            [
                'item_id' => 1, // iPhone Screen
                'movement_type' => 'OUT',
                'quantity' => 1,
                'job_id' => 1,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
            ],
            [
                'item_id' => 3, // iPhone 11 Battery
                'movement_type' => 'OUT',
                'quantity' => 1,
                'job_id' => 6,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'item_id' => 2, // Samsung Display
                'movement_type' => 'IN',
                'quantity' => 10,
                'job_id' => null,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            [
                'item_id' => 4, // Charging Port
                'movement_type' => 'OUT',
                'quantity' => 1,
                'job_id' => 7,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-5 hours'))
            ],
            [
                'item_id' => 6, // Camera Module
                'movement_type' => 'OUT',
                'quantity' => 1,
                'job_id' => 4,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'item_id' => 7, // Speaker
                'movement_type' => 'IN',
                'quantity' => 5,
                'job_id' => null,
                'moved_at' => date('Y-m-d H:i:s', strtotime('-8 days'))
            ]
        ];

        $this->db->table('inventory_movements')->insertBatch($movements);

        echo "Nepali sample data seeded successfully!\n";
        echo "Added:\n";
        echo "- 8 customers with Nepali names\n";
        echo "- 4 technicians\n";
        echo "- 8 inventory items (common mobile parts)\n";
        echo "- 8 repair jobs with Nepali problem descriptions\n";
        echo "- 6 inventory movements\n";
    }
}
