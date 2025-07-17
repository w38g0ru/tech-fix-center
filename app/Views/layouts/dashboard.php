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
                        darkbtn: {
                            primary: '<?= $config->brandColors['primary'] ?>',    // #212529
                            secondary: '<?= $config->brandColors['secondary'] ?>', // #495057
                            accent: '<?= $config->brandColors['accent'] ?>',      // #6c757d
                            success: '<?= $config->brandColors['success'] ?>',    // #155724
                            info: '<?= $config->brandColors['info'] ?>',          // #0c5460
                            warning: '<?= $config->brandColors['warning'] ?>',    // #856404
                            danger: '<?= $config->brandColors['danger'] ?>',      // #721c24
                            light: '<?= $config->brandColors['light'] ?>',        // #f8f9fa
                            dark: '<?= $config->brandColors['dark'] ?>',          // #1a1e21
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Dark Button Based Design Theme */
        :root {
            --darkbtn-primary: #212529;
            --darkbtn-secondary: #495057;
            --darkbtn-accent: #6c757d;
            --darkbtn-success: #155724;
            --darkbtn-info: #0c5460;
            --darkbtn-warning: #856404;
            --darkbtn-danger: #721c24;
            --darkbtn-light: #f8f9fa;
            --darkbtn-dark: #1a1e21;
            --darkbtn-white: #ffffff;
            --darkbtn-gray-100: #f8f9fa;
            --darkbtn-gray-200: #e9ecef;
            --darkbtn-gray-300: #dee2e6;
            --darkbtn-gray-400: #ced4da;
            --darkbtn-gray-500: #adb5bd;
            --darkbtn-gray-600: #6c757d;
            --darkbtn-gray-700: #495057;
            --darkbtn-gray-800: #343a40;
            --darkbtn-gray-900: #212529;
        }

        /* Dark Button Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            background: var(--darkbtn-dark);
            border-right: 2px solid var(--darkbtn-primary);
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
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
            background: rgba(26, 30, 33, 0.9);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Dark Button Dropdown Menus */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease-in-out;
            background: var(--darkbtn-white);
            border: 2px solid var(--darkbtn-primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Dark Button Navigation Links */
        .nav-link {
            transition: all 0.2s ease-in-out;
            border-radius: 0.5rem;
            margin: 3px 0;
            position: relative;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            background: var(--darkbtn-primary);
            color: #ffffff;
            border-color: var(--darkbtn-accent);
            box-shadow: 0 2px 8px rgba(33, 37, 41, 0.3);
        }

        .nav-link.active {
            background: var(--darkbtn-primary);
            color: #ffffff;
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 12px rgba(33, 37, 41, 0.4);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -1px;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--darkbtn-accent);
            border-radius: 0 4px 4px 0;
        }

        /* Dark Button Cards */
        .card {
            background: var(--darkbtn-white);
            border: 2px solid var(--darkbtn-primary);
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(33, 37, 41, 0.15);
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(33, 37, 41, 0.25);
            transform: translateY(-2px);
            border-color: var(--darkbtn-accent);
        }

        .card-header {
            background: var(--darkbtn-primary);
            color: var(--darkbtn-white);
            border-bottom: 2px solid var(--darkbtn-accent);
            padding: 1rem 1.5rem;
            border-radius: 0.75rem 0.75rem 0 0;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Dark Button System */
        .btn-primary {
            background: var(--darkbtn-primary);
            color: #ffffff;
            border: 2px solid var(--darkbtn-primary);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease-in-out;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(33, 37, 41, 0.2);
        }

        .btn-primary:hover {
            background: var(--darkbtn-dark);
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 16px rgba(33, 37, 41, 0.3);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--darkbtn-secondary);
            color: #ffffff;
            border: 2px solid var(--darkbtn-secondary);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(73, 80, 87, 0.2);
        }

        .btn-secondary:hover {
            background: var(--darkbtn-primary);
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 16px rgba(73, 80, 87, 0.3);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--darkbtn-success);
            color: #ffffff;
            border: 2px solid var(--darkbtn-success);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(21, 87, 36, 0.2);
        }

        .btn-success:hover {
            background: #0f4419;
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 16px rgba(21, 87, 36, 0.3);
            transform: translateY(-1px);
        }

        .btn-info {
            background: var(--darkbtn-info);
            color: #ffffff;
            border: 2px solid var(--darkbtn-info);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(12, 84, 96, 0.2);
        }

        .btn-info:hover {
            background: #083d44;
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 16px rgba(12, 84, 96, 0.3);
            transform: translateY(-1px);
        }

        .btn-warning {
            background: var(--darkbtn-warning);
            color: #ffffff;
            border: 2px solid var(--darkbtn-warning);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(133, 100, 4, 0.2);
        }

        .btn-warning:hover {
            background: #664d03;
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 16px rgba(133, 100, 4, 0.3);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: var(--darkbtn-danger);
            color: #ffffff;
            border: 2px solid var(--darkbtn-danger);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(114, 28, 36, 0.2);
        }

        .btn-danger:hover {
            background: #58151c;
            border-color: var(--darkbtn-accent);
            box-shadow: 0 4px 16px rgba(114, 28, 36, 0.3);
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

        /* Dark Button Focus styles */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.3);
        }

        /* Dark Button Form Controls */
        .form-control {
            border: 2px solid var(--darkbtn-primary);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease-in-out;
            background: var(--darkbtn-white);
        }

        .form-control:focus {
            border-color: var(--darkbtn-accent);
            box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.15);
            background: var(--darkbtn-light);
        }

        /* Status indicators */
        .status-active { color: #059669; }
        .status-pending { color: #f59e0b; }
        .status-inactive { color: #dc2626; }
    </style>
</head>
<body style="background-color: var(--darkbtn-light);" class="text-gray-800">
    <div class="flex h-screen overflow-hidden" id="app-container">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 z-40 lg:hidden sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 shadow-2xl sidebar lg:static lg:inset-0 lg:z-auto" id="sidebar">

            <!-- AdminLTE Logo -->
            <div class="flex items-center justify-center h-16 px-4" style="background-color: var(--adminlte-dark); border-bottom: 1px solid var(--adminlte-gray-700);">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded flex items-center justify-center mr-3" style="background-color: var(--adminlte-primary);">
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white"><?= $config->appShortName ?></h1>
                        <p class="text-xs text-gray-400 font-normal">Control Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-4 py-2">
                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link flex items-center px-3 py-2 text-gray-300 font-normal text-sm <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt mr-3 w-4 text-center"></i>
                        Dashboard
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link flex items-center px-3 py-2 text-gray-300 font-normal text-sm <?= strpos(uri_string(), 'jobs') !== false ? 'active' : '' ?>">
                        <i class="fas fa-wrench mr-3 w-4 text-center"></i>
                        Jobs
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link flex items-center px-3 py-2 text-gray-300 font-normal text-sm <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users mr-3 w-4 text-center"></i>
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
            <!-- Dark Button Header -->
            <header class="bg-white shadow-lg border-b-2 flex-shrink-0" style="border-color: var(--darkbtn-primary);">
                <div class="flex items-center justify-between px-6 py-4 lg:px-8">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" id="mobile-menu-btn"
                                class="lg:hidden p-3 rounded-lg hover:bg-gray-100 focus:outline-none focus-ring transition-all btn-secondary"
                                style="color: var(--darkbtn-primary);">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="ml-3 text-2xl font-bold lg:ml-0 lg:text-3xl truncate" style="color: var(--darkbtn-primary);">
                            <?= $title ?? 'Dashboard' ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <button class="btn-secondary flex items-center p-3 transition-all">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" style="background-color: var(--darkbtn-danger);">3</span>
                            </button>
                        </div>

                        <div class="relative">
                            <button onclick="toggleUserMenu()" id="user-menu-btn" class="btn-primary flex items-center space-x-3 focus-ring transition-all">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shadow-lg" style="background-color: var(--darkbtn-accent); border: 2px solid var(--darkbtn-primary);">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-bold"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs capitalize opacity-80"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform" id="user-menu-arrow"></i>
                            </button>

                            <!-- Dark Button Dropdown Menu -->
                            <div class="absolute right-0 mt-3 w-64 bg-white shadow-2xl py-2 z-50 dropdown-menu" id="user-menu">
                                <div class="px-6 py-4" style="background: var(--darkbtn-primary); color: white; border-bottom: 2px solid var(--darkbtn-accent);">
                                    <div class="font-bold text-lg"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-sm opacity-80"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs capitalize font-semibold mt-1" style="color: var(--darkbtn-accent);"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-gray-100 transition-colors" style="color: var(--darkbtn-primary);">
                                    <div class="w-8 h-8 rounded flex items-center justify-center mr-3" style="background: var(--darkbtn-secondary);">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    Profile
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-gray-100 transition-colors" style="color: var(--darkbtn-primary);">
                                    <div class="w-8 h-8 rounded flex items-center justify-center mr-3" style="background: var(--darkbtn-secondary);">
                                        <i class="fas fa-cog text-white text-sm"></i>
                                    </div>
                                    Settings
                                </a>
                                <div style="border-top: 2px solid var(--darkbtn-primary);" class="my-2"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-6 py-3 text-sm font-medium hover:bg-red-50 transition-colors" style="color: var(--darkbtn-danger);">
                                    <div class="w-8 h-8 rounded flex items-center justify-center mr-3" style="background: var(--darkbtn-danger);">
                                        <i class="fas fa-sign-out-alt text-white text-sm"></i>
                                    </div>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dark Button Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto" style="background-color: var(--darkbtn-light);">
                <div class="container mx-auto px-6 py-8 lg:px-8 lg:py-10">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-6 px-6 py-4 border-l-4 rounded-lg shadow-lg" role="alert" style="background-color: #d4edda; border-color: var(--darkbtn-success); color: var(--darkbtn-success);">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4" style="background: var(--darkbtn-success);">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                                <span class="font-bold text-lg"><?= session()->getFlashdata('success') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-6 px-6 py-4 border-l-4 rounded-lg shadow-lg" role="alert" style="background-color: #f8d7da; border-color: var(--darkbtn-danger); color: var(--darkbtn-danger);">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4" style="background: var(--darkbtn-danger);">
                                    <i class="fas fa-exclamation-circle text-white"></i>
                                </div>
                                <span class="font-bold text-lg"><?= session()->getFlashdata('error') ?></span>
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
