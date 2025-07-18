<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
            <p class="mt-1 text-sm text-gray-600">Comprehensive business insights and performance metrics</p>
        </div>
        
        <!-- Date Range Filter -->
        <div class="mt-4 sm:mt-0 flex items-center space-x-4">
            <form method="GET" class="flex items-center space-x-2">
                <input type="date" name="start_date" value="<?= $startDate ?>" 
                       class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span class="text-gray-500">to</span>
                <input type="date" name="end_date" value="<?= $endDate ?>" 
                       class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Jobs Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wrench text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Jobs</p>
                    <p class="text-2xl font-bold text-gray-900"><?= number_format($jobStats['total']) ?></p>
                    <p class="text-sm text-green-600"><?= $jobStats['completion_rate'] ?>% completion rate</p>
                </div>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rs. <?= number_format($revenueStats['total_revenue'], 2) ?></p>
                    <p class="text-sm text-gray-600">Avg: Rs. <?= number_format($revenueStats['average_job_value'], 2) ?></p>
                </div>
            </div>
        </div>

        <!-- Customers Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900"><?= number_format($customerStats['total']) ?></p>
                    <p class="text-sm text-blue-600"><?= $customerStats['new'] ?> new, <?= $customerStats['active'] ?> registered</p>
                </div>
            </div>
        </div>

        <!-- Inventory Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-orange-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Inventory Items</p>
                    <p class="text-2xl font-bold text-gray-900"><?= number_format($inventoryStats['total_items']) ?></p>
                    <p class="text-sm text-red-600"><?= $inventoryStats['low_stock'] ?> low stock</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Job Status Breakdown -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Status Breakdown</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">Completed</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900"><?= $jobStats['completed'] ?></span>
                        <span class="text-xs text-gray-500 ml-2"><?= $jobStats['total'] > 0 ? round(($jobStats['completed'] / $jobStats['total']) * 100, 1) : 0 ?>%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">In Progress</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900"><?= $jobStats['in_progress'] ?></span>
                        <span class="text-xs text-gray-500 ml-2"><?= $jobStats['total'] > 0 ? round(($jobStats['in_progress'] / $jobStats['total']) * 100, 1) : 0 ?>%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">Pending</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-900"><?= $jobStats['pending'] ?></span>
                        <span class="text-xs text-gray-500 ml-2"><?= $jobStats['total'] > 0 ? round(($jobStats['pending'] / $jobStats['total']) * 100, 1) : 0 ?>%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Trends -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Job Trends</h3>
            <div class="space-y-3">
                <?php foreach ($monthlyData['jobs'] as $month): ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600"><?= $month['month'] ?></span>
                    <div class="flex items-center">
                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?= $month['jobs'] > 0 ? min(($month['jobs'] / max(array_column($monthlyData['jobs'], 'jobs'))) * 100, 100) : 0 ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 w-8 text-right"><?= $month['jobs'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Export Reports</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?= base_url('dashboard/reports/export?type=jobs&format=csv&start_date=' . $startDate . '&end_date=' . $endDate) ?>" 
               class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-download mr-2"></i>
                Export Jobs (CSV)
            </a>
            <a href="<?= base_url('dashboard/reports/export?type=customers&format=csv&start_date=' . $startDate . '&end_date=' . $endDate) ?>" 
               class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-download mr-2"></i>
                Export Customers (CSV)
            </a>
            <a href="<?= base_url('dashboard/reports/export?type=inventory&format=csv') ?>" 
               class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-download mr-2"></i>
                Export Inventory (CSV)
            </a>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
