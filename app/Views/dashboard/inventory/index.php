<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Inventory Management</h1>
                <p class="text-sm text-gray-600">Track stock levels and manage your inventory items</p>
            </div>
        </div>
        <div class="text-right flex items-center space-x-3">
            <!-- Import/Export Actions (Admin Only) -->
            <?php if (in_array($userRole, ['superadmin', 'admin'])): ?>
            <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-1">
                <a href="<?= base_url('dashboard/inventory/downloadTemplate') ?>"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 bg-white rounded-md hover:bg-green-50 transition-colors duration-200"
                   title="Download CSV template for bulk import">
                    <i class="fas fa-download mr-1"></i>Template
                </a>
                <a href="<?= base_url('dashboard/inventory/bulk-import') ?>"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-white rounded-md hover:bg-blue-50 transition-colors duration-200"
                   title="Import items from CSV/Excel file">
                    <i class="fas fa-upload mr-1"></i>Import
                </a>
                <a href="<?= base_url('dashboard/inventory/export') ?>"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-50 transition-colors duration-200"
                   title="Export all inventory items to CSV">
                    <i class="fas fa-file-export mr-1"></i>Export
                </a>
            </div>
            <?php endif; ?>

            <!-- Primary Action -->
            <a href="<?= base_url('dashboard/inventory/create') ?>"
               class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>Add New Item
            </a>
        </div>
    </div>
</div>

<!-- Inventory Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $inventoryStats['total_items'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Total Items</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-cubes text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $inventoryStats['total_stock'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Total Stock</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-orange-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $inventoryStats['low_stock'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Low Stock</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-red-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-times-circle text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $inventoryStats['out_of_stock'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Out of Stock</p>
            </div>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <form method="GET" action="<?= base_url('dashboard/inventory') ?>" class="flex flex-col lg:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search Inventory</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text"
                       name="search"
                       value="<?= esc($search ?? '') ?>"
                       placeholder="Search by device name, brand, or model..."
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
            </div>
        </div>
        <div class="flex items-end gap-3">
            <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/inventory') ?>"
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Inventory Cards -->
<div class="space-y-4">
    <?php if (!empty($items)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($items as $item): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <!-- Item Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-box text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900"><?= esc($item['device_name'] ?? 'N/A') ?></h3>
                                <p class="text-sm text-gray-500">ID: #<?= $item['id'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>"
                               class="text-blue-600 hover:text-blue-900 p-1.5 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                               title="View">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <?php
                            $userRole = session('access_level') ?? session('role') ?? 'guest';
                            if (in_array($userRole, ['admin', 'superadmin'])):
                            ?>
                                <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>"
                                   class="text-green-600 hover:text-green-900 p-1.5 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="<?= base_url('dashboard/inventory/delete/' . $item['id']) ?>"
                                   onclick="return confirm('Are you sure you want to delete this item?')"
                                   class="text-red-600 hover:text-red-900 p-1.5 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                   title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Item Details -->
                    <div class="space-y-3">
                        <!-- Brand & Model -->
                        <div>
                            <span class="text-sm text-gray-600">Brand & Model:</span>
                            <div class="mt-1">
                                <p class="font-medium text-gray-900"><?= esc($item['brand'] ?? 'N/A') ?></p>
                                <p class="text-sm text-gray-500"><?= esc($item['model'] ?? 'N/A') ?></p>
                            </div>
                        </div>

                        <!-- Stock Level -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Stock:</span>
                            <?php
                            if ($item['total_stock'] <= 0) {
                                $stockClass = 'bg-red-100 text-red-800';
                            } elseif ($item['total_stock'] <= 10) {
                                $stockClass = 'bg-orange-100 text-orange-800';
                            } else {
                                $stockClass = 'bg-green-100 text-green-800';
                            }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $stockClass ?>">
                                <?= $item['total_stock'] ?> units
                            </span>
                        </div>

                        <!-- Pricing -->
                        <div>
                            <span class="text-sm text-gray-600">Price:</span>
                            <div class="mt-1">
                                <?php if (!empty($item['selling_price'])): ?>
                                    <p class="font-medium text-gray-900">NPR <?= number_format($item['selling_price'], 2) ?></p>
                                    <?php if (!empty($item['purchase_price']) && hasAnyRole(['superadmin', 'admin'])): ?>
                                        <p class="text-xs text-gray-500">Cost: NPR <?= number_format($item['purchase_price'], 2) ?></p>
                                    <?php endif; ?>
                                <?php elseif (!empty($item['purchase_price']) && hasAnyRole(['superadmin', 'admin'])): ?>
                                    <p class="font-medium text-gray-900">NPR <?= number_format($item['purchase_price'], 2) ?></p>
                                    <p class="text-xs text-gray-500">Purchase price</p>
                                <?php else: ?>
                                    <span class="text-gray-400">No pricing</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status:</span>
                            <?php
                            $statusClasses = [
                                'Active' => 'bg-green-100 text-green-800',
                                'Inactive' => 'bg-orange-100 text-orange-800',
                                'Discontinued' => 'bg-red-100 text-red-800'
                            ];
                            $statusClass = $statusClasses[$item['status'] ?? 'Active'] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                <?= esc($item['status'] ?? 'Active') ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager): ?>
            <div class="mt-6">
                <?php helper('pagination'); ?>
                <?= renderPagination($pager) ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-16 text-center">
            <div class="text-gray-500">
                <i class="fas fa-boxes text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium mb-2 text-gray-900">No inventory items found</p>
                <p class="text-sm mb-6">Get started by adding your first inventory item.</p>
                <a href="<?= base_url('dashboard/inventory/create') ?>"
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Add Item
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
