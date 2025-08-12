<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserActivityLogsEnum extends Migration
{
    public function up()
    {
        // Update the activity_type enum to include all required values
        $this->forge->modifyColumn('user_activity_logs', [
            'activity_type' => [
                'type' => 'ENUM',
                'constraint' => ['login', 'logout', 'post', 'update', 'delete', 'view'],
                'null' => false
            ]
        ]);
    }

    public function down()
    {
        // Revert to original enum values
        $this->forge->modifyColumn('user_activity_logs', [
            'activity_type' => [
                'type' => 'ENUM',
                'constraint' => ['login', 'logout', 'post'],
                'null' => false
            ]
        ]);
    }
}
