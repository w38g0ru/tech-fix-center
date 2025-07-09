<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Job #<?= $job['id'] ?></h1>
        <p class="mt-1 text-sm text-gray-600">Update job information</p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
            <i class="fas fa-eye mr-2"></i>
            View Job
        </a>
        <a href="<?= base_url('dashboard/jobs') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Jobs
        </a>
    </div>
</div>

<div class="max-w-4xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/jobs/update/' . $job['id']) ?>" method="POST" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.user_id') ? 'border-red-500' : '' ?>">
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
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.walk_in_customer_name') ? 'border-red-500' : '' ?>">
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
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.walk_in_customer_mobile') ? 'border-red-500' : '' ?>">
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.technician_id') ? 'border-red-500' : '' ?>">
                        <option value="">Unassigned</option>
                        <?php if (!empty($technicians)): ?>
                            <?php foreach ($technicians as $technician): ?>
                                <option value="<?= $technician['id'] ?>" <?= old('technician_id', $job['technician_id']) == $technician['id'] ? 'selected' : '' ?>>
                                    <?= esc($technician['name']) ?>
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
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.device_name') ? 'border-red-500' : '' ?>">
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
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.serial_number') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.serial_number')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.serial_number') ?></p>
                    <?php endif; ?>
                </div>
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
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.problem') ? 'border-red-500' : '' ?>"><?= old('problem', $job['problem']) ?></textarea>
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.status') ? 'border-red-500' : '' ?>">
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

            <!-- Job Info -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Job Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><strong>Job ID:</strong> #<?= $job['id'] ?></p>
                        <p><strong>Created:</strong> <?= date('F j, Y \a\t g:i A', strtotime($job['created_at'])) ?></p>
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

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/jobs') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
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
