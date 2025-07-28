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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="<?= base_url('dashboard/jobs/create') ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <div class="w-10 h-10 bg-fuchsia-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-plus text-white"></i>
            </div>
            <div>
                <div class="font-medium text-gray-900">New Job</div>
                <div class="text-sm text-gray-500">Create repair job</div>
            </div>
        </a>
        
        <a href="<?= base_url('dashboard/users/create') ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <div class="w-10 h-10 bg-fuchsia-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-user-plus text-white"></i>
            </div>
            <div>
                <div class="font-medium text-gray-900">Add Customer</div>
                <div class="text-sm text-gray-500">New customer</div>
            </div>
        </a>
        
        <a href="<?= base_url('dashboard/reports') ?>" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <div class="w-10 h-10 bg-fuchsia-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-chart-bar text-white"></i>
            </div>
            <div>
                <div class="font-medium text-gray-900">Reports</div>
                <div class="text-sm text-gray-500">View analytics</div>
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
        <div class="mt-4 flex items-center space-x-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <?= $jobStats['completed'] ?> Completed
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                <?= $jobStats['pending'] ?> Pending
            </span>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Customers</p>
                <p class="text-3xl font-bold text-gray-900"><?= $userStats['total'] ?></p>
            </div>
            <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center space-x-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <?= $userStats['registered'] ?> Registered
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                <?= $userStats['walk_in'] ?> Walk-in
            </span>
        </div>
    </div>

    <!-- Total Technicians -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Technicians</p>
                <p class="text-3xl font-bold text-gray-900"><?= $technicianStats['total'] ?></p>
            </div>
            <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-cog text-white"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Active Team
            </span>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">This Month</p>
                <p class="text-3xl font-bold text-gray-900">₹<?= number_format($monthlyRevenue ?? 0) ?></p>
            </div>
            <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-fuchsia-100 text-fuchsia-800">
                +12% Growth
            </span>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h2>
    <div class="space-y-4">
        <?php if (!empty($recentJobs)): ?>
            <?php foreach (array_slice($recentJobs, 0, 5) as $job): ?>
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
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
                    <div class="text-sm text-gray-500"><?= isset($job['created_at']) ? date('M j', strtotime($job['created_at'])) : 'Recent' ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-clipboard-list text-3xl mb-3"></i>
                <p>No recent jobs found</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
