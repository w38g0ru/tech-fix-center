<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferredModel extends Model
{
    protected $table = 'referred';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['customer_name', 'customer_phone', 'device_name', 'problem_description', 'referred_to', 'status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'customer_name' => 'required|min_length[2]|max_length[100]',
        'customer_phone' => 'permit_empty|min_length[10]|max_length[20]',
        'device_name' => 'permit_empty|max_length[100]',
        'problem_description' => 'permit_empty',
        'referred_to' => 'permit_empty|max_length[100]',
        'status' => 'required|in_list[Pending,Dispatched,Completed]'
    ];

    protected $validationMessages = [
        'customer_name' => [
            'required' => 'Customer name is required',
            'min_length' => 'Customer name must be at least 2 characters long',
            'max_length' => 'Customer name cannot exceed 100 characters'
        ],
        'customer_phone' => [
            'min_length' => 'Phone number must be at least 10 digits',
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be Pending, Dispatched, or Completed'
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
     * Get referred items with photo count
     */
    public function getReferredWithPhotos()
    {
        return $this->select('referred.*, COUNT(photos.id) as photo_count')
                    ->join('photos', 'photos.referred_id = referred.id', 'left')
                    ->groupBy('referred.id')
                    ->orderBy('referred.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Search referred items
     */
    public function searchReferred($search)
    {
        return $this->like('customer_name', $search)
                    ->orLike('customer_phone', $search)
                    ->orLike('device_name', $search)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get referred items by status
     */
    public function getReferredByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get referred statistics
     */
    public function getReferredStats()
    {
        $total = $this->countAll();
        $pending = $this->where('status', 'Pending')->countAllResults();
        $dispatched = $this->where('status', 'Dispatched')->countAllResults();
        $completed = $this->where('status', 'Completed')->countAllResults();
        
        return [
            'total' => $total,
            'pending' => $pending,
            'dispatched' => $dispatched,
            'completed' => $completed
        ];
    }
}
