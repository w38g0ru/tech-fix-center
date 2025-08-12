<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-semibold text-gray-900">Job Management</h1>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $isAdmin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                <i class="fas <?= $isAdmin ? 'fa-crown' : 'fa-user' ?> mr-1"></i>
                <?= ucfirst($userRole) ?> Access
            </span>
        </div>
        <p class="mt-1 text-sm text-gray-600">
            <?= $isAdmin ? 'Full job management with admin privileges' : 'View and manage repair jobs' ?>
        </p>
    </div>
    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
        <?php if ($isAdmin): ?>
            <button onclick="showBulkActions()" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                <i class="fas fa-tasks mr-2"></i>
                Bulk Actions
            </button>
        <?php endif; ?>
        <a href="<?= base_url('dashboard/jobs/create') ?>"
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Create Job
        </a>
    </div>
</div>

<!-- Quick Actions for Jobs Requiring Attention -->
<?php
$overdueJobs = [];
$readyForDispatchJobs = [];
if (!empty($jobs)) {
    foreach ($jobs as $job) {
        if ($job['status'] === 'Ready to Dispatch to Customer') {
            $readyForDispatchJobs[] = $job;
        }
        // Add logic for overdue jobs if needed
    }
}
?>
<?php if (!empty($readyForDispatchJobs)): ?>
<div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-shipping-fast text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Jobs Ready for Dispatch</h2>
                <p class="text-sm text-gray-600"><?= count($readyForDispatchJobs) ?> job(s) ready to be dispatched to customers</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach (array_slice($readyForDispatchJobs, 0, 6) as $job): ?>
        <div class="bg-white rounded-lg border border-blue-200 p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-900">Job #<?= $job['id'] ?></span>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Ready
                </span>
            </div>
            <div class="text-sm text-gray-600 mb-3">
                <div><strong>Device:</strong> <?= esc($job['device_name']) ?></div>
                <div><strong>Customer:</strong> <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'Walk-in Customer') ?></div>
                <?php if (!empty($job['walk_in_customer_mobile'])): ?>
                <div><strong>Mobile:</strong> <?= esc($job['walk_in_customer_mobile']) ?></div>
                <?php endif; ?>
            </div>
            <div class="flex items-center space-x-2">
                <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-600 border border-transparent rounded text-xs font-medium text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <i class="fas fa-eye mr-1"></i>
                    View
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (count($readyForDispatchJobs) > 6): ?>
    <div class="mt-4 text-center">
        <a href="<?= base_url('dashboard/jobs?status=Ready to Dispatch to Customer') ?>"
           class="text-blue-600 hover:text-blue-700 text-sm font-medium">
            View all <?= count($readyForDispatchJobs) ?> jobs ready for dispatch →
        </a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Job Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['total'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['pending'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-cog"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">In Progress</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['in_progress'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Completed</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['completed'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="mb-6">
    <form method="GET" action="<?= base_url('dashboard/jobs') ?>" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text"
                   name="search"
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by customer name, phone, or device..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div class="flex gap-2">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Status</option>
                <option value="Pending" <?= ($status ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= ($status ?? '') === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Parts Pending" <?= ($status ?? '') === 'Parts Pending' ? 'selected' : '' ?>>Parts Pending</option>
                <option value="Referred to Service Center" <?= ($status ?? '') === 'Referred to Service Center' ? 'selected' : '' ?>>Referred to Service Center</option>
                <option value="Ready to Dispatch to Customer" <?= ($status ?? '') === 'Ready to Dispatch to Customer' ? 'selected' : '' ?>>Ready to Dispatch to Customer</option>
                <option value="Returned" <?= ($status ?? '') === 'Returned' ? 'selected' : '' ?>>Returned</option>
                <option value="Completed" <?= ($status ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search) || !empty($status)): ?>
                <a href="<?= base_url('dashboard/jobs') ?>"
                   class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Jobs Cards -->
<div class="space-y-6">
    <?php if (!empty($jobs)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($jobs as $job): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <!-- Card Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                    Job #<?= $job['id'] ?>
                                </h3>
                                <div class="text-sm text-gray-600">
                                    <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'Walk-in Customer') ?>
                                </div>
                                <?php if (!empty($job['walk_in_customer_mobile']) || !empty($job['mobile_number'])): ?>
                                    <div class="text-sm text-gray-500">
                                        <?= esc($job['walk_in_customer_mobile'] ?? $job['mobile_number']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <?php
                                $statusClass = match($job['status']) {
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'In Progress' => 'bg-blue-100 text-blue-800',
                                    'Parts Pending' => 'bg-orange-100 text-orange-800',
                                    'Referred to Service Center' => 'bg-purple-100 text-purple-800',
                                    'Ready to Dispatch to Customer' => 'bg-indigo-100 text-indigo-800',
                                    'Returned' => 'bg-red-100 text-red-800',
                                    'Completed' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                    <?= esc($job['status']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Device Info -->
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-mobile-alt text-gray-400 mr-2"></i>
                                <span class="font-medium"><?= esc($job['device_name']) ?></span>
                            </div>
                            <?php if (!empty($job['serial_number'])): ?>
                                <div class="text-xs text-gray-500 ml-6">
                                    SN: <?= esc($job['serial_number']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($job['problem'])): ?>
                                <div class="text-sm text-gray-600 mt-2">
                                    <span class="font-medium">Problem:</span>
                                    <p class="mt-1 text-gray-500 line-clamp-2">
                                        <?= esc($job['problem']) ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Technician & Photos Info -->
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-user-cog text-gray-400 mr-2"></i>
                                <span><?= esc($job['technician_name'] ?? 'Unassigned') ?></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-camera text-gray-400 mr-1"></i>
                                <span class="text-sm text-gray-600"><?= $job['photo_count'] ?? 0 ?></span>
                                <?php if (($job['photo_count'] ?? 0) > 0): ?>
                                    <a href="<?= base_url('dashboard/photos/jobs/' . $job['id']) ?>"
                                       class="ml-2 text-primary-600 hover:text-primary-700 text-xs">
                                        View
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="text-xs text-gray-500 mb-4">
                            <i class="fas fa-calendar text-gray-400 mr-1"></i>
                            Created: <?= formatNepaliDate($job['created_at'], 'short') ?>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    View
                                </a>
                                <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
                                   class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors duration-200">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                            </div>
                            <?php helper('auth'); ?>
                            <?php if (canDeleteJob()): ?>
                                <a href="<?= base_url('dashboard/jobs/delete/' . $job['id']) ?>"
                                   onclick="return confirm('Are you sure you want to delete this job?')"
                                   class="text-red-600 hover:text-red-700 p-1.5 rounded-md hover:bg-red-50 transition-colors duration-200">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager): ?>
            <div class="mt-8">
                <?= renderPagination($pager) ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="text-gray-500">
                <i class="fas fa-wrench text-6xl mb-4 text-gray-300"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No jobs found</h3>
                <p class="text-gray-600 mb-6">Get started by creating your first repair job.</p>
                <a href="<?= base_url('dashboard/jobs/create') ?>"
                   class="inline-flex items-center px-6 py-3 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-primary-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Create Job
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function showBulkActions() {
    alert('Bulk actions functionality coming soon!');
}
</script>

<?= $this->endSection() ?>
