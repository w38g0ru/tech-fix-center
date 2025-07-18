<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add Stock Movement</h1>
        <p class="mt-1 text-sm text-gray-600">Record stock IN or OUT movement</p>
    </div>
    <a href="<?= base_url('dashboard/movements') ?>" 
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Movements
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/movements/store') ?>" method="POST" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
            <!-- Inventory Item -->
            <div>
                <label for="item_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Inventory Item <span class="text-red-500">*</span>
                </label>
                <select id="item_id" 
                        name="item_id" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.item_id') ? 'border-red-500' : '' ?>">
                    <option value="">Select an inventory item</option>
                    <?php if (!empty($inventoryItems)): ?>
                        <?php foreach ($inventoryItems as $item): ?>
                            <option value="<?= $item['id'] ?>" <?= old('item_id') == $item['id'] ? 'selected' : '' ?>>
                                <?= esc($item['device_name']) ?> - <?= esc($item['brand']) ?> <?= esc($item['model']) ?> (Stock: <?= $item['total_stock'] ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if (session('errors.item_id')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.item_id') ?></p>
                <?php endif; ?>
            </div>

            <!-- Movement Type -->
            <div>
                <label for="movement_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Movement Type <span class="text-red-500">*</span>
                </label>
                <select id="movement_type" 
                        name="movement_type" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.movement_type') ? 'border-red-500' : '' ?>">
                    <option value="">Select movement type</option>
                    <option value="IN" <?= old('movement_type') === 'IN' ? 'selected' : '' ?>>IN - Stock Received</option>
                    <option value="OUT" <?= old('movement_type') === 'OUT' ? 'selected' : '' ?>>OUT - Stock Used</option>
                </select>
                <?php if (session('errors.movement_type')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.movement_type') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">
                    <strong>IN:</strong> Adding stock (purchases, returns)<br>
                    <strong>OUT:</strong> Using stock (repairs, sales)
                </p>
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Quantity <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="quantity" 
                       name="quantity" 
                       value="<?= old('quantity', 1) ?>"
                       min="1"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.quantity') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.quantity')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.quantity') ?></p>
                <?php endif; ?>
            </div>

            <!-- Related Job (Optional) -->
            <div>
                <label for="job_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Related Job (Optional)
                </label>
                <select id="job_id" 
                        name="job_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.job_id') ? 'border-red-500' : '' ?>">
                    <option value="">No job linked</option>
                    <?php if (!empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                            <option value="<?= $job['id'] ?>" <?= old('job_id') == $job['id'] ? 'selected' : '' ?>>
                                Job #<?= $job['id'] ?> - <?= esc($job['device_name']) ?> 
                                <?php if (!empty($job['customer_name'])): ?>
                                    (<?= esc($job['customer_name']) ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if (session('errors.job_id')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.job_id') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Link this movement to a specific repair job</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/movements') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Record Movement
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
