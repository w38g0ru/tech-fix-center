<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Customer</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new customer record</p>
    </div>
    <a href="<?= base_url('dashboard/users') ?>"
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200 shadow-lg shadow-gray-500/25">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Customers
    </a>
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
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.name') ? 'border-red-500' : '' ?>">
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
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.mobile_number') ? 'border-red-500' : '' ?>">
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.user_type') ? 'border-red-500' : '' ?>">
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
            <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                <a href="<?= base_url('dashboard/users') ?>"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-xl text-sm font-medium text-white hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg shadow-blue-500/25">
                    <i class="fas fa-save mr-2"></i>
                    Create Customer
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
