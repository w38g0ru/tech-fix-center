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
                        <div class="font-medium text-gray-900"><?= esc($job['device_model']) ?></div>
                        <div class="text-sm text-gray-500"><?= esc($job['customer_name']) ?></div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-medium text-gray-900">₹<?= number_format($job['estimated_cost']) ?></div>
                    <div class="text-sm text-gray-500"><?= date('M j', strtotime($job['created_at'])) ?></div>
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
                                    <?= formatNepaliDate($job['created_at'], 'short') ?>
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

<script>
// Quick Actions FAB functionality
document.addEventListener('DOMContentLoaded', function() {
    const fab = document.getElementById('quickActionsFab');
    const menu = document.getElementById('quickActionsMenu');
    let isMenuOpen = false;

    // Toggle menu on FAB click
    fab.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenu();
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (isMenuOpen && !menu.contains(e.target) && !fab.contains(e.target)) {
            closeMenu();
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMenu();
        }
    });

    function toggleMenu() {
        if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    function openMenu() {
        menu.classList.remove('opacity-0', 'invisible', 'translate-y-4');
        menu.classList.add('opacity-100', 'visible', 'translate-y-0');
        fab.querySelector('i').classList.add('rotate-45');
        isMenuOpen = true;
    }

    function closeMenu() {
        menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
        menu.classList.add('opacity-0', 'invisible', 'translate-y-4');
        fab.querySelector('i').classList.remove('rotate-45');
        isMenuOpen = false;
    }

    // Auto-hide FAB on scroll down, show on scroll up
    let lastScrollTop = 0;
    const fabContainer = fab.parentElement;

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            fabContainer.style.transform = 'translateY(100px)';
            if (isMenuOpen) closeMenu();
        } else {
            // Scrolling up
            fabContainer.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop;
    });
});
</script>

<?= $this->endSection() ?>
