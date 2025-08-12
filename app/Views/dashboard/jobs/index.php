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
            <button onclick="showBulkActions()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                <i class="fas fa-tasks mr-2"></i>
                Bulk Actions
            </button>
        <?php endif; ?>
        <a href="<?= base_url('dashboard/jobs/create') ?>"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Create Job
        </a>
    </div>
</div>



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
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search) || !empty($status)): ?>
                <a href="<?= base_url('dashboard/jobs') ?>"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Jobs Cards -->
<div class="space-y-6">
    <?php if (!empty($jobs)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($jobs as $job): ?>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                <!-- First line: Job ID -->
                <div class="text-lg font-semibold text-gray-900">
                    Job #<?= $job['id'] ?>
                </div>

                <!-- Second line: Customer name / phone -->
                <div class="text-sm text-gray-700">
                    <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'Walk-in Customer') ?>
                    <?php if (!empty($job['walk_in_customer_mobile']) || !empty($job['mobile_number'])): ?>
                        / <?= esc($job['walk_in_customer_mobile'] ?? $job['mobile_number']) ?>
                    <?php endif; ?>
                </div>

                <!-- Third line: Status -->
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
                <div class="mt-1">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                        <?= esc($job['status']) ?>
                    </span>
                </div>

                <!-- Fourth line: Device + SN -->
                <div class="text-sm text-gray-700 mt-1">
                    <?= esc($job['device_name']) ?>
                    <?php if (!empty($job['serial_number'])): ?>
                        (SN: <?= esc($job['serial_number']) ?>)
                    <?php endif; ?>
                </div>

                <!-- Fifth line: Problem -->
                <?php if (!empty($job['problem'])): ?>
                    <div class="text-sm text-gray-700 mt-1">
                        Problem: <?= esc($job['problem']) ?>
                    </div>
                <?php endif; ?>

                <!-- Sixth line: Technician / Created date -->
                <div class="text-xs text-gray-500 mt-2">
                    <?= esc($job['technician_name'] ?? 'Unassigned') ?>
                    / Created: <?= formatNepaliDate($job['created_at'], 'short') ?>
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
        <div class="text-center py-12 text-gray-500">
            No jobs found.
        </div>
    <?php endif; ?>
</div>


<script>
function showBulkActions() {
    alert('Bulk actions functionality coming soon!');
}
</script>

<?= $this->endSection() ?>
