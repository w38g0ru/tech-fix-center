<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BugReportsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Login page not responsive on mobile devices',
                'description' => 'The login page layout breaks on mobile devices with screen width less than 768px. The form elements overlap and the submit button is not visible.',
                'severity' => 'High',
                'status' => 'Open',
                'priority' => 'High',
                'category' => 'UI/UX Issue',
                'reporter_name' => 'राम बहादुर श्रेष्ठ',
                'reporter_email' => 'ram.shrestha@example.com',
                'reporter_phone' => '+977-9841234567',
                'browser' => 'Chrome 120.0.6099.109',
                'operating_system' => 'Android 13',
                'steps_to_reproduce' => "1. Open the application on a mobile device\n2. Navigate to the login page\n3. Try to view the form elements\n4. Notice the layout issues",
                'expected_behavior' => 'The login page should be fully responsive and display properly on all mobile devices.',
                'actual_behavior' => 'Form elements overlap, submit button is hidden, and the page is not usable on mobile.',
                'user_agent' => 'Mozilla/5.0 (Linux; Android 13; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
                'ip_address' => '192.168.1.100',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title' => 'Dashboard statistics showing incorrect inventory count',
                'description' => 'The dashboard displays wrong inventory statistics. The total count shows 150 items but the actual inventory has 175 items.',
                'severity' => 'Medium',
                'status' => 'In Progress',
                'priority' => 'Normal',
                'category' => 'Data Issue',
                'reporter_name' => 'सीता देवी पौडेल',
                'reporter_email' => 'sita.poudel@example.com',
                'reporter_phone' => '+977-9851234567',
                'browser' => 'Firefox 121.0',
                'operating_system' => 'Windows 11',
                'steps_to_reproduce' => "1. Login to the dashboard\n2. Check the inventory statistics card\n3. Navigate to inventory page\n4. Count the actual items\n5. Compare the numbers",
                'expected_behavior' => 'Dashboard should show accurate inventory count matching the actual inventory items.',
                'actual_behavior' => 'Dashboard shows 150 items while inventory page shows 175 items.',
                'resolution_notes' => 'Investigating the inventory count query in the dashboard model.',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
                'ip_address' => '192.168.1.101',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
            ],
            [
                'title' => 'File upload fails for images larger than 2MB',
                'description' => 'When trying to upload job photos or inventory images larger than 2MB, the upload fails without proper error message.',
                'severity' => 'Critical',
                'status' => 'Open',
                'priority' => 'Urgent',
                'category' => 'Functionality Bug',
                'reporter_name' => 'हरि प्रसाद गुरुङ',
                'reporter_email' => 'hari.gurung@example.com',
                'reporter_phone' => '+977-9861234567',
                'browser' => 'Safari 17.2',
                'operating_system' => 'macOS 14.2',
                'steps_to_reproduce' => "1. Go to job creation page\n2. Try to upload a photo larger than 2MB\n3. Click submit\n4. Observe the error",
                'expected_behavior' => 'System should either accept the file or show a clear error message about file size limits.',
                'actual_behavior' => 'Upload fails silently without any error message, leaving users confused.',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15',
                'ip_address' => '192.168.1.102',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
            ],
            [
                'title' => 'Search functionality not working in inventory page',
                'description' => 'The search box in the inventory page does not return any results even when searching for existing items.',
                'severity' => 'Medium',
                'status' => 'Resolved',
                'priority' => 'Normal',
                'category' => 'Functionality Bug',
                'reporter_name' => 'गीता कुमारी तामाङ',
                'reporter_email' => 'geeta.tamang@example.com',
                'reporter_phone' => '+977-9871234567',
                'browser' => 'Chrome 120.0.6099.109',
                'operating_system' => 'Ubuntu 22.04',
                'steps_to_reproduce' => "1. Navigate to inventory page\n2. Enter a known item name in search box\n3. Press enter or click search\n4. No results are displayed",
                'expected_behavior' => 'Search should return matching inventory items based on name, description, or SKU.',
                'actual_behavior' => 'Search returns no results even for items that exist in the inventory.',
                'resolution_notes' => 'Fixed the search query in InventoryModel. The LIKE clause was missing proper wildcards.',
                'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'ip_address' => '192.168.1.103',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'resolved_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'title' => 'Email notifications not being sent for new jobs',
                'description' => 'When a new job is created, the system should send email notifications to assigned technicians, but emails are not being delivered.',
                'severity' => 'High',
                'status' => 'Open',
                'priority' => 'High',
                'category' => 'Integration Problem',
                'reporter_name' => 'अनिल कुमार यादव',
                'reporter_email' => 'anil.yadav@example.com',
                'reporter_phone' => '+977-9881234567',
                'browser' => 'Edge 120.0.2210.91',
                'operating_system' => 'Windows 10',
                'steps_to_reproduce' => "1. Create a new job\n2. Assign it to a technician\n3. Submit the job\n4. Check if technician receives email notification",
                'expected_behavior' => 'Technician should receive an email notification about the new job assignment.',
                'actual_behavior' => 'No email notifications are being sent to technicians.',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.2210.91',
                'ip_address' => '192.168.1.104',
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-6 hours'))
            ]
        ];

        // Insert sample bug reports
        $this->db->table('bug_reports')->insertBatch($data);
    }
}
