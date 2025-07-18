<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">User Details</h1>
        <p class="mt-1 text-sm text-gray-600">View user information and account details</p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/user-management/edit/' . $user['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
            <i class="fas fa-edit mr-2"></i>
            Edit User
        </a>
        <a href="<?= base_url('dashboard/user-management') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">User ID</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">#<?= $user['id'] ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Full Name</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?= esc($user['full_name']) ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Username</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">@<?= esc($user['username']) ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Email Address</label>
                    <p class="mt-1">
                        <a href="mailto:<?= esc($user['email']) ?>" 
                           class="text-primary-600 hover:text-primary-700 font-medium">
                            <?= esc($user['email']) ?>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">Current Status</label>
                    <div class="mt-1">
                        <?php
                        $statusConfig = match($user['status']) {
                            'active' => ['bg-green-100 text-green-800', 'fas fa-check-circle', 'Active'],
                            'inactive' => ['bg-gray-100 text-gray-800', 'fas fa-pause-circle', 'Inactive'],
                            'suspended' => ['bg-red-100 text-red-800', 'fas fa-ban', 'Suspended'],
                            default => ['bg-gray-100 text-gray-800', 'fas fa-question-circle', 'Unknown']
                        };
                        ?>
                        <span class="px-3 py-1 text-sm font-medium rounded-full <?= $statusConfig[0] ?>">
                            <i class="<?= $statusConfig[1] ?> mr-1"></i>
                            <?= $statusConfig[2] ?>
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Last Login</label>
                    <p class="mt-1 text-sm text-gray-900">
                        <?php if (!empty($user['last_login'])): ?>
                            <?= date('F j, Y \a\t g:i A', strtotime($user['last_login'])) ?>
                        <?php else: ?>
                            <span class="text-gray-400">Never logged in</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Account Created</p>
                        <p class="text-sm text-gray-500"><?= date('F j, Y \a\t g:i A', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
                
                <?php if (!empty($user['updated_at'])): ?>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-yellow-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Profile Updated</p>
                            <p class="text-sm text-gray-500"><?= date('F j, Y \a\t g:i A', strtotime($user['updated_at'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($user['last_login'])): ?>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-sign-in-alt text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Last Login</p>
                            <p class="text-sm text-gray-500"><?= date('F j, Y \a\t g:i A', strtotime($user['last_login'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Role Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Role & Permissions</h3>
            
            <div class="text-center">
                <?php
                $roleConfig = match($user['role']) {
                    'superadmin' => ['bg-red-100 text-red-800', 'fas fa-crown', 'Super Admin', 'Full system access'],
                    'admin' => ['bg-purple-100 text-purple-800', 'fas fa-shield-alt', 'Admin', 'Can manage users and jobs'],
                    'technician' => ['bg-green-100 text-green-800', 'fas fa-cog', 'Technician', 'Can manage jobs and inventory'],
                    'user' => ['bg-gray-100 text-gray-800', 'fas fa-user', 'User', 'Limited access'],
                    default => ['bg-gray-100 text-gray-800', 'fas fa-question', 'Unknown', 'Unknown permissions']
                };
                ?>
                
                <div class="w-16 h-16 mx-auto mb-3 rounded-full <?= str_replace('text-', 'bg-', str_replace('100', '200', explode(' ', $roleConfig[0])[0])) ?> flex items-center justify-center">
                    <i class="<?= $roleConfig[1] ?> text-2xl <?= explode(' ', $roleConfig[0])[1] ?>"></i>
                </div>
                
                <h4 class="text-lg font-semibold text-gray-900"><?= $roleConfig[2] ?></h4>
                <p class="text-sm text-gray-600 mt-1"><?= $roleConfig[3] ?></p>
                
                <div class="mt-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full <?= $roleConfig[0] ?>">
                        <i class="<?= $roleConfig[1] ?> mr-1"></i>
                        <?= $roleConfig[2] ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Statistics</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Account Age</span>
                    <span class="text-sm font-medium text-gray-900">
                        <?php
                        $created = new DateTime($user['created_at']);
                        $now = new DateTime();
                        $diff = $now->diff($created);
                        echo $diff->days . ' days';
                        ?>
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Login Count</span>
                    <span class="text-sm font-medium text-gray-900">
                        <?= !empty($user['last_login']) ? '1+' : '0' ?>
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Profile Updates</span>
                    <span class="text-sm font-medium text-gray-900">
                        <?= !empty($user['updated_at']) ? '1+' : '0' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                <a href="mailto:<?= esc($user['email']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Email
                </a>
                
                <a href="<?= base_url('dashboard/user-management/edit/' . $user['id']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-edit mr-2"></i>
                    Edit User
                </a>
                
                <?php if ($user['status'] === 'active'): ?>
                    <form action="<?= base_url('dashboard/user-management/updateStatus/' . $user['id']) ?>" method="POST" class="w-full">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="suspended">
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to suspend this user?')"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50">
                            <i class="fas fa-ban mr-2"></i>
                            Suspend User
                        </button>
                    </form>
                <?php else: ?>
                    <form action="<?= base_url('dashboard/user-management/updateStatus/' . $user['id']) ?>" method="POST" class="w-full">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="active">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 hover:bg-green-50">
                            <i class="fas fa-check mr-2"></i>
                            Activate User
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
