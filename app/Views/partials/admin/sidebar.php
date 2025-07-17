<?php
// Get current URI for active menu highlighting
$currentUri = uri_string();
$currentSegment = service('request')->getUri()->getSegment(2) ?? 'dashboard';

// Helper function to check if menu item is active
function isActive($path, $currentUri) {
    return strpos($currentUri, $path) !== false;
}
?>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:static lg:inset-0">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-center h-16 px-4 bg-primary-600 dark:bg-gray-900">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                <i class="fas fa-cogs text-primary-600 text-lg"></i>
            </div>
            <h1 class="text-xl font-bold text-white">AdminLTE</h1>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="mt-6 px-4 pb-4 overflow-y-auto scrollbar-thin h-full">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="<?= base_url('admin/dashboard') ?>" 
                   class="nav-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200 <?= $currentSegment === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>
            
            <!-- Users Management -->
            <li>
                <a href="<?= base_url('admin/users') ?>" 
                   class="nav-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200 <?= isActive('users', $currentUri) ? 'active' : '' ?>">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span class="font-medium">Users</span>
                    <span class="ml-auto bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 text-xs font-semibold px-2 py-1 rounded-full">
                        <?= $userCount ?? '0' ?>
                    </span>
                </a>
            </li>
            
            <!-- Reports -->
            <li>
                <div class="nav-item">
                    <button onclick="toggleSubmenu('reports-submenu')" 
                            class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200 <?= isActive('reports', $currentUri) ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                        <span class="font-medium">Reports</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-200" id="reports-chevron"></i>
                    </button>
                    <ul id="reports-submenu" class="mt-2 ml-8 space-y-1 hidden">
                        <li>
                            <a href="<?= base_url('admin/reports/analytics') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-analytics w-4 h-4 mr-2"></i>
                                Analytics
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/reports/sales') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-dollar-sign w-4 h-4 mr-2"></i>
                                Sales Report
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/reports/users') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-user-chart w-4 h-4 mr-2"></i>
                                User Report
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Content Management -->
            <li>
                <div class="nav-item">
                    <button onclick="toggleSubmenu('content-submenu')" 
                            class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        <span class="font-medium">Content</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-200" id="content-chevron"></i>
                    </button>
                    <ul id="content-submenu" class="mt-2 ml-8 space-y-1 hidden">
                        <li>
                            <a href="<?= base_url('admin/content/pages') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-file w-4 h-4 mr-2"></i>
                                Pages
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/content/posts') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-blog w-4 h-4 mr-2"></i>
                                Blog Posts
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/content/media') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-images w-4 h-4 mr-2"></i>
                                Media Library
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- E-commerce -->
            <li>
                <div class="nav-item">
                    <button onclick="toggleSubmenu('ecommerce-submenu')" 
                            class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200">
                        <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
                        <span class="font-medium">E-commerce</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-200" id="ecommerce-chevron"></i>
                    </button>
                    <ul id="ecommerce-submenu" class="mt-2 ml-8 space-y-1 hidden">
                        <li>
                            <a href="<?= base_url('admin/products') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-box w-4 h-4 mr-2"></i>
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/orders') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-receipt w-4 h-4 mr-2"></i>
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/categories') ?>" 
                               class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-tags w-4 h-4 mr-2"></i>
                                Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Divider -->
            <li class="pt-4">
                <hr class="border-gray-200 dark:border-gray-700">
            </li>
            
            <!-- Settings -->
            <li>
                <a href="<?= base_url('admin/settings') ?>" 
                   class="nav-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200 <?= isActive('settings', $currentUri) ? 'active' : '' ?>">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </li>
            
            <!-- Profile -->
            <li>
                <a href="<?= base_url('admin/profile') ?>" 
                   class="nav-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200 <?= isActive('profile', $currentUri) ? 'active' : '' ?>">
                    <i class="fas fa-user-circle w-5 h-5 mr-3"></i>
                    <span class="font-medium">Profile</span>
                </a>
            </li>
            
            <!-- Logout -->
            <li class="pt-4">
                <a href="<?= base_url('admin/logout') ?>" 
                   class="nav-item flex items-center px-4 py-3 text-red-600 dark:text-red-400 rounded-lg transition-colors duration-200 hover:bg-red-50 dark:hover:bg-red-900/20">
                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                    <span class="font-medium">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<script>
    // Submenu toggle functionality
    function toggleSubmenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        const chevron = document.getElementById(submenuId.replace('-submenu', '-chevron'));
        
        if (submenu.classList.contains('hidden')) {
            submenu.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            submenu.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }
    
    // Auto-expand active submenu
    document.addEventListener('DOMContentLoaded', function() {
        const activeItem = document.querySelector('.nav-item.active');
        if (activeItem && activeItem.closest('ul[id$="-submenu"]')) {
            const submenu = activeItem.closest('ul[id$="-submenu"]');
            const submenuId = submenu.id;
            const chevron = document.getElementById(submenuId.replace('-submenu', '-chevron'));
            
            submenu.classList.remove('hidden');
            if (chevron) {
                chevron.style.transform = 'rotate(180deg)';
            }
        }
    });
</script>
