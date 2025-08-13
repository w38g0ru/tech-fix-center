<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900"><?= esc($item['device_name']) ?></h1>
        <p class="mt-1 text-sm text-gray-600">Inventory item details and movement history</p>
    </div>
    <div class="flex items-center gap-2">
        <?php
        $userRole = session('access_level') ?? session('role') ?? 'guest';
        if (in_array($userRole, ['admin', 'superadmin'])):
        ?>
            <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>"
               class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200"
               title="Edit Item">
                <i class="fas fa-edit text-sm"></i>
                <span class="hidden md:inline md:ml-2 whitespace-nowrap">Edit Item</span>
            </a>
        <?php endif; ?>
        <a href="<?= base_url('dashboard/inventory') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
           title="Back to Inventory">
            <i class="fas fa-arrow-left text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Inventory</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Item Details -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Item Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Device Name</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($item['device_name']) ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Brand</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($item['brand'] ?: 'N/A') ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Model</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($item['model'] ?: 'N/A') ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Category</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($item['category'] ?: 'N/A') ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Supplier</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($item['supplier'] ?: 'N/A') ?></p>
                    </div>
                </div>
                
                <!-- Stock and Pricing -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Current Stock</label>
                        <p class="mt-1 text-lg font-semibold <?= $item['total_stock'] <= ($item['minimum_order_level'] ?: 0) ? 'text-red-600' : 'text-green-600' ?>">
                            <?= number_format($item['total_stock']) ?>
                            <?php if ($item['total_stock'] <= ($item['minimum_order_level'] ?: 0)): ?>
                                <span class="text-xs text-red-500 ml-2">
                                    <i class="fas fa-exclamation-triangle"></i> Low Stock
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Minimum Order Level</label>
                        <p class="mt-1 text-sm text-gray-900"><?= $item['minimum_order_level'] ? number_format($item['minimum_order_level']) : 'Not set' ?></p>
                    </div>
                    
                    <?php if (hasAnyRole(['superadmin', 'admin'])): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Purchase Price</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?= $item['purchase_price'] ? 'NPR ' . number_format($item['purchase_price'], 2) : 'Not set' ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Selling Price</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <?= $item['selling_price'] ? 'NPR ' . number_format($item['selling_price'], 2) : 'Not set' ?>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php
                            switch($item['status']) {
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
                            <?= esc($item['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <?php if (!empty($item['description'])): ?>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md"><?= esc($item['description']) ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Timestamps -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                    <div>
                        <span class="font-medium">सिर्जना:</span>
                        <?= formatNepaliDateTime($item['created_at'], 'short') ?>
                    </div>
                    <div>
                        <span class="font-medium">अन्तिम अपडेट:</span>
                        <?= formatNepaliDateTime($item['updated_at'], 'short') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <?php
        $userRole = session('access_level') ?? session('role') ?? 'guest';
        if (in_array($userRole, ['admin', 'superadmin'])):
        ?>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Item
                </a>

                <button onclick="confirmDelete(<?= $item['id'] ?>)"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Item
                </button>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Stock Status -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Stock Status</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Current Stock:</span>
                    <span class="text-sm font-medium text-gray-900"><?= number_format($item['total_stock']) ?></span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Min. Order Level:</span>
                    <span class="text-sm font-medium text-gray-900"><?= $item['minimum_order_level'] ? number_format($item['minimum_order_level']) : 'Not set' ?></span>
                </div>
                
                <?php if ($item['minimum_order_level'] && $item['total_stock'] <= $item['minimum_order_level']): ?>
                <div class="bg-red-50 border border-red-200 rounded-md p-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Low Stock Alert</h3>
                            <p class="text-sm text-red-700 mt-1">Stock is at or below minimum order level. Consider reordering.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Pricing Information -->
        <?php
        $showPurchasePrice = hasAnyRole(['superadmin', 'admin']) && $item['purchase_price'];
        $showPricingSection = $showPurchasePrice || $item['selling_price'];
        ?>
        <?php if ($showPricingSection): ?>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing</h3>
            <div class="space-y-3">
                <?php if ($showPurchasePrice): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Purchase Price:</span>
                    <span class="text-sm font-medium text-gray-900">NPR <?= number_format($item['purchase_price'], 2) ?></span>
                </div>
                <?php endif; ?>

                <?php if ($item['selling_price']): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Selling Price:</span>
                    <span class="text-sm font-medium text-gray-900">NPR <?= number_format($item['selling_price'], 2) ?></span>
                </div>
                <?php endif; ?>

                <?php if ($showPurchasePrice && $item['selling_price']): ?>
                <div class="pt-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Profit Margin:</span>
                        <span class="text-sm font-medium text-green-600">
                            NPR <?= number_format($item['selling_price'] - $item['purchase_price'], 2) ?>
                            (<?= number_format((($item['selling_price'] - $item['purchase_price']) / $item['purchase_price']) * 100, 1) ?>%)
                        </span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Movement History -->
<?php if (!empty($movements)): ?>
<div class="mt-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Movement History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($movements as $movement): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?= date('M j, Y', strtotime($movement['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?= $movement['movement_type'] === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= ucfirst($movement['movement_type']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?= number_format($movement['quantity']) ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <?= esc($movement['notes'] ?: 'No notes') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function confirmDelete(itemId) {
    if (confirm('Are you sure you want to delete this inventory item? This action cannot be undone.')) {
        window.location.href = '<?= base_url('dashboard/inventory/delete/') ?>' + itemId;
    }
}
</script>

<?= $this->endSection() ?>
