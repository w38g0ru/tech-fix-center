<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Technician Details</h1>
        <p class="mt-1 text-sm text-gray-600">View technician information and contact details</p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/technicians/edit/' . $technician['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
            <i class="fas fa-edit mr-2"></i>
            Edit Technician
        </a>
        <a href="<?= base_url('dashboard/technicians') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Technician Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">Technician ID</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">#<?= $technician['id'] ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Name</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?= esc($technician['full_name']) ?></p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            
            <div class="space-y-4">
                <?php if (!empty($technician['email'])): ?>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Email Address</p>
                            <a href="mailto:<?= esc($technician['email']) ?>" 
                               class="text-primary-600 hover:text-primary-700 font-medium">
                                <?= esc($technician['email']) ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($technician['contact_number'])): ?>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-phone text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Phone Number</p>
                            <a href="tel:<?= esc($technician['contact_number']) ?>" 
                               class="text-primary-600 hover:text-primary-700 font-medium">
                                <?= esc($technician['contact_number']) ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($technician['email']) && empty($technician['contact_number'])): ?>
                    <div class="text-center py-8">
                        <i class="fas fa-address-book text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500">No contact information available</p>
                        <a href="<?= base_url('dashboard/technicians/edit/' . $technician['id']) ?>" 
                           class="mt-2 text-primary-600 hover:text-primary-700 text-sm">
                            Add contact information
                        </a>
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
                $roleConfig = match($technician['role']) {
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

        <!-- Account Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
            
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-500">Created Date</label>
                    <p class="mt-1 text-sm text-gray-900"><?= date('F j, Y', strtotime($technician['created_at'])) ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Created Time</label>
                    <p class="mt-1 text-sm text-gray-900"><?= date('g:i A', strtotime($technician['created_at'])) ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Account Status</label>
                    <p class="mt-1">
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Active
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                <?php if (!empty($technician['email'])): ?>
                    <a href="mailto:<?= esc($technician['email']) ?>" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-envelope mr-2"></i>
                        Send Email
                    </a>
                <?php endif; ?>
                
                <?php if (!empty($technician['contact_number'])): ?>
                    <a href="tel:<?= esc($technician['contact_number']) ?>" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-phone mr-2"></i>
                        Call Now
                    </a>
                <?php endif; ?>
                
                <a href="<?= base_url('dashboard/technicians/edit/' . $technician['id']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Details
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
