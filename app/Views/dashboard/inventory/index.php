<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Inventory Management</h1>
        <p class="text-gray-600">Track stock levels and manage your inventory items</p>
    </div>
    <div class="mt-4 lg:mt-0 flex flex-wrap gap-3">
        <!-- Import/Export Actions -->
        <div class="flex items-center gap-2 bg-gray-50 rounded-xl p-1">
            <a href="<?= base_url('dashboard/inventory/downloadTemplate') ?>"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-white rounded-lg hover:bg-green-50 transition-colors duration-200 shadow-sm"
               title="Download CSV template for bulk import">
                <i class="fas fa-download mr-2"></i>Template
            </a>
            <a href="<?= base_url('dashboard/inventory/bulk-import') ?>"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-white rounded-lg hover:bg-blue-50 transition-colors duration-200 shadow-sm"
               title="Import items from CSV/Excel file">
                <i class="fas fa-upload mr-2"></i>Import
            </a>
            <a href="<?= base_url('dashboard/inventory/export') ?>"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors duration-200 shadow-sm"
               title="Export all inventory items to CSV">
                <i class="fas fa-file-export mr-2"></i>Export
            </a>
        </div>

        <!-- Primary Action -->
        <a href="<?= base_url('dashboard/inventory/create') ?>"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white font-semibold rounded-xl hover:from-orange-700 hover:to-orange-800 transition-all duration-200 shadow-lg shadow-orange-500/25 hover:shadow-xl hover:shadow-orange-500/30">
            <i class="fas fa-plus mr-2"></i>Add New Item
        </a>
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

<!-- Inventory Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand & Model</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Level</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 32px; height: 32px; background: rgba(255, 152, 0, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <i class="fas fa-box" style="color: #ff9800; font-size: 14px;"></i>
                                </div>
                                <div style="font-weight: 500;">
                                    <?= esc($item['device_name'] ?? 'N/A') ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <?= esc($item['brand'] ?? 'N/A') ?>
                            </div>
                            <div style="font-size: 12px; color: #666;">
                                <?= esc($item['model'] ?? 'N/A') ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $stockColor = '#059669';
                            $stockBg = 'rgba(5, 150, 105, 0.1)';
                            if ($item['total_stock'] <= 0) {
                                $stockColor = '#dc2626';
                                $stockBg = 'rgba(220, 38, 38, 0.1)';
                            } elseif ($item['total_stock'] <= 10) {
                                $stockColor = '#d97706';
                                $stockBg = 'rgba(217, 119, 6, 0.1)';
                            }
                            ?>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $stockBg ?>; color: <?= $stockColor ?>;">
                                <?= $item['total_stock'] ?> units
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($item['selling_price'])): ?>
                                <div style="font-weight: 500;">NPR <?= number_format($item['selling_price'], 2) ?></div>
                                <?php if (!empty($item['purchase_price'])): ?>
                                    <div style="font-size: 12px; color: #666;">Cost: NPR <?= number_format($item['purchase_price'], 2) ?></div>
                                <?php endif; ?>
                            <?php elseif (!empty($item['purchase_price'])): ?>
                                <div>NPR <?= number_format($item['purchase_price'], 2) ?></div>
                                <div style="font-size: 12px; color: #666;">Purchase price</div>
                            <?php else: ?>
                                <span style="color: #999;">No pricing</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $statusColor = '#059669';
                            $statusBg = 'rgba(5, 150, 105, 0.1)';
                            switch($item['status'] ?? 'Active') {
                                case 'Active':
                                    $statusColor = '#059669';
                                    $statusBg = 'rgba(5, 150, 105, 0.1)';
                                    break;
                                case 'Inactive':
                                    $statusColor = '#d97706';
                                    $statusBg = 'rgba(217, 119, 6, 0.1)';
                                    break;
                                case 'Discontinued':
                                    $statusColor = '#dc2626';
                                    $statusBg = 'rgba(220, 38, 38, 0.1)';
                                    break;
                                default:
                                    $statusColor = '#6b7280';
                                    $statusBg = 'rgba(107, 114, 128, 0.1)';
                            }
                            ?>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                <?= esc($item['status'] ?? 'Active') ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: end;">
                                <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>"
                                   style="color: #2563eb; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>"
                                   style="color: #059669; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('dashboard/inventory/delete/' . $item['id']) ?>"
                                   onclick="return confirm('Are you sure you want to delete this item?')"
                                   style="color: #dc2626; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center;">
                        <div style="color: #666;">
                            <i class="fas fa-boxes" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                            <p style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">No inventory items found</p>
                            <p style="font-size: 14px; margin-bottom: 20px;">Get started by adding your first inventory item.</p>
                            <a href="<?= base_url('dashboard/inventory/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i>Add Item
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
