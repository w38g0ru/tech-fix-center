<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Dashboard Content -->
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($stats['total_users'] ?? 1234) ?></p>
                    <p class="text-sm text-green-600 dark:text-green-400 flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +12% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Sales Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sales</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">$<?= number_format($stats['total_sales'] ?? 45678, 2) ?></p>
                    <p class="text-sm text-green-600 dark:text-green-400 flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +8% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Orders Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($stats['total_orders'] ?? 892) ?></p>
                    <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-1">
                        <i class="fas fa-arrow-down mr-1"></i>
                        -3% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Revenue Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 card-hover transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">$<?= number_format($stats['monthly_revenue'] ?? 23456, 2) ?></p>
                    <p class="text-sm text-green-600 dark:text-green-400 flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +15% from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sales Overview</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 rounded-full">
                        7 Days
                    </button>
                    <button class="px-3 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        30 Days
                    </button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- User Growth Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Growth</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 rounded-full">
                        This Year
                    </button>
                    <button class="px-3 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        Last Year
                    </button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="userChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                <a href="<?= base_url('admin/activity') ?>" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                    View all
                </a>
            </div>
            <div class="space-y-4">
                <?php 
                $activities = [
                    ['user' => 'John Doe', 'action' => 'created a new user account', 'time' => '2 minutes ago', 'icon' => 'fas fa-user-plus', 'color' => 'text-green-500'],
                    ['user' => 'Jane Smith', 'action' => 'updated product inventory', 'time' => '5 minutes ago', 'icon' => 'fas fa-box', 'color' => 'text-blue-500'],
                    ['user' => 'Admin', 'action' => 'processed order #1234', 'time' => '10 minutes ago', 'icon' => 'fas fa-shopping-cart', 'color' => 'text-purple-500'],
                    ['user' => 'Mike Johnson', 'action' => 'uploaded new media files', 'time' => '15 minutes ago', 'icon' => 'fas fa-upload', 'color' => 'text-yellow-500'],
                    ['user' => 'System', 'action' => 'completed backup process', 'time' => '1 hour ago', 'icon' => 'fas fa-database', 'color' => 'text-gray-500']
                ];
                ?>
                <?php foreach ($activities as $activity): ?>
                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <div class="flex-shrink-0">
                            <i class="<?= $activity['icon'] ?> <?= $activity['color'] ?> text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900 dark:text-white">
                                <span class="font-medium"><?= $activity['user'] ?></span>
                                <?= $activity['action'] ?>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?= $activity['time'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('admin/users/create') ?>"
                   class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200 group">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Add New User</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Create user account</p>
                    </div>
                </a>
                
                <a href="<?= base_url('admin/products/create') ?>"
                   class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200 group">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Add Product</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Create new product</p>
                    </div>
                </a>
                
                <a href="<?= base_url('admin/reports') ?>" 
                   class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors duration-200 group">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-bar text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">View Reports</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Analytics & insights</p>
                    </div>
                </a>
                
                <a href="<?= base_url('admin/settings') ?>" 
                   class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 group">
                    <div class="w-8 h-8 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-cog text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Settings</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">System configuration</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Chart.js configuration
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;
    
    // Check if dark mode is enabled
    const isDarkMode = document.documentElement.classList.contains('dark');
    
    // Chart colors based on theme
    const chartColors = {
        primary: isDarkMode ? '#60a5fa' : '#3b82f6',
        secondary: isDarkMode ? '#34d399' : '#10b981',
        text: isDarkMode ? '#f3f4f6' : '#374151',
        grid: isDarkMode ? '#374151' : '#e5e7eb'
    };
    
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales',
                data: [1200, 1900, 3000, 5000, 2000, 3000, 4500],
                borderColor: chartColors.primary,
                backgroundColor: chartColors.primary + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: chartColors.grid
                    },
                    ticks: {
                        color: chartColors.text
                    }
                },
                x: {
                    grid: {
                        color: chartColors.grid
                    },
                    ticks: {
                        color: chartColors.text
                    }
                }
            }
        }
    });
    
    // User Growth Chart
    const userCtx = document.getElementById('userChart').getContext('2d');
    new Chart(userCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Users',
                data: [65, 59, 80, 81, 56, 95],
                backgroundColor: chartColors.secondary,
                borderColor: chartColors.secondary,
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: chartColors.grid
                    },
                    ticks: {
                        color: chartColors.text
                    }
                },
                x: {
                    grid: {
                        color: chartColors.grid
                    },
                    ticks: {
                        color: chartColors.text
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>
