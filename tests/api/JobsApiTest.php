<?php

namespace Tests\Api;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Jobs API Test Suite
 * 
 * Comprehensive tests for the Jobs API controller
 * Tests all CRUD operations, relationships, and business logic
 */
class JobsApiTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $migrateOnce = false;
    protected $refresh = true;
    protected $namespace = null;

    protected $seed = 'TestDataSeeder';

    protected function setUp(): void
    {
        parent::setUp();
        
        // Set up authentication for API tests
        $this->withSession([
            'user' => [
                'id' => 1,
                'email' => 'admin@teknophix.com',
                'role' => 'admin'
            ]
        ]);
    }

    /**
     * Test GET /api/v1/jobs - List jobs with pagination
     */
    public function testListJobs()
    {
        $response = $this->get('/api/v1/jobs');

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Jobs retrieved successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('jobs', $data['data']);
        $this->assertArrayHasKey('pagination', $data['data']);
        $this->assertArrayHasKey('statistics', $data['data']);
    }

    /**
     * Test GET /api/v1/jobs with filters
     */
    public function testListJobsWithFilters()
    {
        $response = $this->get('/api/v1/jobs?status=Pending&per_page=5');

        $response->assertStatus(200);
        
        $data = $response->getJSON(true);
        $this->assertArrayHasKey('filters_applied', $data['data']);
        $this->assertEquals('Pending', $data['data']['filters_applied']['status']);
    }

    /**
     * Test GET /api/v1/jobs/{id} - Show single job
     */
    public function testShowJob()
    {
        // Assuming job with ID 1 exists from seeder
        $response = $this->get('/api/v1/jobs/1');

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job retrieved successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('id', $data['data']);
        $this->assertArrayHasKey('can_edit', $data['data']);
        $this->assertArrayHasKey('can_delete', $data['data']);
    }

    /**
     * Test GET /api/v1/jobs/{id} - Job not found
     */
    public function testShowJobNotFound()
    {
        $response = $this->get('/api/v1/jobs/99999');

        $response->assertStatus(404);
        $response->assertJSONFragment([
            'status' => 'error',
            'message' => 'Job not found'
        ]);
    }

    /**
     * Test POST /api/v1/jobs - Create job with registered customer
     */
    public function testCreateJobWithRegisteredCustomer()
    {
        $jobData = [
            'device_name' => 'iPhone 13',
            'problem' => 'Screen cracked',
            'status' => 'Pending',
            'expected_return_date' => date('Y-m-d', strtotime('+3 days')),
            'user_id' => 1, // Assuming user with ID 1 exists
            'charge' => 15000.00,
            'serial_number' => 'TEST123456'
        ];

        $response = $this->post('/api/v1/jobs', $jobData);

        $response->assertStatus(201);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job created successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals('iPhone 13', $data['data']['device_name']);
    }

    /**
     * Test POST /api/v1/jobs - Create job with walk-in customer
     */
    public function testCreateJobWithWalkInCustomer()
    {
        $jobData = [
            'device_name' => 'Samsung Galaxy S21',
            'problem' => 'Battery not charging',
            'status' => 'Pending',
            'expected_return_date' => date('Y-m-d', strtotime('+2 days')),
            'walk_in_customer_name' => 'John Doe',
            'walk_in_customer_mobile' => '9841234567',
            'charge' => 8000.00
        ];

        $response = $this->post('/api/v1/jobs', $jobData);

        $response->assertStatus(201);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job created successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertEquals('John Doe', $data['data']['walk_in_customer_name']);
    }

    /**
     * Test POST /api/v1/jobs - Validation errors
     */
    public function testCreateJobValidationErrors()
    {
        $jobData = [
            'device_name' => '', // Required field empty
            'problem' => '',     // Required field empty
            'status' => 'InvalidStatus', // Invalid status
        ];

        $response = $this->post('/api/v1/jobs', $jobData);

        $response->assertStatus(422);
        $response->assertJSONFragment([
            'status' => 'error'
        ]);
    }

    /**
     * Test PUT /api/v1/jobs/{id} - Update job
     */
    public function testUpdateJob()
    {
        $updateData = [
            'status' => 'In Progress',
            'technician_id' => 1, // Assuming technician with ID 1 exists
            'charge' => 18000.00
        ];

        $response = $this->put('/api/v1/jobs/1', $updateData);

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job updated successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertEquals('In Progress', $data['data']['status']);
    }

    /**
     * Test DELETE /api/v1/jobs/{id} - Delete job
     */
    public function testDeleteJob()
    {
        // Create a job that can be deleted (no related data)
        $jobData = [
            'device_name' => 'Test Device',
            'problem' => 'Test Problem',
            'status' => 'Pending',
            'expected_return_date' => date('Y-m-d', strtotime('+1 day')),
            'walk_in_customer_name' => 'Test Customer',
            'walk_in_customer_mobile' => '9841111111'
        ];

        $createResponse = $this->post('/api/v1/jobs', $jobData);
        $createData = $createResponse->getJSON(true);
        $jobId = $createData['data']['id'];

        $response = $this->delete("/api/v1/jobs/{$jobId}");

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job deleted successfully'
        ]);
    }

    /**
     * Test GET /api/v1/jobs/attention - Jobs requiring attention
     */
    public function testJobsRequiringAttention()
    {
        $response = $this->get('/api/v1/jobs/attention');

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Jobs requiring attention retrieved successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('overdue', $data['data']);
        $this->assertArrayHasKey('no_technician', $data['data']);
        $this->assertArrayHasKey('parts_pending', $data['data']);
        $this->assertArrayHasKey('ready_for_dispatch', $data['data']);
    }

    /**
     * Test GET /api/v1/jobs/metrics - Job performance metrics
     */
    public function testJobMetrics()
    {
        $response = $this->get('/api/v1/jobs/metrics');

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job metrics retrieved successfully'
        ]);

        $data = $response->getJSON(true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('total_jobs', $data['data']);
        $this->assertArrayHasKey('completed_jobs', $data['data']);
        $this->assertArrayHasKey('completion_rate', $data['data']);
    }

    /**
     * Test POST /api/v1/jobs/{id}/assign-technician
     */
    public function testAssignTechnician()
    {
        $assignData = [
            'technician_id' => 1 // Assuming technician with ID 1 exists
        ];

        $response = $this->post('/api/v1/jobs/1/assign-technician', $assignData);

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Technician assigned successfully'
        ]);
    }

    /**
     * Test POST /api/v1/jobs/{id}/refer-service-center
     */
    public function testReferToServiceCenter()
    {
        $referData = [
            'service_center_id' => 1 // Assuming service center with ID 1 exists
        ];

        $response = $this->post('/api/v1/jobs/1/refer-service-center', $referData);

        $response->assertStatus(200);
        $response->assertJSONFragment([
            'status' => 'success',
            'message' => 'Job referred to service center successfully'
        ]);
    }

    /**
     * Test foreign key validation
     */
    public function testForeignKeyValidation()
    {
        $jobData = [
            'device_name' => 'Test Device',
            'problem' => 'Test Problem',
            'status' => 'Pending',
            'expected_return_date' => date('Y-m-d', strtotime('+1 day')),
            'user_id' => 99999, // Non-existent user ID
        ];

        $response = $this->post('/api/v1/jobs', $jobData);

        $response->assertStatus(422);
        $response->assertJSONFragment([
            'status' => 'error',
            'message' => 'Invalid customer ID provided'
        ]);
    }
}
