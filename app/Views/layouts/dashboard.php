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
                        google: {
                            blue: '<?= $config->brandColors['primary'] ?>',      // #1a73e8
                            gray: '<?= $config->brandColors['secondary'] ?>',    // #5f6368
                            green: '<?= $config->brandColors['accent'] ?>',      // #34a853
                            yellow: '<?= $config->brandColors['warning'] ?>',    // #fbbc04
                            red: '<?= $config->brandColors['danger'] ?>',        // #ea4335
                            info: '<?= $config->brandColors['info'] ?>',         // #4285f4
                            dark: '<?= $config->brandColors['dark'] ?>',         // #202124
                            light: '<?= $config->brandColors['light'] ?>',       // #ffffff
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Google Clean Design Theme */
        :root {
            --google-blue: #1a73e8;
            --google-blue-hover: #1557b0;
            --google-gray: #5f6368;
            --google-gray-light: #9aa0a6;
            --google-gray-lighter: #dadce0;
            --google-gray-lightest: #f8f9fa;
            --google-green: #34a853;
            --google-yellow: #fbbc04;
            --google-red: #ea4335;
            --google-dark: #202124;
            --google-white: #ffffff;
            --google-surface: #ffffff;
            --google-background: #fafafa;
            --google-border: #e8eaed;
            --google-shadow: rgba(60, 64, 67, 0.3);
            --google-shadow-light: rgba(60, 64, 67, 0.15);
        }

        /* Google Clean Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            background: var(--google-surface);
            border-right: 1px solid var(--google-border);
            box-shadow: 0 1px 2px 0 var(--google-shadow-light), 0 1px 3px 1px var(--google-shadow-light);
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
            transition: opacity 0.3s cubic-bezier(0.4, 0.0, 0.2, 1), visibility 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            background: rgba(32, 33, 36, 0.6);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Google Clean Dropdown Menus */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s cubic-bezier(0.4, 0.0, 0.2, 1);
            background: var(--google-surface);
            border: 1px solid var(--google-border);
            box-shadow: 0 2px 10px 0 var(--google-shadow);
            border-radius: 8px;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Google Clean Navigation Links */
        .nav-link {
            transition: all 0.2s cubic-bezier(0.4, 0.0, 0.2, 1);
            border-radius: 24px;
            margin: 4px 8px;
            position: relative;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(26, 115, 232, 0.08);
            color: var(--google-blue);
        }

        .nav-link.active {
            background: rgba(26, 115, 232, 0.12);
            color: var(--google-blue);
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: var(--google-blue);
            border-radius: 0 2px 2px 0;
        }

        /* Google Clean Cards */
        .card {
            background: var(--google-surface);
            border: 1px solid var(--google-border);
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light), 0 1px 3px 1px var(--google-shadow-light);
            transition: all 0.2s cubic-bezier(0.4, 0.0, 0.2, 1);
        }

        .card:hover {
            box-shadow: 0 1px 3px 0 var(--google-shadow), 0 4px 8px 3px var(--google-shadow-light);
            transform: translateY(-1px);
        }

        .card-header {
            background: var(--google-surface);
            color: var(--google-dark);
            border-bottom: 1px solid var(--google-border);
            padding: 16px 24px;
            border-radius: 8px 8px 0 0;
            font-weight: 500;
            font-size: 16px;
        }

        .card-body {
            padding: 24px;
        }

        /* Google Clean Button System */
        .btn-primary {
            background: var(--google-blue);
            color: var(--google-white);
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            transition: all 0.2s cubic-bezier(0.4, 0.0, 0.2, 1);
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light), 0 1px 3px 1px var(--google-shadow-light);
            text-transform: none;
        }

        .btn-primary:hover {
            background: var(--google-blue-hover);
            box-shadow: 0 1px 3px 0 var(--google-shadow), 0 4px 8px 3px var(--google-shadow-light);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--google-surface);
            color: var(--google-blue);
            border: 1px solid var(--google-border);
            border-radius: 4px;
            padding: 10px 24px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light);
            text-transform: none;
        }

        .btn-secondary:hover {
            background: rgba(26, 115, 232, 0.04);
            border-color: var(--google-blue);
            box-shadow: 0 1px 3px 0 var(--google-shadow-light);
        }

        .btn-success {
            background: var(--google-green);
            color: var(--google-white);
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light);
            text-transform: none;
        }

        .btn-success:hover {
            background: #2d8f47;
            box-shadow: 0 1px 3px 0 var(--google-shadow-light);
            transform: translateY(-1px);
        }

        .btn-info {
            background: var(--google-info);
            color: var(--google-white);
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light);
            text-transform: none;
        }

        .btn-info:hover {
            background: #3367d6;
            box-shadow: 0 1px 3px 0 var(--google-shadow-light);
            transform: translateY(-1px);
        }

        .btn-warning {
            background: var(--google-yellow);
            color: var(--google-dark);
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light);
            text-transform: none;
        }

        .btn-warning:hover {
            background: #f9ab00;
            box-shadow: 0 1px 3px 0 var(--google-shadow-light);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: var(--google-red);
            color: var(--google-white);
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 1px 2px 0 var(--google-shadow-light);
            text-transform: none;
        }

        .btn-danger:hover {
            background: #d33b2c;
            box-shadow: 0 1px 3px 0 var(--google-shadow-light);
            transform: translateY(-1px);
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

        /* Google Clean Focus styles */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }

        /* Google Clean Form Controls */
        .form-control {
            border: 1px solid var(--google-border);
            border-radius: 4px;
            padding: 12px 16px;
            transition: all 0.2s cubic-bezier(0.4, 0.0, 0.2, 1);
            background: var(--google-surface);
            font-size: 14px;
            line-height: 20px;
        }

        .form-control:focus {
            border-color: var(--google-blue);
            box-shadow: 0 0 0 1px var(--google-blue);
            outline: none;
        }

        .form-control:hover {
            border-color: var(--google-gray);
        }

        /* Status indicators */
        .status-active { color: #059669; }
        .status-pending { color: #f59e0b; }
        .status-inactive { color: #dc2626; }
    </style>
</head>
<body style="background-color: var(--google-background);" class="text-gray-800">
    <div class="flex h-screen overflow-hidden" id="app-container">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 z-40 lg:hidden sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 shadow-2xl sidebar lg:static lg:inset-0 lg:z-auto" id="sidebar">

            <!-- Google Clean Logo -->
            <div class="flex items-center justify-center h-16 px-6" style="background-color: var(--google-surface); border-bottom: 1px solid var(--google-border);">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full flex items-center justify-center mr-3" style="background-color: var(--google-blue);">
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-medium" style="color: var(--google-dark);"><?= $config->appShortName ?></h1>
                        <p class="text-xs" style="color: var(--google-gray);">Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-2 py-4">
                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link flex items-center px-4 py-3 font-medium <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>" style="color: var(--google-gray);">
                        <i class="fas fa-tachometer-alt mr-4 w-5 text-center"></i>
                        Dashboard
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link flex items-center px-4 py-3 font-medium <?= strpos(uri_string(), 'jobs') !== false ? 'active' : '' ?>" style="color: var(--google-gray);">
                        <i class="fas fa-wrench mr-4 w-5 text-center"></i>
                        Jobs
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link flex items-center px-4 py-3 font-medium <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>" style="color: var(--google-gray);">
                        <i class="fas fa-users mr-4 w-5 text-center"></i>
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
            <!-- Google Clean Header -->
            <header class="bg-white shadow-sm border-b flex-shrink-0" style="border-color: var(--google-border); box-shadow: 0 1px 2px 0 var(--google-shadow-light);">
                <div class="flex items-center justify-between px-6 py-4 lg:px-8">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" id="mobile-menu-btn"
                                class="lg:hidden p-2 rounded-full hover:bg-gray-100 focus:outline-none focus-ring transition-all"
                                style="color: var(--google-gray);">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="ml-3 text-xl font-normal lg:ml-0 lg:text-2xl truncate" style="color: var(--google-dark);">
                            <?= $title ?? 'Dashboard' ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <button class="p-2 rounded-full hover:bg-gray-100 transition-all" style="color: var(--google-gray);">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-medium" style="background-color: var(--google-red);">3</span>
                            </button>
                        </div>

                        <div class="relative">
                            <button onclick="toggleUserMenu()" id="user-menu-btn" class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-100 focus-ring transition-all" style="color: var(--google-dark);">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white" style="background-color: var(--google-blue);">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-medium"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs capitalize" style="color: var(--google-gray);"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" id="user-menu-arrow"></i>
                            </button>

                            <!-- Google Clean Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white shadow-lg py-2 z-50 dropdown-menu" id="user-menu">
                                <div class="px-4 py-3" style="border-bottom: 1px solid var(--google-border);">
                                    <div class="font-medium" style="color: var(--google-dark);"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-sm" style="color: var(--google-gray);"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs capitalize font-medium mt-1" style="color: var(--google-blue);"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-4 py-2 text-sm hover:bg-gray-50 transition-colors" style="color: var(--google-dark);">
                                    <i class="fas fa-user mr-3 w-4" style="color: var(--google-gray);"></i>Profile
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-4 py-2 text-sm hover:bg-gray-50 transition-colors" style="color: var(--google-dark);">
                                    <i class="fas fa-cog mr-3 w-4" style="color: var(--google-gray);"></i>Settings
                                </a>
                                <div style="border-top: 1px solid var(--google-border);" class="my-1"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-2 text-sm hover:bg-red-50 transition-colors" style="color: var(--google-red);">
                                    <i class="fas fa-sign-out-alt mr-3 w-4"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Google Clean Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto" style="background-color: var(--google-background);">
                <div class="container mx-auto px-6 py-6 lg:px-8 lg:py-8">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-4 px-4 py-3 rounded-lg" role="alert" style="background-color: #e8f5e8; border: 1px solid var(--google-green); color: var(--google-green);">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3" style="color: var(--google-green);"></i>
                                <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-4 px-4 py-3 rounded-lg" role="alert" style="background-color: #fce8e6; border: 1px solid var(--google-red); color: var(--google-red);">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3" style="color: var(--google-red);"></i>
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
