<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBugReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => false,
            ],
            'feedback' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'steps_to_reproduce' => [
                'type'       => 'VARCHAR',
                'constraint' => 1000,
                'null'       => true,
                'default'    => null,
            ],
            'bug_type' => [
                'type'       => 'ENUM',
                'constraint' => ['UI', 'Functional', 'Crash', 'Typo', 'Other'],
                'default'    => 'Other',
                'null'       => false,
            ],
            'severity' => [
                'type'       => 'ENUM',
                'constraint' => ['Low', 'Medium', 'High', 'Critical'],
                'default'    => 'Medium',
                'null'       => false,
            ],
            'screenshot' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'user_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
                'default'    => null,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'can_contact' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('bug_type');
        $this->forge->addKey('severity');
        $this->forge->addKey('created_at');

        $this->forge->createTable('bug_reports');
    }

    public function down()
    {
        $this->forge->dropTable('bug_reports');
    }
}
