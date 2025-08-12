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



<!-- Search and Filter -->
<div class="mb-6">
    <?php if (!empty($search) || !empty($status)): ?>
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-1"></i>
                <?php if (!empty($search) && !empty($status)): ?>
                    Showing results for "<strong><?= esc($search) ?></strong>" with status "<strong><?= esc($status) ?></strong>"
                <?php elseif (!empty($search)): ?>
                    Showing search results for "<strong><?= esc($search) ?></strong>"
                <?php elseif (!empty($status)): ?>
                    Showing jobs with status "<strong><?= esc($status) ?></strong>"
                <?php endif; ?>
            </p>
        </div>
    <?php endif; ?>
    <form method="GET" action="<?= base_url('dashboard/jobs') ?>" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text"
                   name="search"
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by customer, device, or serial number..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex gap-2">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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

<!-- Jobs Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer & Device
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Job Details
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($jobs)): ?>
                    <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'Walk-in Customer') ?>
                                        </div>
                                        <?php if (!empty($job['walk_in_customer_mobile'])): ?>
                                            <div class="text-sm text-gray-500"><?= esc($job['walk_in_customer_mobile']) ?></div>
                                        <?php endif; ?>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <strong>Device:</strong> <?= esc($job['device_name']) ?>
                                        </div>
                                        <?php if (!empty($job['serial_number'])): ?>
                                            <div class="text-xs text-gray-400">SN: <?= esc($job['serial_number']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <strong>Job #<?= $job['id'] ?></strong>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= esc(substr($job['problem'], 0, 60)) ?><?= strlen($job['problem']) > 60 ? '...' : '' ?>
                                </div>
                                <?php if (!empty($job['technician_name'])): ?>
                                    <div class="text-xs text-gray-400 mt-1">
                                        <strong>Technician:</strong> <?= esc($job['technician_name']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClasses = [
                                    'Completed' => 'bg-green-100 text-green-800',
                                    'In Progress' => 'bg-blue-100 text-blue-800',
                                    'Pending' => 'bg-orange-100 text-orange-800',
                                    'Parts Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Referred to Service Center' => 'bg-purple-100 text-purple-800',
                                    'Ready to Dispatch to Customer' => 'bg-indigo-100 text-indigo-800',
                                    'Returned' => 'bg-red-100 text-red-800'
                                ];
                                $statusClass = $statusClasses[$job['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                    <?= esc($job['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= formatNepaliDate($job['created_at'], 'short') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
                                   class="text-blue-600 hover:text-blue-700 mr-3">
                                    View
                                </a>
                                <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
                                   class="text-green-600 hover:text-green-700">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-wrench text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No jobs found</p>
                                <p class="text-sm">Get started by creating your first repair job.</p>
                                <a href="<?= base_url('dashboard/jobs/create') ?>"
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create Job
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager) && $pager): ?>
        <?= renderPagination($pager) ?>
    <?php endif; ?>
</div>

<script>
function showBulkActions() {
    alert('Bulk actions functionality coming soon!');
}
</script>

<?= $this->endSection() ?>
