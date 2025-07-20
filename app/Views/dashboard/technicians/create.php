<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Technician</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new technician record</p>
    </div>
    <a href="<?= base_url('dashboard/technicians') ?>" 
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Technicians
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/technicians/store') ?>" method="POST" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Technician Name <span class="text-red-500">*</span>
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

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="<?= old('email') ?>"
                       placeholder="Enter email address"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.email') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.email')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Optional - Technician's email address</p>
            </div>

            <!-- Contact Number -->
            <div>
                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Contact Number
                </label>
                <input type="tel"
                       id="contact_number"
                       name="contact_number"
                       value="<?= old('contact_number') ?>"
                       placeholder="Enter contact number"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.contact_number') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.contact_number')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.contact_number') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Optional - Technician's contact number</p>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role"
                        name="role"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.role') ? 'border-red-500' : '' ?>">
                    <option value="">Select role</option>
                    <?php helper('auth'); ?>
                    <?php if (hasRole('superadmin')): ?>
                        <option value="superadmin" <?= old('role') === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                    <?php endif; ?>
                    <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="technician" <?= old('role') === 'technician' ? 'selected' : '' ?>>Technician</option>
                    <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>User</option>
                </select>
                <?php if (session('errors.role')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.role') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">
                    <strong>Super Admin:</strong> Full system access<br>
                    <strong>Admin:</strong> Can manage users, jobs, and technicians<br>
                    <strong>Technician:</strong> Can manage jobs and inventory<br>
                    <strong>User:</strong> Limited access
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/technicians') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Save Technician
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
