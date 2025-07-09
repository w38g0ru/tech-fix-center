<?php

namespace App\Models;

use CodeIgniter\Model;

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
        'technician_id', 'status', 'charge', 'dispatch_type', 'service_center_id',
        'dispatch_date', 'nepali_date', 'expected_return_date', 'actual_return_date',
        'dispatch_notes'
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
        'dispatch_type' => 'permit_empty|in_list[Customer,Service Center,Other]',
        'service_center_id' => 'permit_empty|is_natural_no_zero',
        'dispatch_date' => 'permit_empty|valid_date',
        'nepali_date' => 'permit_empty|max_length[20]',
        'expected_return_date' => 'permit_empty|valid_date',
        'actual_return_date' => 'permit_empty|valid_date',
        'dispatch_notes' => 'permit_empty|max_length[1000]'
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
        'dispatch_type' => [
            'in_list' => 'Please select a valid dispatch type'
        ],
        'service_center_id' => [
            'is_natural_no_zero' => 'Please select a valid service center'
        ],
        'dispatch_date' => [
            'valid_date' => 'Please enter a valid dispatch date'
        ],
        'nepali_date' => [
            'max_length' => 'Nepali date cannot exceed 20 characters'
        ],
        'expected_return_date' => [
            'valid_date' => 'Please enter a valid expected return date'
        ],
        'actual_return_date' => [
            'valid_date' => 'Please enter a valid actual return date'
        ],
        'dispatch_notes' => [
            'max_length' => 'Dispatch notes cannot exceed 1000 characters'
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

    /**
     * Get jobs with customer and technician details
     */
    public function getJobsWithDetails()
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            technicians.name as technician_name, technicians.contact_number as technician_contact,
                            service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->orderBy('jobs.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get job by ID with details
     */
    public function getJobWithDetails($id)
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number, users.user_type,
                            technicians.name as technician_name, technicians.contact_number as technician_contact,
                            service_centers.name as service_center_name, service_centers.contact_person as service_center_contact')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.id', $id)
                    ->first();
    }

    /**
     * Search jobs
     */
    public function searchJobs($search)
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number, 
                            technicians.name as technician_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->groupStart()
                        ->like('jobs.device_name', $search)
                        ->orLike('jobs.serial_number', $search)
                        ->orLike('users.name', $search)
                        ->orLike('technicians.name', $search)
                    ->groupEnd()
                    ->orderBy('jobs.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get jobs by status
     */
    public function getJobsByStatus($status)
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number, 
                            technicians.name as technician_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->where('jobs.status', $status)
                    ->orderBy('jobs.created_at', 'DESC')
                    ->findAll();
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
        return $this->select('jobs.*, users.name as customer_name, technicians.name as technician_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->orderBy('jobs.created_at', 'DESC')
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
                            technicians.name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->join('service_centers', 'service_centers.id = jobs.service_center_id', 'left')
                    ->where('jobs.dispatch_type', $dispatchType)
                    ->orderBy('jobs.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get jobs at service centers
     */
    public function getJobsAtServiceCenters()
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number,
                            technicians.name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
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
                            technicians.name as technician_name, service_centers.name as service_center_name')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
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
}
