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
                        yellow: {
                            50: '#fffbeb',   // Amber-50 (Light background)
                            100: '#fef3c7',  // Amber-100
                            200: '#fde68a',  // Amber-200
                            300: '#fcd34d',  // Amber-300
                            400: '<?= $config->brandColors['accent'] ?>',   // Amber-400 (Accent)
                            500: '#f59e0b',  // Amber-500
                            600: '<?= $config->brandColors['primary'] ?>',  // Amber-600 (Primary)
                            700: '<?= $config->brandColors['secondary'] ?>', // Amber-700 (Secondary)
                            800: '#92400e',  // Amber-800
                            900: '<?= $config->brandColors['dark'] ?>',     // Amber-900 (Dark)
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Dark Yellow Minimal Design Theme */
        :root {
            --yellow-50: #fffbeb;
            --yellow-100: #fef3c7;
            --yellow-200: #fde68a;
            --yellow-300: #fcd34d;
            --yellow-400: #fbbf24;
            --yellow-500: #f59e0b;
            --yellow-600: #d97706;
            --yellow-700: #b45309;
            --yellow-800: #92400e;
            --yellow-900: #451a03;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        /* Dark Yellow Minimal Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            background: var(--yellow-900);
            border-right: 2px solid var(--yellow-600);
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
            background: rgba(69, 26, 3, 0.8);
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
            border: 1px solid var(--yellow-200);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.1);
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Dark Yellow Navigation Links */
        .nav-link {
            transition: all 0.2s ease-in-out;
            border-radius: 12px;
            margin: 3px 0;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            background: rgba(251, 191, 36, 0.1);
            color: var(--yellow-400);
            border-color: var(--yellow-600);
        }

        .nav-link.active {
            background: var(--yellow-600);
            color: white;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.4);
            border-color: var(--yellow-500);
        }

        /* Dark Yellow Minimal Cards */
        .card {
            background: white;
            border: 1px solid var(--yellow-200);
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 12px 32px rgba(217, 119, 6, 0.15);
            border-color: var(--yellow-400);
            transform: translateY(-4px);
        }

        /* Dark Yellow Minimal Buttons */
        .btn-primary {
            background: var(--yellow-600);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            transition: all 0.3s ease-in-out;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--yellow-700);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.4);
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
            outline: 2px solid var(--yellow-600);
            outline-offset: 2px;
        }

        /* Status indicators */
        .status-active { color: #059669; }
        .status-pending { color: #f59e0b; }
        .status-inactive { color: #dc2626; }
    </style>
</head>
<body class="bg-yellow-50 text-gray-800">
    <div class="flex h-screen overflow-hidden" id="app-container">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 z-40 lg:hidden sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 shadow-2xl sidebar lg:static lg:inset-0 lg:z-auto" id="sidebar">

            <!-- Logo -->
            <div class="flex items-center justify-center h-18 px-6 bg-yellow-900 border-b-2 border-yellow-600">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-yellow-600 rounded-2xl flex items-center justify-center mr-4 shadow-xl">
                        <i class="fas fa-tools text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight"><?= $config->appShortName ?></h1>
                        <p class="text-sm text-yellow-300 font-medium">Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link flex items-center px-4 py-3 text-yellow-200 font-medium <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt mr-4 w-5 text-lg"></i>
                        Dashboard
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link flex items-center px-4 py-3 text-yellow-200 font-medium <?= strpos(uri_string(), 'jobs') !== false ? 'active' : '' ?>">
                        <i class="fas fa-wrench mr-4 w-5 text-lg"></i>
                        Jobs
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link flex items-center px-4 py-3 text-yellow-200 font-medium <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users mr-4 w-5 text-lg"></i>
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
            <header class="bg-white shadow-sm border-b-2 border-yellow-200 flex-shrink-0">
                <div class="flex items-center justify-between px-6 py-5 lg:px-8">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" id="mobile-menu-btn"
                                class="text-yellow-600 hover:text-yellow-700 lg:hidden p-3 rounded-xl hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-600 transition-all focus-ring">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="ml-3 text-2xl font-bold text-gray-800 lg:ml-0 lg:text-3xl truncate">
                            <?= $title ?? 'Dashboard' ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center text-yellow-600 hover:text-yellow-700 p-3 rounded-xl hover:bg-yellow-100 transition-all">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-yellow-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">3</span>
                            </button>
                        </div>

                        <div class="relative">
                            <button onclick="toggleUserMenu()" id="user-menu-btn" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 p-3 rounded-xl hover:bg-yellow-100 focus-ring transition-all">
                                <div class="w-10 h-10 bg-yellow-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-semibold"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs text-yellow-600 capitalize font-medium"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" id="user-menu-arrow"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl py-3 z-50 border border-yellow-200 dropdown-menu" id="user-menu">
                                <div class="px-5 py-4 border-b border-yellow-100">
                                    <div class="font-bold text-gray-800"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-sm text-gray-600"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs text-yellow-600 capitalize font-semibold mt-1"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors rounded-lg mx-2">
                                    <i class="fas fa-user mr-3 w-4 text-yellow-600"></i>Profile
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors rounded-lg mx-2">
                                    <i class="fas fa-cog mr-3 w-4 text-yellow-600"></i>Settings
                                </a>
                                <div class="border-t border-yellow-100 my-2"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-5 py-3 text-sm text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors rounded-lg mx-2">
                                    <i class="fas fa-sign-out-alt mr-3 w-4 text-red-500"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-yellow-50">
                <div class="container mx-auto px-6 py-8 lg:px-8 lg:py-10">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-8 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-lg" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-4 text-lg"></i>
                                <span class="font-semibold"><?= session()->getFlashdata('success') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-8 bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-lg" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-600 mr-4 text-lg"></i>
                                <span class="font-semibold"><?= session()->getFlashdata('error') ?></span>
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
