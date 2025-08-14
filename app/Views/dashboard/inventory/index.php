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
$isAdmin = in_array($role, ['admin', 'superadmin']);
?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-semibold text-gray-900">Inventory Management</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $isAdmin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                        <i class="fas <?= $isAdmin ? 'fa-crown' : 'fa-user' ?> mr-1"></i>
                        <?= ucfirst($role) ?> Access
                    </span>
                </div>
                <p class="text-sm text-gray-600">
                    <?= $isAdmin ? 'Full inventory management with admin privileges' : 'Track stock levels and manage inventory items' ?>
                </p>
            </div>
        </div>
        <div class="flex items-center justify-start lg:justify-end gap-2">
            <?php if ($isAdmin): ?>
                <button onclick="showBulkActions()"
                        class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                        title="Download Template">
                    <i class="fas fa-download text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Template</span>
                </button>
                <a href="<?= base_url('dashboard/inventory/bulk-import') ?>"
                   class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                   title="Import items from CSV/Excel file">
                    <i class="fas fa-upload text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Import</span>
                </a>
                <a href="<?= base_url('dashboard/inventory/export') ?>"
                   class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                   title="Export all inventory items to CSV">
                    <i class="fas fa-file-export text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Export</span>
                </a>
            <?php endif; ?>
            <a href="<?= base_url('dashboard/inventory/create') ?>"
               class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
               title="Add New Inventory Item">
                <i class="fas fa-plus text-sm"></i>
                <span class="hidden md:inline md:ml-2 whitespace-nowrap">Add New Item</span>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <?php
    $stats = [
        [
            'label' => 'Total Items',
            'value' => $inventoryStats['total_items'],
            'color' => 'blue',
            'icon' => 'fa-boxes',
            'trend' => '+12%',
            'description' => 'Total inventory items'
        ],
        [
            'label' => 'Total Stock',
            'value' => $inventoryStats['total_stock'],
            'color' => 'green',
            'icon' => 'fa-cubes',
            'trend' => '+8%',
            'description' => 'Units in stock'
        ],
        [
            'label' => 'Low Stock',
            'value' => $inventoryStats['low_stock'],
            'color' => 'orange',
            'icon' => 'fa-exclamation-triangle',
            'trend' => '-5%',
            'description' => 'Items need reorder'
        ],
        [
            'label' => 'Out of Stock',
            'value' => $inventoryStats['out_of_stock'],
            'color' => 'red',
            'icon' => 'fa-times-circle',
            'trend' => '-15%',
            'description' => 'Items unavailable'
        ],
    ];
    foreach ($stats as $s): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-<?= $s['color'] ?>-500 to-<?= $s['color'] ?>-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas <?= $s['icon'] ?> text-white text-xl"></i>
                </div>
                <span class="text-xs font-medium text-<?= $s['color'] ?>-600 bg-<?= $s['color'] ?>-50 px-2 py-1 rounded-full">
                    <?= $s['trend'] ?>
                </span>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= number_format($s['value']) ?></h3>
                <p class="text-sm font-medium text-gray-900 mb-1"><?= $s['label'] ?></p>
                <p class="text-xs text-gray-500"><?= $s['description'] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Advanced Search & Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Search & Filter</h3>
        <button type="button" onclick="toggleAdvancedFilters()" class="text-sm text-green-600 hover:text-green-700 font-medium">
            <i class="fas fa-sliders-h mr-1"></i>Advanced Filters
        </button>
    </div>

    <form method="GET" action="<?= base_url('dashboard/inventory') ?>" class="space-y-4">
        <!-- Main Search -->
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Inventory</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                           placeholder="Search by device name, brand, model, or SKU..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button type="submit"
                        class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                        title="Search Inventory">
                    <i class="fas fa-search text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Search</span>
                </button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('dashboard/inventory') ?>"
                       class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                       title="Clear Search">
                        <i class="fas fa-times text-sm"></i>
                        <span class="hidden md:inline md:ml-2 whitespace-nowrap">Clear</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Filters -->
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-medium text-gray-700 hidden md:inline">Quick Filters:</span>
            <button type="button" onclick="filterByStock('all')" class="inline-flex items-center justify-center min-w-0 px-3 py-1.5 text-xs font-medium rounded-full border bg-white text-gray-700 border-gray-300 hover:border-green-500 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 cursor-pointer" title="Show All Items">All</button>
            <button type="button" onclick="filterByStock('low')" class="inline-flex items-center justify-center min-w-0 px-3 py-1.5 text-xs font-medium rounded-full border bg-white text-gray-700 border-gray-300 hover:border-green-500 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 cursor-pointer" title="Show Low Stock Items">Low</button>
            <button type="button" onclick="filterByStock('out')" class="inline-flex items-center justify-center min-w-0 px-3 py-1.5 text-xs font-medium rounded-full border bg-white text-gray-700 border-gray-300 hover:border-green-500 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 cursor-pointer" title="Show Out of Stock Items">Out</button>
            <button type="button" onclick="filterByStatus('active')" class="inline-flex items-center justify-center min-w-0 px-3 py-1.5 text-xs font-medium rounded-full border bg-white text-gray-700 border-gray-300 hover:border-green-500 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 cursor-pointer" title="Show Active Items">Active</button>
            <button type="button" onclick="filterByStatus('inactive')" class="inline-flex items-center justify-center min-w-0 px-3 py-1.5 text-xs font-medium rounded-full border bg-white text-gray-700 border-gray-300 hover:border-green-500 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 cursor-pointer" title="Show Inactive Items">Inactive</button>
        </div>

        <!-- Advanced Filters (Hidden by default) -->
        <div id="advancedFilters" class="hidden grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="accessories">Accessories</option>
                    <option value="parts">Parts</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Range</label>
                <select name="stock_range" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Any Stock Level</option>
                    <option value="0">Out of Stock (0)</option>
                    <option value="1-10">Low Stock (1-10)</option>
                    <option value="11-50">Medium Stock (11-50)</option>
                    <option value="50+">High Stock (50+)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                <select name="price_range" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Any Price</option>
                    <option value="0-1000">NPR 0 - 1,000</option>
                    <option value="1000-5000">NPR 1,000 - 5,000</option>
                    <option value="5000-10000">NPR 5,000 - 10,000</option>
                    <option value="10000+">NPR 10,000+</option>
                </select>
            </div>
        </div>
    </form>
</div>

<!-- Bulk Actions (Admin Only) -->
<?php if ($isAdmin && !empty($items)): ?>
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
            <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
            <span id="selectedCount" class="text-sm text-gray-500">0 items selected</span>
        </div>
        <div id="bulkActions" class="hidden flex items-center space-x-1 sm:space-x-2">
            <button onclick="bulkUpdateStatus('active')" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm bg-green-100 text-green-800 rounded-lg hover:bg-green-200 transition-colors" title="Activate Selected Items">
                <i class="fas fa-check"></i>
                <span class="hidden sm:inline sm:ml-1">Activate</span>
            </button>
            <button onclick="bulkUpdateStatus('inactive')" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors" title="Deactivate Selected Items">
                <i class="fas fa-pause"></i>
                <span class="hidden sm:inline sm:ml-1">Deactivate</span>
            </button>
            <button onclick="bulkDelete()" class="px-2 sm:px-3 py-1.5 text-xs sm:text-sm bg-red-100 text-red-800 rounded-lg hover:bg-red-200 transition-colors" title="Delete Selected Items">
                <i class="fas fa-trash"></i>
                <span class="hidden sm:inline sm:ml-1">Delete</span>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Enhanced Inventory Items -->
<div class="space-y-6">
    <?php if (!empty($items)): ?>
        <!-- View Toggle -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h3 class="text-lg font-semibold text-gray-900">Inventory Items</h3>
                <span class="text-sm text-gray-500"><?= count($items) ?> items found</span>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="toggleView('grid')" id="gridView" class="p-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                    <i class="fas fa-th-large"></i>
                </button>
                <button onclick="toggleView('list')" id="listView" class="p-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <!-- Grid View -->
        <div id="gridViewContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($items as $item): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group" data-item-id="<?= $item['id'] ?>">
                    <!-- Card Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <?php if ($isAdmin): ?>
                                <input type="checkbox" class="item-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500" value="<?= $item['id'] ?>">
                            <?php endif; ?>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-box text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors"><?= esc($item['device_name']) ?></h3>
                                <p class="text-xs text-gray-500">SKU: #<?= $item['id'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>"
                               class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                               title="View Details">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <?php if ($isAdmin): ?>
                                <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>"
                                   class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                   title="Edit Item">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deleteItem(<?= $item['id'] ?>)"
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                        title="Delete Item">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Item Details -->
                    <div class="space-y-3">
                        <!-- Brand & Model -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Brand:</span>
                            <span class="text-sm font-medium text-gray-900"><?= esc($item['brand'] ?? 'N/A') ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Model:</span>
                            <span class="text-sm text-gray-700"><?= esc($item['model'] ?? 'N/A') ?></span>
                        </div>

                        <!-- Stock Level with Visual Indicator -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Stock:</span>
                            <div class="flex items-center space-x-2">
                                <?php
                                $stockLevel = $item['total_stock'];
                                $stockIndicatorClass = $stockLevel <= 0 ? 'bg-red-500' : ($stockLevel <= 5 ? 'bg-orange-500' : ($stockLevel <= 20 ? 'bg-yellow-500' : 'bg-green-500'));
                                $stockBadge = $stockLevel <= 0 ? 'bg-red-100 text-red-800' : ($stockLevel <= 10 ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800');
                                ?>
                                <span class="w-3 h-3 rounded-full inline-block mr-2 <?= $stockIndicatorClass ?>"></span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $stockBadge ?>">
                                    <?= $stockLevel ?> units
                                </span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="border-t border-gray-100 pt-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Selling Price:</span>
                                <?php if (!empty($item['selling_price'])): ?>
                                    <span class="text-sm font-semibold text-gray-900">NPR <?= number_format($item['selling_price'], 2) ?></span>
                                <?php else: ?>
                                    <span class="text-sm text-gray-400">Not set</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item['purchase_price']) && $isAdmin): ?>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-500">Cost Price:</span>
                                    <span class="text-xs text-gray-600">NPR <?= number_format($item['purchase_price'], 2) ?></span>
                                </div>
                                <?php if (!empty($item['selling_price'])): ?>
                                    <?php $margin = (($item['selling_price'] - $item['purchase_price']) / $item['selling_price']) * 100; ?>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-xs text-gray-500">Margin:</span>
                                        <span class="text-xs font-medium <?= $margin > 20 ? 'text-green-600' : ($margin > 10 ? 'text-yellow-600' : 'text-red-600') ?>">
                                            <?= number_format($margin, 1) ?>%
                                        </span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColors[$item['status']] ?? 'bg-gray-100 text-gray-800' ?>">
                                <?= esc($item['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager): ?>
            <div class="mt-8 flex justify-center">
                <?php helper('pagination'); ?>
                <?= renderPagination($pager) ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Enhanced Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-16 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-boxes text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No inventory items found</h3>
                <p class="text-gray-600 mb-8">Get started by adding your first inventory item to track stock levels and manage your products efficiently.</p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="<?= base_url('dashboard/inventory/create') ?>"
                       class="inline-flex items-center justify-center min-w-0 px-6 py-3 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>Add First Item
                    </a>
                    <?php if ($isAdmin): ?>
                        <a href="<?= base_url('dashboard/inventory/bulk-import') ?>"
                           class="inline-flex items-center justify-center min-w-0 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                            <i class="fas fa-upload mr-2"></i>Import Items
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript for Enhanced Functionality -->
<script>
// Advanced Filters Toggle
function toggleAdvancedFilters() {
    const filters = document.getElementById('advancedFilters');
    filters.classList.toggle('hidden');
}

// Quick Filter Functions
function filterByStock(type) {
    // Update active state of filter buttons
    updateFilterButtonStates('stock', type);

    const url = new URL(window.location);
    if (type === 'all') {
        url.searchParams.delete('stock_filter');
    } else {
        url.searchParams.set('stock_filter', type);
    }
    window.location.href = url.toString();
}

function filterByStatus(status) {
    // Update active state of filter buttons
    updateFilterButtonStates('status', status);

    const url = new URL(window.location);
    url.searchParams.set('status_filter', status);
    window.location.href = url.toString();
}

// Update filter button active states
function updateFilterButtonStates(filterType, activeValue) {
    const buttons = document.querySelectorAll('[onclick*="filter"]');
    buttons.forEach(button => {
        // Reset all buttons to inactive state
        button.classList.remove('bg-green-600', 'text-white', 'border-green-600');
        button.classList.add('bg-white', 'text-gray-700', 'border-gray-300');

        // Set active button
        if ((filterType === 'stock' && button.onclick.toString().includes(`'${activeValue}'`)) ||
            (filterType === 'status' && button.onclick.toString().includes(`'${activeValue}'`))) {
            button.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
            button.classList.add('bg-green-600', 'text-white', 'border-green-600');
        }
    });
}

// View Toggle
function toggleView(viewType) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridContainer = document.getElementById('gridViewContainer');

    if (viewType === 'grid') {
        gridView.classList.add('text-green-600', 'bg-green-50');
        listView.classList.remove('text-green-600', 'bg-green-50');
        gridContainer.classList.remove('hidden');
        localStorage.setItem('inventoryView', 'grid');
    } else {
        listView.classList.add('text-green-600', 'bg-green-50');
        gridView.classList.remove('text-green-600', 'bg-green-50');
        // List view implementation would go here
        localStorage.setItem('inventoryView', 'list');
    }
}

// Bulk Actions
function initializeBulkActions() {
    const selectAll = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const bulkActions = document.getElementById('bulkActions');

    if (!selectAll) return;

    selectAll.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        const count = checkedBoxes.length;

        selectedCount.textContent = `${count} items selected`;

        if (count > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }

        // Update select all checkbox state
        selectAll.indeterminate = count > 0 && count < itemCheckboxes.length;
        selectAll.checked = count === itemCheckboxes.length;
    }
}

// Bulk Operations
function bulkUpdateStatus(status) {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);

    if (ids.length === 0) {
        alert('Please select items to update.');
        return;
    }

    if (confirm(`Are you sure you want to ${status === 'active' ? 'activate' : 'deactivate'} ${ids.length} items?`)) {
        // Implementation would send AJAX request to bulk update endpoint
        console.log('Bulk update status:', status, 'IDs:', ids);
        // window.location.href = `<?= base_url('dashboard/inventory/bulk-update-status') ?>?ids=${ids.join(',')}&status=${status}`;
    }
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);

    if (ids.length === 0) {
        alert('Please select items to delete.');
        return;
    }

    if (confirm(`Are you sure you want to delete ${ids.length} items? This action cannot be undone.`)) {
        // Implementation would send AJAX request to bulk delete endpoint
        console.log('Bulk delete IDs:', ids);
        // window.location.href = `<?= base_url('dashboard/inventory/bulk-delete') ?>?ids=${ids.join(',')}`;
    }
}

// Individual Item Actions
function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        window.location.href = `<?= base_url('dashboard/inventory/delete/') ?>${id}`;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize bulk actions
    initializeBulkActions();

    // Restore view preference
    const savedView = localStorage.getItem('inventoryView') || 'grid';
    toggleView(savedView);

    // Add staggered animation to cards using Tailwind classes
    const cards = document.querySelectorAll('[data-item-id]');
    cards.forEach((card, index) => {
        // Add initial hidden state
        card.classList.add('opacity-0', 'translate-y-4');

        // Animate in with delay
        setTimeout(() => {
            card.classList.remove('opacity-0', 'translate-y-4');
            card.classList.add('opacity-100', 'translate-y-0');
        }, index * 50);
    });
});
</script>

<?= $this->endSection() ?>
