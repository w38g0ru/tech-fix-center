<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Jobs -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-wrench text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                <p class="text-2xl font-semibold text-gray-900"><?= $jobStats['total'] ?></p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex text-sm">
                <span class="text-green-600 font-medium"><?= $jobStats['completed'] ?> Completed</span>
                <span class="text-yellow-600 font-medium ml-4"><?= $jobStats['pending'] ?> Pending</span>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Customers</p>
                <p class="text-2xl font-semibold text-gray-900"><?= $userStats['total'] ?></p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex text-sm">
                <span class="text-blue-600 font-medium"><?= $userStats['registered'] ?> Registered</span>
                <span class="text-gray-600 font-medium ml-4"><?= $userStats['walk_in'] ?> Walk-in</span>
            </div>
        </div>
    </div>

    <!-- Total Technicians -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-user-cog text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Technicians</p>
                <p class="text-2xl font-semibold text-gray-900"><?= $technicianStats['total'] ?></p>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-sm text-gray-600">Active technicians</span>
        </div>
    </div>

    <!-- Inventory Items -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-boxes text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Inventory Items</p>
                <p class="text-2xl font-semibold text-gray-900"><?= $inventoryStats['total_items'] ?></p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex text-sm">
                <span class="text-red-600 font-medium"><?= $inventoryStats['low_stock'] ?> Low Stock</span>
                <span class="text-gray-600 font-medium ml-4"><?= $inventoryStats['total_stock'] ?> Total Stock</span>
            </div>
        </div>
    </div>
</div>

<!-- Job Status Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Status Overview</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">Pending</span>
                </div>
                <span class="text-sm font-semibold text-gray-900"><?= $jobStats['pending'] ?></span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">In Progress</span>
                </div>
                <span class="text-sm font-semibold text-gray-900"><?= $jobStats['in_progress'] ?></span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                    <span class="text-sm font-medium text-gray-700">Completed</span>
                </div>
                <span class="text-sm font-semibold text-gray-900"><?= $jobStats['completed'] ?></span>
            </div>
        </div>
    </div>

    <!-- Recent Jobs -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Jobs</h3>
            <a href="<?= base_url('dashboard/jobs') ?>" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-2 text-xs font-medium text-gray-500 uppercase">Device</th>
                        <th class="text-left py-2 text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="text-left py-2 text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="text-left py-2 text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($recentJobs)): ?>
                        <?php foreach ($recentJobs as $job): ?>
                            <tr>
                                <td class="py-3 text-sm text-gray-900"><?= esc($job['device_name'] ?? 'N/A') ?></td>
                                <td class="py-3 text-sm text-gray-900"><?= esc($job['customer_name'] ?? 'N/A') ?></td>
                                <td class="py-3">
                                    <?php
                                    $statusClass = match($job['status']) {
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'In Progress' => 'bg-blue-100 text-blue-800',
                                        'Completed' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    ?>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?= $statusClass ?>">
                                        <?= esc($job['status']) ?>
                                    </span>
                                </td>
                                <td class="py-3 text-sm text-gray-500"><?= date('M j, Y', strtotime($job['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">No recent jobs found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Low Stock Alert & Recent Movements -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Low Stock Items -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Low Stock Alert</h3>
            <a href="<?= base_url('dashboard/inventory') ?>" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($lowStockItems)): ?>
                <?php foreach (array_slice($lowStockItems, 0, 5) as $item): ?>
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900"><?= esc($item['device_name'] ?? 'N/A') ?></p>
                            <p class="text-xs text-gray-500"><?= esc($item['brand']) ?> <?= esc($item['model']) ?></p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            <?= $item['total_stock'] ?> left
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-center py-4">No low stock items</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Stock Movements -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Stock Movements</h3>
            <a href="<?= base_url('dashboard/movements') ?>" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($recentMovements)): ?>
                <?php foreach ($recentMovements as $movement): ?>
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900"><?= esc($movement['device_name'] ?? 'N/A') ?></p>
                            <p class="text-xs text-gray-500"><?= esc($movement['brand']) ?> <?= esc($movement['model']) ?></p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?= $movement['movement_type'] === 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= $movement['movement_type'] === 'IN' ? '+' : '-' ?><?= $movement['quantity'] ?>
                            </span>
                            <p class="text-xs text-gray-500 mt-1"><?= date('M j', strtotime($movement['moved_at'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-center py-4">No recent movements</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
