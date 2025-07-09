<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWalkInCustomerMobile extends Migration
{
    public function up()
    {
        // Add walk_in_customer_mobile column to jobs table
        $fields = [
            'walk_in_customer_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'walk_in_customer_name'
            ]
        ];
        
        $this->forge->addColumn('jobs', $fields);
    }

    public function down()
    {
        // Drop the column
        $this->forge->dropColumn('jobs', 'walk_in_customer_mobile');
    }
}
