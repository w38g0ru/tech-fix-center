<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceCenterModel extends Model
{
    protected $table = 'service_centers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'address', 'contact_person', 'phone', 'email', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'address' => 'permit_empty|max_length[500]',
        'contact_person' => 'permit_empty|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'status' => 'required|in_list[Active,Inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Service center name is required',
            'min_length' => 'Service center name must be at least 2 characters long',
            'max_length' => 'Service center name cannot exceed 100 characters'
        ],
        'address' => [
            'max_length' => 'Address cannot exceed 500 characters'
        ],
        'contact_person' => [
            'max_length' => 'Contact person name cannot exceed 100 characters'
        ],
        'phone' => [
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Email cannot exceed 100 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be Active or Inactive'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get active service centers
     */
    public function getActiveServiceCenters($perPage = null)
    {
        $builder = $this->where('status', 'Active')
                    ->orderBy('name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get service center statistics
     */
    public function getServiceCenterStats()
    {
        $total = $this->countAll();
        $active = $this->where('status', 'Active')->countAllResults();
        $inactive = $this->where('status', 'Inactive')->countAllResults();
        
        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive
        ];
    }

    /**
     * Search service centers
     */
    public function searchServiceCenters($search, $perPage = null)
    {
        $builder = $this->like('name', $search)
                    ->orLike('contact_person', $search)
                    ->orLike('phone', $search)
                    ->orLike('email', $search)
                    ->orderBy('name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get service centers with job counts
     */
    public function getServiceCentersWithJobCounts($perPage = null)
    {
        $builder = $this->select('service_centers.*, COUNT(jobs.id) as job_count')
                    ->join('jobs', 'jobs.service_center_id = service_centers.id', 'left')
                    ->groupBy('service_centers.id')
                    ->orderBy('service_centers.name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }
}
