<?php

namespace App\Models;

use CodeIgniter\Model;

class TechnicianModel extends Model
{
    protected $table = 'technicians';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'contact_number', 'role'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'contact_number' => 'permit_empty|min_length[10]|max_length[20]',
        'role' => 'required|in_list[superadmin,admin,technician,user]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Technician name is required',
            'min_length' => 'Technician name must be at least 2 characters long',
            'max_length' => 'Technician name cannot exceed 100 characters'
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Email address cannot exceed 100 characters'
        ],
        'contact_number' => [
            'min_length' => 'Contact number must be at least 10 digits',
            'max_length' => 'Contact number cannot exceed 20 characters'
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list' => 'Role must be superadmin, admin, technician, or user'
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
     * Get technicians with job count
     */
    public function getTechniciansWithJobCount()
    {
        return $this->select('technicians.*, COUNT(jobs.id) as job_count, 
                            COUNT(CASE WHEN jobs.status = "Pending" THEN 1 END) as pending_jobs,
                            COUNT(CASE WHEN jobs.status = "In Progress" THEN 1 END) as in_progress_jobs,
                            COUNT(CASE WHEN jobs.status = "Completed" THEN 1 END) as completed_jobs')
                    ->join('jobs', 'jobs.technician_id = technicians.id', 'left')
                    ->groupBy('technicians.id')
                    ->orderBy('technicians.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Search technicians by name, email, or contact
     */
    public function searchTechnicians($search, $perPage = null)
    {
        $builder = $this->like('name', $search)
                    ->orLike('email', $search)
                    ->orLike('contact_number', $search)
                    ->orderBy('created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get available technicians (with least pending jobs)
     */
    public function getAvailableTechnicians($perPage = null)
    {
        $builder = $this->select('technicians.*, COUNT(CASE WHEN jobs.status IN ("Pending", "In Progress") THEN 1 END) as active_jobs')
                    ->join('jobs', 'jobs.technician_id = technicians.id', 'left')
                    ->groupBy('technicians.id')
                    ->orderBy('active_jobs', 'ASC')
                    ->orderBy('technicians.name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get technician statistics
     */
    public function getTechnicianStats()
    {
        $total = $this->countAll();
        
        return [
            'total' => $total
        ];
    }
}
