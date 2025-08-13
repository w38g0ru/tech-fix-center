<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Create New User</h1>
        <p class="mt-1 text-sm text-gray-600">Add a new user to the system (including technicians, admins, and customers)</p>
    </div>
    <a href="<?= base_url('dashboard/user-management') ?>"
       class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
       title="Back to Users">
        <i class="fas fa-arrow-left text-sm"></i>
        <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Users</span>
    </a>
</div>

<div class="w-full">
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

    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/user-management/store') ?>" method="POST" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-circle text-blue-600 mr-3"></i>
                        Basic Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Enter the user's personal details</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
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
                    <p class="mt-1 text-sm text-gray-500">Optional contact number</p>
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
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.email') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.email')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Must be a valid email address</p>
                </div>
            </div>
            </div>

            <!-- Security Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-lock text-green-600 mr-3"></i>
                        Security & Authentication
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Set up login credentials for the user</p>
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
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.password') ? 'border-red-500' : '' ?>">
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
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.confirm_password') ? 'border-red-500' : '' ?>">
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
            </div>

            <!-- Role & Permissions Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-shield text-purple-600 mr-3"></i>
                        Role & Permissions
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Define user access level and account status</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.role') ? 'border-red-500' : '' ?>">
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.status') ? 'border-red-500' : '' ?>">
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
            </div>

            <!-- Information & Guidelines Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                        Guidelines & Role Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Important information about user creation and role permissions</p>
                </div>

            <!-- User Guidelines -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">User Creation Guidelines</h3>
                        <div class="text-sm text-blue-700 space-y-1">
                            <p>• Use this form to create all types of users including technicians, admins, and customers</p>
                            <p>• Select appropriate role based on user's responsibilities and access requirements</p>
                            <p>• Default status is "Active" - users can login immediately after creation</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Descriptions -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-users-cog text-gray-600 mr-2"></i>
                    Role Descriptions
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 text-sm">
                    <div class="flex items-start space-x-3 p-3 bg-white rounded-lg border border-gray-100">
                        <i class="fas fa-crown text-red-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="font-medium text-gray-900">Super Admin</div>
                            <div class="text-gray-600 text-xs mt-1">Full system access and control</div>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-white rounded-lg border border-gray-100">
                        <i class="fas fa-shield-alt text-purple-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="font-medium text-gray-900">Admin</div>
                            <div class="text-gray-600 text-xs mt-1">Manage users, jobs, and inventory</div>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-white rounded-lg border border-gray-100">
                        <i class="fas fa-user-tie text-blue-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="font-medium text-gray-900">Manager</div>
                            <div class="text-gray-600 text-xs mt-1">Oversee operations and reports</div>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-white rounded-lg border border-gray-100">
                        <i class="fas fa-tools text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="font-medium text-gray-900">Technician</div>
                            <div class="text-gray-600 text-xs mt-1">Handle repairs and maintenance</div>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-white rounded-lg border border-gray-100">
                        <i class="fas fa-user text-gray-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <div class="font-medium text-gray-900">Customer</div>
                            <div class="text-gray-600 text-xs mt-1">Basic access to own jobs</div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-2 pt-8 border-t border-gray-200">
                <a href="<?= base_url('dashboard/user-management') ?>"
                   class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                   title="Cancel and Return">
                    <i class="fas fa-times text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Cancel</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                        title="Create User">
                    <i class="fas fa-user-plus text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Create User</span>
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
