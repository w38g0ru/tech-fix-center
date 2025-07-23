<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Job #<?= $job['id'] ?> Details</h1>
        <p class="mt-1 text-sm text-gray-600">View complete job information</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <i class="fas fa-edit mr-2"></i>
            Edit Job
        </a>
        <a href="<?= base_url('dashboard/photos/upload?type=Job&job_id=' . $job['id']) ?>"
           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            <i class="fas fa-camera-retro mr-2"></i>
            Add Photos
        </a>
        <button onclick="window.print()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-print mr-2"></i>
            Print
        </button>
        <a href="<?= base_url('dashboard/jobs') ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Jobs
        </a>
    </div>
</div>

<!-- Mobile Quick Actions (visible on small screens) -->
<div class="lg:hidden mb-6">
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-2">
            <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
               class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="<?= base_url('dashboard/photos/upload?type=Job&job_id=' . $job['id']) ?>"
               class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-camera-retro mr-2"></i>
                Photos
            </a>
            <a href="<?= base_url('dashboard/movements/job/' . $job['id']) ?>"
               class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-exchange-alt mr-2"></i>
                Movements
            </a>
            <button onclick="window.print()"
                    class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-print mr-2"></i>
                Print
            </button>
        </div>
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
        <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-orange-500">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-tasks text-orange-600 mr-2"></i>
                Quick Status Update
            </h3>
            <form action="<?= base_url('dashboard/jobs/updateStatus/' . $job['id']) ?>" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <?= csrf_field() ?>
                <div class="flex-1 w-full sm:w-auto">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                    <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white">
                        <option value="Pending" <?= $job['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="In Progress" <?= $job['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Parts Pending" <?= $job['status'] === 'Parts Pending' ? 'selected' : '' ?>>Parts Pending</option>
                        <option value="Referred to Service Center" <?= $job['status'] === 'Referred to Service Center' ? 'selected' : '' ?>>Referred to Service Center</option>
                        <option value="Ready to Dispatch to Customer" <?= $job['status'] === 'Ready to Dispatch to Customer' ? 'selected' : '' ?>>Ready to Dispatch to Customer</option>
                        <option value="Returned" <?= $job['status'] === 'Returned' ? 'selected' : '' ?>>Returned</option>
                        <option value="Completed" <?= $job['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-orange-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors shadow-md">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Update Status
                    </button>
                </div>
            </form>
            <p class="mt-3 text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                Current status: <span class="font-semibold text-<?= match($job['status']) {
                    'Pending' => 'yellow-600',
                    'In Progress' => 'blue-600',
                    'Completed' => 'green-600',
                    'Parts Pending' => 'orange-600',
                    'Referred to Service Center' => 'purple-600',
                    default => 'gray-600'
                } ?>"><?= esc($job['status']) ?></span>
            </p>
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

        <!-- Dispatch Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-shipping-fast text-green-600 mr-2"></i>
                Dispatch Information
            </h3>

            <div class="space-y-4">
                <?php if (!empty($job['dispatch_type'])): ?>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Dispatch Type:</span>
                        <span class="text-sm text-gray-900"><?= esc($job['dispatch_type']) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['service_center_name'])): ?>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Service Center:</span>
                        <span class="text-sm text-gray-900"><?= esc($job['service_center_name']) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['dispatch_date'])): ?>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Dispatch Date:</span>
                        <span class="text-sm text-gray-900"><?= formatNepaliDate($job['dispatch_date'], 'short') ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['expected_return_date'])): ?>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Expected Return:</span>
                        <span class="text-sm text-gray-900"><?= formatNepaliDate($job['expected_return_date'], 'short') ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['actual_return_date'])): ?>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Actual Return:</span>
                        <span class="text-sm text-gray-900"><?= formatNepaliDate($job['actual_return_date'], 'short') ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['dispatch_notes'])): ?>
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-sm font-medium text-gray-500 block mb-2">Dispatch Notes:</span>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md"><?= nl2br(esc($job['dispatch_notes'])) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (empty($job['dispatch_type']) && empty($job['service_center_name']) && empty($job['dispatch_date']) && empty($job['expected_return_date']) && empty($job['actual_return_date']) && empty($job['dispatch_notes'])): ?>
                    <p class="text-gray-500 italic">No dispatch information available</p>
                    <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
                       class="mt-2 inline-flex items-center text-sm text-primary-600 hover:text-primary-700">
                        <i class="fas fa-plus mr-1"></i>
                        Add Dispatch Information
                    </a>
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
        <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-primary-500">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-cogs text-primary-600 mr-2"></i>
                Job Actions
            </h3>
            <div class="space-y-3">
                <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Job
                </a>

                <a href="<?= base_url('dashboard/movements/job/' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    View Stock Movements
                </a>

                <a href="<?= base_url('dashboard/photos/upload?type=Job&job_id=' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-camera-retro mr-2"></i>
                    Add Photoproofs
                </a>

                <a href="<?= base_url('dashboard/photos/job/' . $job['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-purple-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                    <i class="fas fa-images mr-2"></i>
                    View All Photoproofs
                </a>

                <button onclick="window.print()"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
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
