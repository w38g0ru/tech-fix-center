<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAdminToTechnician extends Migration
{
    public function up()
    {
        // Update admin@techfixcenter.com user role to technician
        $this->db->table('admin_users')
                 ->where('email', 'admin@techfixcenter.com')
                 ->update([
                     'role' => 'technician',
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
    }

    public function down()
    {
        // Rollback: Change technician back to admin
        $this->db->table('admin_users')
                 ->where('email', 'admin@techfixcenter.com')
                 ->update([
                     'role' => 'admin',
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
    }
}
