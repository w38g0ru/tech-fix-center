<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * JobModel - Central model for job management with comprehensive relationships
 *
 * DATABASE RELATIONSHIPS:
 *
 * 1. MANY-TO-ONE RELATIONSHIPS:
 *    - jobs.user_id -> users.id (Customer relationship)
 *    - jobs.technician_id -> admin_users.id (Technician relationship)
 *    - jobs.service_center_id -> service_centers.id (Service Center relationship)
 *
 * 2. ONE-TO-MANY RELATIONSHIPS:
 *    - jobs.id -> photos.job_id (Job Photos)
 *    - jobs.id -> inventory_movements.job_id (Parts/Inventory Usage)
 *
 * 3. RELATIONSHIP METHODS:
 *    - getCustomer($jobId) - Get customer details
 *    - getTechnician($jobId) - Get assigned technician
 *    - getServiceCenter($jobId) - Get service center details
 *    - getPhotos($jobId) - Get all job photos
 *    - getInventoryMovements($jobId) - Get parts used
 *
 * 4. QUERY METHODS BY RELATIONSHIP:
 *    - getJobsByCustomer($customerId) - All jobs for a customer
 *    - getJobsByTechnician($technicianId) - All jobs for a technician
 *    - getJobsByServiceCenter($serviceCenterId) - All jobs at service center
 *
 * 5. UTILITY METHODS:
 *    - hasCustomer($jobId) - Check if job has customer
 *    - hasTechnician($jobId) - Check if technician assigned
 *    - hasServiceCenter($jobId) - Check if referred to service center
 *    - assignTechnician($jobId, $technicianId) - Assign technician
 *    - referToServiceCenter($jobId, $serviceCenterId) - Refer to service center
 *
 * 6. CUSTOMER TYPES:
 *    - Registered: user_id is set, customer data from users table
 *    - Walk-in: user_id is null, customer data in walk_in_customer_* fields
 *
 * 7. JOB STATUSES:
 *    - Pending, In Progress, Parts Pending
 *    - Referred to Service Center, Ready to Dispatch to Customer
 *    - Returned, Completed
 */
class JobModel extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'walk_in_customer_name', 'walk_in_customer_mobile', 'device_name', 'serial_number', 'problem',
        'technician_id', 'status', 'charge', 'service_center_id', 'expected_return_date'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'user_id' => 'permit_empty|is_natural_no_zero',
        'walk_in_customer_name' => 'permit_empty|max_length[100]',
        'device_name' => 'permit_empty|max_length[100]',
        'serial_number' => 'permit_empty|max_length[100]',
        'problem' => 'permit_empty',
        'technician_id' => 'permit_empty|is_natural_no_zero',
        'status' => 'required|in_list[Pending,In Progress,Parts Pending,Referred to Service Center,Ready to Dispatch to Customer,Returned,Completed]',
        'charge' => 'permit_empty|decimal',
        'service_center_id' => 'permit_empty|is_natural_no_zero',
        'expected_return_date' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'user_id' => [
            'is_natural_no_zero' => 'Please select a valid customer'
        ],
        'walk_in_customer_name' => [
            'max_length' => 'Walk-in customer name cannot exceed 100 characters'
        ],
        'device_name' => [
            'max_length' => 'Device name cannot exceed 100 characters'
        ],
        'serial_number' => [
            'max_length' => 'Serial number cannot exceed 100 characters'
        ],
        'technician_id' => [
            'is_natural_no_zero' => 'Please select a valid technician'
        ],
        'status' => [
            'required' => 'Job status is required',
            'in_list' => 'Please select a valid status'
        ],
        'service_center_id' => [
            'is_natural_no_zero' => 'Please select a valid service center',
            'required' => 'Service center is required when status is "Referred to Service Center"'
        ],
        'expected_return_date' => [
            'required' => 'Expected return date is required',
            'valid_date' => 'Please enter a valid expected return date'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    // ========================================
    // RELATIONSHIP METHODS
    // ========================================

    /**
     * Get the customer (user) associated with this job
     * Relationship: jobs.user_id -> users.id (Many-to-One)
     *
     * @param int $jobId
     * @return array|null
     */
    public function getCustomer($jobId)
    {
        $userModel = new \App\Models\UserModel();
        $job = $this->find($jobId);

        if (!$job || empty($job['user_id'])) {
            return null;
        }

        return $userModel->find($job['user_id']);
    }

    /**
     * Get the technician (admin_user) assigned to this job
     * Relationship: jobs.technician_id -> admin_users.id (Many-to-One)
     *
     * @param int $jobId
     * @return array|null
     */
    public function getTechnician($jobId)
    {
        $adminUserModel = new \App\Models\AdminUserModel();
        $job = $this->find($jobId);

        if (!$job || empty($job['technician_id'])) {
            return null;
        }

        return $adminUserModel->where('id', $job['technician_id'])
                             ->where('role', 'technician')
                             ->first();
    }

    /**
     * Get the service center associated with this job
     * Relationship: jobs.service_center_id -> service_centers.id (Many-to-One)
     *
     * @param int $jobId
     * @return array|null
     */
    public function getServiceCenter($jobId)
    {
        $serviceCenterModel = new \App\Models\ServiceCenterModel();
        $job = $this->find($jobId);

        if (!$job || empty($job['service_center_id'])) {
            return null;
        }

        return $serviceCenterModel->find($job['service_center_id']);
    }

    /**
     * Get all photos associated with this job
     * Relationship: jobs.id -> photos.job_id (One-to-Many)
     *
     * @param int $jobId
     * @return array
     */
    public function getPhotos($jobId)
    {
        $photoModel = new \App\Models\PhotoModel();

        return $photoModel->where('job_id', $jobId)
                         ->where('photo_type', 'Job')
                         ->orderBy('uploaded_at', 'DESC')
                         ->findAll();
    }

    /**
     * Get all inventory movements associated with this job
     * Relationship: jobs.id -> inventory_movements.job_id (One-to-Many)
     *
     * @param int $jobId
     * @return array
     */
    public function getInventoryMovements($jobId)
    {
        $movementModel = new \App\Models\InventoryMovementModel();

        return $movementModel->select('inventory_movements.*, inventory_items.name as item_name, inventory_items.part_number')
                            ->join('inventory_items', 'inventory_items.id = inventory_movements.item_id', 'left')
                            ->where('inventory_movements.job_id', $jobId)
                            ->orderBy('inventory_movements.moved_at', 'DESC')
                            ->findAll();
    }

    /**
     * Get complete job data with all relationships
     * Returns job with customer, technician, service center, photos, and inventory movements
     *
     * @param int $jobId
     * @return array|null
     */
    public function getJobWithAllRelations($jobId)
    {
        $job = $this->getJobWithDetails($jobId);

        if (!$job) {
            return null;
        }

        // Add relationship data
        $job['customer'] = $this->getCustomer($jobId);
        $job['technician'] = $this->getTechnician($jobId);
        $job['service_center'] = $this->getServiceCenter($jobId);
        $job['photos'] = $this->getPhotos($jobId);
        $job['inventory_movements'] = $this->getInventoryMovements($jobId);

        return $job;
    }

    /**
     * Get jobs by customer ID
     * Relationship: Find all jobs for a specific customer
     *
     * @param int $customerId
     * @param int|null $perPage
     * @return array
     */
    public function getJobsByCustomer($customerId, $perPage = null)
    {
        $builder = $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.user_id', $customerId)
                    ->orderBy('jobs.id', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get jobs by technician ID
     * Relationship: Find all jobs assigned to a specific technician
     *
     * @param int $technicianId
     * @param int|null $perPage
     * @return array
     */
    public function getJobsByTechnician($technicianId, $perPage = null)
    {
        $builder = $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.technician_id', $technicianId)
                    ->orderBy('jobs.id', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get jobs by service center ID
     * Relationship: Find all jobs referred to a specific service center
     *
     * @param int $serviceCenterId
     * @param int|null $perPage
     * @return array
     */
    public function getJobsByServiceCenter($serviceCenterId, $perPage = null)
    {
        $builder = $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.service_center_id', $serviceCenterId)
                    ->orderBy('jobs.id', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    // ========================================
    // REVERSE RELATIONSHIP METHODS
    // ========================================

    /**
     * Get all jobs for a specific customer (reverse relationship)
     * Called from UserModel: $userModel->getJobs($userId)
     *
     * @param int $userId
     * @return array
     */
    public function getJobsForUser($userId)
    {
        return $this->getJobsByCustomer($userId);
    }

    /**
     * Get all jobs for a specific technician (reverse relationship)
     * Called from AdminUserModel: $adminUserModel->getAssignedJobs($technicianId)
     *
     * @param int $technicianId
     * @return array
     */
    public function getJobsForTechnician($technicianId)
    {
        return $this->getJobsByTechnician($technicianId);
    }

    /**
     * Get all jobs for a specific service center (reverse relationship)
     * Called from ServiceCenterModel: $serviceCenterModel->getJobs($serviceCenterId)
     *
     * @param int $serviceCenterId
     * @return array
     */
    public function getJobsForServiceCenter($serviceCenterId)
    {
        return $this->getJobsByServiceCenter($serviceCenterId);
    }

    /**
     * Get jobs with customer and technician details
     */
    public function getJobsWithDetails($perPage = null)
    {
        $builder = $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, admin_users.phone as technician_contact,
                            service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->orderBy('jobs.id', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get job by ID with details
     */
    public function getJobWithDetails($id)
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number, users.user_type,
                            admin_users.full_name as technician_name, admin_users.phone as technician_contact,
                            service_centers.name as service_center_name, service_centers.contact_person as service_center_contact')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.id', $id)
                    ->first();
    }

    /**
     * Search jobs
     */
    public function searchJobs($search, $perPage = null)
    {
        $builder = $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->groupStart()
                        ->like('jobs.device_name', $search)
                        ->orLike('jobs.serial_number', $search)
                        ->orLike('users.name', $search)
                        ->orLike('admin_users.full_name', $search)
                    ->groupEnd()
                    ->orderBy('jobs.id', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get jobs by status
     */
    public function getJobsByStatus($status, $perPage = null)
    {
        $builder = $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->where('jobs.status', $status)
                    ->orderBy('jobs.id', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get job statistics
     */
    public function getJobStats()
    {
        $total = $this->countAll();
        $pending = $this->where('status', 'Pending')->countAllResults();
        $inProgress = $this->where('status', 'In Progress')->countAllResults();
        $partsPending = $this->where('status', 'Parts Pending')->countAllResults();
        $referredToService = $this->where('status', 'Referred to Service Center')->countAllResults();
        $readyToDispatch = $this->where('status', 'Ready to Dispatch to Customer')->countAllResults();
        $returned = $this->where('status', 'Returned')->countAllResults();
        $completed = $this->where('status', 'Completed')->countAllResults();

        return [
            'total' => $total,
            'pending' => $pending,
            'in_progress' => $inProgress,
            'parts_pending' => $partsPending,
            'referred_to_service' => $referredToService,
            'ready_to_dispatch' => $readyToDispatch,
            'returned' => $returned,
            'completed' => $completed
        ];
    }

    /**
     * Get recent jobs
     */
    public function getRecentJobs($limit = 10)
    {
        return $this->select('jobs.*, users.name as customer_name, admin_users.full_name as technician_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->orderBy('jobs.id', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get customer display name (handles walk-in customers)
     */
    public function getCustomerDisplayName($job)
    {
        if (!empty($job['walk_in_customer_name'])) {
            return $job['walk_in_customer_name'] . ' (Walk-in Customer)';
        } elseif (!empty($job['customer_name'])) {
            return $job['customer_name'];
        } else {
            return 'Walk-in Customer';
        }
    }

    /**
     * Get jobs by dispatch type
     */
    public function getJobsByDispatchType($dispatchType)
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.dispatch_type', $dispatchType)
                    ->orderBy('jobs.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get jobs at service centers
     */
    public function getJobsAtServiceCenters()
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.status', 'Referred to Service Center')
                    ->orderBy('jobs.dispatch_date', 'DESC')
                    ->findAll();
    }

    /**
     * Get overdue jobs from service centers
     */
    public function getOverdueJobsFromServiceCenters()
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            admin_users.full_name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.status', 'Referred to Service Center')
                    ->where('jobs.expected_return_date <', date('Y-m-d'))
                    ->orderBy('jobs.expected_return_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get all available job statuses
     */
    public function getJobStatuses()
    {
        return [
            'Pending' => 'Pending',
            'In Progress' => 'In Progress',
            'Parts Pending' => 'Parts Pending',
            'Referred to Service Center' => 'Referred to Service Center',
            'Ready to Dispatch to Customer' => 'Ready to Dispatch to Customer',
            'Returned' => 'Returned',
            'Completed' => 'Completed'
        ];
    }

    /**
     * Get dispatch types
     */
    public function getDispatchTypes()
    {
        return [
            'Customer' => 'Customer',
            'Service Center' => 'Service Center',
            'Other' => 'Other'
        ];
    }

    // ========================================
    // RELATIONSHIP UTILITY METHODS
    // ========================================

    /**
     * Check if job has a customer assigned
     *
     * @param int $jobId
     * @return bool
     */
    public function hasCustomer($jobId)
    {
        $job = $this->find($jobId);
        return $job && !empty($job['user_id']);
    }

    /**
     * Check if job has a technician assigned
     *
     * @param int $jobId
     * @return bool
     */
    public function hasTechnician($jobId)
    {
        $job = $this->find($jobId);
        return $job && !empty($job['technician_id']);
    }

    /**
     * Check if job is referred to a service center
     *
     * @param int $jobId
     * @return bool
     */
    public function hasServiceCenter($jobId)
    {
        $job = $this->find($jobId);
        return $job && !empty($job['service_center_id']);
    }

    /**
     * Check if job has photos
     *
     * @param int $jobId
     * @return bool
     */
    public function hasPhotos($jobId)
    {
        $photos = $this->getPhotos($jobId);
        return !empty($photos);
    }

    /**
     * Check if job has inventory movements
     *
     * @param int $jobId
     * @return bool
     */
    public function hasInventoryMovements($jobId)
    {
        $movements = $this->getInventoryMovements($jobId);
        return !empty($movements);
    }

    /**
     * Assign technician to job
     *
     * @param int $jobId
     * @param int $technicianId
     * @return bool
     */
    public function assignTechnician($jobId, $technicianId)
    {
        // Verify technician exists and has correct role
        $adminUserModel = new \App\Models\AdminUserModel();
        $technician = $adminUserModel->where('id', $technicianId)
                                   ->where('role', 'technician')
                                   ->where('status', 'active')
                                   ->first();

        if (!$technician) {
            return false;
        }

        return $this->update($jobId, ['technician_id' => $technicianId]);
    }

    /**
     * Refer job to service center
     *
     * @param int $jobId
     * @param int $serviceCenterId
     * @return bool
     */
    public function referToServiceCenter($jobId, $serviceCenterId)
    {
        // Verify service center exists and is active
        $serviceCenterModel = new \App\Models\ServiceCenterModel();
        $serviceCenter = $serviceCenterModel->where('id', $serviceCenterId)
                                          ->where('status', 'Active')
                                          ->first();

        if (!$serviceCenter) {
            return false;
        }

        return $this->update($jobId, [
            'service_center_id' => $serviceCenterId,
            'status' => 'Referred to Service Center'
        ]);
    }

    /**
     * Get job statistics by relationship
     *
     * @return array
     */
    public function getRelationshipStats()
    {
        $total = $this->countAll();
        $withCustomers = $this->where('user_id IS NOT NULL')->countAllResults();
        $walkInCustomers = $this->where('user_id IS NULL')->countAllResults();
        $withTechnicians = $this->where('technician_id IS NOT NULL')->countAllResults();
        $withServiceCenters = $this->where('service_center_id IS NOT NULL')->countAllResults();

        return [
            'total_jobs' => $total,
            'registered_customers' => $withCustomers,
            'walk_in_customers' => $walkInCustomers,
            'assigned_technicians' => $withTechnicians,
            'referred_to_service_centers' => $withServiceCenters,
            'unassigned_technicians' => $total - $withTechnicians,
            'not_referred' => $total - $withServiceCenters
        ];
    }

    /**
     * Get jobs with missing relationships (for data integrity checks)
     *
     * @return array
     */
    public function getJobsWithMissingRelationships()
    {
        return [
            'no_customer_info' => $this->where('user_id IS NULL')
                                      ->where('walk_in_customer_name IS NULL OR walk_in_customer_name = ""')
                                      ->findAll(),
            'no_technician' => $this->where('technician_id IS NULL')
                                   ->where('status !=', 'Pending')
                                   ->findAll(),
            'referred_but_no_service_center' => $this->where('status', 'Referred to Service Center')
                                                    ->where('service_center_id IS NULL')
                                                    ->findAll()
        ];
    }
}
