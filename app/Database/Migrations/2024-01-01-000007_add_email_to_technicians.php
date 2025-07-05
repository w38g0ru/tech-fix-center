<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToTechnicians extends Migration
{
    public function up()
    {
        // Add email column to technicians table
        $this->forge->addColumn('technicians', [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'name'
            ]
        ]);
    }

    public function down()
    {
        // Remove email column
        $this->forge->dropColumn('technicians', 'email');
    }
}
