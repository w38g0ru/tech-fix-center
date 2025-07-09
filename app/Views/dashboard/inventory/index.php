<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Inventory</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your inventory items and stock levels</p>
    </div>
    <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
        <!-- Import/Export Buttons -->
        <div class="flex gap-2">
            <a href="<?= base_url('dashboard/inventory/downloadTemplate') ?>"
               class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
               title="Download CSV template for bulk import">
                <i class="fas fa-download mr-2"></i>
                Template
            </a>

            <a href="<?= base_url('dashboard/inventory/bulk-import') ?>"
               class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
               title="Import items from CSV/Excel file">
                <i class="fas fa-upload mr-2"></i>
                Import
            </a>

            <a href="<?= base_url('dashboard/inventory/export') ?>"
               class="inline-flex items-center px-3 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150"
               title="Export all inventory items to CSV">
                <i class="fas fa-file-export mr-2"></i>
                Export
            </a>
        </div>

        <!-- Add Item Button -->
        <a href="<?= base_url('dashboard/inventory/create') ?>"
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Add Item
        </a>
    </div>
</div>

<!-- Inventory Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Items</p>
                <p class="text-lg font-semibold text-gray-900"><?= $inventoryStats['total_items'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-cubes"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Stock</p>
                <p class="text-lg font-semibold text-gray-900"><?= $inventoryStats['total_stock'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Low Stock</p>
                <p class="text-lg font-semibold text-gray-900"><?= $inventoryStats['low_stock'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                <p class="text-lg font-semibold text-gray-900"><?= $inventoryStats['out_of_stock'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="mb-6">
    <form method="GET" action="<?= base_url('dashboard/inventory') ?>" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" 
                   name="search" 
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search inventory by device name, brand, or model..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/inventory') ?>" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Inventory Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Item Details
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Brand & Model
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock Level
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pricing
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                            <i class="fas fa-box text-orange-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($item['device_name'] ?? 'N/A') ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?= esc($item['brand'] ?? 'N/A') ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= esc($item['model'] ?? 'N/A') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $stockClass = 'bg-green-100 text-green-800';
                                if ($item['total_stock'] <= 0) {
                                    $stockClass = 'bg-red-100 text-red-800';
                                } elseif ($item['total_stock'] <= 10) {
                                    $stockClass = 'bg-yellow-100 text-yellow-800';
                                }
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $stockClass ?>">
                                    <?= $item['total_stock'] ?> units
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if (!empty($item['selling_price'])): ?>
                                    <div class="text-sm font-medium text-gray-900">NPR <?= number_format($item['selling_price'], 2) ?></div>
                                    <?php if (!empty($item['purchase_price'])): ?>
                                        <div class="text-xs text-gray-500">Cost: NPR <?= number_format($item['purchase_price'], 2) ?></div>
                                    <?php endif; ?>
                                <?php elseif (!empty($item['purchase_price'])): ?>
                                    <div class="text-sm text-gray-900">NPR <?= number_format($item['purchase_price'], 2) ?></div>
                                    <div class="text-xs text-gray-500">Purchase price</div>
                                <?php else: ?>
                                    <span class="text-gray-400">No pricing</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php
                                    switch($item['status'] ?? 'Active') {
                                        case 'Active':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'Inactive':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'Discontinued':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?= esc($item['status'] ?? 'Active') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>" 
                                       class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('dashboard/inventory/delete/' . $item['id']) ?>" 
                                       onclick="return confirm('Are you sure you want to delete this item?')"
                                       class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-boxes text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No inventory items found</p>
                                <p class="text-sm">Get started by adding your first inventory item.</p>
                                <a href="<?= base_url('dashboard/inventory/create') ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Item
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
