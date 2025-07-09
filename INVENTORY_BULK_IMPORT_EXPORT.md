# Inventory Bulk Import/Export Implementation

## 🎯 **Overview**

Implemented comprehensive bulk import/export functionality for the Inventory module with CSV support, including purchase price, selling price, and minimum order level fields as requested.

## ✨ **Features Implemented**

### **1. CSV Export Functionality**
- **Full inventory export** to CSV format
- **All fields included** including pricing information
- **Timestamped filenames** for easy organization
- **Proper CSV formatting** with headers and data

### **2. CSV Import Template**
- **Downloadable template** with sample data
- **Nepali context examples** (iPhone, Samsung, MacBook)
- **Proper field formatting** and structure
- **Sample pricing data** for reference

### **3. Bulk Import Processing**
- **CSV file validation** and parsing
- **Duplicate handling** with update option
- **Error reporting** with detailed messages
- **Batch processing** for large files

### **4. Pricing Fields Support**
- **Purchase Price** (optional field)
- **Selling Price** (optional field) 
- **Minimum Order Level** (optional field)
- **Flexible pricing** - can be left empty

## 🔧 **Implementation Details**

### **Database Fields**
The inventory_items table already includes:
```sql
purchase_price DECIMAL(10,2) NULL
selling_price DECIMAL(10,2) NULL  
minimum_order_level INT NULL
```

### **Model Enhancements**
Enhanced `InventoryItemModel.php` with:

#### **Export Methods**
```php
public function getExportData()
{
    return $this->select([
        'device_name', 'brand', 'model', 'category',
        'total_stock', 'purchase_price', 'selling_price', 
        'minimum_order_level', 'supplier', 'description',
        'status', 'created_at', 'updated_at'
    ])->findAll();
}

public function getCsvHeaders()
{
    return [
        'device_name', 'brand', 'model', 'category',
        'total_stock', 'purchase_price', 'selling_price',
        'minimum_order_level', 'supplier', 'description', 'status'
    ];
}
```

#### **Import Methods**
```php
public function bulkImport($data, $updateExisting = false)
{
    // Process CSV data with validation
    // Handle duplicates based on device_name + brand + model
    // Return detailed results with success/error counts
}

public function validateImportData($headers)
{
    // Validate CSV headers against allowed fields
    // Check for required fields
    // Return validation errors if any
}
```

### **Controller Enhancements**
Enhanced `Inventory.php` controller with:

#### **Export Method**
```php
public function exportInventory()
{
    $items = $this->inventoryModel->findAll();
    // Generate CSV with all fields including pricing
    // Set proper headers for download
    // Include purchase_price, selling_price, minimum_order_level
}
```

#### **Template Download**
```php
public function downloadTemplate()
{
    // Generate CSV template with headers
    // Include sample data with Nepali context
    // Pricing examples: iPhone (120000/135000), Samsung (95000/110000)
}
```

## 📊 **CSV Format Structure**

### **Required Fields**
- **device_name** (Required)

### **Optional Pricing Fields**
- **purchase_price** (Decimal, can be empty)
- **selling_price** (Decimal, can be empty)
- **minimum_order_level** (Integer, can be empty)

### **Other Optional Fields**
- brand, model, category, total_stock, supplier, description, status

### **Sample CSV Data**
```csv
device_name,brand,model,category,total_stock,purchase_price,selling_price,minimum_order_level,supplier,description,status
iPhone 14 Pro,Apple,A2894,Mobile Phone,10,120000,135000,5,Apple Store Nepal,Latest iPhone model with Pro features,Active
Samsung Galaxy S23,Samsung,SM-S911B,Mobile Phone,15,95000,110000,3,Samsung Nepal,Flagship Android smartphone,Active
MacBook Air M2,Apple,MLY33,Laptop,5,180000,200000,2,Apple Store Nepal,13-inch MacBook Air with M2 chip,Active
```

## 🎨 **User Interface**

### **Enhanced Inventory Index**
Added import/export buttons to the main inventory page:

```html
<!-- Import/Export Buttons -->
<div class="flex gap-2">
    <a href="/inventory/downloadTemplate" class="btn-green">
        <i class="fas fa-download"></i> Template
    </a>
    <a href="/inventory/bulkImport" class="btn-blue">
        <i class="fas fa-upload"></i> Import
    </a>
    <a href="/inventory/exportInventory" class="btn-purple">
        <i class="fas fa-file-export"></i> Export
    </a>
</div>
```

### **Enhanced Bulk Import Page**
Redesigned with Tailwind CSS:
- **Modern responsive design**
- **Clear pricing field information**
- **Step-by-step instructions**
- **Sample data examples**
- **Update existing option**

## 🔄 **Workflow Examples**

### **Export Workflow**
1. Go to Inventory page
2. Click "Export" button
3. CSV file downloads with all inventory data
4. Includes all pricing fields (purchase_price, selling_price, minimum_order_level)

### **Import Workflow**
1. Click "Template" to download CSV template
2. Fill in inventory data with pricing information
3. Go to "Import" page
4. Upload CSV file
5. Choose whether to update existing items
6. Review import results

### **Template Usage**
1. Download template with sample data
2. Replace sample data with actual inventory
3. Pricing fields are optional - can be left empty
4. Use proper format: numbers only (e.g., 120000 for NPR 1,20,000)

## 📋 **Files Updated**

### **Models**
- **app/Models/InventoryItemModel.php**
  - Added `getExportData()` method
  - Added `getCsvHeaders()` method  
  - Added `bulkImport()` method
  - Added `validateImportData()` method

### **Controllers**
- **app/Controllers/Inventory.php**
  - Enhanced `exportInventory()` method
  - Enhanced `downloadTemplate()` method
  - Existing `processBulkImport()` uses new model methods

### **Views**
- **app/Views/dashboard/inventory/index.php**
  - Added import/export buttons with proper styling
  - Template, Import, Export buttons with icons

- **app/Views/dashboard/inventory/bulk_import.php**
  - Complete redesign with Tailwind CSS
  - Enhanced pricing field information
  - Better user experience and instructions

## ✅ **Validation & Error Handling**

### **Import Validation**
- **File type validation** (CSV only)
- **File size limit** (5MB maximum)
- **Header validation** against allowed fields
- **Required field checking** (device_name)
- **Data type validation** for numeric fields

### **Error Reporting**
- **Detailed error messages** with row numbers
- **Success/failure counts** in import results
- **Validation errors** displayed to user
- **Exception handling** for file processing

## 🚀 **Benefits**

### **For Users**
- **Easy bulk operations** - import/export hundreds of items
- **Pricing support** - manage purchase/selling prices efficiently  
- **Template guidance** - clear format with examples
- **Error feedback** - know exactly what went wrong
- **Update flexibility** - choose to update existing items

### **For Business**
- **Time savings** - bulk operations vs manual entry
- **Data consistency** - standardized import format
- **Pricing management** - track purchase and selling prices
- **Inventory control** - minimum order level tracking
- **Data backup** - easy export for backup purposes

### **For System**
- **Scalability** - handle large inventory datasets
- **Data integrity** - validation prevents bad data
- **Performance** - efficient batch processing
- **Maintainability** - clean separation of concerns

## 🎯 **Usage Instructions**

### **Exporting Inventory**
1. Go to **Inventory** page
2. Click **"Export"** button
3. CSV file downloads automatically
4. Contains all items with pricing information

### **Downloading Template**
1. Click **"Template"** button
2. CSV template downloads with sample data
3. Use as reference for import format
4. Includes Nepali context examples

### **Importing Inventory**
1. Prepare CSV file using template format
2. Go to **"Import"** page  
3. Upload CSV file
4. Check **"Update existing"** if needed
5. Click **"Import Inventory"**
6. Review results and error messages

### **Pricing Field Usage**
- **Purchase Price**: Cost price in NPR (e.g., 120000)
- **Selling Price**: Retail price in NPR (e.g., 135000)  
- **Minimum Order Level**: Reorder threshold (e.g., 5)
- **All pricing fields are optional** - can be left empty
- **Use numbers only** - no currency symbols or commas

The inventory bulk import/export functionality is now complete with full pricing support as requested! 🎉
