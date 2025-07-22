<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Technician</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new technician record</p>
    </div>
    <a href="<?= base_url('dashboard/technicians') ?>"
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200 shadow-lg shadow-gray-500/25">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Technicians
    </a>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/technicians/store') ?>" method="POST" class="p-6 lg:p-8 space-y-8">
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

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>
                <input type="text"
                       id="username"
                       name="username"
                       value="<?= old('username') ?>"
                       placeholder="Leave blank to auto-generate from name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.username') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.username')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.username') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Optional - Will be auto-generated from name if left blank</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Leave blank for default password (technician123)"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.password') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.password')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Optional - Default password 'technician123' will be used if left blank</p>
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
