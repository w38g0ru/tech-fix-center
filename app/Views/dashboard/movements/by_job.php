<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Stock Movements - Job #<?= $job['id'] ?></h1>
        <p class="mt-1 text-sm text-gray-600">
            <?= esc($job['device_name']) ?>
            <?php if (!empty($job['customer_name'])): ?>
                - <?= esc($job['customer_name']) ?>
            <?php endif; ?>
        </p>
    </div>
    <div class="flex items-center justify-start lg:justify-end gap-2">
        <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
           class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
           title="View Job Details">
            <i class="fas fa-eye text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">View Job</span>
        </a>
        <a href="<?= base_url('dashboard/movements') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
           title="Back to Movements">
            <i class="fas fa-arrow-left text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Movements</span>
        </a>
    </div>
</div>

<!-- Job Summary Card -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center space-x-4">
        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-wrench text-white text-xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Job #<?= $job['id'] ?></h3>
            <p class="text-sm text-gray-600">
                <?= esc($job['device_name']) ?>
                <?php if (!empty($job['brand'])): ?>
                    - <?= esc($job['brand']) ?>
                <?php endif; ?>
                <?php if (!empty($job['model'])): ?>
                    <?= esc($job['model']) ?>
                <?php endif; ?>
            </p>
            <div class="flex items-center space-x-4 mt-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= getJobStatusBadgeClass($job['status']) ?>">
                    <?= ucfirst($job['status']) ?>
                </span>
                <?php if (!empty($job['customer_name'])): ?>
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-user mr-1"></i>
                        <?= esc($job['customer_name']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Movements Table -->
<div class="bg-white shadow-sm rounded-lg border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Stock Movements</h3>
        <p class="mt-1 text-sm text-gray-600">
            All inventory movements related to this job
        </p>
    </div>

    <?php if (empty($movements)): ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Stock Movements</h3>
            <p class="text-gray-600 mb-6">No inventory movements have been recorded for this job yet.</p>
            <a href="<?= base_url('dashboard/movements/create?job_id=' . $job['id']) ?>"
               class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Add Movement
            </a>
        </div>
    <?php else: ?>
        <!-- Movements Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Item
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($movements as $movement): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= esc($movement['device_name']) ?>
                                </div>
                                <?php if (!empty($movement['brand']) || !empty($movement['model'])): ?>
                                    <div class="text-sm text-gray-500">
                                        <?= esc($movement['brand']) ?>
                                        <?php if (!empty($movement['model'])): ?>
                                            <?= esc($movement['model']) ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $movement['movement_type'] === 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas fa-arrow-<?= $movement['movement_type'] === 'IN' ? 'down' : 'up' ?> mr-1"></i>
                                    <?= $movement['movement_type'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= $movement['quantity'] ?> units
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y g:i A', strtotime($movement['moved_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Movement Button -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <a href="<?= base_url('dashboard/movements/create?job_id=' . $job['id']) ?>"
               class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Add Movement
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
