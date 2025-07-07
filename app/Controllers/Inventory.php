<?php

namespace App\Controllers;

use App\Models\InventoryItemModel;
use App\Models\InventoryMovementModel;
use App\Models\PhotoModel;

class Inventory extends BaseController
{
    protected $inventoryModel;
    protected $movementModel;
    protected $photoModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryItemModel();
        $this->movementModel = new InventoryMovementModel();
        $this->photoModel = new PhotoModel();

        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $search = $this->request->getGet('search');

        if ($search) {
            $items = $this->inventoryModel->searchItems($search);
        } else {
            $items = $this->inventoryModel->getItemsWithMovements();
        }

        // Simplified version to avoid errors
        $data = [
            'title' => 'Inventory',
            'items' => $items ?: [],
            'search' => $search,
            'inventoryStats' => [
                'total_items' => 0,
                'total_stock' => 0,
                'low_stock' => 0,
                'out_of_stock' => 0
            ],
            'userRole' => 'admin'
        ];

        return view('dashboard/inventory/index', $data);
    }

    public function create()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Restrict technicians from adding stock
        if (hasRole(['technician'])) {
            return redirect()->to('/inventory')->with('error', 'Access denied. Technicians cannot add inventory items.');
        }

        $data = ['title' => 'Add New Inventory Item'];
        return view('dashboard/inventory/create', $data);
    }

    public function store()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Restrict technicians from adding stock
        if (hasRole(['technician'])) {
            return redirect()->to('/inventory')->with('error', 'Access denied. Technicians cannot add inventory items.');
        }

        $rules = [
            'device_name' => 'permit_empty|max_length[100]',
            'brand' => 'permit_empty|max_length[100]',
            'model' => 'permit_empty|max_length[100]',
            'total_stock' => 'required|is_natural',
            'photo_description' => 'permit_empty|max_length[255]',
            'inventory_photos' => 'permit_empty|max_size[inventory_photos,5120]|is_image[inventory_photos]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create the inventory item first
        $data = [
            'device_name' => $this->request->getPost('device_name'),
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'total_stock' => $this->request->getPost('total_stock')
        ];

        $inventoryId = $this->inventoryModel->insert($data);

        if (!$inventoryId) {
            return redirect()->back()->withInput()->with('error', 'Failed to add inventory item.');
        }

        // Handle photo uploads if any
        $uploadedFiles = $this->request->getFiles();
        $photoDescription = $this->request->getPost('photo_description');
        $uploadedCount = 0;
        $photoErrors = [];

        if (!empty($uploadedFiles['inventory_photos'])) {
            // Create upload directory if it doesn't exist
            $uploadPath = WRITEPATH . 'uploads/photos/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($uploadedFiles['inventory_photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate unique filename
                    $newName = $file->getRandomName();

                    try {
                        // Move file to upload directory
                        if ($file->move($uploadPath, $newName)) {
                            // Save to database
                            $photoData = [
                                'job_id' => null,
                                'referred_id' => null,
                                'inventory_id' => $inventoryId,
                                'photo_type' => 'Inventory',
                                'file_name' => $newName,
                                'description' => $photoDescription,
                                'uploaded_at' => date('Y-m-d H:i:s')
                            ];

                            if ($this->photoModel->insert($photoData)) {
                                $uploadedCount++;
                            } else {
                                $photoErrors[] = "Failed to save photo record for {$file->getName()}";
                                // Delete the uploaded file if database insert failed
                                unlink($uploadPath . $newName);
                            }
                        } else {
                            $photoErrors[] = "Failed to upload {$file->getName()}";
                        }
                    } catch (\Exception $e) {
                        $photoErrors[] = "Error uploading {$file->getName()}: " . $e->getMessage();
                    }
                }
            }
        }

        // Prepare success message
        $message = 'Inventory item added successfully!';
        if ($uploadedCount > 0) {
            $message .= " {$uploadedCount} photoproof(s) uploaded.";
        }
        if (!empty($photoErrors)) {
            $message .= " Photo upload issues: " . implode(', ', $photoErrors);
        }

        return redirect()->to('/dashboard/inventory')->with('success', $message);
    }

    public function edit($id)
    {
        $item = $this->inventoryModel->find($id);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $data = [
            'title' => 'Edit Inventory Item',
            'item' => $item
        ];

        return view('dashboard/inventory/edit', $data);
    }

    public function update($id)
    {
        $item = $this->inventoryModel->find($id);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $rules = [
            'device_name' => 'permit_empty|max_length[100]',
            'brand' => 'permit_empty|max_length[100]',
            'model' => 'permit_empty|max_length[100]',
            'total_stock' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'device_name' => $this->request->getPost('device_name'),
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'total_stock' => $this->request->getPost('total_stock')
        ];

        if ($this->inventoryModel->update($id, $data)) {
            return redirect()->to('/dashboard/inventory')->with('success', 'Inventory item updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update inventory item.');
        }
    }

    public function delete($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Restrict technicians from deleting stock
        if (hasRole(['technician'])) {
            return redirect()->to('/inventory')->with('error', 'Access denied. Technicians cannot delete inventory items.');
        }

        $item = $this->inventoryModel->find($id);

        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        if ($this->inventoryModel->delete($id)) {
            return redirect()->to('/dashboard/inventory')->with('success', 'Inventory item deleted successfully!');
        } else {
            return redirect()->to('/dashboard/inventory')->with('error', 'Failed to delete inventory item.');
        }
    }

    public function view($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $item = $this->inventoryModel->find($id);

        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $movements = $this->movementModel->getMovementsByItem($id);

        $data = [
            'title' => 'Inventory Item Details',
            'item' => $item,
            'movements' => $movements
        ];

        return view('dashboard/inventory/view', $data);
    }

    public function bulkImport()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Restrict technicians from bulk import
        if (hasRole(['technician'])) {
            return redirect()->to('/inventory')->with('error', 'Access denied. Technicians cannot import inventory.');
        }

        $data = ['title' => 'Bulk Import Inventory'];
        return view('dashboard/inventory/bulk_import', $data);
    }

    public function processBulkImport()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Restrict technicians from bulk import
        if (hasRole(['technician'])) {
            return redirect()->to('/inventory')->with('error', 'Access denied. Technicians cannot import inventory.');
        }

        $file = $this->request->getFile('import_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid file.');
        }

        $allowedTypes = ['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Please upload a CSV or Excel file.');
        }

        // Move file to uploads directory
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $fileName);
        $filePath = WRITEPATH . 'uploads/' . $fileName;

        // Process the file
        $result = $this->processImportFile($filePath, $fileName);

        // Clean up uploaded file
        unlink($filePath);

        if ($result['success']) {
            return redirect()->to('/inventory')
                           ->with('success', "Import completed! {$result['successful']} items imported, {$result['failed']} failed.");
        } else {
            return redirect()->back()
                           ->with('error', 'Import failed: ' . $result['error']);
        }
    }

    public function exportInventory()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $items = $this->inventoryModel->findAll();

        // Create CSV content
        $csvContent = "Device Name,Brand,Model,Total Stock,Purchase Price,Selling Price,Minimum Order Level,Category,Description,Supplier,Status\n";

        foreach ($items as $item) {
            $csvContent .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $item['device_name'] ?? '',
                $item['brand'] ?? '',
                $item['model'] ?? '',
                $item['total_stock'] ?? 0,
                $item['purchase_price'] ?? '',
                $item['selling_price'] ?? '',
                $item['minimum_order_level'] ?? 0,
                $item['category'] ?? '',
                str_replace('"', '""', $item['description'] ?? ''),
                $item['supplier'] ?? '',
                $item['status'] ?? 'Active'
            );
        }

        // Set headers for download
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="inventory_export_' . date('Y-m-d_H-i-s') . '.csv"');

        return $this->response->setBody($csvContent);
    }

    private function processImportFile($filePath, $fileName)
    {
        $successful = 0;
        $failed = 0;
        $errors = [];

        try {
            // Read CSV file
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                $header = fgetcsv($handle); // Skip header row

                while (($data = fgetcsv($handle)) !== FALSE) {
                    if (count($data) < 4) { // Minimum required fields
                        $failed++;
                        $errors[] = "Row " . ($successful + $failed + 1) . ": Insufficient data";
                        continue;
                    }

                    $itemData = [
                        'device_name' => $data[0] ?? '',
                        'brand' => $data[1] ?? '',
                        'model' => $data[2] ?? '',
                        'total_stock' => is_numeric($data[3]) ? (int)$data[3] : 0,
                        'purchase_price' => isset($data[4]) && is_numeric($data[4]) ? (float)$data[4] : null,
                        'selling_price' => isset($data[5]) && is_numeric($data[5]) ? (float)$data[5] : null,
                        'minimum_order_level' => isset($data[6]) && is_numeric($data[6]) ? (int)$data[6] : 0,
                        'category' => $data[7] ?? '',
                        'description' => $data[8] ?? '',
                        'supplier' => $data[9] ?? '',
                        'status' => isset($data[10]) && in_array($data[10], ['Active', 'Inactive', 'Discontinued']) ? $data[10] : 'Active'
                    ];

                    if ($this->inventoryModel->save($itemData)) {
                        $successful++;
                    } else {
                        $failed++;
                        $errors[] = "Row " . ($successful + $failed + 1) . ": " . implode(', ', $this->inventoryModel->errors());
                    }
                }
                fclose($handle);
            }

            // Log the import
            $this->logImport($fileName, $successful + $failed, $successful, $failed, $errors);

            return [
                'success' => true,
                'successful' => $successful,
                'failed' => $failed,
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function logImport($fileName, $totalRows, $successful, $failed, $errors)
    {
        $db = \Config\Database::connect();
        $db->table('inventory_import_logs')->insert([
            'filename' => $fileName,
            'imported_by' => getUserId(),
            'total_rows' => $totalRows,
            'successful_rows' => $successful,
            'failed_rows' => $failed,
            'error_log' => implode("\n", $errors),
            'status' => $failed > 0 ? 'Completed' : 'Completed',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
