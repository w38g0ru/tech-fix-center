<?php

namespace App\Models;

use CodeIgniter\Model;

class PartsRequestModel extends Model
{
    protected $table = 'parts_requests';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'technician_id', 'job_id', 'item_name', 'brand', 'model', 'quantity_requested',
        'description', 'urgency', 'status', 'requested_by', 'approved_by', 'approved_at',
        'rejection_reason', 'estimated_cost', 'actual_cost', 'supplier', 'order_date',
        'expected_delivery_date', 'actual_delivery_date', 'notes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'technician_id' => 'required|is_natural_no_zero',
        'job_id' => 'permit_empty|is_natural_no_zero',
        'item_name' => 'required|min_length[2]|max_length[100]',
        'brand' => 'permit_empty|max_length[100]',
        'model' => 'permit_empty|max_length[100]',
        'quantity_requested' => 'required|is_natural_no_zero',
        'description' => 'permit_empty|max_length[1000]',
        'urgency' => 'required|in_list[Low,Medium,High,Critical]',
        'status' => 'required|in_list[Pending,Approved,Rejected,Ordered,Received,Cancelled]',
        'requested_by' => 'required|is_natural_no_zero',
        'approved_by' => 'permit_empty|is_natural_no_zero',
        'rejection_reason' => 'permit_empty|max_length[500]',
        'estimated_cost' => 'permit_empty|decimal',
        'actual_cost' => 'permit_empty|decimal',
        'supplier' => 'permit_empty|max_length[100]',
        'order_date' => 'permit_empty|valid_date',
        'expected_delivery_date' => 'permit_empty|valid_date',
        'actual_delivery_date' => 'permit_empty|valid_date',
        'notes' => 'permit_empty|max_length[1000]'
    ];

    protected $validationMessages = [
        'technician_id' => [
            'required' => 'Technician is required',
            'is_natural_no_zero' => 'Please select a valid technician'
        ],
        'job_id' => [
            'is_natural_no_zero' => 'Please select a valid job'
        ],
        'item_name' => [
            'required' => 'Item name is required',
            'min_length' => 'Item name must be at least 2 characters long',
            'max_length' => 'Item name cannot exceed 100 characters'
        ],
        'brand' => [
            'max_length' => 'Brand cannot exceed 100 characters'
        ],
        'model' => [
            'max_length' => 'Model cannot exceed 100 characters'
        ],
        'quantity_requested' => [
            'required' => 'Quantity is required',
            'is_natural_no_zero' => 'Quantity must be a positive number'
        ],
        'description' => [
            'max_length' => 'Description cannot exceed 1000 characters'
        ],
        'urgency' => [
            'required' => 'Urgency level is required',
            'in_list' => 'Please select a valid urgency level'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Please select a valid status'
        ],
        'requested_by' => [
            'required' => 'Requester is required',
            'is_natural_no_zero' => 'Please select a valid requester'
        ],
        'approved_by' => [
            'is_natural_no_zero' => 'Please select a valid approver'
        ],
        'rejection_reason' => [
            'max_length' => 'Rejection reason cannot exceed 500 characters'
        ],
        'estimated_cost' => [
            'decimal' => 'Please enter a valid estimated cost'
        ],
        'actual_cost' => [
            'decimal' => 'Please enter a valid actual cost'
        ],
        'supplier' => [
            'max_length' => 'Supplier name cannot exceed 100 characters'
        ],
        'order_date' => [
            'valid_date' => 'Please enter a valid order date'
        ],
        'expected_delivery_date' => [
            'valid_date' => 'Please enter a valid expected delivery date'
        ],
        'actual_delivery_date' => [
            'valid_date' => 'Please enter a valid actual delivery date'
        ],
        'notes' => [
            'max_length' => 'Notes cannot exceed 1000 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get parts requests with related data
     */
    public function getPartsRequestsWithDetails($perPage = null)
    {
        $builder = $this->select('parts_requests.*,
                            technicians.name as technician_name,
                            jobs.device_name as job_device,
                            requester.username as requested_by_name,
                            approver.username as approved_by_name')
                    ->join('technicians', 'technicians.id = parts_requests.technician_id', 'left')
                    ->join('jobs', 'jobs.id = parts_requests.job_id', 'left')
                    ->join('admin_users as requester', 'requester.id = parts_requests.requested_by', 'left')
                    ->join('admin_users as approver', 'approver.id = parts_requests.approved_by', 'left')
                    ->orderBy('parts_requests.created_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get parts request by ID with details
     */
    public function getPartsRequestWithDetails($id)
    {
        return $this->select('parts_requests.*, 
                            technicians.name as technician_name,
                            jobs.device_name as job_device,
                            requester.username as requested_by_name,
                            approver.username as approved_by_name')
                    ->join('technicians', 'technicians.id = parts_requests.technician_id', 'left')
                    ->join('jobs', 'jobs.id = parts_requests.job_id', 'left')
                    ->join('admin_users as requester', 'requester.id = parts_requests.requested_by', 'left')
                    ->join('admin_users as approver', 'approver.id = parts_requests.approved_by', 'left')
                    ->where('parts_requests.id', $id)
                    ->first();
    }

    /**
     * Get parts requests by technician
     */
    public function getPartsRequestsByTechnician($technicianId)
    {
        return $this->select('parts_requests.*, 
                            jobs.device_name as job_device,
                            requester.username as requested_by_name,
                            approver.username as approved_by_name')
                    ->join('jobs', 'jobs.id = parts_requests.job_id', 'left')
                    ->join('admin_users as requester', 'requester.id = parts_requests.requested_by', 'left')
                    ->join('admin_users as approver', 'approver.id = parts_requests.approved_by', 'left')
                    ->where('parts_requests.technician_id', $technicianId)
                    ->orderBy('parts_requests.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get pending parts requests
     */
    public function getPendingPartsRequests()
    {
        return $this->select('parts_requests.*, 
                            technicians.name as technician_name,
                            jobs.device_name as job_device,
                            requester.username as requested_by_name')
                    ->join('technicians', 'technicians.id = parts_requests.technician_id', 'left')
                    ->join('jobs', 'jobs.id = parts_requests.job_id', 'left')
                    ->join('admin_users as requester', 'requester.id = parts_requests.requested_by', 'left')
                    ->where('parts_requests.status', 'Pending')
                    ->orderBy('parts_requests.urgency', 'DESC')
                    ->orderBy('parts_requests.created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Get parts request statistics
     */
    public function getPartsRequestStats()
    {
        $total = $this->countAll();
        $pending = $this->where('status', 'Pending')->countAllResults();
        $approved = $this->where('status', 'Approved')->countAllResults();
        $rejected = $this->where('status', 'Rejected')->countAllResults();
        $ordered = $this->where('status', 'Ordered')->countAllResults();
        $received = $this->where('status', 'Received')->countAllResults();
        
        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'ordered' => $ordered,
            'received' => $received
        ];
    }

    /**
     * Get urgency levels
     */
    public function getUrgencyLevels()
    {
        return [
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            'Critical' => 'Critical'
        ];
    }

    /**
     * Get request statuses
     */
    public function getRequestStatuses()
    {
        return [
            'Pending' => 'Pending',
            'Approved' => 'Approved',
            'Rejected' => 'Rejected',
            'Ordered' => 'Ordered',
            'Received' => 'Received',
            'Cancelled' => 'Cancelled'
        ];
    }
}
