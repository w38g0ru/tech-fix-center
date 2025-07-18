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
        'name' => 'required|min_length[2]|max_length[100]',
        'mobile_number' => 'permit_empty|min_length[10]|max_length[20]',
        'user_type' => 'required|in_list[Registered,Walk-in]'
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

    /**
     * Search users by name or mobile
     */
    public function searchUsers($search, $perPage = null)
    {
        $builder = $this->like('name', $search)
                    ->orLike('mobile_number', $search)
                    ->orderBy('created_at', 'DESC');

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
        $total = $this->countAll();
        $registered = $this->where('user_type', 'Registered')->countAllResults();
        $walkIn = $this->where('user_type', 'Walk-in')->countAllResults();
        
        return [
            'total' => $total,
            'registered' => $registered,
            'walk_in' => $walkIn
        ];
    }
}
