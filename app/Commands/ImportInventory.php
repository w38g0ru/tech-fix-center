<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportInventory extends BaseCommand
{
    protected $group = 'Inventory';
    protected $name = 'inventory:import';
    protected $description = 'Import inventory from XLSX file';

    public function run(array $params)
    {
        try {
            CLI::write('Starting inventory import process...', 'green');
            
            // Get database connection
            $db = \Config\Database::connect();
            
            // Clear existing inventory
            CLI::write('Clearing existing inventory...');
            $db->query("DELETE FROM inventory_items");
            CLI::write('Existing inventory cleared.', 'yellow');
            
            // Load the XLSX file
            CLI::write('Loading XLSX file...');
            $filePath = ROOTPATH . 'MOBILE PARTS.xlsx';
            
            if (!file_exists($filePath)) {
                CLI::error('XLSX file not found: ' . $filePath);
                return;
            }
            
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Get the highest row
            $highestRow = $worksheet->getHighestRow();
            CLI::write("Found $highestRow rows in the file.");
            
            $imported = 0;
            $errors = 0;
            
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
                    
                    // Create item name combining device name, brand, and model
                    $itemName = trim("$deviceName $brand $model");
                    if (empty($itemName)) {
                        CLI::write("Skipping row $row: Empty item name", 'yellow');
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
                    
                    // Prepare data for insertion
                    $data = [
                        'device_name' => $itemName,
                        'brand' => $brand,
                        'model' => $model,
                        'total_stock' => $totalStock,
                        'purchase_price' => $purchasePrice,
                        'selling_price' => $sellingPrice,
                        'minimum_order_level' => $minimumOrderLevel,
                        'category' => $category,
                        'description' => $description,
                        'supplier' => $supplier,
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    // Insert into database
                    $db->table('inventory_items')->insert($data);
                    $imported++;
                    
                    CLI::write("Row $row: Imported '$itemName' (Stock: $totalStock)", 'green');
                    
                } catch (\Exception $e) {
                    $errors++;
                    CLI::write("Error on row $row: " . $e->getMessage(), 'red');
                }
            }
            
            CLI::write('', 'white');
            CLI::write('=== Import Summary ===', 'cyan');
            CLI::write("Total rows processed: " . ($highestRow - 1), 'white');
            CLI::write("Successfully imported: $imported", 'green');
            CLI::write("Errors: $errors", 'red');
            CLI::write('Import completed!', 'green');
            
        } catch (\Exception $e) {
            CLI::error('Fatal error: ' . $e->getMessage());
        }
    }
}
