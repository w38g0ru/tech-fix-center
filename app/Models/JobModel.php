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
    protected $allowedFields = ['user_id', 'device_name', 'serial_number', 'problem', 'technician_id', 'status', 'charge'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'user_id' => 'permit_empty|is_natural_no_zero',
        'device_name' => 'permit_empty|max_length[100]',
        'serial_number' => 'permit_empty|max_length[100]',
        'problem' => 'permit_empty',
        'technician_id' => 'permit_empty|is_natural_no_zero',
        'status' => 'required|in_list[Pending,In Progress,Completed]',
        'charge' => 'permit_empty|decimal'
    ];

    protected $validationMessages = [
        'user_id' => [
            'is_natural_no_zero' => 'Please select a valid customer'
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
            'in_list' => 'Status must be Pending, In Progress, or Completed'
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
                            technicians.name as technician_name, technicians.contact_number as technician_contact')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
                    ->orderBy('jobs.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get job by ID with details
     */
    public function getJobWithDetails($id)
    {
        return $this->select('jobs.*, users.name as customer_name, users.mobile_number, users.user_type,
                            technicians.name as technician_name, technicians.contact_number as technician_contact')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('technicians', 'technicians.id = jobs.technician_id', 'left')
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
        $completed = $this->where('status', 'Completed')->countAllResults();
        
        return [
            'total' => $total,
            'pending' => $pending,
            'in_progress' => $inProgress,
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
}
