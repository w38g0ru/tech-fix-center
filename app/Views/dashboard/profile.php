<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your account information</p>
    </div>
</div>

<div class="max-w-4xl">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= session()->get('full_name') ?? 'User' ?></p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Username</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">@<?= session()->get('username') ?? 'username' ?></p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email Address</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900"><?= session()->get('email') ?? 'email@example.com' ?></p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Role</label>
                        <div class="mt-1">
                            <?php
                            $role = session()->get('role') ?? 'user';
                            $roleConfig = match($role) {
                                'superadmin' => ['bg-red-100 text-red-800', 'fas fa-crown', 'Super Admin'],
                                'admin' => ['bg-purple-100 text-purple-800', 'fas fa-shield-alt', 'Admin'],
                                'technician' => ['bg-green-100 text-green-800', 'fas fa-cog', 'Technician'],
                                'user' => ['bg-gray-100 text-gray-800', 'fas fa-user', 'User'],
                                default => ['bg-gray-100 text-gray-800', 'fas fa-question', 'Unknown']
                            };
                            ?>
                            <span class="px-3 py-1 text-sm font-medium rounded-full <?= $roleConfig[0] ?>">
                                <i class="<?= $roleConfig[1] ?> mr-1"></i>
                                <?= $roleConfig[2] ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <button class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Stats -->
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Active
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Member Since</span>
                        <span class="text-sm font-medium text-gray-900">Jan 2024</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Last Login</span>
                        <span class="text-sm font-medium text-gray-900">Today</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="<?= base_url('dashboard/settings') ?>" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-cog mr-2"></i>
                        Account Settings
                    </a>
                    
                    <a href="<?= base_url('auth/logout') ?>" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
