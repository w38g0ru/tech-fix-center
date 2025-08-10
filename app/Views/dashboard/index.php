<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Welcome back! 👋</h1>
                <p class="text-sm text-gray-600">Here's what's happening at TeknoPhix today</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500"><?= formatNepaliDate(date('Y-m-d'), 'full') ?></div>
            <div class="text-xs text-gray-400">TeknoPhix Center</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?= base_url('dashboard/jobs/create') ?>" class="btn btn-outline btn-lg flex-col text-left p-4 h-auto">
            <div class="flex items-center w-full">
                <div class="w-10 h-10 bg-fuchsia-600 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-900">New Job</div>
                    <div class="text-sm text-gray-500">Create repair job</div>
                </div>
            </div>
        </a>

        <a href="<?= base_url('dashboard/referred/create') ?>" class="btn btn-outline btn-lg flex-col text-left p-4 h-auto">
            <div class="flex items-center w-full">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-shipping-fast text-white"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-900">New Dispatch</div>
                    <div class="text-sm text-gray-500">Create dispatch item</div>
                </div>
            </div>
        </a>

        <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-outline btn-lg flex-col text-left p-4 h-auto">
            <div class="flex items-center w-full">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-900">Add Customer</div>
                    <div class="text-sm text-gray-500">New customer</div>
                </div>
            </div>
        </a>

        <a href="<?= base_url('dashboard/reports') ?>" class="btn btn-outline btn-lg flex-col text-left p-4 h-auto">
            <div class="flex items-center w-full">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-white"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-900">Reports</div>
                    <div class="text-sm text-gray-500">View analytics</div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Jobs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                <p class="text-3xl font-bold text-gray-900"><?= $jobStats['total'] ?></p>
            </div>
            <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-wrench text-white"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center space-x-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <?= $jobStats['completed'] ?> Completed
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                <?= $jobStats['pending'] ?> Pending
            </span>
        </div>
    </div>

    <!-- Dispatch Status -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Ready for Dispatch</p>
                <p class="text-3xl font-bold text-gray-900"><?= count($readyForDispatch) ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-shipping-fast text-white"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center space-x-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <?= $jobStats['ready_to_dispatch'] ?? 0 ?> Jobs Ready
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                <?= $jobStats['referred_to_service'] ?? 0 ?> At Service Centers
            </span>
        </div>
    </div>

    <!-- Service Centers -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Service Centers</p>
                <p class="text-3xl font-bold text-gray-900"><?= count($jobsAtServiceCenters) ?></p>
            </div>
            <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-building text-white"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center space-x-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                Active Jobs
            </span>
            <?php if (count($overdueFromServiceCenters) > 0): ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <?= count($overdueFromServiceCenters) ?> Overdue
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Attention Required -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Needs Attention</p>
                <p class="text-3xl font-bold text-gray-900"><?= count($overdueJobs) ?></p>
            </div>
            <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                Overdue Jobs
            </span>
        </div>
    </div>
</div>

<!-- Dispatch Management & Attention Required -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Jobs Requiring Attention -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Jobs Requiring Attention</h2>
            <a href="<?= base_url('dashboard/jobs?status=overdue') ?>" class="text-sm text-fuchsia-600 hover:text-fuchsia-700">View All</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($overdueJobs)): ?>
                <?php foreach (array_slice($overdueJobs, 0, 4) as $job): ?>
                <div class="flex items-center justify-between p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900"><?= esc($job['device_name'] ?? 'Device') ?></div>
                            <div class="text-sm text-gray-500"><?= esc($job['customer_name'] ?? 'Customer') ?></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-red-600">Overdue</div>
                        <div class="text-xs text-gray-500">
                            Due: <?= isset($job['expected_return_date']) ? date('M j', strtotime($job['expected_return_date'])) : 'N/A' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-check-circle text-2xl mb-2 text-green-500"></i>
                    <p class="text-sm">No overdue jobs! 🎉</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ready for Dispatch -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Ready for Dispatch</h2>
            <a href="<?= base_url('dashboard/referred') ?>" class="text-sm text-fuchsia-600 hover:text-fuchsia-700">Manage Dispatch</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($readyForDispatch)): ?>
                <?php foreach (array_slice($readyForDispatch, 0, 4) as $job): ?>
                <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shipping-fast text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900"><?= esc($job['device_name'] ?? 'Device') ?></div>
                            <div class="text-sm text-gray-500"><?= esc($job['customer_name'] ?? 'Customer') ?></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-blue-600">Ready</div>
                        <div class="text-xs text-gray-500">
                            <?= isset($job['mobile_number']) ? esc($job['mobile_number']) : 'No mobile' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-clipboard-list text-2xl mb-2"></i>
                    <p class="text-sm">No jobs ready for dispatch</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Service Center Status & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Jobs at Service Centers -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Jobs at Service Centers</h2>
            <a href="<?= base_url('dashboard/service-centers') ?>" class="text-sm text-fuchsia-600 hover:text-fuchsia-700">View Centers</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($jobsAtServiceCenters)): ?>
                <?php foreach (array_slice($jobsAtServiceCenters, 0, 4) as $job): ?>
                <div class="flex items-center justify-between p-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900"><?= esc($job['device_name'] ?? 'Device') ?></div>
                            <div class="text-sm text-gray-500"><?= esc($job['service_center_name'] ?? 'Service Center') ?></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-indigo-600">At Center</div>
                        <div class="text-xs text-gray-500">
                            <?= isset($job['expected_return_date']) ? date('M j', strtotime($job['expected_return_date'])) : 'N/A' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-building text-2xl mb-2"></i>
                    <p class="text-sm">No jobs at service centers</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
            <a href="<?= base_url('dashboard/jobs') ?>" class="text-sm text-fuchsia-600 hover:text-fuchsia-700">View All Jobs</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($recentJobs)): ?>
                <?php foreach (array_slice($recentJobs, 0, 4) as $job): ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900"><?= esc($job['device_name'] ?? 'Device') ?></div>
                            <div class="text-sm text-gray-500"><?= esc($job['customer_name'] ?? 'Customer') ?></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-medium text-gray-900">₹<?= number_format($job['charge'] ?? 0) ?></div>
                        <div class="text-xs text-gray-500">
                            <?= isset($job['created_at']) ? date('M j, g:i A', strtotime($job['created_at'])) : 'Recent' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-clipboard-list text-2xl mb-2"></i>
                    <p class="text-sm">No recent jobs found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
