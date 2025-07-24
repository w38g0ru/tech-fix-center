<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\AdminUserModel;
use App\Models\ServiceCenterModel;
use App\Libraries\SmsService;

/**
 * Jobs API Controller
 * 
 * Clean, efficient controller for managing jobs with comprehensive relationships
 * Leverages model relationships with admin_users, users, and service_centers
 * Includes proper validation, error handling, and structured JSON responses
 */
class JobsController extends ResourceController
{
    use ResponseTrait;

    protected $jobModel;
    protected $userModel;
    protected $adminUserModel;
    protected $serviceCenterModel;
    protected $smsService;
    protected $format = 'json';

    /**
     * Constructor with dependency injection
     */
    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->userModel = new UserModel();
        $this->adminUserModel = new AdminUserModel();
        $this->serviceCenterModel = new ServiceCenterModel();
        $this->smsService = new SmsService();
        
        helper(['auth', 'nepali_date']);
    }

    /**
     * List jobs with related data and pagination
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        try {
            $perPage = $this->request->getGet('per_page') ?? 15;
            $page = $this->request->getGet('page') ?? 1;
            $filters = $this->getFilters();

            // Get jobs with comprehensive analytics
            if (!empty($filters)) {
                $jobs = $this->jobModel->getJobsWithAnalytics($filters);
                $paginatedJobs = $this->paginateArray($jobs, $perPage, $page);
            } else {
                $paginatedJobs = $this->jobModel->getJobsWithDetails($perPage);
            }

            // Get summary statistics
            $stats = $this->jobModel->getJobPerformanceMetrics($filters);

            return $this->respond([
                'status' => 'success',
                'message' => 'Jobs retrieved successfully',
                'data' => [
                    'jobs' => $paginatedJobs['data'] ?? $paginatedJobs,
                    'pagination' => $paginatedJobs['pager'] ?? null,
                    'statistics' => $stats,
                    'filters_applied' => $filters
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Jobs index error: ' . $e->getMessage());
            return $this->failServerError('Failed to retrieve jobs: ' . $e->getMessage());
        }
    }

    /**
     * Show a single job with all related data
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function show($id = null)
    {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->failValidationError('Invalid job ID provided');
            }

            // Get job with all relationships
            $job = $this->jobModel->getJobWithAllRelations($id);

            if (!$job) {
                return $this->failNotFound('Job not found');
            }

            // Add additional context data
            $job['can_edit'] = $this->canEditJob($job);
            $job['can_delete'] = $this->canDeleteJob($job);
            $job['status_history'] = $this->getJobStatusHistory($id);

            return $this->respond([
                'status' => 'success',
                'message' => 'Job retrieved successfully',
                'data' => $job
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Job show error: ' . $e->getMessage());
            return $this->failServerError('Failed to retrieve job: ' . $e->getMessage());
        }
    }

    /**
     * Create a new job with proper validation
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function create()
    {
        try {
            $data = $this->request->getJSON(true) ?? $this->request->getPost();

            if (empty($data)) {
                return $this->failValidationError('No data provided');
            }

            // Validate and prepare job data
            $jobData = $this->prepareJobData($data);
            
            // Validate foreign key relationships
            $validationResult = $this->validateRelationships($jobData);
            if (!$validationResult['valid']) {
                return $this->failValidationError($validationResult['message']);
            }

            // Validate using JobModel
            if (!$this->jobModel->validate($jobData)) {
                return $this->failValidationError($this->jobModel->errors());
            }

            // Create the job
            $jobId = $this->jobModel->insert($jobData);

            if (!$jobId) {
                return $this->failServerError('Failed to create job');
            }

            // Send SMS notification (if applicable)
            $this->sendJobCreationNotification($jobId, $jobData);

            // Get the created job with all relationships
            $createdJob = $this->jobModel->getJobWithAllRelations($jobId);

            return $this->respondCreated([
                'status' => 'success',
                'message' => 'Job created successfully',
                'data' => $createdJob
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Job creation error: ' . $e->getMessage());
            return $this->failServerError('Failed to create job: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing job
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null)
    {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->failValidationError('Invalid job ID provided');
            }

            // Check if job exists
            $existingJob = $this->jobModel->find($id);
            if (!$existingJob) {
                return $this->failNotFound('Job not found');
            }

            $data = $this->request->getJSON(true) ?? $this->request->getPost();

            if (empty($data)) {
                return $this->failValidationError('No data provided');
            }

            // Prepare job data
            $jobData = $this->prepareJobData($data, $id);

            // Validate foreign key relationships
            $validationResult = $this->validateRelationships($jobData);
            if (!$validationResult['valid']) {
                return $this->failValidationError($validationResult['message']);
            }

            // Validate using JobModel
            if (!$this->jobModel->validate($jobData)) {
                return $this->failValidationError($this->jobModel->errors());
            }

            // Store old status for SMS notification
            $oldStatus = $existingJob['status'];

            // Update the job
            if (!$this->jobModel->update($id, $jobData)) {
                return $this->failServerError('Failed to update job');
            }

            // Send SMS notification for status changes
            if (isset($jobData['status']) && $jobData['status'] !== $oldStatus) {
                $this->sendStatusChangeNotification($id, $jobData, $oldStatus);
            }

            // Get the updated job with all relationships
            $updatedJob = $this->jobModel->getJobWithAllRelations($id);

            return $this->respond([
                'status' => 'success',
                'message' => 'Job updated successfully',
                'data' => $updatedJob
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Job update error: ' . $e->getMessage());
            return $this->failServerError('Failed to update job: ' . $e->getMessage());
        }
    }

    /**
     * Delete a job (soft delete if implemented)
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id = null)
    {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->failValidationError('Invalid job ID provided');
            }

            $job = $this->jobModel->find($id);
            if (!$job) {
                return $this->failNotFound('Job not found');
            }

            // Check if job can be deleted
            if (!$this->canDeleteJob($job)) {
                return $this->failForbidden('Job cannot be deleted due to business rules');
            }

            if (!$this->jobModel->delete($id)) {
                return $this->failServerError('Failed to delete job');
            }

            return $this->respondDeleted([
                'status' => 'success',
                'message' => 'Job deleted successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Job deletion error: ' . $e->getMessage());
            return $this->failServerError('Failed to delete job: ' . $e->getMessage());
        }
    }

    // ========================================
    // ADDITIONAL API ENDPOINTS
    // ========================================

    /**
     * Get jobs requiring attention (overdue, unassigned, etc.)
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function attention()
    {
        try {
            $attentionJobs = $this->jobModel->getJobsRequiringAttention();

            return $this->respond([
                'status' => 'success',
                'message' => 'Jobs requiring attention retrieved successfully',
                'data' => $attentionJobs
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Jobs attention error: ' . $e->getMessage());
            return $this->failServerError('Failed to retrieve attention jobs: ' . $e->getMessage());
        }
    }

    /**
     * Get job performance metrics
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function metrics()
    {
        try {
            $filters = $this->getFilters();
            $metrics = $this->jobModel->getJobPerformanceMetrics($filters);

            return $this->respond([
                'status' => 'success',
                'message' => 'Job metrics retrieved successfully',
                'data' => $metrics
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Job metrics error: ' . $e->getMessage());
            return $this->failServerError('Failed to retrieve job metrics: ' . $e->getMessage());
        }
    }

    /**
     * Assign technician to job
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function assignTechnician($id = null)
    {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->failValidationError('Invalid job ID provided');
            }

            $data = $this->request->getJSON(true) ?? $this->request->getPost();
            $technicianId = $data['technician_id'] ?? null;

            if (!$technicianId) {
                return $this->failValidationError('Technician ID is required');
            }

            // Validate technician exists and is active
            $technician = $this->adminUserModel->where('id', $technicianId)
                                              ->where('role', 'technician')
                                              ->where('status', 'active')
                                              ->first();

            if (!$technician) {
                return $this->failValidationError('Invalid or inactive technician');
            }

            // Assign technician using model method
            if (!$this->jobModel->assignTechnician($id, $technicianId)) {
                return $this->failServerError('Failed to assign technician');
            }

            // Get updated job
            $updatedJob = $this->jobModel->getJobWithAllRelations($id);

            return $this->respond([
                'status' => 'success',
                'message' => 'Technician assigned successfully',
                'data' => $updatedJob
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Technician assignment error: ' . $e->getMessage());
            return $this->failServerError('Failed to assign technician: ' . $e->getMessage());
        }
    }

    /**
     * Refer job to service center
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function referToServiceCenter($id = null)
    {
        try {
            if (!$id || !is_numeric($id)) {
                return $this->failValidationError('Invalid job ID provided');
            }

            $data = $this->request->getJSON(true) ?? $this->request->getPost();
            $serviceCenterId = $data['service_center_id'] ?? null;

            if (!$serviceCenterId) {
                return $this->failValidationError('Service center ID is required');
            }

            // Validate service center exists and is active
            $serviceCenter = $this->serviceCenterModel->where('id', $serviceCenterId)
                                                    ->where('status', 'Active')
                                                    ->first();

            if (!$serviceCenter) {
                return $this->failValidationError('Invalid or inactive service center');
            }

            // Refer to service center using model method
            if (!$this->jobModel->referToServiceCenter($id, $serviceCenterId)) {
                return $this->failServerError('Failed to refer to service center');
            }

            // Get updated job
            $updatedJob = $this->jobModel->getJobWithAllRelations($id);

            return $this->respond([
                'status' => 'success',
                'message' => 'Job referred to service center successfully',
                'data' => $updatedJob
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Service center referral error: ' . $e->getMessage());
            return $this->failServerError('Failed to refer to service center: ' . $e->getMessage());
        }
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    /**
     * Get filters from request parameters
     *
     * @return array
     */
    private function getFilters()
    {
        $filters = [];

        // Status filter
        if ($status = $this->request->getGet('status')) {
            $filters['status'] = $status;
        }

        // Technician filter
        if ($technicianId = $this->request->getGet('technician_id')) {
            $filters['technician_id'] = $technicianId;
        }

        // Service center filter
        if ($serviceCenterId = $this->request->getGet('service_center_id')) {
            $filters['service_center_id'] = $serviceCenterId;
        }

        // Date filters
        if ($dateFrom = $this->request->getGet('date_from')) {
            $filters['date_from'] = $dateFrom;
        }

        if ($dateTo = $this->request->getGet('date_to')) {
            $filters['date_to'] = $dateTo;
        }

        // Overdue filter
        if ($this->request->getGet('overdue_only') === 'true') {
            $filters['overdue_only'] = true;
        }

        return $filters;
    }

    /**
     * Prepare job data for insert/update
     *
     * @param array $data
     * @param int|null $jobId
     * @return array
     */
    private function prepareJobData($data, $jobId = null)
    {
        $jobData = [];

        // Required fields
        $requiredFields = ['device_name', 'problem', 'status', 'expected_return_date'];
        foreach ($requiredFields as $field) {
            if (isset($data[$field])) {
                $jobData[$field] = $data[$field];
            }
        }

        // Optional fields
        $optionalFields = [
            'user_id', 'walk_in_customer_name', 'walk_in_customer_mobile',
            'serial_number', 'technician_id', 'charge', 'service_center_id'
        ];

        foreach ($optionalFields as $field) {
            if (isset($data[$field])) {
                $jobData[$field] = $data[$field] ?: null;
            }
        }

        // Handle customer type logic
        if (!empty($data['user_id'])) {
            // Registered customer
            $jobData['user_id'] = $data['user_id'];
            $jobData['walk_in_customer_name'] = null;
            $jobData['walk_in_customer_mobile'] = null;
        } else {
            // Walk-in customer
            $jobData['user_id'] = null;
            $jobData['walk_in_customer_name'] = $data['walk_in_customer_name'] ?? null;
            $jobData['walk_in_customer_mobile'] = $data['walk_in_customer_mobile'] ?? null;
        }

        return $jobData;
    }

    /**
     * Validate foreign key relationships
     *
     * @param array $jobData
     * @return array
     */
    private function validateRelationships($jobData)
    {
        // Validate user_id if provided
        if (!empty($jobData['user_id'])) {
            $user = $this->userModel->find($jobData['user_id']);
            if (!$user) {
                return ['valid' => false, 'message' => 'Invalid customer ID provided'];
            }
        }

        // Validate technician_id if provided
        if (!empty($jobData['technician_id'])) {
            $technician = $this->adminUserModel->where('id', $jobData['technician_id'])
                                              ->where('role', 'technician')
                                              ->where('status', 'active')
                                              ->first();
            if (!$technician) {
                return ['valid' => false, 'message' => 'Invalid or inactive technician ID provided'];
            }
        }

        // Validate service_center_id if provided
        if (!empty($jobData['service_center_id'])) {
            $serviceCenter = $this->serviceCenterModel->where('id', $jobData['service_center_id'])
                                                    ->where('status', 'Active')
                                                    ->first();
            if (!$serviceCenter) {
                return ['valid' => false, 'message' => 'Invalid or inactive service center ID provided'];
            }
        }

        // Validate status-specific requirements
        if ($jobData['status'] === 'Referred to Service Center' && empty($jobData['service_center_id'])) {
            return ['valid' => false, 'message' => 'Service center is required when status is "Referred to Service Center"'];
        }

        return ['valid' => true, 'message' => 'All relationships are valid'];
    }

    /**
     * Paginate array data
     *
     * @param array $data
     * @param int $perPage
     * @param int $page
     * @return array
     */
    private function paginateArray($data, $perPage, $page)
    {
        $total = count($data);
        $offset = ($page - 1) * $perPage;
        $paginatedData = array_slice($data, $offset, $perPage);

        return [
            'data' => $paginatedData,
            'pager' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage),
                'has_next' => $page < ceil($total / $perPage),
                'has_previous' => $page > 1
            ]
        ];
    }

    /**
     * Check if job can be edited
     *
     * @param array $job
     * @return bool
     */
    private function canEditJob($job)
    {
        // Business logic for edit permissions
        if ($job['status'] === 'Completed') {
            return false; // Completed jobs cannot be edited
        }

        // Add more business rules as needed
        return true;
    }

    /**
     * Check if job can be deleted
     *
     * @param array $job
     * @return bool
     */
    private function canDeleteJob($job)
    {
        // Business logic for delete permissions
        if (in_array($job['status'], ['Completed', 'In Progress'])) {
            return false; // Cannot delete completed or in-progress jobs
        }

        // Check if job has related data (photos, inventory movements)
        if ($this->jobModel->hasPhotos($job['id']) || $this->jobModel->hasInventoryMovements($job['id'])) {
            return false; // Cannot delete jobs with related data
        }

        return true;
    }

    /**
     * Get job status history (placeholder - implement based on your audit system)
     *
     * @param int $jobId
     * @return array
     */
    private function getJobStatusHistory($jobId)
    {
        // This would typically come from an audit log table
        // For now, return empty array
        return [];
    }

    /**
     * Send job creation notification
     *
     * @param int $jobId
     * @param array $jobData
     * @return void
     */
    private function sendJobCreationNotification($jobId, $jobData)
    {
        try {
            // Get current user's email to check if it's anish@anish.com.np
            $currentUser = session()->get('user');
            if ($currentUser && $currentUser['email'] === 'anish@anish.com.np') {
                return; // Don't send SMS
            }

            // Get admin phone number
            $admin = $this->adminUserModel
                ->where('email', 'anish@anish.com.np')
                ->orWhere('role', 'admin')
                ->where('phone IS NOT NULL')
                ->where('phone !=', '')
                ->first();

            if (!$admin || empty($admin['phone'])) {
                return;
            }

            // Get customer name
            $customerName = 'Walk-in Customer';
            if (!empty($jobData['user_id'])) {
                $customer = $this->userModel->find($jobData['user_id']);
                $customerName = $customer ? $customer['name'] : 'Registered Customer';
            } elseif (!empty($jobData['walk_in_customer_name'])) {
                $customerName = $jobData['walk_in_customer_name'] . ' (Walk-in)';
            }

            // Compose SMS message
            $currentDateTime = formatNepaliDateTime(date('Y-m-d H:i:s'), 'short');

            $message = "New Job Created!\n";
            $message .= "Job ID: #{$jobId}\n";
            $message .= "Customer: {$customerName}\n";
            $message .= "Device: " . ($jobData['device_name'] ?? 'N/A') . "\n";
            $message .= "Problem: " . (substr($jobData['problem'] ?? 'N/A', 0, 50)) . "\n";
            $message .= "Status: " . ($jobData['status'] ?? 'N/A') . "\n";
            $message .= "Time: {$currentDateTime}\n";
            $message .= "- TeknoPhix";

            $this->smsService->send($admin['phone'], $message);

        } catch (\Exception $e) {
            log_message('error', "Job creation SMS error for job #{$jobId}: " . $e->getMessage());
        }
    }

    /**
     * Send status change notification
     *
     * @param int $jobId
     * @param array $jobData
     * @param string $oldStatus
     * @return void
     */
    private function sendStatusChangeNotification($jobId, $jobData, $oldStatus)
    {
        try {
            // Send SMS if status changed to "Ready to Dispatch to Customer"
            if ($jobData['status'] === 'Ready to Dispatch to Customer') {
                $job = $this->jobModel->find($jobId);
                $customerPhone = null;

                // Get customer phone number
                if (!empty($job['user_id'])) {
                    $customer = $this->userModel->find($job['user_id']);
                    $customerPhone = $customer['mobile_number'] ?? null;
                } elseif (!empty($job['walk_in_customer_mobile'])) {
                    $customerPhone = $job['walk_in_customer_mobile'];
                }

                if ($customerPhone) {
                    $message = "Your service is ready in Infotech Infotech Suppliers & Traders, Gaighat., please pick up. –";
                    $this->smsService->send($customerPhone, $message);
                }
            }

        } catch (\Exception $e) {
            log_message('error', "Status change SMS error for job #{$jobId}: " . $e->getMessage());
        }
    }
}
