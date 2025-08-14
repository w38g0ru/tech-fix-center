<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add Stock Movement</h1>
        <p class="mt-1 text-sm text-gray-600">Record stock IN or OUT movement</p>
    </div>
    <div class="flex items-center justify-start lg:justify-end gap-2">
        <a href="<?= base_url('dashboard/movements') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
           title="Back to Movements">
            <i class="fas fa-arrow-left text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Movements</span>
        </a>
    </div>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/movements/store') ?>" method="POST" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>
            
            <!-- Stock Movement Information -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-boxes text-blue-600 mr-3"></i>
                        Stock Movement Details
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Record inventory stock movement (IN/OUT)</p>
                </div>

                <!-- Inventory Item -->
                <div>
                    <label for="item_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Inventory Item <span class="text-red-500">*</span>
                    </label>
                    <select id="item_id"
                            name="item_id"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.item_id') ? 'border-red-500' : '' ?>">
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
                <?php if (!empty($selectedJob)): ?>
                    <!-- Show selected job info -->
                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-900">
                                    Job #<?= $selectedJob['id'] ?> - <?= esc($selectedJob['device_name']) ?>
                                </p>
                                <?php if (!empty($selectedJob['customer_name'])): ?>
                                    <p class="text-sm text-blue-700">
                                        Customer: <?= esc($selectedJob['customer_name']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <button type="button" onclick="clearJobSelection()" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
                <select id="job_id"
                        name="job_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.job_id') ? 'border-red-500' : '' ?>">
                    <option value="">No job linked</option>
                    <?php if (!empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                            <option value="<?= $job['id'] ?>" <?= (old('job_id', $selectedJobId ?? '') == $job['id']) ? 'selected' : '' ?>>
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

            <script>
            function clearJobSelection() {
                document.getElementById('job_id').value = '';
                // Remove the selected job info div
                const selectedJobDiv = document.querySelector('.bg-blue-50');
                if (selectedJobDiv) {
                    selectedJobDiv.remove();
                }
            }
            </script>

            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-2 pt-8 border-t border-gray-200">
                <a href="<?= base_url('dashboard/movements') ?>"
                   class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                   title="Cancel and Return">
                    <i class="fas fa-times text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Cancel</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                        title="Record Stock Movement">
                    <i class="fas fa-save text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Record Movement</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
