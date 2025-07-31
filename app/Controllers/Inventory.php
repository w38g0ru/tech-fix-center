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
        $perPage = 20; // Items per page

        if ($search) {
            $items = $this->inventoryModel->like('device_name', $search)
                                         ->orLike('brand', $search)
                                         ->orLike('model', $search)
                                         ->paginate($perPage);
        } else {
            $items = $this->inventoryModel->paginate($perPage);
        }

        // Calculate inventory statistics
        $allItems = $this->inventoryModel->findAll();
        $totalItems = count($allItems);
        $totalStock = array_sum(array_column($allItems, 'total_stock'));
        $lowStock = 0;
        $outOfStock = 0;

        foreach ($allItems as $item) {
            if ($item['total_stock'] <= 0) {
                $outOfStock++;
            } elseif ($item['total_stock'] <= ($item['minimum_order_level'] ?: 5)) {
                $lowStock++;
            }
        }

        $data = [
            'title' => 'Inventory',
            'items' => $items ?: [],
            'search' => $search,
            'inventoryStats' => [
                'total_items' => $totalItems,
                'total_stock' => $totalStock,
                'low_stock' => $lowStock,
                'out_of_stock' => $outOfStock
            ],
            'userRole' => 'admin',
            'pager' => $this->inventoryModel->pager
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
        if (hasRole('technician')) {
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
        if (hasRole('technician')) {
            return redirect()->to('/inventory')->with('error', 'Access denied. Technicians cannot add inventory items.');
        }

        $rules = [
            'device_name' => 'permit_empty|max_length[100]',
            'brand' => 'permit_empty|max_length[100]',
            'model' => 'permit_empty|max_length[100]',
            'category' => 'permit_empty|max_length[100]',
            'total_stock' => 'required|is_natural',
            'purchase_price' => 'permit_empty|decimal',
            'selling_price' => 'permit_empty|decimal',
            'minimum_order_level' => 'permit_empty|is_natural',
            'supplier' => 'permit_empty|max_length[100]',
            'description' => 'permit_empty|max_length[1000]',
            'status' => 'required|in_list[Active,Inactive,Discontinued]',
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
            'category' => $this->request->getPost('category'),
            'total_stock' => $this->request->getPost('total_stock'),
            'purchase_price' => $this->request->getPost('purchase_price') ?: null,
            'selling_price' => $this->request->getPost('selling_price') ?: null,
            'minimum_order_level' => $this->request->getPost('minimum_order_level') ?: null,
            'supplier' => $this->request->getPost('supplier'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status') ?: 'Active'
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
            'category' => 'permit_empty|max_length[100]',
            'total_stock' => 'required|is_natural',
            'purchase_price' => 'permit_empty|decimal',
            'selling_price' => 'permit_empty|decimal',
            'minimum_order_level' => 'permit_empty|is_natural',
            'supplier' => 'permit_empty|max_length[100]',
            'description' => 'permit_empty|max_length[1000]',
            'status' => 'required|in_list[Active,Inactive,Discontinued]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'device_name' => $this->request->getPost('device_name'),
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'category' => $this->request->getPost('category'),
            'total_stock' => $this->request->getPost('total_stock'),
            'purchase_price' => $this->request->getPost('purchase_price') ?: null,
            'selling_price' => $this->request->getPost('selling_price') ?: null,
            'minimum_order_level' => $this->request->getPost('minimum_order_level') ?: null,
            'supplier' => $this->request->getPost('supplier'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status')
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
        if (hasRole('technician')) {
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
        if (hasRole('technician')) {
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
        if (hasRole('technician')) {
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
        $isAdmin = hasAnyRole(['superadmin', 'admin']);

        // Create CSV content with conditional headers
        if ($isAdmin) {
            $csvContent = "Device Name,Brand,Model,Total Stock,Purchase Price,Selling Price,Minimum Order Level,Category,Description,Supplier,Status\n";
        } else {
            $csvContent = "Device Name,Brand,Model,Total Stock,Selling Price,Minimum Order Level,Category,Description,Supplier,Status\n";
        }

        foreach ($items as $item) {
            if ($isAdmin) {
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
            } else {
                $csvContent .= sprintf(
                    '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                    $item['device_name'] ?? '',
                    $item['brand'] ?? '',
                    $item['model'] ?? '',
                    $item['total_stock'] ?? 0,
                    $item['selling_price'] ?? '',
                    $item['minimum_order_level'] ?? 0,
                    $item['category'] ?? '',
                    str_replace('"', '""', $item['description'] ?? ''),
                    $item['supplier'] ?? '',
                    $item['status'] ?? 'Active'
                );
            }
        }

        // Set headers for download
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="inventory_export_' . date('Y-m-d_H-i-s') . '.csv"');

        return $this->response->setBody($csvContent);
    }

    /**
     * Download CSV import template
     */
    public function downloadTemplate()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        // Create CSV template content
        $csvContent = "device_name,brand,model,category,total_stock,purchase_price,selling_price,minimum_order_level,supplier,description,status\n";

        // Add sample data row
        $csvContent .= '"iPhone 14 Pro","Apple","A2894","Mobile Phone","10","120000","135000","5","Apple Store Nepal","Latest iPhone model with Pro features","Active"' . "\n";
        $csvContent .= '"Samsung Galaxy S23","Samsung","SM-S911B","Mobile Phone","15","95000","110000","3","Samsung Nepal","Flagship Android smartphone","Active"' . "\n";
        $csvContent .= '"MacBook Air M2","Apple","MLY33","Laptop","5","180000","200000","2","Apple Store Nepal","13-inch MacBook Air with M2 chip","Active"' . "\n";

        // Set headers for download
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="inventory_import_template.csv"');

        return $this->response->setBody($csvContent);
    }

    private function processImportFile($filePath, $fileName)
    {
        $successful = 0;
        $failed = 0;
        $errors = [];

        try {
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if ($fileExtension === 'xlsx' || $fileExtension === 'xls') {
                // Process XLSX/XLS file
                return $this->processExcelFile($filePath);
            } else {
                // Process CSV file
                return $this->processCsvFile($filePath);
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'File processing error: ' . $e->getMessage(),
                'successful' => 0,
                'failed' => 0
            ];
        }
    }

    private function processCsvFile($filePath)
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

    private function processExcelFile($filePath)
    {
        $successful = 0;
        $failed = 0;
        $errors = [];

        try {
            // Load PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            // Process each row (skip header row)
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    // Read row data
                    $deviceName = trim($worksheet->getCell('A' . $row)->getCalculatedValue() ?? '');
                    $brand = trim($worksheet->getCell('B' . $row)->getCalculatedValue() ?? '');
                    $model = trim($worksheet->getCell('C' . $row)->getCalculatedValue() ?? '');
                    $totalStock = (int)($worksheet->getCell('D' . $row)->getCalculatedValue() ?? 0);
                    $purchasePrice = (float)($worksheet->getCell('E' . $row)->getCalculatedValue() ?? 0);
                    $sellingPrice = (float)($worksheet->getCell('F' . $row)->getCalculatedValue() ?? 0);
                    $minimumOrderLevel = (int)($worksheet->getCell('G' . $row)->getCalculatedValue() ?? 0);
                    $category = trim($worksheet->getCell('H' . $row)->getCalculatedValue() ?? '');
                    $description = trim($worksheet->getCell('I' . $row)->getCalculatedValue() ?? '');
                    $supplier = trim($worksheet->getCell('J' . $row)->getCalculatedValue() ?? '');
                    $status = trim($worksheet->getCell('K' . $row)->getCalculatedValue() ?? 'active');

                    // Skip empty rows
                    if (empty($deviceName) && empty($brand) && empty($model)) {
                        continue;
                    }

                    // Set default values for empty fields
                    if (empty($category)) {
                        $category = $deviceName; // Use device name as category
                    }
                    if (empty($description)) {
                        $description = "$deviceName for $brand $model";
                    }
                    if (empty($supplier)) {
                        $supplier = 'Default Supplier';
                    }
                    if (empty($status)) {
                        $status = 'active';
                    }

                    $itemData = [
                        'device_name' => "$deviceName $brand $model",
                        'brand' => $brand,
                        'model' => $model,
                        'total_stock' => $totalStock,
                        'purchase_price' => $purchasePrice > 0 ? $purchasePrice : null,
                        'selling_price' => $sellingPrice > 0 ? $sellingPrice : null,
                        'minimum_order_level' => $minimumOrderLevel,
                        'category' => $category,
                        'description' => $description,
                        'supplier' => $supplier,
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->inventoryModel->save($itemData)) {
                        $successful++;
                    } else {
                        $failed++;
                        $errors[] = "Row $row: " . implode(', ', $this->inventoryModel->errors());
                    }

                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = "Row $row: " . $e->getMessage();
                }
            }

            // Log the import
            $this->logImport(basename($filePath), $highestRow - 1, $successful, $failed, $errors);

            return [
                'success' => true,
                'successful' => $successful,
                'failed' => $failed,
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Excel file processing error: ' . $e->getMessage(),
                'successful' => 0,
                'failed' => 0
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

    /**
     * Export inventory items to CSV
     */
    public function export()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        try {
            // Get export data
            $items = $this->inventoryModel->getExportData();
            $isAdmin = hasAnyRole(['superadmin', 'admin']);

            // Set headers for CSV download
            $filename = 'inventory_export_' . date('Y-m-d_H-i-s') . '.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');

            // Open output stream
            $output = fopen('php://output', 'w');

            // Write CSV headers based on user role
            if ($isAdmin) {
                $headers = [
                    'Device Name',
                    'Brand',
                    'Model',
                    'Category',
                    'Total Stock',
                    'Purchase Price',
                    'Selling Price',
                    'Minimum Order Level',
                    'Supplier',
                    'Description',
                    'Status',
                    'Created At',
                    'Updated At'
                ];
            } else {
                $headers = [
                    'Device Name',
                    'Brand',
                    'Model',
                    'Category',
                    'Total Stock',
                    'Selling Price',
                    'Minimum Order Level',
                    'Supplier',
                    'Description',
                    'Status',
                    'Created At',
                    'Updated At'
                ];
            }
            fputcsv($output, $headers);

            // Write data rows based on user role
            foreach ($items as $item) {
                if ($isAdmin) {
                    $row = [
                        $item['device_name'],
                        $item['brand'],
                        $item['model'],
                        $item['category'],
                        $item['total_stock'],
                        $item['purchase_price'],
                        $item['selling_price'],
                        $item['minimum_order_level'],
                        $item['supplier'],
                        $item['description'],
                        $item['status'],
                        $item['created_at'],
                        $item['updated_at']
                    ];
                } else {
                    $row = [
                        $item['device_name'],
                        $item['brand'],
                        $item['model'],
                        $item['category'],
                        $item['total_stock'],
                        $item['selling_price'],
                        $item['minimum_order_level'],
                        $item['supplier'],
                        $item['description'],
                        $item['status'],
                        $item['created_at'],
                        $item['updated_at']
                    ];
                }
                fputcsv($output, $row);
            }

            fclose($output);
            exit;

        } catch (\Exception $e) {
            return redirect()->to('/dashboard/inventory')->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

}
