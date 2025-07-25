<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb Navigation -->
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?= base_url('jobs') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-fuchsia-600 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Jobs
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-1 md:ml-2 text-sm font-medium text-gray-500">Create New Job</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-900">Create New Job</h1>
    <p class="mt-2 text-sm text-gray-600">
        Add a new device repair job to the system
    </p>
</div>

<!-- Form Container -->
<div class="max-w-4xl">
    <form action="<?= base_url('jobs/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        <?= csrf_field() ?>

        <!-- Device Information Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Device Information</h3>
                <p class="mt-1 text-sm text-gray-500">Enter details about the device to be repaired</p>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Device Name -->
                    <div>
                        <label for="device_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Device Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="device_name" name="device_name" required
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                               placeholder="e.g., iPhone 12 Pro, Samsung Galaxy S21">
                    </div>

                    <!-- Serial Number -->
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Serial Number
                        </label>
                        <input type="text" id="serial_number" name="serial_number"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                               placeholder="Device serial number">
                    </div>

                    <!-- Problem Description -->
                    <div class="md:col-span-2">
                        <label for="problem" class="block text-sm font-medium text-gray-700 mb-2">
                            Problem Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="problem" name="problem" rows="4" required
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                                  placeholder="Describe the issue with the device in detail..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                <p class="mt-1 text-sm text-gray-500">Select existing customer or add walk-in customer details</p>
            </div>
            <div class="px-6 py-4">
                <!-- Customer Type Selection -->
                <div class="mb-6">
                    <fieldset>
                        <legend class="text-sm font-medium text-gray-700 mb-3">Customer Type</legend>
                        <div class="flex space-x-6">
                            <div class="flex items-center">
                                <input id="registered_customer" name="customer_type" type="radio" value="registered" checked
                                       class="h-4 w-4 text-fuchsia-600 focus:ring-fuchsia-500 border-gray-300">
                                <label for="registered_customer" class="ml-2 text-sm font-medium text-gray-700">
                                    Registered Customer
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="walk_in_customer" name="customer_type" type="radio" value="walk_in"
                                       class="h-4 w-4 text-fuchsia-600 focus:ring-fuchsia-500 border-gray-300">
                                <label for="walk_in_customer" class="ml-2 text-sm font-medium text-gray-700">
                                    Walk-in Customer
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <!-- Registered Customer Fields -->
                <div id="registered_fields" class="space-y-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Customer
                        </label>
                        <select id="user_id" name="user_id"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm">
                            <option value="">Choose a customer...</option>
                            <option value="1">John Doe - 9841234567</option>
                            <option value="2">Jane Smith - 9851234567</option>
                            <option value="3">Raj Patel - 9861234567</option>
                        </select>
                    </div>
                </div>

                <!-- Walk-in Customer Fields -->
                <div id="walk_in_fields" class="hidden space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="walk_in_customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Customer Name
                            </label>
                            <input type="text" id="walk_in_customer_name" name="walk_in_customer_name"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                                   placeholder="Customer full name">
                        </div>
                        <div>
                            <label for="walk_in_customer_mobile" class="block text-sm font-medium text-gray-700 mb-2">
                                Mobile Number
                            </label>
                            <input type="tel" id="walk_in_customer_mobile" name="walk_in_customer_mobile"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                                   placeholder="9841234567">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Details Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Job Details</h3>
                <p class="mt-1 text-sm text-gray-500">Set job parameters and assignment</p>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Initial Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                        </select>
                    </div>

                    <!-- Technician -->
                    <div>
                        <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Assign Technician
                        </label>
                        <select id="technician_id" name="technician_id"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm">
                            <option value="">Assign later...</option>
                            <option value="1">Ram Sharma</option>
                            <option value="2">Sita Poudel</option>
                            <option value="3">Hari Thapa</option>
                        </select>
                    </div>

                    <!-- Expected Return Date -->
                    <div>
                        <label for="expected_return_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Expected Return Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="expected_return_date" name="expected_return_date" required
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                               min="<?= date('Y-m-d') ?>">
                    </div>

                    <!-- Estimated Charge -->
                    <div>
                        <label for="charge" class="block text-sm font-medium text-gray-700 mb-2">
                            Estimated Charge (NPR)
                        </label>
                        <input type="number" id="charge" name="charge" step="0.01" min="0"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm"
                               placeholder="0.00">
                    </div>

                    <!-- Photo Upload -->
                    <div class="md:col-span-2">
                        <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">
                            Device Photos
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-fuchsia-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-fuchsia-600 hover:text-fuchsia-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-fuchsia-500">
                                        <span>Upload photos</span>
                                        <input id="photos" name="photos[]" type="file" class="sr-only" multiple accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <button type="button" onclick="history.back()"
                    class="inline-flex items-center px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                Cancel
            </button>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Job
            </button>
        </div>
    </form>
</div>

<!-- JavaScript for form interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const registeredRadio = document.getElementById('registered_customer');
    const walkInRadio = document.getElementById('walk_in_customer');
    const registeredFields = document.getElementById('registered_fields');
    const walkInFields = document.getElementById('walk_in_fields');

    function toggleCustomerFields() {
        if (registeredRadio.checked) {
            registeredFields.classList.remove('hidden');
            walkInFields.classList.add('hidden');
        } else {
            registeredFields.classList.add('hidden');
            walkInFields.classList.remove('hidden');
        }
    }

    registeredRadio.addEventListener('change', toggleCustomerFields);
    walkInRadio.addEventListener('change', toggleCustomerFields);

    // Set minimum date to today
    const dateInput = document.getElementById('expected_return_date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;
});
</script>

<?= $this->endSection() ?>
