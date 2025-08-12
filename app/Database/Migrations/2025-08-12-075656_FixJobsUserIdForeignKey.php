<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixJobsUserIdForeignKey extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Step 1: Check and clean up invalid user_id references
        log_message('info', 'Starting jobs foreign key fix migration');

        // Find jobs with user_id that don't exist in users table
        $invalidJobs = $db->query("
            SELECT j.id, j.user_id
            FROM jobs j
            LEFT JOIN users u ON j.user_id = u.id
            WHERE j.user_id IS NOT NULL AND u.id IS NULL
        ")->getResultArray();

        if (!empty($invalidJobs)) {
            log_message('info', 'Found ' . count($invalidJobs) . ' jobs with invalid user_id references');

            // Set invalid user_id to NULL
            $invalidIds = array_column($invalidJobs, 'id');
            $db->query("UPDATE jobs SET user_id = NULL WHERE id IN (" . implode(',', $invalidIds) . ")");

            log_message('info', 'Set user_id to NULL for jobs with invalid references: ' . implode(',', $invalidIds));
        }

        // Step 2: Get current foreign keys for jobs table
        $query = $db->query("
            SELECT CONSTRAINT_NAME, REFERENCED_TABLE_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'jobs'
            AND COLUMN_NAME = 'user_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        $foreignKeys = $query->getResultArray();

        // Step 3: Drop incorrect foreign keys
        foreach ($foreignKeys as $fk) {
            if ($fk['REFERENCED_TABLE_NAME'] === 'admin_users') {
                $db->query("ALTER TABLE jobs DROP FOREIGN KEY " . $fk['CONSTRAINT_NAME']);
                log_message('info', 'Dropped incorrect foreign key: ' . $fk['CONSTRAINT_NAME']);
            }
        }

        // Step 4: Check if correct foreign key already exists
        $correctFkExists = false;
        foreach ($foreignKeys as $fk) {
            if ($fk['REFERENCED_TABLE_NAME'] === 'users') {
                $correctFkExists = true;
                break;
            }
        }

        // Step 5: Add correct foreign key if it doesn't exist
        if (!$correctFkExists) {
            try {
                // Use raw SQL to ensure proper constraint creation
                $db->query("
                    ALTER TABLE jobs
                    ADD CONSTRAINT jobs_user_id_foreign
                    FOREIGN KEY (user_id) REFERENCES users(id)
                    ON DELETE SET NULL ON UPDATE CASCADE
                ");
                log_message('info', 'Added correct foreign key: jobs_user_id_foreign');
            } catch (\Exception $e) {
                log_message('error', 'Failed to add foreign key: ' . $e->getMessage());
                throw $e;
            }
        }

        log_message('info', 'Jobs foreign key fix migration completed successfully');
    }

    public function down()
    {
        // Drop the correct foreign key
        $db = \Config\Database::connect();

        try {
            $db->query("ALTER TABLE jobs DROP FOREIGN KEY jobs_user_id_foreign");
        } catch (\Exception $e) {
            // Foreign key might not exist, that's okay
            log_message('info', 'Foreign key jobs_user_id_foreign not found during rollback');
        }
    }
}
