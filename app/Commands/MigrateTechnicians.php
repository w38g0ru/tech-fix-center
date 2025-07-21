<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateTechnicians extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'migrate:technicians';
    protected $description = 'Migrate technicians from technicians table to admin_users table';

    public function run(array $params)
    {
        CLI::write('=== Migrating Technicians to Admin Users System ===', 'yellow');
        CLI::newLine();

        $db = \Config\Database::connect();

        try {
            // Check if technicians table exists
            if (!$db->tableExists('technicians')) {
                CLI::write('✓ Technicians table does not exist - migration not needed', 'green');
                return;
            }

            // Check if admin_users table exists
            if (!$db->tableExists('admin_users')) {
                CLI::write('✗ Admin users table does not exist - please create it first', 'red');
                return;
            }

            // Get all technicians
            $technicians = $db->table('technicians')->get()->getResultArray();
            
            if (empty($technicians)) {
                CLI::write('✓ No technicians to migrate', 'green');
                return;
            }

            CLI::write('Found ' . count($technicians) . ' technicians to migrate', 'yellow');
            CLI::newLine();

            $migrated = 0;
            $skipped = 0;
            $errors = 0;

            foreach ($technicians as $technician) {
                try {
                    // Check if technician already exists in admin_users (by email or name)
                    $existing = null;
                    if (!empty($technician['email'])) {
                        $existing = $db->table('admin_users')
                                     ->where('email', $technician['email'])
                                     ->get()
                                     ->getRowArray();
                    }

                    if ($existing) {
                        CLI::write("⚠ Skipping {$technician['name']} - email already exists in admin_users", 'yellow');
                        $skipped++;
                        continue;
                    }

                    // Generate username from name
                    $username = $this->generateUsername($technician['name'], $db);

                    // Generate email if not provided
                    $email = $technician['email'] ?: $username . '@teknophix.com';

                    // Prepare admin user data
                    $adminUserData = [
                        'username' => $username,
                        'email' => $email,
                        'password' => password_hash('technician123', PASSWORD_DEFAULT), // Default password
                        'full_name' => $technician['name'],
                        'role' => 'technician',
                        'status' => isset($technician['status']) && $technician['status'] === 'Inactive' ? 'inactive' : 'active',
                        'phone' => $technician['contact_number'] ?: null,
                        'created_at' => $technician['created_at'] ?? date('Y-m-d H:i:s'),
                        'updated_at' => $technician['updated_at'] ?? date('Y-m-d H:i:s')
                    ];

                    // Insert into admin_users (let auto-increment handle ID)
                    $db->table('admin_users')->insert($adminUserData);
                    $newId = $db->insertID();

                    if ($newId) {
                        // Update foreign key references to use new ID
                        $this->updateForeignKeyReferences($db, $technician['id'], $newId);
                    }
                    
                    CLI::write("✓ Migrated: {$technician['name']} -> @{$username}", 'green');
                    $migrated++;

                } catch (\Exception $e) {
                    CLI::write("✗ Error migrating {$technician['name']}: " . $e->getMessage(), 'red');
                    $errors++;
                }
            }

            CLI::newLine();
            CLI::write("=== Migration Summary ===", 'yellow');
            CLI::write("✓ Migrated: {$migrated}", 'green');
            CLI::write("⚠ Skipped: {$skipped}", 'yellow');
            CLI::write("✗ Errors: {$errors}", $errors > 0 ? 'red' : 'green');
            CLI::newLine();

            if ($migrated > 0) {
                CLI::write("All technicians have been migrated to the admin_users system.", 'green');
                CLI::write("Default password for all migrated technicians: 'technician123'", 'yellow');
                CLI::write("Please ask technicians to change their passwords on first login.", 'yellow');
                CLI::newLine();
                
                // Ask if user wants to drop the technicians table
                if (CLI::prompt('Do you want to drop the technicians table now? (y/N)', 'n') === 'y') {
                    $this->dropTechniciansTable($db);
                }
            }

        } catch (\Exception $e) {
            CLI::write('✗ Migration failed: ' . $e->getMessage(), 'red');
            CLI::write('Stack trace: ' . $e->getTraceAsString(), 'red');
        }
    }

    private function generateUsername($name, $db)
    {
        // Convert to lowercase and replace spaces with underscores
        $username = strtolower(str_replace(' ', '_', $name));
        
        // Remove special characters except underscores
        $username = preg_replace('/[^a-z0-9_]/', '', $username);
        
        // Ensure minimum length
        if (strlen($username) < 3) {
            $username = 'tech_' . $username;
        }
        
        // Check if username exists and add number if needed
        $originalUsername = $username;
        $counter = 1;
        
        while ($db->table('admin_users')->where('username', $username)->get()->getRowArray()) {
            $username = $originalUsername . '_' . $counter;
            $counter++;
        }
        
        return $username;
    }

    private function updateForeignKeyReferences($db, $oldId, $newId)
    {
        try {
            // Update jobs table
            $db->table('jobs')
               ->where('technician_id', $oldId)
               ->update(['technician_id' => $newId]);

            // Update parts_requests table
            $db->table('parts_requests')
               ->where('technician_id', $oldId)
               ->update(['technician_id' => $newId]);

        } catch (\Exception $e) {
            CLI::write("⚠ Warning: Could not update foreign key references for ID {$oldId}: " . $e->getMessage(), 'yellow');
        }
    }

    private function dropTechniciansTable($db)
    {
        try {
            CLI::write('Dropping technicians table...', 'yellow');
            $db->query('DROP TABLE IF EXISTS technicians');
            CLI::write('✓ Technicians table dropped successfully', 'green');

        } catch (\Exception $e) {
            CLI::write('✗ Error dropping technicians table: ' . $e->getMessage(), 'red');
            CLI::write('You may need to drop it manually.', 'yellow');
        }
    }
}
