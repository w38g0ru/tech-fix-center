<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-semibold text-gray-900">Add New Customer</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-user mr-1"></i>
                        Management
                    </span>
                </div>
                <p class="text-sm text-gray-600">
                    Create a new customer record for your repair shop
                </p>
            </div>
        </div>
        <div class="flex items-center justify-start lg:justify-end gap-2">
            <a href="<?= base_url('dashboard/users') ?>"
               class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
               title="Back to Customers">
                <i class="fas fa-arrow-left text-sm"></i>
                <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Customers</span>
            </a>
        </div>
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
                <h3 class="text-sm font-medium">Please fix the following errors:</h3>
                <div class="mt-2 text-sm">
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
        <form action="<?= base_url('dashboard/users/store') ?>" method="POST" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>
            
            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-circle text-blue-600 mr-3"></i>
                        Customer Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">Enter the customer's basic details</p>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Customer Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="<?= old('name') ?>"
                           required
                           placeholder="Enter customer name"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.name') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.name')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.name') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Mobile Number -->
                <div>
                    <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Mobile Number
                    </label>
                    <input type="tel"
                           id="mobile_number"
                           name="mobile_number"
                           value="<?= old('mobile_number') ?>"
                           placeholder="Enter mobile number"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.mobile_number') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.mobile_number')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.mobile_number') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Optional - Customer's contact number</p>
                </div>

            <!-- User Type -->
            <div>
                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Customer Type <span class="text-red-500">*</span>
                </label>
                <select id="user_type"
                        name="user_type"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.user_type') ? 'border-red-500' : '' ?>">
                    <option value="">Select customer type</option>
                    <option value="Registered" <?= old('user_type') === 'Registered' ? 'selected' : '' ?>>Registered</option>
                    <option value="Walk-in" <?= old('user_type') === 'Walk-in' ? 'selected' : '' ?>>Walk-in</option>
                </select>
                <?php if (session('errors.user_type')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.user_type') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">
                    <strong>Registered:</strong> Regular customers with accounts<br>
                    <strong>Walk-in:</strong> One-time or occasional customers
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-2 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/users') ?>"
                   class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                   title="Cancel and Return">
                    <i class="fas fa-times text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Cancel</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                        title="Create Customer">
                    <i class="fas fa-save text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Create Customer</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
