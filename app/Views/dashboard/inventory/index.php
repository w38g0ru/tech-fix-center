<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<?php
// Reusable status colors
$statusColors = [
    'Pending'      => 'bg-yellow-100 text-yellow-800',
    'In Progress'  => 'bg-blue-100 text-blue-800',
    'Low Stock'    => 'bg-orange-100 text-orange-800',
    'Ready'        => 'bg-green-100 text-green-800',
    'Inactive'     => 'bg-red-100 text-red-800',
    'Active'       => 'bg-green-100 text-green-800',
    'Discontinued' => 'bg-gray-200 text-gray-700',
];
$role = session('access_level') ?? session('role') ?? 'guest';
?>

<!-- Header -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-boxes text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Inventory Management</h1>
            <p class="text-sm text-gray-600">Track stock levels and manage inventory items efficiently</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <?php if (in_array($role, ['superadmin', 'admin'])): ?>
            <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-1">
                <a href="<?= base_url('dashboard/inventory/downloadTemplate') ?>"
                   class="btn-secondary text-green-700 hover:bg-green-50" title="Download CSV template">
                    <i class="fas fa-download mr-1"></i>Template
                </a>
                <a href="<?= base_url('dashboard/inventory/bulk-import') ?>"
                   class="btn-secondary text-blue-700 hover:bg-blue-50" title="Import from CSV/Excel">
                    <i class="fas fa-upload mr-1"></i>Import
                </a>
                <a href="<?= base_url('dashboard/inventory/export') ?>"
                   class="btn-secondary text-gray-700 hover:bg-gray-50" title="Export inventory">
                    <i class="fas fa-file-export mr-1"></i>Export
                </a>
            </div>
        <?php endif; ?>

        <a href="<?= base_url('dashboard/inventory/create') ?>"
           class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Add New Item
        </a>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <?php
    $stats = [
        ['label' => 'Total Items', 'value' => $inventoryStats['total_items'], 'color' => 'blue', 'icon' => 'fa-boxes'],
        ['label' => 'Total Stock', 'value' => $inventoryStats['total_stock'], 'color' => 'green', 'icon' => 'fa-cubes'],
        ['label' => 'Low Stock', 'value' => $inventoryStats['low_stock'], 'color' => 'orange', 'icon' => 'fa-exclamation-triangle'],
        ['label' => 'Out of Stock', 'value' => $inventoryStats['out_of_stock'], 'color' => 'red', 'icon' => 'fa-times-circle'],
    ];
    foreach ($stats as $s): ?>
        <div class="stat-card group">
            <div class="stat-icon bg-gradient-to-br from-<?= $s['color'] ?>-500 to-<?= $s['color'] ?>-600">
                <i class="fas <?= $s['icon'] ?> text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-3xl font-bold"><?= $s['value'] ?></h3>
                <p class="text-sm font-medium text-gray-600"><?= $s['label'] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <form method="GET" action="<?= base_url('dashboard/inventory') ?>" class="flex flex-col lg:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search Inventory</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                       placeholder="Search by device name, brand, or model..."
                       class="input-primary pl-10">
            </div>
        </div>
        <div class="flex items-end gap-3">
            <button type="submit" class="btn-primary flex items-center">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/inventory') ?>" class="btn-secondary flex items-center">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Items -->
<div class="space-y-4">
    <?php if (!empty($items)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($items as $item): ?>
                <div class="card hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-box text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold"><?= esc($item['device_name']) ?></h3>
                                <p class="text-xs text-gray-500">ID: #<?= $item['id'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>" class="icon-btn text-blue-600" title="View"><i class="fas fa-eye"></i></a>
                            <?php if (in_array($role, ['admin', 'superadmin'])): ?>
                                <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>" class="icon-btn text-green-600" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('dashboard/inventory/delete/' . $item['id']) ?>" onclick="return confirm('Delete this item?')" class="icon-btn text-red-600" title="Delete"><i class="fas fa-trash"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div><span class="text-gray-600">Brand:</span> <span class="font-medium"><?= esc($item['brand'] ?? 'N/A') ?></span></div>
                        <div><span class="text-gray-600">Model:</span> <?= esc($item['model'] ?? 'N/A') ?></div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stock:</span>
                            <?php
                            $stockBadge = $item['total_stock'] <= 0 ? 'bg-red-100 text-red-800' : ($item['total_stock'] <= 10 ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800');
                            ?>
                            <span class="badge <?= $stockBadge ?>"><?= $item['total_stock'] ?> units</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Price:</span>
                            <?php if (!empty($item['selling_price'])): ?>
                                <span class="font-medium">NPR <?= number_format($item['selling_price'], 2) ?></span>
                                <?php if (!empty($item['purchase_price']) && in_array($role, ['admin', 'superadmin'])): ?>
                                    <span class="block text-xs text-gray-500">Cost: NPR <?= number_format($item['purchase_price'], 2) ?></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-gray-400">No pricing</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="badge <?= $statusColors[$item['status']] ?? 'bg-gray-100 text-gray-800' ?>">
                                <?= esc($item['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($pager) && $pager): ?>
            <div class="mt-6"><?= renderPagination($pager) ?></div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-boxes text-5xl text-gray-300 mb-4"></i>
            <p class="text-lg font-medium">No inventory items found</p>
            <p class="text-sm text-gray-500 mb-6">Get started by adding your first item.</p>
            <a href="<?= base_url('dashboard/inventory/create') ?>" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>Add Item
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
