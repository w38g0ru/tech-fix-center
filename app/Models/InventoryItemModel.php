<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryItemModel extends Model
{
    protected $table = 'inventory_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'device_name', 'brand', 'model', 'total_stock', 'purchase_price',
        'selling_price', 'minimum_order_level', 'category', 'description',
        'supplier', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'device_name' => 'permit_empty|max_length[100]',
        'brand' => 'permit_empty|max_length[100]',
        'model' => 'permit_empty|max_length[100]',
        'total_stock' => 'required|is_natural',
        'purchase_price' => 'permit_empty|decimal',
        'selling_price' => 'permit_empty|decimal',
        'minimum_order_level' => 'permit_empty|is_natural',
        'category' => 'permit_empty|max_length[100]',
        'description' => 'permit_empty|max_length[1000]',
        'supplier' => 'permit_empty|max_length[100]',
        'status' => 'required|in_list[Active,Inactive,Discontinued]'
    ];

    protected $validationMessages = [
        'device_name' => [
            'max_length' => 'Device name cannot exceed 100 characters'
        ],
        'brand' => [
            'max_length' => 'Brand cannot exceed 100 characters'
        ],
        'model' => [
            'max_length' => 'Model cannot exceed 100 characters'
        ],
        'total_stock' => [
            'required' => 'Stock quantity is required',
            'is_natural' => 'Stock must be a valid number'
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
     * Get items with movement summary
     */
    public function getItemsWithMovements()
    {
        return $this->select('inventory_items.*, 
                            COALESCE(SUM(CASE WHEN im.movement_type = "IN" THEN im.quantity ELSE 0 END), 0) as total_in,
                            COALESCE(SUM(CASE WHEN im.movement_type = "OUT" THEN im.quantity ELSE 0 END), 0) as total_out')
                    ->join('inventory_movements im', 'im.item_id = inventory_items.id', 'left')
                    ->groupBy('inventory_items.id')
                    ->orderBy('inventory_items.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Search inventory items
     */
    public function searchItems($search)
    {
        return $this->like('device_name', $search)
                    ->orLike('brand', $search)
                    ->orLike('model', $search)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get low stock items
     */
    public function getLowStockItems($threshold = 10)
    {
        return $this->where('total_stock <=', $threshold)
                    ->orderBy('total_stock', 'ASC')
                    ->findAll();
    }

    /**
     * Update stock after movement
     */
    public function updateStock($itemId, $movementType, $quantity)
    {
        $item = $this->find($itemId);
        if (!$item) {
            return false;
        }

        $newStock = $item['total_stock'];
        
        if ($movementType === 'IN') {
            $newStock += $quantity;
        } elseif ($movementType === 'OUT') {
            $newStock -= $quantity;
            if ($newStock < 0) {
                $newStock = 0;
            }
        }

        return $this->update($itemId, ['total_stock' => $newStock]);
    }

    /**
     * Get inventory statistics
     */
    public function getInventoryStats()
    {
        $total = $this->countAll();
        $totalStock = $this->selectSum('total_stock')->first()['total_stock'] ?? 0;
        $lowStock = $this->where('total_stock <=', 10)->countAllResults();
        $outOfStock = $this->where('total_stock', 0)->countAllResults();
        
        return [
            'total_items' => $total,
            'total_stock' => $totalStock,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock
        ];
    }
}
