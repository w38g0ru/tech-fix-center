<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\PartsRequestModel;
use App\Models\TechnicianModel;

class TestPartsRequests extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:parts-requests';
    protected $description = 'Test parts requests functionality';

    public function run(array $params)
    {
        CLI::write('=== Parts Requests Test ===', 'yellow');
        CLI::newLine();

        // Test database connection
        $db = \Config\Database::connect();
        try {
            $db->query("SELECT 1");
            CLI::write('✓ Database connection successful', 'green');
        } catch (\Exception $e) {
            CLI::write('✗ Database connection failed: ' . $e->getMessage(), 'red');
            return;
        }

        // Test PartsRequestModel
        try {
            $partsRequestModel = new PartsRequestModel();
            CLI::write('✓ PartsRequestModel loaded successfully', 'green');
            
            // Test getPartsRequestsWithDetails method
            $partsRequests = $partsRequestModel->getPartsRequestsWithDetails();
            CLI::write('✓ getPartsRequestsWithDetails method working', 'green');
            CLI::write('  - Found ' . count($partsRequests) . ' parts requests', 'white');
            
        } catch (\Exception $e) {
            CLI::write('✗ PartsRequestModel error: ' . $e->getMessage(), 'red');
        }

        // Test TechnicianModel
        try {
            $technicianModel = new TechnicianModel();
            CLI::write('✓ TechnicianModel loaded successfully', 'green');
            
            // Test finding technicians
            $technicians = $technicianModel->findAll();
            CLI::write('✓ Found ' . count($technicians) . ' technicians', 'green');
            
        } catch (\Exception $e) {
            CLI::write('✗ TechnicianModel error: ' . $e->getMessage(), 'red');
        }

        // Test auth helper functions
        try {
            helper('auth');
            CLI::write('✓ Auth helper loaded successfully', 'green');
            
            // Test if functions exist
            if (function_exists('getUserId')) {
                CLI::write('✓ getUserId function exists', 'green');
            } else {
                CLI::write('✗ getUserId function missing', 'red');
            }
            
            if (function_exists('getUserRole')) {
                CLI::write('✓ getUserRole function exists', 'green');
            } else {
                CLI::write('✗ getUserRole function missing', 'red');
            }
            
        } catch (\Exception $e) {
            CLI::write('✗ Auth helper error: ' . $e->getMessage(), 'red');
        }

        // Test PartsRequests controller instantiation
        try {
            $controller = new \App\Controllers\PartsRequests();
            CLI::write('✓ PartsRequests controller can be instantiated', 'green');
        } catch (\Exception $e) {
            CLI::write('✗ PartsRequests controller error: ' . $e->getMessage(), 'red');
        }

        CLI::newLine();
        CLI::write('=== Test Complete ===', 'green');
        CLI::newLine();
        CLI::write('If all tests passed, parts-requests should work at: http://tfc.local/dashboard/parts-requests', 'yellow');
    }
}
