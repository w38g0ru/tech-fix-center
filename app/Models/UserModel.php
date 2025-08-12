<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'mobile_number', 'user_type'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'name' => [
            'label' => 'Name',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        'mobile_number' => [
            'label' => 'Mobile Number',
            'rules' => 'permit_empty|min_length[10]|max_length[20]'
        ],
        'user_type' => [
            'label' => 'User Type',
            'rules' => 'required|in_list[Registered,Walk-in]'
        ]
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Customer name is required',
            'min_length' => 'Customer name must be at least 2 characters long',
            'max_length' => 'Customer name cannot exceed 100 characters'
        ],
        'mobile_number' => [
            'min_length' => 'Mobile number must be at least 10 digits',
            'max_length' => 'Mobile number cannot exceed 20 characters'
        ],
        'user_type' => [
            'required' => 'User type is required',
            'in_list' => 'User type must be either Registered or Walk-in'
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
     * Get user with their jobs
     * Relationship: users.id -> jobs.user_id (One-to-Many)
     */
    public function getUserWithJobs($userId)
    {
        $user = $this->find($userId);
        if (!$user) {
            return null;
        }

        $jobModel = new \App\Models\JobModel();
        $user['jobs'] = $jobModel->where('user_id', $userId)->findAll();

        return $user;
    }

    /**
     * Get users with job counts
     */
    public function getUsersWithJobCounts($perPage = null)
    {
        $builder = $this->select('users.*, COUNT(jobs.id) as job_count')
                        ->join('jobs', 'jobs.user_id = users.id', 'left')
                        ->groupBy('users.id')
                        ->orderBy('users.created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get registered users only
     */
    public function getRegisteredUsers($perPage = null)
    {
        $builder = $this->where('user_type', 'Registered')
                        ->orderBy('name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Search users by name or mobile
     */
    public function searchUsers($search, $perPage = null)
    {
        $builder = $this->groupStart()
                        ->like('name', $search)
                        ->orLike('mobile_number', $search)
                        ->groupEnd()
                        ->orderBy('name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        $totalUsers = $this->countAll();
        $registeredUsers = $this->where('user_type', 'Registered')->countAllResults();
        $walkInUsers = $this->where('user_type', 'Walk-in')->countAllResults();

        return [
            'total_users' => $totalUsers,
            'registered_users' => $registeredUsers,
            'walk_in_users' => $walkInUsers
        ];
    }

    /**
     * Get recent users
     */
    public function getRecentUsers($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Find or create walk-in customer
     */
    public function findOrCreateWalkInCustomer($name = null, $mobile = null)
    {
        // If both name and mobile are provided, try to find existing
        if ($name && $mobile) {
            $existing = $this->where('name', $name)
                             ->where('mobile_number', $mobile)
                             ->where('user_type', 'Walk-in')
                             ->first();

            if ($existing) {
                return $existing;
            }
        }

        // Create new walk-in customer
        $data = [
            'name' => $name ?: 'Walk-in Customer',
            'mobile_number' => $mobile,
            'user_type' => 'Walk-in'
        ];

        $userId = $this->insert($data);
        return $this->find($userId);
    }

    /**
     * Get users with job count
     */
    public function getUsersWithJobCount($perPage = null)
    {
        $builder = $this->select('users.*, COUNT(jobs.id) as job_count')
                    ->join('jobs', 'jobs.user_id = users.id', 'left')
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }





    // ========================================
    // RELATIONSHIP METHODS
    // ========================================

    /**
     * Get all jobs for a specific user
     * Relationship: users.id -> jobs.user_id (One-to-Many)
     *
     * @param int $userId
     * @param int|null $perPage
     * @return array
     */
    public function getJobs($userId, $perPage = null)
    {
        $jobModel = new \App\Models\JobModel();
        return $jobModel->getJobsByCustomer($userId, $perPage);
    }

    /**
     * Get user with job statistics
     *
     * @param int $userId
     * @return array|null
     */
    public function getUserWithJobStats($userId)
    {
        $user = $this->find($userId);
        if (!$user) {
            return null;
        }

        $jobModel = new \App\Models\JobModel();

        // Get job statistics
        $totalJobs = $jobModel->where('user_id', $userId)->countAllResults();
        $completedJobs = $jobModel->where('user_id', $userId)->where('status', 'Completed')->countAllResults();
        $pendingJobs = $jobModel->where('user_id', $userId)->whereNotIn('status', ['Completed', 'Returned'])->countAllResults();

        // Get total spent
        $totalSpent = $jobModel->select('SUM(charge) as total')
                              ->where('user_id', $userId)
                              ->where('status', 'Completed')
                              ->first();

        $user['job_stats'] = [
            'total_jobs' => $totalJobs,
            'completed_jobs' => $completedJobs,
            'pending_jobs' => $pendingJobs,
            'total_spent' => $totalSpent['total'] ?? 0
        ];

        return $user;
    }

    /**
     * Get top customers by job count or revenue
     *
     * @param string $sortBy ('jobs' or 'revenue')
     * @param int $limit
     * @return array
     */
    public function getTopCustomers($sortBy = 'jobs', $limit = 10)
    {
        $orderBy = $sortBy === 'revenue' ? 'total_spent DESC' : 'total_jobs DESC';

        return $this->select('users.*,
                        COUNT(jobs.id) as total_jobs,
                        COUNT(CASE WHEN jobs.status = "Completed" THEN 1 END) as completed_jobs,
                        SUM(CASE WHEN jobs.status = "Completed" THEN jobs.charge ELSE 0 END) as total_spent')
                    ->join('jobs', 'jobs.user_id = users.id', 'inner')
                    ->groupBy('users.id')
                    ->orderBy($orderBy)
                    ->limit($limit)
                    ->findAll();
    }
}
