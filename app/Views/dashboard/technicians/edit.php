<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Technician</h1>
        <p class="mt-1 text-sm text-gray-600">Update technician information</p>
    </div>
    <a href="<?= base_url('dashboard/technicians') ?>" 
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Technicians
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/technicians/update/' . $technician['id']) ?>" method="POST" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Technician Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= old('name', $technician['full_name']) ?>"
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
                       value="<?= old('email', $technician['email'] ?? '') ?>"
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
                       value="<?= old('contact_number', $technician['phone']) ?>"
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
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="username"
                       name="username"
                       value="<?= old('username', $technician['username']) ?>"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.username') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.username')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.username') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Username for login access</p>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status"
                        name="status"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.status') ? 'border-red-500' : '' ?>">
                    <option value="active" <?= old('status', $technician['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= old('status', $technician['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="suspended" <?= old('status', $technician['status']) === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                </select>
                <?php if (session('errors.status')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Current status of the technician account</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    New Password
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Leave blank to keep current password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.password') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.password')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
            </div>

            <!-- Technician Info -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Technician Information</h3>
                <div class="text-sm text-gray-600">
                    <p><strong>Technician ID:</strong> #<?= $technician['id'] ?></p>
                    <p><strong>Created:</strong> <?= date('F j, Y \a\t g:i A', strtotime($technician['created_at'])) ?></p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/technicians') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Update Technician
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
