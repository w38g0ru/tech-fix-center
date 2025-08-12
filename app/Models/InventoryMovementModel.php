<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryMovementModel extends Model
{
    protected $table = 'inventory_movements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['item_id', 'movement_type', 'quantity', 'job_id'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'moved_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'item_id' => [
            'label' => 'Inventory Item',
            'rules' => 'required|is_natural_no_zero'
        ],
        'movement_type' => [
            'label' => 'Movement Type',
            'rules' => 'required|in_list[IN,OUT]'
        ],
        'quantity' => [
            'label' => 'Quantity',
            'rules' => 'required|is_natural_no_zero'
        ],
        'job_id' => [
            'label' => 'Job',
            'rules' => 'permit_empty|is_natural_no_zero'
        ]
    ];

    protected $validationMessages = [
        'item_id' => [
            'required' => 'Please select an inventory item',
            'is_natural_no_zero' => 'Please select a valid inventory item'
        ],
        'movement_type' => [
            'required' => 'Movement type is required',
            'in_list' => 'Movement type must be IN or OUT'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'is_natural_no_zero' => 'Quantity must be a positive number'
        ],
        'job_id' => [
            'is_natural_no_zero' => 'Please select a valid job'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['updateInventoryStock'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get movements with item and job details
     */
    public function getMovementsWithDetails($perPage = null)
    {
        $builder = $this->select('inventory_movements.*,
                            inventory_items.device_name, inventory_items.brand, inventory_items.model,
                            jobs.device_name as job_device, users.name as customer_name')
                    ->join('inventory_items', 'inventory_items.id = inventory_movements.item_id', 'left')
                    ->join('jobs', 'jobs.id = inventory_movements.job_id', 'left')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->orderBy('inventory_movements.moved_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get movements by item
     */
    public function getMovementsByItem($itemId, $perPage = null)
    {
        $builder = $this->select('inventory_movements.*,
                            jobs.device_name as job_device, users.name as customer_name')
                    ->join('jobs', 'jobs.id = inventory_movements.job_id', 'left')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->where('inventory_movements.item_id', $itemId)
                    ->orderBy('inventory_movements.moved_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get movements by job
     */
    public function getMovementsByJob($jobId, $perPage = null)
    {
        $builder = $this->select('inventory_movements.*,
                            inventory_items.device_name, inventory_items.brand, inventory_items.model')
                    ->join('inventory_items', 'inventory_items.id = inventory_movements.item_id', 'left')
                    ->where('inventory_movements.job_id', $jobId)
                    ->orderBy('inventory_movements.moved_at', 'DESC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get recent movements
     */
    public function getRecentMovements($limit = 10)
    {
        return $this->select('inventory_movements.*, 
                            inventory_items.device_name, inventory_items.brand, inventory_items.model,
                            jobs.device_name as job_device, users.name as customer_name')
                    ->join('inventory_items', 'inventory_items.id = inventory_movements.item_id', 'left')
                    ->join('jobs', 'jobs.id = inventory_movements.job_id', 'left')
                    ->join('users', 'users.id = jobs.user_id', 'left')
                    ->orderBy('inventory_movements.moved_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Update inventory stock before insert
     */
    protected function updateInventoryStock(array $data)
    {
        if (isset($data['data']['item_id'], $data['data']['movement_type'], $data['data']['quantity'])) {
            $inventoryModel = new InventoryItemModel();
            $inventoryModel->updateStock(
                $data['data']['item_id'],
                $data['data']['movement_type'],
                $data['data']['quantity']
            );
        }
        
        return $data;
    }

    /**
     * Get movement statistics
     */
    public function getMovementStats()
    {
        $totalIn = $this->where('movement_type', 'IN')->selectSum('quantity')->first()['quantity'] ?? 0;
        $totalOut = $this->where('movement_type', 'OUT')->selectSum('quantity')->first()['quantity'] ?? 0;
        
        return [
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'net_movement' => $totalIn - $totalOut
        ];
    }
}
