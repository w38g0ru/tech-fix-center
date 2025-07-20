<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestActivity extends Controller
{
    public function index()
    {
        // Load helpers
        helper(['auth', 'activity']);

        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $userId = getUserId();

        // Debug information
        $debug = [];
        $results = [];
        $errors = [];

        // Check if table exists
        try {
            $db = \Config\Database::connect();
            $debug['table_exists'] = $db->tableExists('user_activity_logs');

            if ($debug['table_exists']) {
                // Get table structure
                $fields = $db->getFieldData('user_activity_logs');
                $debug['table_fields'] = array_map(function($field) {
                    return $field->name . ' (' . $field->type . ')';
                }, $fields);

                // Check if all required fields exist
                $fieldNames = array_map(function($field) { return $field->name; }, $fields);
                $requiredFields = ['id', 'user_id', 'activity_type', 'details', 'ip_address', 'user_agent', 'created_at'];
                $missingFields = array_diff($requiredFields, $fieldNames);
                $debug['missing_fields'] = $missingFields;
                $debug['has_all_fields'] = empty($missingFields);

                // Test direct database insert
                try {
                    $testData = [
                        'user_id' => $userId,
                        'activity_type' => 'login',
                        'details' => 'Direct database test',
                        'ip_address' => $this->request->getIPAddress(),
                        'user_agent' => $this->request->getUserAgent()->getAgentString()
                    ];

                    $builder = $db->table('user_activity_logs');

                    // Enable query debugging
                    $db->enableQueryDebug();

                    $directInsert = $builder->insert($testData);
                    $debug['direct_insert'] = $directInsert ? 'Success' : 'Failed';

                    // Get the last query to see what SQL was generated
                    $debug['last_query'] = $db->getLastQuery();

                    if (!$directInsert) {
                        $debug['db_error'] = $db->error();
                    }
                } catch (\Exception $e) {
                    $debug['direct_insert'] = 'Error: ' . $e->getMessage();
                }

                // Test with UserActivityLogModel
                try {
                    $model = new \App\Models\UserActivityLogModel();
                    $modelData = [
                        'user_id' => $userId,
                        'activity_type' => 'post',
                        'details' => 'Model test',
                        'ip_address' => $this->request->getIPAddress(),
                        'user_agent' => $this->request->getUserAgent()->getAgentString()
                    ];

                    $modelInsert = $model->insert($modelData);
                    $debug['model_insert'] = $modelInsert ? 'Success' : 'Failed';

                    if (!$modelInsert) {
                        $debug['model_errors'] = $model->errors();
                    }
                } catch (\Exception $e) {
                    $debug['model_insert'] = 'Error: ' . $e->getMessage();
                }
            }
        } catch (\Exception $e) {
            $debug['db_connection'] = 'Error: ' . $e->getMessage();
        }

        // Test activity logging functions
        try {
            $results['login'] = log_login_activity($userId, 'Test login activity');
        } catch (\Exception $e) {
            $errors['login'] = $e->getMessage();
            $results['login'] = false;
        }

        try {
            $results['logout'] = log_logout_activity($userId, 'Test logout activity');
        } catch (\Exception $e) {
            $errors['logout'] = $e->getMessage();
            $results['logout'] = false;
        }

        try {
            $results['post'] = log_post_activity($userId, 'Test post activity - created test data');
        } catch (\Exception $e) {
            $errors['post'] = $e->getMessage();
            $results['post'] = false;
        }

        // Get recent activities
        $recentActivities = [];
        $stats = [];
        try {
            $recentActivities = get_user_recent_activities($userId, 5);
            $stats = get_activity_stats(7); // Last 7 days
        } catch (\Exception $e) {
            $errors['retrieval'] = $e->getMessage();
        }

        $data = [
            'title' => 'Activity Logging Debug Test',
            'debug' => $debug,
            'results' => $results,
            'errors' => $errors,
            'recent_activities' => $recentActivities,
            'stats' => $stats,
            'user_id' => $userId
        ];

        return view('test_activity', $data);
    }
    
    public function testPost()
    {
        // This method is for testing POST activity logging
        helper(['auth', 'activity']);

        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        // This POST request should be automatically logged by the ActivityLogFilter
        return redirect()->to(base_url('test-activity'))->with('success', 'POST request logged successfully!');
    }

    public function createTable()
    {
        // Check if user is logged in and is admin
        helper('auth');
        if (!isLoggedIn() || !hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('auth/login'));
        }

        try {
            $db = \Config\Database::connect();

            // Drop existing table if it exists
            $db->query('DROP TABLE IF EXISTS user_activity_logs');

            // Create the table with correct structure
            $sql = "CREATE TABLE user_activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                activity_type ENUM('login','logout','post') NOT NULL,
                details TEXT,
                ip_address VARCHAR(45),
                user_agent TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_user_id (user_id),
                INDEX idx_activity_type (activity_type),
                INDEX idx_created_at (created_at),
                INDEX idx_user_activity (user_id, activity_type)
            )";

            $db->query($sql);

            return redirect()->to(base_url('test-activity'))->with('success', 'Table created successfully!');

        } catch (\Exception $e) {
            return redirect()->to(base_url('test-activity'))->with('error', 'Failed to create table: ' . $e->getMessage());
        }
    }
}
