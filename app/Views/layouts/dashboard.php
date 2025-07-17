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
                        mono: {
                            50: '#f9fafb',   // Gray-50 (Lightest)
                            100: '#f3f4f6',  // Gray-100
                            200: '#e5e7eb',  // Gray-200
                            300: '#d1d5db',  // Gray-300
                            400: '#9ca3af',  // Gray-400
                            500: '#6b7280',  // Gray-500 (Medium)
                            600: '#4b5563',  // Gray-600
                            700: '<?= $config->brandColors['primary'] ?>',  // Gray-700 (Primary)
                            800: '#1f2937',  // Gray-800
                            900: '<?= $config->brandColors['accent'] ?>',   // Gray-900 (Darkest)
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Monochromatic Design Theme */
        :root {
            --mono-50: #f9fafb;
            --mono-100: #f3f4f6;
            --mono-200: #e5e7eb;
            --mono-300: #d1d5db;
            --mono-400: #9ca3af;
            --mono-500: #6b7280;
            --mono-600: #4b5563;
            --mono-700: #374151;
            --mono-800: #1f2937;
            --mono-900: #111827;
        }

        /* Monochromatic Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            background: var(--mono-900);
            border-right: 1px solid var(--mono-800);
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
            background: rgba(17, 24, 39, 0.8);
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
            background: white;
            border: 1px solid var(--mono-200);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Monochromatic Navigation Links */
        .nav-link {
            transition: all 0.2s ease-in-out;
            border-radius: 8px;
            margin: 2px 0;
        }

        .nav-link:hover {
            background: rgba(107, 114, 128, 0.1);
            color: var(--mono-300);
        }

        .nav-link.active {
            background: var(--mono-700);
            color: white;
            box-shadow: 0 2px 8px rgba(55, 65, 81, 0.3);
        }

        /* Monochromatic Cards and Components */
        .card {
            background: white;
            border: 1px solid var(--mono-200);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: var(--mono-400);
            transform: translateY(-2px);
        }

        /* Monochromatic Buttons */
        .btn-primary {
            background: var(--mono-700);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background: var(--mono-800);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(55, 65, 81, 0.3);
        }

        /* Mobile optimizations */
        @media (max-width: 1023px) {
            body {
                -webkit-overflow-scrolling: touch;
            }

            input, select, textarea {
                font-size: 16px !important;
            }

            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Scrolling */
        .scroll-container {
            -webkit-overflow-scrolling: touch;
            overflow-y: auto;
        }

        /* Tables */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive table {
                min-width: 600px;
            }
        }

        /* Focus styles */
        .focus-ring:focus {
            outline: 2px solid var(--mono-600);
            outline-offset: 2px;
        }

        /* Status indicators */
        .status-active { color: #059669; }
        .status-pending { color: #f59e0b; }
        .status-inactive { color: #dc2626; }
    </style>
</head>
<body class="bg-mono-50 text-mono-800">
    <div class="flex h-screen overflow-hidden" id="app-container">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 z-40 lg:hidden sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 shadow-2xl sidebar lg:static lg:inset-0 lg:z-auto" id="sidebar">

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-mono-800 border-b border-mono-700">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-mono-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white tracking-tight"><?= $config->appShortName ?></h1>
                        <p class="text-xs text-mono-300 font-medium">Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-3 space-y-1">
                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link flex items-center px-3 py-3 text-mono-300 font-medium <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                        Dashboard
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link flex items-center px-3 py-3 text-mono-300 font-medium <?= strpos(uri_string(), 'jobs') !== false ? 'active' : '' ?>">
                        <i class="fas fa-wrench mr-3 w-5"></i>
                        Jobs
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link flex items-center px-3 py-3 text-mono-300 font-medium <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users mr-3 w-5"></i>
                        Customers
                    </a>
                    

                    <a href="<?= base_url('dashboard/inventory') ?>"
                       class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'inventory') !== false ? 'active' : '' ?>">
                        <i class="fas fa-boxes mr-3 w-5"></i>
                        Inventory
                    </a>

                    <a href="<?= base_url('dashboard/movements') ?>"
                       class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'movements') !== false ? 'active' : '' ?>">
                        <i class="fas fa-exchange-alt mr-3 w-5"></i>
                        Stock Movements
                    </a>

                    <a href="<?= base_url('dashboard/photos') ?>"
                       class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'photos') !== false ? 'active' : '' ?>">
                        <i class="fas fa-camera mr-3 w-5"></i>
                        Photoproof
                    </a>

                    <a href="<?= base_url('dashboard/referred') ?>"
                       class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'referred') !== false ? 'active' : '' ?>">
                        <i class="fas fa-shipping-fast mr-3 w-5"></i>
                        Dispatch
                    </a>

                    <a href="<?= base_url('dashboard/parts-requests') ?>"
                       class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'parts-requests') !== false ? 'active' : '' ?>">
                        <i class="fas fa-tools mr-3 w-5"></i>
                        Parts Requests
                    </a>

                    <?php helper('auth'); ?>
                    <?php if (canCreateTechnician()): ?>
                        <div class="border-t border-gray-700 my-4 mx-3"></div>
                        <div class="px-3 mb-2">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</p>
                        </div>

                        <a href="<?= base_url('dashboard/service-centers') ?>"
                           class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'service-centers') !== false ? 'active' : '' ?>">
                            <i class="fas fa-building mr-3 w-5"></i>
                            Service Centers
                        </a>
                        <a href="<?= base_url('dashboard/technicians') ?>"
                           class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'technicians') !== false ? 'active' : '' ?>">
                            <i class="fas fa-user-cog mr-3 w-5"></i>
                            Technicians
                        </a>

                        <a href="<?= base_url('dashboard/user-management') ?>"
                           class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'user-management') !== false ? 'active' : '' ?>">
                            <i class="fas fa-users mr-3 w-5"></i>
                            User Management
                        </a>
                    <?php endif; ?>

                    <div class="border-t border-gray-700 my-4 mx-3"></div>

                    <a href="<?= base_url('dashboard/user-guide') ?>"
                       class="nav-link flex items-center px-3 py-3 text-gray-300 font-medium <?= strpos(uri_string(), 'user-guide') !== false ? 'active' : '' ?>">
                        <i class="fas fa-question-circle mr-3 w-5"></i>
                        User Guide
                    </a>


                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-mono-200 flex-shrink-0">
                <div class="flex items-center justify-between px-4 py-4 lg:px-6">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" id="mobile-menu-btn"
                                class="text-mono-500 hover:text-mono-700 lg:hidden p-2 rounded-lg hover:bg-mono-100 focus:outline-none focus:ring-2 focus:ring-mono-600 transition-all focus-ring">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="ml-2 text-xl font-bold text-mono-800 lg:ml-0 lg:text-2xl truncate">
                            <?= $title ?? 'Dashboard' ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <button class="flex items-center text-mono-500 hover:text-mono-700 p-2 rounded-lg hover:bg-mono-100 transition-all">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-mono-600 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                            </button>
                        </div>

                        <div class="relative">
                            <button onclick="toggleUserMenu()" id="user-menu-btn" class="flex items-center space-x-3 text-mono-700 hover:text-mono-900 p-2 rounded-lg hover:bg-mono-100 focus-ring transition-all">
                                <div class="w-9 h-9 bg-mono-600 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-semibold"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs text-mono-500 capitalize"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" id="user-menu-arrow"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-mono-200 dropdown-menu" id="user-menu">
                                <div class="px-4 py-3 border-b border-mono-100">
                                    <div class="font-semibold text-mono-800"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-sm text-mono-500"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs text-mono-600 capitalize font-medium"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-4 py-3 text-sm text-mono-700 hover:bg-mono-100 hover:text-mono-800 transition-colors">
                                    <i class="fas fa-user mr-3 w-4"></i>Profile
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-4 py-3 text-sm text-mono-700 hover:bg-mono-100 hover:text-mono-800 transition-colors">
                                    <i class="fas fa-cog mr-3 w-4"></i>Settings
                                </a>
                                <div class="border-t border-mono-100 my-1"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-3 text-sm text-mono-600 hover:bg-mono-100 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3 w-4"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-mono-50">
                <div class="container mx-auto px-4 py-6 lg:px-6 lg:py-8">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-6 bg-mono-100 border border-mono-300 text-mono-800 px-4 py-4 rounded-xl shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-mono-600 mr-3"></i>
                                <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-6 bg-mono-200 border border-mono-400 text-mono-800 px-4 py-4 rounded-xl shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-mono-700 mr-3"></i>
                                <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
                            </div>
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
