<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PhotosAndReferredSeeder extends Seeder
{
    public function run()
    {
        // Create upload directory if it doesn't exist
        $uploadPath = WRITEPATH . 'uploads/photos/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Sample Referred (Dispatch) items
        $referredItems = [
            [
                'customer_name' => 'राम बहादुर श्रेष्ठ',
                'customer_phone' => '9841234567',
                'device_name' => 'iPhone 12 Pro',
                'problem_description' => 'मदरबोर्ड रिपेयर गर्नुपर्छ। लोकल रिपेयर सम्भव छैन।',
                'referred_to' => 'Apple Service Center, Kathmandu',
                'status' => 'Dispatched',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'customer_name' => 'सीता देवी पौडेल',
                'customer_phone' => '9851234568',
                'device_name' => 'Samsung Galaxy S21',
                'problem_description' => 'डिस्प्ले IC बिग्रिएको। स्पेशल टूल चाहिन्छ।',
                'referred_to' => 'Samsung Service Center, Pokhara',
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'customer_name' => 'अनिल गुरुङ',
                'customer_phone' => '9861234569',
                'device_name' => 'MacBook Air M1',
                'problem_description' => 'लिक्विड डेमेज। डाटा रिकभरी चाहिन्छ।',
                'referred_to' => 'Mac Specialist, Lalitpur',
                'status' => 'Completed',
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'customer_name' => 'प्रिया तामाङ',
                'customer_phone' => '9871234570',
                'device_name' => 'iPad Pro',
                'problem_description' => 'स्क्रिन र डिजिटाइजर दुवै बिग्रिएको।',
                'referred_to' => 'Tablet Repair Specialist',
                'status' => 'Dispatched',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ]
        ];

        $this->db->table('referred')->insertBatch($referredItems);

        // Create sample placeholder images (you can replace these with actual images)
        $this->createSampleImages($uploadPath);

        // Sample Photos
        $photos = [
            [
                'job_id' => 1,
                'referred_id' => null,
                'photo_type' => 'Job',
                'file_name' => 'job_before_1.jpg',
                'description' => 'iPhone 12 स्क्रिन फुट्नु अगाडिको फोटो',
                'uploaded_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'job_id' => 1,
                'referred_id' => null,
                'photo_type' => 'Job',
                'file_name' => 'job_after_1.jpg',
                'description' => 'iPhone 12 स्क्रिन रिप्लेसमेन्ट पछिको फोटो',
                'uploaded_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
            ],
            [
                'job_id' => null,
                'referred_id' => 1,
                'photo_type' => 'Dispatch',
                'file_name' => 'dispatch_1.jpg',
                'description' => 'iPhone 12 Pro डिस्प्याच गर्दाको फोटो',
                'uploaded_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'job_id' => 3,
                'referred_id' => null,
                'photo_type' => 'Job',
                'file_name' => 'water_damage_1.jpg',
                'description' => 'Xiaomi फोन पानी परेको अवस्था',
                'uploaded_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'job_id' => null,
                'referred_id' => 2,
                'photo_type' => 'Dispatch',
                'file_name' => 'samsung_dispatch.jpg',
                'description' => 'Samsung Galaxy S21 सर्भिस सेन्टर पठाउँदा',
                'uploaded_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'job_id' => null,
                'referred_id' => 3,
                'photo_type' => 'Received',
                'file_name' => 'macbook_received.jpg',
                'description' => 'MacBook Air रिपेयर भएर फिर्ता आएको',
                'uploaded_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];

        $this->db->table('photos')->insertBatch($photos);

        echo "Photos and Referred data seeded successfully!\n";
        echo "Added:\n";
        echo "- 4 dispatch/referred items\n";
        echo "- 6 sample photos\n";
        echo "- Sample placeholder images created\n";
    }

    private function createSampleImages($uploadPath)
    {
        $imageFiles = [
            'job_before_1.jpg',
            'job_after_1.jpg',
            'dispatch_1.jpg',
            'water_damage_1.jpg',
            'samsung_dispatch.jpg',
            'macbook_received.jpg'
        ];

        foreach ($imageFiles as $filename) {
            $filepath = $uploadPath . $filename;
            
            // Create a simple placeholder image (1x1 pixel PNG)
            $image = imagecreate(400, 300);
            $bg = imagecolorallocate($image, 240, 240, 240);
            $text_color = imagecolorallocate($image, 100, 100, 100);
            
            // Add some text to make it identifiable
            $text = str_replace(['_', '.jpg'], [' ', ''], $filename);
            imagestring($image, 3, 50, 140, strtoupper($text), $text_color);
            
            // Save as JPEG
            imagejpeg($image, $filepath, 80);
            imagedestroy($image);
        }
    }
}
