<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 mb-8 -m-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Reports & Analytics</h1>
            <p class="text-blue-100 text-lg">Comprehensive business insights and performance metrics</p>
        </div>
        <div class="mt-4 lg:mt-0">
            <form method="GET" class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-lg p-3">
                    <label class="text-sm font-medium text-blue-100">From:</label>
                    <input type="date" name="start_date" value="<?= $startDate ?>"
                           class="px-3 py-2 bg-white/20 border border-white/30 rounded-md text-sm text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50">
                    <label class="text-sm font-medium text-blue-100">To:</label>
                    <input type="date" name="end_date" value="<?= $endDate ?>"
                           class="px-3 py-2 bg-white/20 border border-white/30 rounded-md text-sm text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50">
                    <button type="submit"
                            class="px-4 py-2 bg-white text-blue-600 text-sm font-medium rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="p-6 pt-0">

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Jobs Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-wrench text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Jobs</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($jobStats['total']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-600 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i><?= $jobStats['completion_rate'] ?>% completion
                        </span>
                        <div class="w-16 bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: <?= $jobStats['completion_rate'] ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-dollar-sign text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">Rs. <?= number_format($revenueStats['total_revenue'], 0) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">
                            Avg: Rs. <?= number_format($revenueStats['average_job_value'], 0) ?>
                        </span>
                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                            <?= $revenueStats['completed_jobs'] ?> jobs
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($customerStats['total']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-blue-600 font-medium">
                            <i class="fas fa-plus mr-1"></i><?= $customerStats['new'] ?> new
                        </span>
                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">
                            <?= $customerStats['active'] ?> active
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Stats -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-orange-500/25 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-boxes text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Inventory Items</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($inventoryStats['total_items']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-red-600 font-medium">
                            <i class="fas fa-exclamation-triangle mr-1"></i><?= $inventoryStats['low_stock'] ?> low stock
                        </span>
                        <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                            Items
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Job Status Breakdown Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Job Status Distribution</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-xs text-gray-600">Completed</span>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full ml-3"></div>
                    <span class="text-xs text-gray-600">In Progress</span>
                    <div class="w-3 h-3 bg-red-500 rounded-full ml-3"></div>
                    <span class="text-xs text-gray-600">Pending</span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="jobStatusChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600"><?= $jobStats['completed'] ?></p>
                    <p class="text-xs text-gray-500">Completed</p>
                    <p class="text-xs text-gray-400"><?= $jobStats['total'] > 0 ? round(($jobStats['completed'] / $jobStats['total']) * 100, 1) : 0 ?>%</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-yellow-600"><?= $jobStats['in_progress'] ?></p>
                    <p class="text-xs text-gray-500">In Progress</p>
                    <p class="text-xs text-gray-400"><?= $jobStats['total'] > 0 ? round(($jobStats['in_progress'] / $jobStats['total']) * 100, 1) : 0 ?>%</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-600"><?= $jobStats['pending'] ?></p>
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="text-xs text-gray-400"><?= $jobStats['total'] > 0 ? round(($jobStats['pending'] / $jobStats['total']) * 100, 1) : 0 ?>%</p>
                </div>
            </div>
        </div>

        <!-- Revenue Trends Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trends</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-xs text-gray-600">Monthly Revenue</span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="text-center">
                    <p class="text-xl font-bold text-blue-600">Rs. <?= number_format($revenueStats['total_revenue'], 0) ?></p>
                    <p class="text-xs text-gray-500">Total Revenue</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-green-600">Rs. <?= number_format($revenueStats['average_job_value'], 0) ?></p>
                    <p class="text-xs text-gray-500">Average Job Value</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Performing Technicians -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Performing Technicians</h3>
            <div class="space-y-4">
                <?php if (!empty($technicianStats['performance'])): ?>
                    <?php foreach (array_slice($technicianStats['performance'], 0, 5) as $index => $tech): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                    <?= $index + 1 ?>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900"><?= esc($tech['name']) ?></p>
                                    <p class="text-sm text-gray-500"><?= $tech['completed_jobs'] ?> jobs completed</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">Rs. <?= number_format($tech['total_revenue'], 0) ?></p>
                                <p class="text-xs text-gray-500">Revenue</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-user-cog text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No technician performance data available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Activity Summary -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Activity Summary</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-plus text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">New Jobs</p>
                            <p class="text-sm text-gray-500">Last 7 days</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-blue-600"><?= $jobStats['recent_jobs'] ?? 0 ?></span>
                </div>

                <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Completed Jobs</p>
                            <p class="text-sm text-gray-500">Last 7 days</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-green-600"><?= $jobStats['recent_completed'] ?? 0 ?></span>
                </div>

                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-plus text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">New Customers</p>
                            <p class="text-sm text-gray-500">Last 7 days</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-purple-600"><?= $customerStats['recent_new'] ?? 0 ?></span>
                </div>

                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-dollar-sign text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Revenue</p>
                            <p class="text-sm text-gray-500">Last 7 days</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-orange-600">Rs. <?= number_format($revenueStats['recent_revenue'] ?? 0, 0) ?></span>
                </div>
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

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Job Status Chart
const jobStatusCtx = document.getElementById('jobStatusChart').getContext('2d');
new Chart(jobStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'In Progress', 'Pending'],
        datasets: [{
            data: [<?= $jobStats['completed'] ?>, <?= $jobStats['in_progress'] ?>, <?= $jobStats['pending'] ?>],
            backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
            borderWidth: 0,
            cutout: '70%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: [<?php echo '"' . implode('","', array_column($monthlyData['jobs'], 'month')) . '"'; ?>],
        datasets: [{
            label: 'Revenue',
            data: [<?php echo implode(',', array_column($monthlyData['revenue'] ?? [], 'amount')); ?>],
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rs. ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>

<?= $this->endsection() ?>
