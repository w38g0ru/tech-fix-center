<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Create New Job</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new repair job</p>
    </div>
    <a href="<?= base_url('dashboard/jobs') ?>"
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200 shadow-lg shadow-gray-500/25">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Jobs
    </a>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/jobs/store') ?>" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Selection -->
                <div>
                    <label for="customer_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Customer Type <span class="text-red-500">*</span>
                    </label>
                    <select id="customer_type"
                            name="customer_type"
                            onchange="toggleCustomerFields()"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Customer Type</option>
                        <option value="existing" <?= old('customer_type') === 'existing' ? 'selected' : '' ?>>Existing Customer</option>
                        <option value="walk_in" <?= old('customer_type') === 'walk_in' ? 'selected' : '' ?>>Walk-in Customer</option>
                    </select>

                    <!-- Existing Customer Selection -->
                    <div id="existing_customer_field" class="mt-3 hidden">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Customer
                        </label>
                        <select id="user_id"
                                name="user_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.user_id') ? 'border-red-500' : '' ?>">
                            <option value="">Select a customer</option>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
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
                    <div id="walk_in_customer_field" class="mt-3 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Walk-in Customer Name -->
                            <div>
                                <label for="walk_in_customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Customer Name (Optional)
                                </label>
                                <input type="text"
                                       id="walk_in_customer_name"
                                       name="walk_in_customer_name"
                                       value="<?= old('walk_in_customer_name') ?>"
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
                                       value="<?= old('walk_in_customer_mobile') ?>"
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
                        <option value="">Assign later</option>
                        <?php if (!empty($technicians)): ?>
                            <?php foreach ($technicians as $technician): ?>
                                <option value="<?= $technician['id'] ?>" <?= old('technician_id') == $technician['id'] ? 'selected' : '' ?>>
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
                    <p class="mt-1 text-sm text-gray-500">Optional - Assign to available technician</p>
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
                           value="<?= old('device_name') ?>"
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
                           value="<?= old('serial_number') ?>"
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
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.problem') ? 'border-red-500' : '' ?>"><?= old('problem') ?></textarea>
                <?php if (session('errors.problem')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.problem') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Detailed description of the problem or repair needed</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Initial Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status"
                            name="status"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.status') ? 'border-red-500' : '' ?>">
                        <option value="">Select status</option>
                        <option value="Pending" <?= old('status') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="In Progress" <?= old('status') === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Parts Pending" <?= old('status') === 'Parts Pending' ? 'selected' : '' ?>>Parts Pending</option>
                        <option value="Referred to Service Center" <?= old('status') === 'Referred to Service Center' ? 'selected' : '' ?>>Referred to Service Center</option>
                        <option value="Ready to Dispatch to Customer" <?= old('status') === 'Ready to Dispatch to Customer' ? 'selected' : '' ?>>Ready to Dispatch to Customer</option>
                        <option value="Returned" <?= old('status') === 'Returned' ? 'selected' : '' ?>>Returned</option>
                        <option value="Completed" <?= old('status') === 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <?php if (session('errors.status')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Most jobs start as "Pending"</p>
                </div>

                <!-- Charge -->
                <div>
                    <label for="charge" class="block text-sm font-medium text-gray-700 mb-2">
                        Repair Charge (NPR)
                    </label>
                    <input type="number"
                           id="charge"
                           name="charge"
                           value="<?= old('charge', '0.00') ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.charge') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.charge')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.charge') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Estimated or final repair cost</p>
                </div>
            </div>

            <!-- Expected Return Date (Always Required) -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-calendar-check text-yellow-600 mr-2"></i>
                    <h3 class="text-sm font-medium text-yellow-900">Expected Return Date</h3>
                </div>
                <div>
                    <label for="expected_return_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Expected Return Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="expected_return_date" name="expected_return_date" value="<?= old('expected_return_date') ?>"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.expected_return_date') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.expected_return_date')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.expected_return_date') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-yellow-700 font-medium">⚠️ This field is required for all jobs regardless of status</p>
                </div>
            </div>

            <!-- Service Center Selection (shown when status is "Referred to Service Center") -->
            <div id="service_center_section" class="bg-blue-50 border border-blue-200 rounded-lg p-4" style="display: none;">
                <div class="flex items-center mb-3">
                    <i class="fas fa-building text-blue-600 mr-2"></i>
                    <h3 class="text-sm font-medium text-blue-900">Service Center Assignment</h3>
                </div>
                <div>
                    <label for="service_center_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Service Center Name <span class="text-red-500">*</span>
                    </label>
                    <select id="service_center_id" name="service_center_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Service Center</option>
                        <?php foreach ($serviceCenters as $center): ?>
                            <option value="<?= esc($center['id']) ?>" <?= old('service_center_id') == $center['id'] ? 'selected' : '' ?>><?= esc($center['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="mt-1 text-sm text-blue-700">Required when referring job to service center</p>
                </div>
            </div>

            <!-- Job Photos -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-camera text-blue-600 mr-2"></i>
                    <h3 class="text-sm font-medium text-blue-900">Job Photoproofs</h3>
                </div>
                <p class="text-sm text-blue-700 mb-3">Upload photos of the device before starting repair work</p>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-2">Upload Photos</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="job_photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-blue-300 border-dashed rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-camera text-blue-400 text-2xl mb-2"></i>
                                    <p class="mb-2 text-sm text-blue-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-blue-500">PNG, JPG, GIF up to 5MB each</p>
                                </div>
                                <input id="job_photos"
                                       name="job_photos[]"
                                       type="file"
                                       multiple
                                       accept="image/*"
                                       onchange="previewJobPhotos(this)"
                                       class="hidden" />
                            </label>
                        </div>
                    </div>

                    <!-- Photo Preview -->
                    <div id="job_photo_preview" class="hidden">
                        <label class="block text-sm font-medium text-blue-900 mb-2">Selected Photos</label>
                        <div id="job_preview_container" class="grid grid-cols-2 md:grid-cols-4 gap-2"></div>
                    </div>

                    <!-- Photo Description -->
                    <div>
                        <label for="photo_description" class="block text-sm font-medium text-blue-900 mb-1">Photo Description</label>
                        <textarea id="photo_description"
                                  name="photo_description"
                                  rows="2"
                                  placeholder="Describe the condition of the device..."
                                  class="w-full px-3 py-2 text-sm border border-blue-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
                <div class="flex flex-wrap gap-2">
                    <button type="button" 
                            onclick="document.getElementById('status').value='Pending'"
                            class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full hover:bg-yellow-200">
                        Set as Pending
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('device_name').value='iPhone'; document.getElementById('problem').value='Screen replacement needed'"
                            class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200">
                        iPhone Template
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('device_name').value='Samsung Galaxy'; document.getElementById('problem').value='Battery replacement needed'"
                            class="px-3 py-1 text-xs bg-green-100 text-green-800 rounded-full hover:bg-green-200">
                        Samsung Template
                    </button>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/jobs') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Create Job
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

    // Clear values
    userIdSelect.value = '';
    walkInInput.value = '';
    document.getElementById('walk_in_customer_mobile').value = '';

    // Show appropriate field based on selection
    if (customerType === 'existing') {
        existingField.classList.remove('hidden');
        userIdSelect.required = true;
        walkInInput.required = false;
    } else if (customerType === 'walk_in') {
        walkInField.classList.remove('hidden');
        userIdSelect.required = false;
        walkInInput.required = false;
    } else {
        userIdSelect.required = false;
        walkInInput.required = false;
    }
}

// Toggle service center field based on job status
function toggleDispatchFields() {
    const status = document.getElementById('status').value;
    const serviceCenterSection = document.getElementById('service_center_section');
    const serviceCenterSelect = document.getElementById('service_center_id');

    console.log('Status changed to:', status); // Debug log

    if (status === 'Referred to Service Center') {
        // Show service center section
        serviceCenterSection.style.display = 'block';
        serviceCenterSelect.required = true;
        console.log('✅ Showing service center section - Service center is REQUIRED'); // Debug log
    } else {
        // Hide service center section
        serviceCenterSection.style.display = 'none';
        serviceCenterSelect.required = false;
        serviceCenterSelect.value = ''; // Clear selection
        console.log('✅ Service center section hidden'); // Debug log
    }

    // Expected Return Date is ALWAYS visible and required (no changes needed)
    console.log('✅ Expected Return Date remains required for all statuses');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's an old value and show appropriate field
    const customerType = document.getElementById('customer_type').value;
    if (customerType) {
        toggleCustomerFields();
    }

    // Initialize dispatch fields based on current status
    toggleDispatchFields();

    // Add event listener to status field
    document.getElementById('status').addEventListener('change', toggleDispatchFields);
});

// Auto-populate device templates
function setTemplate(device, problem) {
    document.getElementById('device_name').value = device;
    document.getElementById('problem').value = problem;
    document.getElementById('status').value = 'Pending';
}

function previewJobPhotos(input) {
    const previewDiv = document.getElementById('job_photo_preview');
    const container = document.getElementById('job_preview_container');

    // Clear previous previews
    container.innerHTML = '';

    if (input.files && input.files.length > 0) {
        previewDiv.classList.remove('hidden');

        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}"
                             alt="Preview ${index + 1}"
                             class="w-full h-20 object-cover rounded-lg border border-blue-200">
                        <div class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-50 text-white text-xs p-1 rounded text-center">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </div>
                        <button type="button"
                                onclick="removeJobPhoto(this, ${index})"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            ×
                        </button>
                    `;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewDiv.classList.add('hidden');
    }
}

function removeJobPhoto(button, index) {
    // Remove the preview
    button.parentElement.remove();

    // Check if any photos remain
    const container = document.getElementById('job_preview_container');
    if (container.children.length === 0) {
        document.getElementById('job_photo_preview').classList.add('hidden');
        document.getElementById('job_photos').value = '';
    }
}
</script>

<?= $this->endSection() ?>
