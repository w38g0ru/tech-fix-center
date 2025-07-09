<?php
$config = config('App');
$pageTitle = $title ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= $config->appName ?></title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $config->appDescription ?>">
    <meta name="author" content="<?= $config->companyName ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <!-- External Resources -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '<?= $config->brandColors['primary'] ?>',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Responsive Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0) !important;
            }
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Dropdown Menus */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease-in-out;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Mobile optimizations */
        @media (max-width: 1023px) {
            body {
                -webkit-overflow-scrolling: touch;
            }

            /* Prevent zoom on input focus */
            input, select, textarea {
                font-size: 16px !important;
            }

            /* Improve touch targets */
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Ensure proper scrolling */
        .scroll-container {
            -webkit-overflow-scrolling: touch;
            overflow-y: auto;
        }

        /* Mobile-first responsive tables */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive table {
                min-width: 600px;
            }
        }

        /* Focus styles for accessibility */
        .focus-ring:focus {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden" id="app-container">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg sidebar lg:static lg:inset-0 lg:z-auto" id="sidebar">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-primary-600">
                <div class="flex items-center">
                    <div class="h-8 w-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white"><?= $config->appShortName ?></h1>
                        <p class="text-xs text-white text-opacity-80">Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="<?= base_url('dashboard') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="<?= base_url('dashboard/jobs') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'jobs') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-wrench mr-3"></i>
                        Jobs
                    </a>
                    
                    <a href="<?= base_url('dashboard/users') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'users') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-users mr-3"></i>
                        Customers
                    </a>
                    

                    <a href="<?= base_url('dashboard/inventory') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'inventory') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-boxes mr-3"></i>
                        Inventory
                    </a>
                    
                    <a href="<?= base_url('dashboard/movements') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'movements') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-exchange-alt mr-3"></i>
                        Stock Movements
                    </a>

                    <a href="<?= base_url('dashboard/photos') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'photos') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-camera mr-3"></i>
                        Photoproof
                    </a>

                    <a href="<?= base_url('dashboard/referred') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'referred') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-shipping-fast mr-3"></i>
                        Dispatch
                    </a>

                    <a href="<?= base_url('dashboard/parts-requests') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'parts-requests') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-tools mr-3"></i>
                        Parts Requests
                    </a>

                    <?php helper('auth'); ?>
                    <?php if (canCreateTechnician()): ?>
                        <a href="<?= base_url('dashboard/service-centers') ?>"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'service-centers') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                            <i class="fas fa-building mr-3"></i>
                            Service Centers
                        </a>
                        <a href="<?= base_url('dashboard/technicians') ?>"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'technicians') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                            <i class="fas fa-user-cog mr-3"></i>
                            Technicians
                        </a>

                        <a href="<?= base_url('dashboard/user-management') ?>"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'user-management') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                            <i class="fas fa-users mr-3"></i>
                            User Management
                        </a>
                    <?php endif; ?>

                    <div class="border-t border-gray-200 my-4"></div>

                    <a href="<?= base_url('dashboard/user-guide') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'user-guide') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-question-circle mr-3"></i>
                        User Guide
                    </a>


                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 flex-shrink-0">
                <div class="flex items-center justify-between px-4 py-4 lg:px-6">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" id="mobile-menu-btn"
                                class="text-gray-500 hover:text-gray-700 lg:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors focus-ring">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="ml-2 text-lg font-semibold text-gray-800 lg:ml-0 lg:text-xl truncate">
                            <?= $title ?? 'Dashboard' ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center text-gray-500 hover:text-gray-700">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <div class="relative">
                            <button onclick="toggleUserMenu()" id="user-menu-btn" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2 rounded-md hover:bg-gray-100 focus-ring">
                                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="text-sm font-medium"><?= session()->get('full_name') ?? 'User' ?></span>
                                <i class="fas fa-chevron-down text-xs transition-transform" id="user-menu-arrow"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border dropdown-menu" id="user-menu">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <div class="font-medium"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs text-gray-500"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs text-gray-500 capitalize"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Settings
                                </a>
                                <div class="border-t"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-4 py-6 lg:px-6 lg:py-8">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>



    <script>
        // Dashboard State Management
        const DashboardState = {
            sidebarOpen: false,
            userMenuOpen: false
        };

        // Sidebar Functions
        function toggleSidebar() {
            DashboardState.sidebarOpen = !DashboardState.sidebarOpen;
            updateSidebarDisplay();

            if (window.innerWidth < 1024) {
                document.body.style.overflow = DashboardState.sidebarOpen ? 'hidden' : '';
            }
        }

        function closeSidebar() {
            DashboardState.sidebarOpen = false;
            updateSidebarDisplay();
            document.body.style.overflow = '';
        }

        function updateSidebarDisplay() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (DashboardState.sidebarOpen) {
                sidebar.classList.add('open');
                overlay.classList.add('active');
            } else {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        }

        // User Menu Functions
        function toggleUserMenu() {
            DashboardState.userMenuOpen = !DashboardState.userMenuOpen;
            updateUserMenuDisplay();
        }

        function closeUserMenu() {
            DashboardState.userMenuOpen = false;
            updateUserMenuDisplay();
        }

        function updateUserMenuDisplay() {
            const userMenu = document.getElementById('user-menu');
            const arrow = document.getElementById('user-menu-arrow');

            if (DashboardState.userMenuOpen) {
                userMenu.classList.add('show');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                userMenu.classList.remove('show');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Initialize Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages
            setTimeout(function() {
                const alerts = document.querySelectorAll('[role="alert"]');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000);

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    document.body.style.overflow = '';
                    closeSidebar();
                }
            });

            // Handle escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (DashboardState.userMenuOpen) {
                        closeUserMenu();
                    }
                    if (window.innerWidth < 1024 && DashboardState.sidebarOpen) {
                        closeSidebar();
                    }
                }
            });

            // Handle clicks outside elements
            document.addEventListener('click', function(e) {
                // Close user menu when clicking outside
                const userMenuContainer = e.target.closest('#user-menu-btn') || e.target.closest('#user-menu');
                if (!userMenuContainer && DashboardState.userMenuOpen) {
                    closeUserMenu();
                }

                // Close sidebar on mobile when clicking outside
                if (window.innerWidth < 1024 && DashboardState.sidebarOpen) {
                    const sidebarContainer = e.target.closest('#sidebar') || e.target.closest('#mobile-menu-btn');
                    if (!sidebarContainer) {
                        closeSidebar();
                    }
                }
            });

            // Auto-close sidebar when clicking navigation links on mobile
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        setTimeout(closeSidebar, 100);
                    }
                });
            });

            // Touch gestures for mobile
            let touchStartX = 0;
            let touchStartY = 0;

            document.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
            });

            document.addEventListener('touchend', function(e) {
                if (window.innerWidth < 1024) {
                    const touchEndX = e.changedTouches[0].clientX;
                    const touchEndY = e.changedTouches[0].clientY;
                    const deltaX = touchEndX - touchStartX;
                    const deltaY = touchEndY - touchStartY;

                    // Swipe right to open sidebar (from left edge)
                    if (deltaX > 50 && Math.abs(deltaY) < 100 && touchStartX < 50) {
                        DashboardState.sidebarOpen = true;
                        updateSidebarDisplay();
                        document.body.style.overflow = 'hidden';
                    }

                    // Swipe left to close sidebar
                    if (deltaX < -50 && Math.abs(deltaY) < 100 && DashboardState.sidebarOpen) {
                        closeSidebar();
                    }
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Alt + M for mobile menu toggle
                if (e.altKey && e.key === 'm' && window.innerWidth < 1024) {
                    e.preventDefault();
                    toggleSidebar();
                }

                // Ctrl/Cmd + K for search (if search exists)
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[type="search"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });

            // Focus management for accessibility
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab' && window.innerWidth < 1024 && DashboardState.sidebarOpen) {
                    const sidebarFocusable = document.querySelectorAll('#sidebar button, #sidebar [href]');
                    const firstFocusable = sidebarFocusable[0];
                    const lastFocusable = sidebarFocusable[sidebarFocusable.length - 1];

                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            e.preventDefault();
                            lastFocusable.focus();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            e.preventDefault();
                            firstFocusable.focus();
                        }
                    }
                }
            });

            // Initialize proper state
            if (window.innerWidth >= 1024) {
                document.body.style.overflow = '';
            }
        });

        // Global notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-opacity ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
            } text-white`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Make functions globally available
        window.toggleSidebar = toggleSidebar;
        window.closeSidebar = closeSidebar;
        window.toggleUserMenu = toggleUserMenu;
        window.closeUserMenu = closeUserMenu;
        window.showNotification = showNotification;
    </script>
</body>
</html>
