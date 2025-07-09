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

    /**
     * Get export data for CSV/Excel
     */
    public function getExportData()
    {
        return $this->select([
            'device_name',
            'brand',
            'model',
            'category',
            'total_stock',
            'purchase_price',
            'selling_price',
            'minimum_order_level',
            'supplier',
            'description',
            'status',
            'created_at',
            'updated_at'
        ])->findAll();
    }

    /**
     * Get CSV template headers
     */
    public function getCsvHeaders()
    {
        return [
            'device_name',
            'brand',
            'model',
            'category',
            'total_stock',
            'purchase_price',
            'selling_price',
            'minimum_order_level',
            'supplier',
            'description',
            'status'
        ];
    }

    /**
     * Validate import data structure
     */
    public function validateImportData($headers)
    {
        $requiredHeaders = ['device_name'];
        $validHeaders = $this->getCsvHeaders();

        $errors = [];

        // Check for required headers
        foreach ($requiredHeaders as $required) {
            if (!in_array($required, $headers)) {
                $errors[] = "Missing required column: $required";
            }
        }

        // Check for invalid headers
        foreach ($headers as $header) {
            if (!in_array($header, $validHeaders)) {
                $errors[] = "Invalid column: $header";
            }
        }

        return $errors;
    }

    /**
     * Bulk import items from array data
     */
    public function bulkImport($data, $updateExisting = false)
    {
        $results = [
            'success' => 0,
            'errors' => 0,
            'updated' => 0,
            'messages' => []
        ];

        foreach ($data as $index => $row) {
            $rowNumber = $index + 2; // +2 because index starts at 0 and we skip header row

            try {
                // Prepare item data
                $itemData = [
                    'device_name' => trim($row['device_name'] ?? ''),
                    'brand' => trim($row['brand'] ?? ''),
                    'model' => trim($row['model'] ?? ''),
                    'category' => trim($row['category'] ?? ''),
                    'total_stock' => (int)($row['total_stock'] ?? 0),
                    'purchase_price' => !empty($row['purchase_price']) ? (float)$row['purchase_price'] : null,
                    'selling_price' => !empty($row['selling_price']) ? (float)$row['selling_price'] : null,
                    'minimum_order_level' => !empty($row['minimum_order_level']) ? (int)$row['minimum_order_level'] : null,
                    'supplier' => trim($row['supplier'] ?? ''),
                    'description' => trim($row['description'] ?? ''),
                    'status' => trim($row['status'] ?? 'Active')
                ];

                // Skip empty rows
                if (empty($itemData['device_name']) && empty($itemData['brand']) && empty($itemData['model'])) {
                    continue;
                }

                // Validate required fields
                if (empty($itemData['device_name'])) {
                    $results['errors']++;
                    $results['messages'][] = "Row $rowNumber: Device name is required";
                    continue;
                }

                // Check if item exists (by device_name, brand, model combination)
                $existingItem = $this->where([
                    'device_name' => $itemData['device_name'],
                    'brand' => $itemData['brand'],
                    'model' => $itemData['model']
                ])->first();

                if ($existingItem && $updateExisting) {
                    // Update existing item
                    if ($this->update($existingItem['id'], $itemData)) {
                        $results['updated']++;
                        $results['messages'][] = "Row $rowNumber: Updated existing item";
                    } else {
                        $results['errors']++;
                        $results['messages'][] = "Row $rowNumber: Failed to update - " . implode(', ', $this->errors());
                    }
                } elseif (!$existingItem) {
                    // Create new item
                    if ($this->insert($itemData)) {
                        $results['success']++;
                        $results['messages'][] = "Row $rowNumber: Successfully imported";
                    } else {
                        $results['errors']++;
                        $results['messages'][] = "Row $rowNumber: Failed to import - " . implode(', ', $this->errors());
                    }
                } else {
                    // Item exists but update not allowed
                    $results['errors']++;
                    $results['messages'][] = "Row $rowNumber: Item already exists (use update option to modify)";
                }

            } catch (\Exception $e) {
                $results['errors']++;
                $results['messages'][] = "Row $rowNumber: Error - " . $e->getMessage();
            }
        }

        return $results;
    }
}
