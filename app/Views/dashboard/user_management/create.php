<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Create New User</h1>
        <p class="mt-1 text-sm text-gray-600">Add a new user to the system (including technicians, admins, and customers)</p>
    </div>
    <a href="<?= base_url('dashboard/user-management') ?>" 
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Users
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/user-management/store') ?>" method="POST" class="p-6 space-y-6">
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
                           value="<?= old('name') ?>"
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
                           value="<?= old('mobile_number') ?>"
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
                       value="<?= old('email') ?>"
                       required
                       placeholder="Enter email address"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.email') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.email')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Must be a valid email address</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Enter password"
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
                    <p class="mt-1 text-sm text-gray-500">Minimum 6 characters</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="confirm_password" 
                               name="confirm_password" 
                               required
                               placeholder="Confirm password"
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
                            <option value="superadmin" <?= old('role') === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                        <?php endif; ?>
                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="manager" <?= old('role') === 'manager' ? 'selected' : '' ?>>Manager</option>
                        <option value="technician" <?= old('role') === 'technician' ? 'selected' : '' ?>>Technician</option>
                        <option value="customer" <?= old('role') === 'customer' ? 'selected' : '' ?>>Customer</option>
                    </select>
                    <?php if (session('errors.role')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.role') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.status') ? 'border-red-500' : '' ?>">
                        <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="suspended" <?= old('status') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                    <?php if (session('errors.status')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Default is Active</p>
                </div>
            </div>

            <!-- Role Descriptions -->
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mr-2 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <strong>Note:</strong> Use this form to create all types of users, including technicians.
                        Select "Technician" role to add new repair technicians to your team.
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Role Descriptions</h3>
                <div class="text-sm text-gray-600 space-y-2">
                    <div class="flex items-start">
                        <i class="fas fa-crown text-red-500 mr-2 mt-0.5"></i>
                        <div>
                            <strong>Super Admin:</strong> Full system access, can manage all users and settings
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-shield-alt text-purple-500 mr-2 mt-0.5"></i>
                        <div>
                            <strong>Admin:</strong> Can manage users, jobs, technicians, and inventory
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-cog text-green-500 mr-2 mt-0.5"></i>
                        <div>
                            <strong>Technician:</strong> Can manage jobs and inventory, limited user access
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-user text-gray-500 mr-2 mt-0.5"></i>
                        <div>
                            <strong>User:</strong> Basic access to view jobs and limited functionality
                        </div>
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
                    Create User
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
