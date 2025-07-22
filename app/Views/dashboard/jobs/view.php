<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Job #<?= $job['id'] ?> Details</h1>
        <p class="mt-1 text-sm text-gray-600">View complete job information</p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
            <i class="fas fa-edit mr-2"></i>
            Edit Job
        </a>
        <a href="<?= base_url('dashboard/jobs') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Jobs
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Job Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Job Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Job Information</h3>
                <span class="px-3 py-1 text-sm font-medium rounded-full <?= match($job['status']) {
                    'Pending' => 'bg-yellow-100 text-yellow-800',
                    'In Progress' => 'bg-blue-100 text-blue-800',
                    'Completed' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800'
                } ?>">
                    <?= esc($job['status']) ?>
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Device Details</h4>
                    <div class="space-y-2">
                        <p><strong>Device:</strong> <?= esc($job['device_name'] ?? 'N/A') ?></p>
                        <p><strong>Serial Number:</strong> <?= esc($job['serial_number'] ?? 'N/A') ?></p>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Job Details</h4>
                    <div class="space-y-2">
                        <p><strong>Job ID:</strong> #<?= $job['id'] ?></p>
                        <p><strong>सिर्जना:</strong> <?= formatNepaliDateTime($job['created_at'], 'medium') ?></p>
                        <p><strong>Status:</strong> <?= esc($job['status']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Problem Description -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Problem Description</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <?php if (!empty($job['problem'])): ?>
                    <p class="text-gray-700 whitespace-pre-wrap"><?= esc($job['problem']) ?></p>
                <?php else: ?>
                    <p class="text-gray-500 italic">No problem description provided</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Status Update -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Status Update</h3>
            <form action="<?= base_url('dashboard/jobs/updateStatus/' . $job['id']) ?>" method="POST" class="flex items-center space-x-4">
                <?= csrf_field() ?>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    <option value="Pending" <?= $job['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= $job['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Completed" <?= $job['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
            <?php
            // Get proper customer display name
            $jobModel = new \App\Models\JobModel();
            $customerDisplayName = $jobModel->getCustomerDisplayName($job);
            $isWalkIn = empty($job['user_id']);
            ?>

            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                            <i class="fas fa-<?= $isWalkIn ? 'walking' : 'user' ?> text-primary-600"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900"><?= esc($customerDisplayName) ?></p>
                        <p class="text-sm text-gray-500">
                            <?= $isWalkIn ? 'Walk-in Customer' : esc($job['user_type'] ?? 'Registered Customer') ?>
                        </p>
                    </div>
                </div>

                <?php if (!empty($job['mobile_number']) && !$isWalkIn): ?>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-phone mr-2"></i>
                        <a href="tel:<?= esc($job['mobile_number']) ?>" class="hover:text-primary-600">
                            <?= esc($job['mobile_number']) ?>
                        </a>
                    </div>
                <?php elseif (!empty($job['walk_in_customer_mobile']) && $isWalkIn): ?>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-phone mr-2"></i>
                        <a href="tel:<?= esc($job['walk_in_customer_mobile']) ?>" class="hover:text-primary-600">
                            <?= esc($job['walk_in_customer_mobile']) ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['email']) && !$isWalkIn): ?>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-envelope mr-2"></i>
                        <?= esc($job['email']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Technician Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Assigned Technician</h3>
            <?php if (!empty($job['technician_name'])): ?>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-user-cog text-purple-600"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900"><?= esc($job['technician_name']) ?></p>
                            <p class="text-sm text-gray-500">Technician</p>
                        </div>
                    </div>
                    
                    <?php if (!empty($job['technician_contact'])): ?>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-phone mr-2"></i>
                            <a href="tel:<?= esc($job['technician_contact']) ?>" class="hover:text-primary-600">
                                <?= esc($job['technician_contact']) ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 italic">No technician assigned</p>
                <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>" 
                   class="mt-2 inline-flex items-center text-sm text-primary-600 hover:text-primary-700">
                    <i class="fas fa-plus mr-1"></i>
                    Assign Technician
                </a>
            <?php endif; ?>
        </div>

        <!-- Job Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Job
                </a>
                
                <a href="<?= base_url('dashboard/movements/job/' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    View Stock Movements
                </a>

                <a href="<?= base_url('dashboard/photos/upload?type=Job&job_id=' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-camera-retro mr-2"></i>
                    Add Photoproofs
                </a>

                <a href="<?= base_url('dashboard/photos/job/' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-images mr-2"></i>
                    View All Photoproofs
                </a>
                
                <button onclick="window.print()" 
                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-print mr-2"></i>
                    Print Job Details
                </button>
                
                <a href="<?= base_url('dashboard/jobs/delete/' . $job['id']) ?>" 
                   onclick="return confirm('Are you sure you want to delete this job?')"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Job
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
