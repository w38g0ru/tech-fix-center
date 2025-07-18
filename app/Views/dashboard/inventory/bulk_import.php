<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-dark-900">Bulk Import Inventory</h1>
        <p class="mt-2 text-dark-600">Import multiple inventory items from CSV or Excel file</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('dashboard/inventory') ?>"
           class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Inventory
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm"><?= session()->getFlashdata('success') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Upload Form -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="card-header">
                <h3 class="text-xl font-bold text-dark-900 flex items-center">
                    <i class="fas fa-upload text-primary-600 mr-3"></i>
                    Upload Inventory File
                </h3>
            </div>
            <div class="card-body">
                <p class="text-dark-600 mb-6">Upload a CSV or Excel file to bulk import inventory items with pricing information.</p>

                <form action="<?= base_url('dashboard/inventory/process-bulk-import') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?= csrf_field() ?>

                    <!-- File Upload -->
                    <div class="form-group">
                        <label for="import_file" class="form-label">
                            Select File <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="import_file"
                               name="import_file"
                               accept=".csv,.xlsx,.xls"
                               required
                               class="form-control file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-100 file:text-primary-700 hover:file:bg-primary-200">
                        <p class="mt-2 text-sm text-dark-500">
                            <i class="fas fa-info-circle text-primary-600 mr-2"></i>
                            Supported: CSV, Excel (.xlsx, .xls). Max size: 10MB.
                        </p>
                    </div>

                    <!-- Update Existing Option -->
                    <div class="flex items-center p-4 bg-primary-50 rounded-lg border border-primary-200">
                        <input type="checkbox"
                               id="update_existing"
                               name="update_existing"
                               value="1"
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-primary-300 rounded">
                        <label for="update_existing" class="ml-3 text-sm font-medium text-dark-700">
                            Update existing items (if device name, brand, and model match)
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-upload mr-2"></i>
                            Import Inventory
                        </button>

                        <a href="<?= base_url('dashboard/inventory/downloadTemplate') ?>" class="btn btn-outline btn-lg">
                            <i class="fas fa-download mr-2"></i>
                            Download Template
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Information Panel -->
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-bold text-dark-900 flex items-center">
                    <i class="fas fa-info-circle text-primary-600 mr-3"></i>
                    Import Information
                </h3>
            </div>
            <div class="card-body space-y-6">

            <!-- CSV Format -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Required CSV Format</h4>
                <div class="bg-gray-50 rounded-md p-3 text-xs font-mono">
                    <div class="text-gray-600">device_name,brand,model,category,...</div>
                    <div class="text-gray-800">iPhone 14 Pro,Apple,A2894,Mobile Phone,...</div>
                </div>
            </div>

            <!-- Required Fields -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Required Fields</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>device_name</li>
                </ul>
            </div>

            <!-- Pricing Fields -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">
                    <i class="fas fa-dollar-sign text-green-500 mr-1"></i>
                    Pricing Fields (Optional)
                </h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-shopping-cart text-blue-500 mr-2"></i>purchase_price</li>
                    <li><i class="fas fa-tag text-green-500 mr-2"></i>selling_price</li>
                    <li><i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>minimum_order_level</li>
                </ul>
                <p class="text-xs text-gray-500 mt-2">
                    Prices can be left empty if not available. Use numbers only (e.g., 120000 for NPR 1,20,000).
                </p>
            </div>

            <!-- All Available Fields -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">All Available Fields</h4>
                <div class="text-xs text-gray-600 space-y-1">
                    <div>• device_name <span class="text-red-500">(required)</span></div>
                    <div>• brand</div>
                    <div>• model</div>
                    <div>• category</div>
                    <div>• total_stock</div>
                    <div>• purchase_price <span class="text-green-600">(optional)</span></div>
                    <div>• selling_price <span class="text-green-600">(optional)</span></div>
                    <div>• minimum_order_level <span class="text-green-600">(optional)</span></div>
                    <div>• supplier</div>
                    <div>• description</div>
                    <div>• status (Active/Inactive/Discontinued)</div>
                </div>
            </div>

            <!-- Sample Data -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Sample Data</h4>
                <div class="bg-gray-50 rounded-md p-3 text-xs">
                    <div class="text-gray-800 mb-2">
                        <strong>Device:</strong> iPhone 14 Pro<br>
                        <strong>Brand:</strong> Apple<br>
                        <strong>Purchase Price:</strong> 120000<br>
                        <strong>Selling Price:</strong> 135000<br>
                        <strong>Min Order:</strong> 5
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-blue-50 rounded-md p-3">
                <h4 class="text-sm font-medium text-blue-900 mb-2">
                    <i class="fas fa-lightbulb mr-1"></i>
                    Tips
                </h4>
                <ul class="text-xs text-blue-800 space-y-1">
                    <li>• Download the template for correct format</li>
                    <li>• Prices are optional but recommended</li>
                    <li>• Use "Active" status for new items</li>
                    <li>• Check "Update existing" to modify items</li>
                    <li>• Backup your data before importing</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
