<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="mb-8 animate-fade-in">
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl p-8 text-white relative overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Welcome back! 👋</h1>
            <p class="text-blue-100 text-lg">Here's what's happening at TeknoPhix today</p>
            <div class="mt-4 flex items-center space-x-4">
                <div class="flex items-center text-blue-200">
                    <i class="fas fa-clock mr-2"></i>
                    <span class="text-sm"><?= date('l, F j, Y') ?></span>
                </div>
                <div class="flex items-center text-blue-200">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span class="text-sm">TeknoPhix Center</span>
                </div>
            </div>
        </div>
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full animate-bounce-gentle"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-white/5 rounded-full"></div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Jobs -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 group animate-slide-up">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-wrench text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $jobStats['total'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                <div class="mt-3 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <?= $jobStats['completed'] ?> Completed
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        <?= $jobStats['pending'] ?> Pending
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $userStats['total'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Total Customers</p>
                <div class="mt-3 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <?= $userStats['registered'] ?> Registered
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <?= $userStats['walk_in'] ?> Walk-in
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Technicians -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-cog text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $technicianStats['total'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Total Technicians</p>
                <div class="mt-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active Team
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Items -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-orange-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-boxes text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $inventoryStats['total_items'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Inventory Items</p>
                <div class="mt-3 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <?= $inventoryStats['low_stock'] ?> Low Stock
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <?= $inventoryStats['total_stock'] ?> Total
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
    <!-- Recent Jobs -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusClasses = [
                                        'Completed' => 'bg-green-100 text-green-800',
                                        'In Progress' => 'bg-blue-100 text-blue-800',
                                        'Pending' => 'bg-orange-100 text-orange-800'
                                    ];
                                    $statusClass = $statusClasses[$job['status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                        <?= esc($job['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('M j, Y', strtotime($job['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-16 text-center text-gray-500">
                <i class="fas fa-wrench text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium text-gray-900">No recent jobs found</p>
                <p class="text-sm mt-2">Jobs will appear here once you start creating them</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Low Stock Items -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Low Stock Items</h3>
            <a href="<?= base_url('dashboard/inventory') ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                <i class="fas fa-eye mr-1"></i>View All
            </a>
        </div>

        <?php if (!empty($lowStockItems)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($lowStockItems as $item): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900"><?= esc($item['device_name']) ?></div>
                                    <div class="text-xs text-gray-500"><?= esc($item['brand']) ?> <?= esc($item['model']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-red-600">
                                        <?= $item['total_stock'] ?> units
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Low Stock
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-16 text-center text-gray-500">
                <i class="fas fa-boxes text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium text-gray-900">All items are well stocked</p>
                <p class="text-sm mt-2">No items currently below minimum stock levels</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-8">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
        <p class="text-sm text-gray-500 mt-1">Frequently used actions for faster workflow</p>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="<?= base_url('dashboard/jobs/create') ?>"
               class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl border border-blue-200 hover:border-blue-300 transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200 shadow-lg shadow-blue-500/25">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <span class="font-semibold text-blue-900 text-center">Create Job</span>
                <span class="text-xs text-blue-600 mt-1">New repair job</span>
            </a>

            <a href="<?= base_url('dashboard/users/create') ?>"
               class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl border border-green-200 hover:border-green-300 transition-all duration-200 hover:shadow-lg hover:shadow-green-500/25">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200 shadow-lg shadow-green-500/25">
                    <i class="fas fa-user-plus text-white text-lg"></i>
                </div>
                <span class="font-semibold text-green-900 text-center">Add Customer</span>
                <span class="text-xs text-green-600 mt-1">New customer</span>
            </a>

            <a href="<?= base_url('dashboard/inventory/create') ?>"
               class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-xl border border-orange-200 hover:border-orange-300 transition-all duration-200 hover:shadow-lg hover:shadow-orange-500/25">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200 shadow-lg shadow-orange-500/25">
                    <i class="fas fa-box text-white text-lg"></i>
                </div>
                <span class="font-semibold text-orange-900 text-center">Add Item</span>
                <span class="text-xs text-orange-600 mt-1">Inventory item</span>
            </a>

            <a href="<?= base_url('dashboard/reports') ?>"
               class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl border border-purple-200 hover:border-purple-300 transition-all duration-200 hover:shadow-lg hover:shadow-purple-500/25">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200 shadow-lg shadow-purple-500/25">
                    <i class="fas fa-chart-bar text-white text-lg"></i>
                </div>
                <span class="font-semibold text-purple-900 text-center">View Reports</span>
                <span class="text-xs text-purple-600 mt-1">Analytics</span>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
