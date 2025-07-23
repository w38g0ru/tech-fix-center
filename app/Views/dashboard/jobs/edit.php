<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Job #<?= $job['id'] ?></h1>
        <p class="mt-1 text-sm text-gray-600">Update job information</p>
    </div>
    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
        <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-all duration-200 shadow-lg shadow-blue-500/25">
            <i class="fas fa-eye mr-2"></i>
            View Job
        </a>
        <a href="<?= base_url('dashboard/jobs') ?>"
           class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200 shadow-lg shadow-gray-500/25">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Jobs
        </a>
    </div>
</div>

<!-- Error Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-800"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/jobs/update/' . $job['id']) ?>" method="POST" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>
            
            <!-- Customer Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-circle text-blue-600 mr-3"></i>
                        Customer Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Update customer details for this job</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Selection -->
                    <div>
                    <?php
                    // Determine current customer type
                    $currentCustomerType = '';
                    if (!empty($job['user_id'])) {
                        $currentCustomerType = 'existing';
                    } elseif (!empty($job['walk_in_customer_name']) || (empty($job['user_id']) && empty($job['walk_in_customer_name']))) {
                        $currentCustomerType = 'walk_in';
                    }
                    ?>

                    <label for="customer_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Customer Type <span class="text-red-500">*</span>
                    </label>
                    <select id="customer_type"
                            name="customer_type"
                            onchange="toggleCustomerFields()"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Select Customer Type</option>
                        <option value="existing" <?= old('customer_type', $currentCustomerType) === 'existing' ? 'selected' : '' ?>>Existing Customer</option>
                        <option value="walk_in" <?= old('customer_type', $currentCustomerType) === 'walk_in' ? 'selected' : '' ?>>Walk-in Customer</option>
                    </select>

                    <!-- Existing Customer Selection -->
                    <div id="existing_customer_field" class="mt-3 <?= $currentCustomerType !== 'existing' ? 'hidden' : '' ?>">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Customer
                        </label>
                        <select id="user_id"
                                name="user_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.user_id') ? 'border-red-500' : '' ?>">
                            <option value="">Select a customer</option>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= old('user_id', $job['user_id']) == $user['id'] ? 'selected' : '' ?>>
                                        <?= esc($user['name']) ?>
                                        <?php if (!empty($user['mobile_number'])): ?>
                                            - <?= esc($user['mobile_number']) ?>
                                        <?php endif; ?>
                                        (<?= esc($user['user_type']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (session('errors.user_id')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.user_id') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Walk-in Customer Details -->
                    <div id="walk_in_customer_field" class="mt-3 <?= $currentCustomerType !== 'walk_in' ? 'hidden' : '' ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Walk-in Customer Name -->
                            <div>
                                <label for="walk_in_customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Customer Name (Optional)
                                </label>
                                <input type="text"
                                       id="walk_in_customer_name"
                                       name="walk_in_customer_name"
                                       value="<?= old('walk_in_customer_name', $job['walk_in_customer_name']) ?>"
                                       placeholder="e.g., रमेश श्रेष्ठ"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.walk_in_customer_name') ? 'border-red-500' : '' ?>">
                                <?php if (session('errors.walk_in_customer_name')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= session('errors.walk_in_customer_name') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Walk-in Customer Mobile -->
                            <div>
                                <label for="walk_in_customer_mobile" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mobile Number (Optional)
                                </label>
                                <input type="tel"
                                       id="walk_in_customer_mobile"
                                       name="walk_in_customer_mobile"
                                       value="<?= old('walk_in_customer_mobile', $job['walk_in_customer_mobile'] ?? '') ?>"
                                       placeholder="e.g., 9841234567"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.walk_in_customer_mobile') ? 'border-red-500' : '' ?>">
                                <?php if (session('errors.walk_in_customer_mobile')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= session('errors.walk_in_customer_mobile') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <p class="mt-3 text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Both fields are optional. Leave name blank to show "Walk-in Customer" only.
                        </p>
                    </div>
                </div>

                <!-- Technician Assignment -->
                <div>
                    <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Assign Technician
                    </label>
                    <select id="technician_id"
                            name="technician_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.technician_id') ? 'border-red-500' : '' ?>">
                        <option value="">Unassigned</option>
                        <?php if (!empty($technicians)): ?>
                            <?php foreach ($technicians as $technician): ?>
                                <option value="<?= $technician['id'] ?>" <?= old('technician_id', $job['technician_id']) == $technician['id'] ? 'selected' : '' ?>>
                                    <?= esc($technician['full_name']) ?>
                                    <?php if (isset($technician['active_jobs'])): ?>
                                        (<?= $technician['active_jobs'] ?> active jobs)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (session('errors.technician_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.technician_id') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Device Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-mobile-alt text-green-600 mr-3"></i>
                        Device Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Update device details and specifications</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Device Name -->
                    <div>
                    <label for="device_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Device Name
                    </label>
                    <input type="text"
                           id="device_name"
                           name="device_name"
                           value="<?= old('device_name', $job['device_name']) ?>"
                           placeholder="e.g., iPhone 12, Samsung Galaxy S21"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.device_name') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.device_name')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.device_name') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Serial Number -->
                <div>
                    <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Serial Number
                    </label>
                    <input type="text"
                           id="serial_number"
                           name="serial_number"
                           value="<?= old('serial_number', $job['serial_number']) ?>"
                           placeholder="Device serial number or IMEI"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.serial_number') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.serial_number')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.serial_number') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Job Details Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-clipboard-list text-orange-600 mr-3"></i>
                        Job Details
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Update job status, problem description, and charges</p>
                </div>

                <!-- Problem Description -->
                <div>
                <label for="problem" class="block text-sm font-medium text-gray-700 mb-2">
                    Problem Description
                </label>
                <textarea id="problem"
                          name="problem"
                          rows="4"
                          placeholder="Describe the issue with the device..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.problem') ? 'border-red-500' : '' ?>"><?= old('problem', $job['problem']) ?></textarea>
                <?php if (session('errors.problem')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.problem') ?></p>
                <?php endif; ?>
            </div>

            <!-- Job Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Job Status <span class="text-red-500">*</span>
                </label>
                <select id="status"
                        name="status"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.status') ? 'border-red-500' : '' ?>">
                    <option value="">Select status</option>
                    <option value="Pending" <?= old('status', $job['status']) === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= old('status', $job['status']) === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Parts Pending" <?= old('status', $job['status']) === 'Parts Pending' ? 'selected' : '' ?>>Parts Pending</option>
                    <option value="Referred to Service Center" <?= old('status', $job['status']) === 'Referred to Service Center' ? 'selected' : '' ?>>Referred to Service Center</option>
                    <option value="Ready to Dispatch to Customer" <?= old('status', $job['status']) === 'Ready to Dispatch to Customer' ? 'selected' : '' ?>>Ready to Dispatch to Customer</option>
                    <option value="Returned" <?= old('status', $job['status']) === 'Returned' ? 'selected' : '' ?>>Returned</option>
                    <option value="Completed" <?= old('status', $job['status']) === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <?php if (session('errors.status')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                <?php endif; ?>
            </div>

                <!-- Charge -->
                <div>
                    <label for="charge" class="block text-sm font-medium text-gray-700 mb-2">
                        Repair Charge (NPR)
                    </label>
                    <input type="number"
                           id="charge"
                           name="charge"
                           value="<?= old('charge', $job['charge'] ?? '0.00') ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.charge') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.charge')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.charge') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Estimated or final repair cost</p>
                </div>
            </div>

            <!-- Dispatch Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-shipping-fast text-green-600 mr-3"></i>
                        Dispatch Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Update dispatch and return details</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dispatch Type -->
                    <div>
                        <label for="dispatch_type" class="block text-sm font-medium text-gray-700 mb-2">Dispatch Type</label>
                        <select id="dispatch_type" name="dispatch_type" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Select Dispatch Type</option>
                            <?php foreach ($dispatchTypes as $key => $value): ?>
                                <option value="<?= esc($key) ?>" <?= old('dispatch_type', $job['dispatch_type'] ?? '') == $key ? 'selected' : '' ?>><?= esc($value) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Where will this job be dispatched?</p>
                    </div>

                    <!-- Service Center -->
                    <div>
                        <label for="service_center_id" class="block text-sm font-medium text-gray-700 mb-2">Service Center</label>
                        <select id="service_center_id" name="service_center_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Select Service Center</option>
                            <?php foreach ($serviceCenters as $center): ?>
                                <option value="<?= esc($center['id']) ?>" <?= old('service_center_id', $job['service_center_id'] ?? '') == $center['id'] ? 'selected' : '' ?>><?= esc($center['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Required if dispatching to service center</p>
                    </div>

                    <!-- Dispatch Date -->
                    <div>
                        <label for="dispatch_date" class="block text-sm font-medium text-gray-700 mb-2">Dispatch Date</label>
                        <input type="date" id="dispatch_date" name="dispatch_date" value="<?= old('dispatch_date', $job['dispatch_date'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <p class="mt-1 text-sm text-gray-500">When will this job be dispatched?</p>
                    </div>

                    <!-- Expected Return Date -->
                    <div>
                        <label for="expected_return_date" class="block text-sm font-medium text-gray-700 mb-2">Expected Return Date</label>
                        <input type="date" id="expected_return_date" name="expected_return_date" value="<?= old('expected_return_date', $job['expected_return_date'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <p class="mt-1 text-sm text-gray-500">When do you expect this job to return?</p>
                    </div>

                    <!-- Actual Return Date -->
                    <div>
                        <label for="actual_return_date" class="block text-sm font-medium text-gray-700 mb-2">Actual Return Date</label>
                        <input type="date" id="actual_return_date" name="actual_return_date" value="<?= old('actual_return_date', $job['actual_return_date'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <p class="mt-1 text-sm text-gray-500">When did this job actually return?</p>
                    </div>
                </div>

                <!-- Dispatch Notes -->
                <div>
                    <label for="dispatch_notes" class="block text-sm font-medium text-gray-700 mb-2">Dispatch Notes</label>
                    <textarea id="dispatch_notes" name="dispatch_notes" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                              placeholder="Enter any dispatch-related notes, instructions, or special requirements..."><?= old('dispatch_notes', $job['dispatch_notes'] ?? '') ?></textarea>
                    <p class="mt-1 text-sm text-gray-500">Additional information about dispatch requirements</p>
                </div>
            </div>

                <!-- Job Info -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Current Job Information
                    </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><strong>Job ID:</strong> #<?= $job['id'] ?></p>
                        <p><strong>सिर्जना:</strong> <?= formatNepaliDateTime($job['created_at'], 'medium') ?></p>
                    </div>
                    <div>
                        <p><strong>Current Status:</strong> 
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?= match($job['status']) {
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'In Progress' => 'bg-blue-100 text-blue-800',
                                'Completed' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800'
                            } ?>">
                                <?= esc($job['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                <a href="<?= base_url('dashboard/jobs') ?>"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-xl text-sm font-medium text-white hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg shadow-blue-500/25">
                    <i class="fas fa-save mr-2"></i>
                    Update Job
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle customer fields based on customer type selection
function toggleCustomerFields() {
    const customerType = document.getElementById('customer_type').value;
    const existingField = document.getElementById('existing_customer_field');
    const walkInField = document.getElementById('walk_in_customer_field');
    const userIdSelect = document.getElementById('user_id');
    const walkInInput = document.getElementById('walk_in_customer_name');

    // Hide both fields initially
    existingField.classList.add('hidden');
    walkInField.classList.add('hidden');

    // Show appropriate field based on selection
    if (customerType === 'existing') {
        existingField.classList.remove('hidden');
        userIdSelect.required = true;
        walkInInput.required = false;
        // Clear walk-in name when switching to existing customer
        if (!walkInInput.value) {
            walkInInput.value = '';
        }
    } else if (customerType === 'walk_in') {
        walkInField.classList.remove('hidden');
        userIdSelect.required = false;
        walkInInput.required = false;
        // Clear user selection when switching to walk-in
        userIdSelect.value = '';
        // Don't clear walk-in fields when switching to walk-in (preserve existing data)
    } else {
        userIdSelect.required = false;
        walkInInput.required = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a customer type selected and show appropriate field
    const customerType = document.getElementById('customer_type').value;
    if (customerType) {
        toggleCustomerFields();
    }
});
</script>

<?= $this->endSection() ?>
