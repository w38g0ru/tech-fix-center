<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Test extends Controller
{
    public function index()
    {
        // Test basic functionality
        $data = [
            'title' => 'TeknoPhix Test Page',
            'message' => 'If you can see this, your CodeIgniter 4 setup is working correctly!',
            'base_url' => base_url(),
            'environment' => ENVIRONMENT,
            'php_version' => PHP_VERSION,
            'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'server_info' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Unknown'
        ];

        return view('test_page', $data);
    }

    public function database()
    {
        // Test database connection
        $db = \Config\Database::connect();
        
        try {
            $query = $db->query("SELECT 1 as test");
            $result = $query->getRow();
            
            $data = [
                'title' => 'Database Test',
                'status' => 'success',
                'message' => 'Database connection successful!',
                'database_name' => $db->getDatabase(),
                'hostname' => $db->hostname,
                'username' => $db->username,
                'driver' => $db->DBDriver
            ];
        } catch (\Exception $e) {
            $data = [
                'title' => 'Database Test',
                'status' => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage(),
                'database_name' => $db->getDatabase(),
                'hostname' => $db->hostname,
                'username' => $db->username,
                'driver' => $db->DBDriver
            ];
        }

        return view('test_database', $data);
    }

    public function routes()
    {
        // Test routes
        $routes = service('routes');
        $collection = $routes->getRoutes();
        
        $data = [
            'title' => 'Routes Test',
            'routes' => $collection,
            'total_routes' => count($collection)
        ];

        return view('test_routes', $data);
    }
}
