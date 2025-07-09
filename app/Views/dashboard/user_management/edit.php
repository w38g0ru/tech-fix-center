<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit User</h1>
        <p class="mt-1 text-sm text-gray-600">Update user information and settings</p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/user-management/view/' . $user['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
            <i class="fas fa-eye mr-2"></i>
            View User
        </a>
        <a href="<?= base_url('dashboard/user-management') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Users
        </a>
    </div>
</div>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/user-management/update/' . $user['id']) ?>" method="POST" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="<?= old('name', $user['name']) ?>"
                           required
                           placeholder="Enter full name"
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
                           value="<?= old('mobile_number', $user['mobile_number']) ?>"
                           placeholder="Enter mobile number"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.mobile_number') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.mobile_number')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.mobile_number') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Optional contact number</p>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?= old('email', $user['email']) ?>"
                       required
                       placeholder="Enter email address"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.email') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.email')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Must be a valid email address</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password (Optional for updates) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        New Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Leave blank to keep current password"
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.password') ? 'border-red-500' : '' ?>">
                        <button type="button" 
                                onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    <?php if (session('errors.password')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Minimum 6 characters if changing</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="confirm_password" 
                               name="confirm_password" 
                               placeholder="Confirm new password"
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.confirm_password') ? 'border-red-500' : '' ?>">
                        <button type="button" 
                                onclick="togglePassword('confirm_password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="confirm_password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    <?php if (session('errors.confirm_password')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.confirm_password') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                            <option value="superadmin" <?= old('role', $user['role']) === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                        <?php endif; ?>
                        <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="technician" <?= old('role', $user['role']) === 'technician' ? 'selected' : '' ?>>Technician</option>
                        <option value="user" <?= old('role', $user['role']) === 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                    <?php if (session('errors.role')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.role') ?></p>
                    <?php endif; ?>
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
                        <option value="active" <?= old('status', $user['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= old('status', $user['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="suspended" <?= old('status', $user['status']) === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                    <?php if (session('errors.status')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- User Info -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Account Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <p><strong>User ID:</strong> #<?= $user['id'] ?></p>
                        <p><strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($user['created_at'])) ?></p>
                    </div>
                    <div>
                        <p><strong>Last Updated:</strong> <?= $user['updated_at'] ? date('M j, Y g:i A', strtotime($user['updated_at'])) : 'Never' ?></p>
                        <p><strong>Last Login:</strong> <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?></p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/user-management') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-save mr-2"></i>
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const passwordIcon = document.getElementById(fieldId + '-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}
</script>

<?= $this->endSection() ?>
