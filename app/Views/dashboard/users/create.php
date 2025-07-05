<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Customer</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new customer record</p>
    </div>
    <a href="<?= base_url('dashboard/users') ?>" 
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Customers
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/users/store') ?>" method="POST" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
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
                       placeholder="e.g., +1234567890"
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
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/users') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Save Customer
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
