<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateTechnicianRolesSeeder extends Seeder
{
    public function run()
    {
        // Update existing technicians with roles
        $this->db->query("UPDATE technicians SET role = 'admin' WHERE id = 1");
        $this->db->query("UPDATE technicians SET role = 'admin' WHERE id = 2");
        $this->db->query("UPDATE technicians SET role = 'technician' WHERE id = 3");
        $this->db->query("UPDATE technicians SET role = 'technician' WHERE id = 4");

        // Add a super admin technician
        $superAdmin = [
            'name' => 'सुपर एडमिन',
            'contact_number' => '9801111115',
            'role' => 'superadmin',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('technicians')->insert($superAdmin);

        echo "Technician roles updated successfully!\n";
        echo "- सुरेश महर्जन: Admin\n";
        echo "- राजेश श्रेष्ठ: Admin\n";
        echo "- प्रकाश तुलाधर: Technician\n";
        echo "- अमित मानन्धर: Technician\n";
        echo "- सुपर एडमिन: Super Admin (new)\n";
    }
}
