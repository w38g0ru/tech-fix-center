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
        
        // Test activity logging
        $results = [];
        
        // Test login activity logging
        $results['login'] = log_login_activity($userId, 'Test login activity');
        
        // Test logout activity logging
        $results['logout'] = log_logout_activity($userId, 'Test logout activity');
        
        // Test post activity logging
        $results['post'] = log_post_activity($userId, 'Test post activity - created test data');
        
        // Get recent activities
        $recentActivities = get_user_recent_activities($userId, 5);
        
        // Get activity stats
        $stats = get_activity_stats(7); // Last 7 days
        
        $data = [
            'title' => 'Activity Logging Test',
            'results' => $results,
            'recent_activities' => $recentActivities,
            'stats' => $stats
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
