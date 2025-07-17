<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('admin_users', [
            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'email'
            ]
        ]);

        // Add index for google_id for faster lookups
        $this->forge->addKey('google_id', false, false, 'admin_users');
    }

    public function down()
    {
        $this->forge->dropColumn('admin_users', 'google_id');
    }
}
