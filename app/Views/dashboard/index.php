<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section with Quick Actions -->
<div class="mb-8 animate-fade-in">
    <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl p-8 text-white relative overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="flex-1">
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

                <!-- Quick Actions in Header -->
                <div class="mt-6 lg:mt-0 lg:ml-8">
                    <div class="flex flex-wrap gap-3">
                        <a href="<?= base_url('dashboard/jobs/create') ?>"
                           class="group inline-flex items-center px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl border border-white/30 hover:border-white/40 transition-all duration-200 hover:shadow-lg hover:shadow-white/10">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-plus text-white text-sm"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-white text-sm">New Job</div>
                                <div class="text-xs text-blue-100">Create repair job</div>
                            </div>
                        </a>

                        <a href="<?= base_url('dashboard/users/create') ?>"
                           class="group inline-flex items-center px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl border border-white/30 hover:border-white/40 transition-all duration-200 hover:shadow-lg hover:shadow-white/10">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-user-plus text-white text-sm"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-white text-sm">Add Customer</div>
                                <div class="text-xs text-blue-100">New customer</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full animate-bounce-gentle"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-white/5 rounded-full"></div>
    </div>
</div>

<!-- Floating Quick Actions Button -->
<div class="fixed bottom-6 right-6 z-50">
    <div class="relative">
        <!-- Main FAB Button -->
        <button id="quickActionsFab"
                class="w-14 h-14 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full shadow-2xl hover:shadow-blue-500/50 transition-all duration-300 flex items-center justify-center group hover:scale-110">
            <i class="fas fa-plus text-xl group-hover:rotate-45 transition-transform duration-300"></i>
        </button>

        <!-- Quick Actions Menu -->
        <div id="quickActionsMenu"
             class="absolute bottom-16 right-0 bg-white rounded-2xl shadow-2xl border border-gray-200 p-4 min-w-64 opacity-0 invisible transform translate-y-4 transition-all duration-300">
            <div class="mb-3">
                <h3 class="font-semibold text-gray-900 text-sm">Quick Actions</h3>
                <p class="text-xs text-gray-500">Frequently used actions</p>
            </div>

            <div class="space-y-1">
                <a href="<?= base_url('dashboard/jobs/create') ?>"
                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 rounded-lg">
                    <i class="fas fa-plus w-4 mr-3 text-blue-500"></i>
                    <div>
                        <div class="font-medium">Create Job</div>
                        <div class="text-xs text-gray-500">New repair job</div>
                    </div>
                </a>

                <a href="<?= base_url('dashboard/users/create') ?>"
                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-all duration-200 rounded-lg">
                    <i class="fas fa-user-plus w-4 mr-3 text-green-500"></i>
                    <div>
                        <div class="font-medium">Add Customer</div>
                        <div class="text-xs text-gray-500">New customer</div>
                    </div>
                </a>

                <a href="<?= base_url('dashboard/inventory/create') ?>"
                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition-all duration-200 rounded-lg">
                    <i class="fas fa-box w-4 mr-3 text-orange-500"></i>
                    <div>
                        <div class="font-medium">Add Item</div>
                        <div class="text-xs text-gray-500">Inventory item</div>
                    </div>
                </a>

                <div class="border-t border-gray-200 my-2"></div>

                <a href="<?= base_url('dashboard/reports') ?>"
                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-all duration-200 rounded-lg">
                    <i class="fas fa-chart-bar w-4 mr-3 text-purple-500"></i>
                    <div>
                        <div class="font-medium">View Reports</div>
                        <div class="text-xs text-gray-500">Analytics & insights</div>
                    </div>
                </a>

                <?php if (hasAnyRole(['superadmin', 'admin'])): ?>
                <div class="border-t border-gray-200 my-2"></div>

                <a href="<?= base_url('dashboard/user-management') ?>"
                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 rounded-lg">
                    <i class="fas fa-users-cog w-4 mr-3 text-indigo-500"></i>
                    <div>
                        <div class="font-medium">User Management</div>
                        <div class="text-xs text-gray-500">Manage users & roles</div>
                    </div>
                </a>

                <a href="<?= base_url('dashboard/technicians') ?>"
                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-all duration-200 rounded-lg">
                    <i class="fas fa-user-cog w-4 mr-3 text-teal-500"></i>
                    <div>
                        <div class="font-medium">Technicians</div>
                        <div class="text-xs text-gray-500">Manage technicians</div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
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
