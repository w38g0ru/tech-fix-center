<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Parts Request</h1>
        <p class="mt-2 text-gray-600">Update parts request details</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('dashboard/parts-requests') ?>"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Parts Requests
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

<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">Please fix the following errors:</p>
                <ul class="mt-2 text-sm list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Parts Request Information</h3>
    </div>
    
    <form action="<?= base_url('dashboard/parts-requests/update/' . $partsRequest['id']) ?>" method="POST" class="p-6 space-y-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Part Name -->
            <div class="form-group">
                <label for="part_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Part Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="part_name" 
                       name="part_name" 
                       value="<?= old('part_name', $partsRequest['part_name']) ?>"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Part Number -->
            <div class="form-group">
                <label for="part_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Part Number
                </label>
                <input type="text" 
                       id="part_number" 
                       name="part_number" 
                       value="<?= old('part_number', $partsRequest['part_number']) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Quantity <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="quantity" 
                       name="quantity" 
                       value="<?= old('quantity', $partsRequest['quantity']) ?>"
                       min="1"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Urgency -->
            <div class="form-group">
                <label for="urgency" class="block text-sm font-medium text-gray-700 mb-2">
                    Urgency <span class="text-red-500">*</span>
                </label>
                <select id="urgency" 
                        name="urgency" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <?php foreach ($urgencyLevels as $level): ?>
                        <option value="<?= $level ?>" <?= old('urgency', $partsRequest['urgency']) === $level ? 'selected' : '' ?>>
                            <?= $level ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Estimated Cost -->
            <div class="form-group">
                <label for="estimated_cost" class="block text-sm font-medium text-gray-700 mb-2">
                    Estimated Cost (NPR)
                </label>
                <input type="number" 
                       id="estimated_cost" 
                       name="estimated_cost" 
                       value="<?= old('estimated_cost', $partsRequest['estimated_cost']) ?>"
                       step="0.01"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Expected Delivery Date -->
            <div class="form-group">
                <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Expected Delivery Date
                </label>
                <input type="date" 
                       id="expected_delivery_date" 
                       name="expected_delivery_date" 
                       value="<?= old('expected_delivery_date', $partsRequest['expected_delivery_date']) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Supplier Preference -->
            <div class="form-group md:col-span-2">
                <label for="supplier_preference" class="block text-sm font-medium text-gray-700 mb-2">
                    Supplier Preference
                </label>
                <input type="text" 
                       id="supplier_preference" 
                       name="supplier_preference" 
                       value="<?= old('supplier_preference', $partsRequest['supplier_preference']) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Admin-only fields -->
            <?php if (in_array($userRole, ['superadmin', 'admin'])): ?>
                <!-- Job Assignment -->
                <div class="form-group">
                    <label for="job_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Related Job
                    </label>
                    <select id="job_id" 
                            name="job_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Job (Optional)</option>
                        <?php foreach ($jobs as $job): ?>
                            <option value="<?= $job['id'] ?>" <?= old('job_id', $partsRequest['job_id']) == $job['id'] ? 'selected' : '' ?>>
                                Job #<?= $job['id'] ?> - <?= esc($job['customer_name']) ?> (<?= esc($job['device_model']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Technician Assignment -->
                <div class="form-group">
                    <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Assigned Technician
                    </label>
                    <select id="technician_id" 
                            name="technician_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Technician</option>
                        <?php foreach ($technicians as $technician): ?>
                            <option value="<?= $technician['id'] ?>" <?= old('technician_id', $partsRequest['technician_id']) == $technician['id'] ? 'selected' : '' ?>>
                                <?= esc($technician['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Description -->
            <div class="form-group md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description/Notes
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Additional details about the part request..."><?= old('description', $partsRequest['description']) ?></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>
                Update Parts Request
            </button>
            
            <a href="<?= base_url('dashboard/parts-requests') ?>"
               class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
