<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Jobs -->
    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-wrench text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-2xl font-bold text-gray-900"><?= $jobStats['total'] ?></h3>
            <p class="text-sm text-gray-600">Total Jobs</p>
            <div class="mt-2 text-xs">
                <span class="text-green-600 font-medium"><?= $jobStats['completed'] ?> Completed</span>
                <span class="text-orange-600 font-medium ml-4"><?= $jobStats['pending'] ?> Pending</span>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-users text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-2xl font-bold text-gray-900"><?= $userStats['total'] ?></h3>
            <p class="text-sm text-gray-600">Total Customers</p>
            <div class="mt-2 text-xs">
                <span class="text-blue-600 font-medium"><?= $userStats['registered'] ?> Registered</span>
                <span class="text-gray-500 font-medium ml-4"><?= $userStats['walk_in'] ?> Walk-in</span>
            </div>
        </div>
    </div>

    <!-- Total Technicians -->
    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-user-cog text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-2xl font-bold text-gray-900"><?= $technicianStats['total'] ?></h3>
            <p class="text-sm text-gray-600">Total Technicians</p>
            <div class="mt-2 text-xs">
                <span class="text-green-600 font-medium">Active technicians</span>
            </div>
        </div>
    </div>

    <!-- Inventory Items -->
    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-boxes text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-2xl font-bold text-gray-900"><?= $inventoryStats['total_items'] ?></h3>
            <p class="text-sm text-gray-600">Inventory Items</p>
            <div class="mt-2 text-xs">
                <span class="text-red-600 font-medium"><?= $inventoryStats['low_stock'] ?> Low Stock</span>
                <span class="text-gray-500 font-medium ml-4"><?= $inventoryStats['total_stock'] ?> Total Stock</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
    <!-- Recent Jobs -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Jobs</h3>
            <a href="<?= base_url('dashboard/jobs') ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                <i class="fas fa-eye mr-1"></i>View All
            </a>
        </div>

        <?php if (!empty($recentJobs)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recentJobs as $job): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">
                                        <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900"><?= esc($job['device_name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= esc($job['serial_number']) ?></div>
                                </td>
                                <td>
                                    <?php
                                    $statusColor = '#6b7280';
                                    $statusBg = 'rgba(107, 114, 128, 0.1)';
                                    switch($job['status']) {
                                        case 'Completed':
                                            $statusColor = '#059669';
                                            $statusBg = 'rgba(5, 150, 105, 0.1)';
                                            break;
                                        case 'In Progress':
                                            $statusColor = '#2563eb';
                                            $statusBg = 'rgba(37, 99, 235, 0.1)';
                                            break;
                                        case 'Pending':
                                            $statusColor = '#d97706';
                                            $statusBg = 'rgba(217, 119, 6, 0.1)';
                                            break;
                                    }
                                    ?>
                                    <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                        <?= esc($job['status']) ?>
                                    </span>
                                </td>
                                <td style="font-size: 12px; color: #666;">
                                    <?= date('M j, Y', strtotime($job['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #666;">
                <i class="fas fa-wrench" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                <p>No recent jobs found</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Low Stock Items -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Low Stock Items</h3>
            <a href="<?= base_url('dashboard/inventory') ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                <i class="fas fa-eye"></i>View All
            </a>
        </div>
        
        <?php if (!empty($lowStockItems)): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lowStockItems as $item): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 500;"><?= esc($item['device_name']) ?></div>
                                    <div style="font-size: 12px; color: #666;"><?= esc($item['brand']) ?> <?= esc($item['model']) ?></div>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #dc2626;">
                                        <?= $item['total_stock'] ?> units
                                    </span>
                                </td>
                                <td>
                                    <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                                        Low Stock
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #666;">
                <i class="fas fa-boxes" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                <p>All items are well stocked</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <h3 class="card-title">Quick Actions</h3>
    </div>
    
    <div class="grid grid-4" style="padding: 20px;">
        <a href="<?= base_url('dashboard/jobs/create') ?>" class="btn btn-primary" style="justify-content: center; padding: 16px;">
            <i class="fas fa-plus"></i>Create Job
        </a>
        
        <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-success" style="justify-content: center; padding: 16px;">
            <i class="fas fa-user-plus"></i>Add Customer
        </a>
        
        <a href="<?= base_url('dashboard/inventory/create') ?>" class="btn btn-secondary" style="justify-content: center; padding: 16px;">
            <i class="fas fa-box"></i>Add Item
        </a>
        
        <a href="<?= base_url('dashboard/reports') ?>" class="btn btn-primary" style="justify-content: center; padding: 16px; background: #9333ea;">
            <i class="fas fa-chart-bar"></i>View Reports
        </a>
    </div>
</div>

<?= $this->endSection() ?>
