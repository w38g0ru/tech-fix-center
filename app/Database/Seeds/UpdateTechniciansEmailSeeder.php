<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateTechniciansEmailSeeder extends Seeder
{
    public function run()
    {
        // Update existing technicians with email addresses
        $updates = [
            [
                'id' => 1,
                'email' => 'suresh.maharjan@tfc.com'
            ],
            [
                'id' => 2,
                'email' => 'rajesh.shrestha@tfc.com'
            ],
            [
                'id' => 3,
                'email' => 'prakash.tuladhar@tfc.com'
            ],
            [
                'id' => 4,
                'email' => 'amit.manandhar@tfc.com'
            ],
            [
                'id' => 5,
                'email' => 'superadmin@tfc.com'
            ]
        ];

        foreach ($updates as $update) {
            $this->db->table('technicians')
                     ->where('id', $update['id'])
                     ->update(['email' => $update['email']]);
        }

        echo "Technician emails updated successfully!\n";
        echo "Updated emails for all existing technicians.\n";
    }
}
