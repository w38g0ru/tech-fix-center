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
                    $directInsert = $builder->insert($testData);
                    $debug['direct_insert'] = $directInsert ? 'Success' : 'Failed';
                    if (!$directInsert) {
                        $debug['db_error'] = $db->error();
                    }
                } catch (\Exception $e) {
                    $debug['direct_insert'] = 'Error: ' . $e->getMessage();
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
}
