<?php

namespace App\Models;

use CodeIgniter\Model;

class PhotoModel extends Model
{
    protected $table = 'photos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['job_id', 'referred_id', 'inventory_id', 'photo_type', 'file_name', 'description', 'uploaded_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'uploaded_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'photo_type' => [
            'label' => 'Photo Type',
            'rules' => 'required|in_list[Job,Dispatch,Received,Inventory]'
        ],
        'file_name' => [
            'label' => 'File Name',
            'rules' => 'required|max_length[255]'
        ],
        'description' => [
            'label' => 'Description',
            'rules' => 'permit_empty|max_length[255]'
        ],
        'job_id' => [
            'label' => 'Job',
            'rules' => 'permit_empty|is_natural_no_zero'
        ],
        'referred_id' => [
            'label' => 'Referred Job',
            'rules' => 'permit_empty|is_natural_no_zero'
        ],
        'inventory_id' => [
            'label' => 'Inventory Item',
            'rules' => 'permit_empty|is_natural_no_zero'
        ]
    ];

    protected $validationMessages = [
        'photo_type' => [
            'required' => 'Photo type is required',
            'in_list' => 'Photo type must be Job, Dispatch, Received, or Inventory'
        ],
        'file_name' => [
            'required' => 'File name is required',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 255 characters'
        ],
        'job_id' => [
            'is_natural_no_zero' => 'Please select a valid job'
        ],
        'referred_id' => [
            'is_natural_no_zero' => 'Please select a valid referred job'
        ],
        'inventory_id' => [
            'is_natural_no_zero' => 'Please select a valid inventory item'
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
     * Get photos by job ID
     */
    public function getPhotosByJob($jobId, $perPage = null)
    {
        $builder = $this->where('job_id', $jobId)
                    ->orderBy('uploaded_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get photos by referred ID
     */
    public function getPhotosByReferred($referredId, $perPage = null)
    {
        $builder = $this->where('referred_id', $referredId)
                    ->orderBy('uploaded_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get photos by inventory ID
     */
    public function getPhotosByInventory($inventoryId, $perPage = null)
    {
        $builder = $this->where('inventory_id', $inventoryId)
                    ->orderBy('uploaded_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get photos by type
     */
    public function getPhotosByType($type)
    {
        return $this->where('photo_type', $type)
                    ->orderBy('uploaded_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get recent photos with related data
     */
    public function getRecentPhotos($limit = 10)
    {
        return $this->select('photos.*,
                             jobs.device_name as job_device,
                             jobs.status as job_status,
                             users.name as customer_name,
                             referred.customer_name as referred_customer,
                             referred.device_name as referred_device,
                             referred.status as referred_status,
                             inventory_items.device_name as inventory_device,
                             inventory_items.brand as inventory_brand,
                             inventory_items.model as inventory_model')
                    ->join('jobs', 'jobs.id = photos.job_id', 'left')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('referred', 'referred.id = photos.referred_id', 'left')
                    ->join('inventory_items', 'inventory_items.id = photos.inventory_id', 'left')
                    ->orderBy('photos.uploaded_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get photos with all related data
     */
    public function getPhotosWithDetails($perPage = null)
    {
        $builder = $this->select('photos.*,
                             jobs.device_name as job_device,
                             jobs.status as job_status,
                             users.name as customer_name,
                             referred.customer_name as referred_customer,
                             referred.device_name as referred_device,
                             referred.status as referred_status,
                             inventory_items.device_name as inventory_device,
                             inventory_items.brand as inventory_brand,
                             inventory_items.model as inventory_model')
                    ->join('jobs', 'jobs.id = photos.job_id', 'left')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('referred', 'referred.id = photos.referred_id', 'left')
                    ->join('inventory_items', 'inventory_items.id = photos.inventory_id', 'left')
                    ->orderBy('photos.uploaded_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get photo with related data
     */
    public function getPhotoWithDetails($id)
    {
        return $this->select('photos.*,
                             jobs.device_name as job_device,
                             jobs.status as job_status,
                             jobs.serial_number as job_serial,
                             jobs.problem as job_problem,
                             users.name as customer_name,
                             users.mobile_number as customer_phone,
                             admin_users.full_name as technician_name,
                             referred.customer_name as referred_customer,
                             referred.device_name as referred_device,
                             referred.status as referred_status,
                             referred.customer_phone as referred_phone,
                             referred.referred_to')
                    ->join('jobs', 'jobs.id = photos.job_id', 'left')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->join('admin_users', 'admin_users.id = jobs.technician_id AND admin_users.role = "technician"', 'left')
                    ->join('referred', 'referred.id = photos.referred_id', 'left')
                    ->where('photos.id', $id)
                    ->first();
    }
}
