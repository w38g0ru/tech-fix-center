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
                        quasar: {
                            primary: '<?= $config->brandColors['primary'] ?>',    // #1976d2
                            secondary: '<?= $config->brandColors['secondary'] ?>', // #26a69a
                            accent: '<?= $config->brandColors['accent'] ?>',      // #9c27b0
                            warning: '<?= $config->brandColors['warning'] ?>',    // #ff9800
                            danger: '<?= $config->brandColors['danger'] ?>',      // #f44336
                            success: '<?= $config->brandColors['success'] ?>',    // #4caf50
                            info: '<?= $config->brandColors['info'] ?>',          // #2196f3
                            dark: '<?= $config->brandColors['dark'] ?>',          // #1d1d1d
                            light: '<?= $config->brandColors['light'] ?>',        // #fafafa
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Quasar Minimalist Design Theme */
        :root {
            --quasar-primary: #1976d2;
            --quasar-primary-hover: #1565c0;
            --quasar-secondary: #26a69a;
            --quasar-secondary-hover: #00897b;
            --quasar-accent: #9c27b0;
            --quasar-accent-hover: #7b1fa2;
            --quasar-warning: #ff9800;
            --quasar-danger: #f44336;
            --quasar-success: #4caf50;
            --quasar-info: #2196f3;
            --quasar-dark: #1d1d1d;
            --quasar-light: #fafafa;
            --quasar-white: #ffffff;
            --quasar-surface: #ffffff;
            --quasar-background: #f5f5f5;
            --quasar-border: #e0e0e0;
            --quasar-separator: #e0e0e0;
            --quasar-shadow: rgba(0, 0, 0, 0.2);
            --quasar-shadow-light: rgba(0, 0, 0, 0.12);
            --quasar-text-primary: #212121;
            --quasar-text-secondary: #757575;
        }

        /* Quasar Improved Layout Sidebar */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--quasar-surface);
            border-right: 1px solid var(--quasar-separator);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15), 0 2px 4px rgba(0, 0, 0, 0.12);
            width: 320px;
            backdrop-filter: blur(15px);
            z-index: 1000;
        }

        @media (min-width: 1024px) {
            .sidebar {
                width: 280px;
            }
        }

        @media (min-width: 1280px) {
            .sidebar {
                width: 320px;
            }
        }

        .sidebar.open {
            transform: translateX(0);
        }

        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0) !important;
            }
        }

        /* Quasar Mobile Overlay */
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.28s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Quasar Minimalist Dropdown Menus */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(0.95);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--quasar-surface);
            border: none;
            box-shadow: 0 5px 5px -3px rgba(0, 0, 0, 0.2), 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12);
            border-radius: 4px;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Quasar Minimalist Improved Navigation Links */
        .nav-link {
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
            margin: 2px 12px;
            position: relative;
            font-weight: 500;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: rgba(25, 118, 210, 0.08);
            color: var(--quasar-primary);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--quasar-primary), var(--quasar-primary-hover));
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 32px;
            background: var(--quasar-accent);
            border-radius: 2px 0 0 2px;
        }

        /* Quasar Improved Layout Cards */
        .card {
            background: var(--quasar-surface);
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1), 0 4px 16px rgba(0, 0, 0, 0.08);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12), 0 8px 32px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--quasar-primary), var(--quasar-primary-hover));
            color: white;
            border-bottom: none;
            padding: 20px 32px;
            border-radius: 0;
            font-weight: 600;
            font-size: 18px;
            position: relative;
            min-height: 80px;
            display: flex;
            align-items: center;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--quasar-accent), var(--quasar-secondary));
        }

        .card-body {
            padding: 32px;
            background: var(--quasar-surface);
            line-height: 1.6;
        }

        .card-compact .card-header {
            padding: 16px 24px;
            min-height: 60px;
            font-size: 16px;
        }

        .card-compact .card-body {
            padding: 24px;
        }

        /* Quasar Minimalist Button System */
        .btn-primary {
            background: linear-gradient(135deg, var(--quasar-primary), var(--quasar-primary-hover));
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px 24px;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            box-shadow: 0 3px 5px -1px rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--quasar-surface);
            color: var(--quasar-primary);
            border: 1px solid var(--quasar-primary);
            border-radius: 4px;
            padding: 12px 24px;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2), 0 2px 2px rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.12);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(25, 118, 210, 0.1), transparent);
            transition: left 0.5s;
        }

        .btn-secondary:hover::before {
            left: 100%;
        }

        .btn-secondary:hover {
            background: rgba(25, 118, 210, 0.04);
            border-color: var(--quasar-primary-hover);
            box-shadow: 0 3px 5px -1px rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--quasar-success), #388e3c);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px 24px;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-success:hover {
            box-shadow: 0 3px 5px -1px rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
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

        /* Quasar Minimalist Focus styles */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }

        /* Quasar Minimalist Form Controls */
        .form-control {
            border: 1px solid var(--quasar-separator);
            border-radius: 4px;
            padding: 12px 16px;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--quasar-surface);
            font-size: 14px;
            line-height: 20px;
            position: relative;
        }

        .form-control:focus {
            border-color: var(--quasar-primary);
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
            outline: none;
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: var(--quasar-text-secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        /* Quasar Improved Layout System */
        .layout-grid {
            display: grid;
            gap: 24px;
        }

        .layout-grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .layout-grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .layout-grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        @media (min-width: 768px) {
            .layout-grid {
                gap: 32px;
            }

            .layout-grid-2 {
                grid-template-columns: repeat(2, 1fr);
            }

            .layout-grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }

            .layout-grid-4 {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Layout Spacing */
        .layout-section {
            margin-bottom: 48px;
        }

        .layout-section:last-child {
            margin-bottom: 0;
        }

        /* Responsive Containers */
        .container-fluid {
            width: 100%;
            padding-left: 16px;
            padding-right: 16px;
        }

        @media (min-width: 640px) {
            .container-fluid {
                padding-left: 24px;
                padding-right: 24px;
            }
        }

        @media (min-width: 1024px) {
            .container-fluid {
                padding-left: 32px;
                padding-right: 32px;
            }
        }

        /* Enhanced Shadows */
        .shadow-soft {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
        }

        .shadow-medium {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08), 0 8px 32px rgba(0, 0, 0, 0.06);
        }

        .shadow-strong {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 16px 64px rgba(0, 0, 0, 0.08);
        }

        /* Status indicators */
        .status-active { color: #059669; }
        .status-pending { color: #f59e0b; }
        .status-inactive { color: #dc2626; }
    </style>
</head>
<body style="background-color: var(--quasar-background);" class="text-gray-800">
    <div class="flex h-screen overflow-hidden" id="app-container" style="background: var(--quasar-background);">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 z-40 lg:hidden sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-80 shadow-2xl sidebar lg:static lg:inset-0 lg:z-auto lg:w-72 xl:w-80" id="sidebar">

            <!-- Quasar Improved Layout Logo -->
            <div class="flex items-center justify-center h-24 px-8 relative" style="background: linear-gradient(135deg, var(--quasar-primary), var(--quasar-primary-hover)); border-bottom: 3px solid var(--quasar-accent);">
                <div class="flex items-center">
                    <div class="h-14 w-14 rounded-xl flex items-center justify-center mr-5 shadow-xl" style="background-color: var(--quasar-surface); border: 2px solid var(--quasar-accent);">
                        <i class="fas fa-tools text-2xl" style="color: var(--quasar-primary);"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white"><?= $config->appShortName ?></h1>
                        <p class="text-sm text-blue-100 font-semibold">Control Center</p>
                    </div>
                </div>
                <!-- Enhanced decorative accent -->
                <div class="absolute bottom-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, var(--quasar-accent), var(--quasar-secondary), var(--quasar-info));"></div>
                <!-- Corner decorations -->
                <div class="absolute top-4 right-4 w-2 h-2 rounded-full" style="background: var(--quasar-accent); opacity: 0.7;"></div>
                <div class="absolute bottom-4 left-4 w-1 h-1 rounded-full" style="background: var(--quasar-secondary); opacity: 0.5;"></div>
            </div>

            <!-- Quasar Improved Layout Navigation -->
            <nav class="mt-8 px-4">
                <!-- Navigation Header -->
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider px-2" style="color: var(--quasar-text-secondary);">Main Menu</h3>
                    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent mt-2"></div>
                </div>

                <div class="space-y-2">
                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link group flex items-center px-4 py-4 font-medium rounded-xl transition-all duration-300 <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>" style="color: var(--quasar-text-primary);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 transition-all duration-300 group-hover:scale-110" style="background: rgba(25, 118, 210, 0.1);">
                            <i class="fas fa-tachometer-alt text-xl transition-all duration-300" style="color: var(--quasar-primary);"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-base">Dashboard</div>
                            <div class="text-sm font-medium opacity-70" style="color: var(--quasar-text-secondary);">Overview & Analytics</div>
                        </div>
                        <div class="w-2 h-2 rounded-full transition-all duration-300 opacity-0 group-hover:opacity-100" style="background: var(--quasar-primary);"></div>
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link group flex items-center px-4 py-4 font-medium rounded-xl transition-all duration-300 <?= strpos(uri_string(), 'jobs') !== false ? 'active' : '' ?>" style="color: var(--quasar-text-primary);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 transition-all duration-300 group-hover:scale-110" style="background: rgba(38, 166, 154, 0.1);">
                            <i class="fas fa-wrench text-xl transition-all duration-300" style="color: var(--quasar-secondary);"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-base">Jobs</div>
                            <div class="text-sm font-medium opacity-70" style="color: var(--quasar-text-secondary);">Repair Management</div>
                        </div>
                        <div class="w-2 h-2 rounded-full transition-all duration-300 opacity-0 group-hover:opacity-100" style="background: var(--quasar-secondary);"></div>
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link group flex items-center px-4 py-4 font-medium rounded-xl transition-all duration-300 <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>" style="color: var(--quasar-text-primary);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 transition-all duration-300 group-hover:scale-110" style="background: rgba(156, 39, 176, 0.1);">
                            <i class="fas fa-users text-xl transition-all duration-300" style="color: var(--quasar-accent);"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-base">Customers</div>
                            <div class="text-sm font-medium opacity-70" style="color: var(--quasar-text-secondary);">Client Database</div>
                        </div>
                        <div class="w-2 h-2 rounded-full transition-all duration-300 opacity-0 group-hover:opacity-100" style="background: var(--quasar-accent);"></div>
                    </a>
                </div>

                <!-- Secondary Navigation -->
                <div class="mt-8">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider px-2" style="color: var(--quasar-text-secondary);">Management</h3>
                        <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent mt-2"></div>
                    </div>

                    <div class="space-y-1">
                        <a href="<?= base_url('dashboard/inventory') ?>"
                           class="nav-link group flex items-center px-4 py-3 font-medium rounded-lg transition-all duration-300 <?= strpos(uri_string(), 'inventory') !== false ? 'active' : '' ?>" style="color: var(--quasar-text-primary);">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(255, 152, 0, 0.1);">
                                <i class="fas fa-boxes text-sm" style="color: var(--quasar-warning);"></i>
                            </div>
                            <span class="font-semibold">Inventory</span>
                        </a>

                        <a href="<?= base_url('dashboard/reports') ?>"
                           class="nav-link group flex items-center px-4 py-3 font-medium rounded-lg transition-all duration-300" style="color: var(--quasar-text-primary);">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(33, 150, 243, 0.1);">
                                <i class="fas fa-chart-bar text-sm" style="color: var(--quasar-info);"></i>
                            </div>
                            <span class="font-semibold">Reports</span>
                        </a>
                    </div>
                </div>
                    

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
            <!-- Quasar Improved Layout Header -->
            <header class="bg-white shadow-sm border-b flex-shrink-0 relative" style="border-color: var(--quasar-separator); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <!-- Header Background Gradient -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 opacity-30"></div>

                <div class="relative flex items-center justify-between px-6 py-5 lg:px-8">
                    <div class="flex items-center flex-1">
                        <button onclick="toggleSidebar()" id="mobile-menu-btn"
                                class="lg:hidden p-3 rounded-xl hover:bg-white hover:bg-opacity-50 focus:outline-none focus-ring transition-all shadow-sm"
                                style="color: var(--quasar-text-secondary); background: rgba(255, 255, 255, 0.8);">
                            <i class="fas fa-bars text-lg"></i>
                        </button>

                        <!-- Page Title Section -->
                        <div class="ml-4 lg:ml-0 flex-1">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <h1 class="text-3xl font-bold truncate" style="color: var(--quasar-text-primary);">
                                        <?= $title ?? 'Dashboard' ?>
                                    </h1>
                                    <?php if (isset($subtitle)): ?>
                                        <p class="text-sm font-medium mt-1" style="color: var(--quasar-text-secondary);"><?= $subtitle ?></p>
                                    <?php endif; ?>
                                    <div class="h-1 w-20 mt-2 rounded-full" style="background: linear-gradient(90deg, var(--quasar-primary), var(--quasar-accent));"></div>
                                </div>

                                <!-- Quick Stats or Info -->
                                <?php if (isset($headerStats) && !empty($headerStats)): ?>
                                    <div class="hidden md:flex items-center space-x-6 ml-8">
                                        <?php foreach ($headerStats as $stat): ?>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold" style="color: var(--quasar-primary);"><?= $stat['value'] ?></div>
                                                <div class="text-xs font-medium" style="color: var(--quasar-text-secondary);"><?= $stat['label'] ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <button class="p-3 rounded-lg hover:bg-gray-100 transition-all" style="color: var(--quasar-text-secondary);">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" style="background: linear-gradient(135deg, var(--quasar-danger), #d32f2f);">3</span>
                            </button>
                        </div>

                        <div class="relative">
                            <button onclick="toggleUserMenu()" id="user-menu-btn" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 focus-ring transition-all" style="color: var(--quasar-text-primary);">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white shadow-lg" style="background: linear-gradient(135deg, var(--quasar-primary), var(--quasar-primary-hover));">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <div class="text-sm font-semibold"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs capitalize font-medium" style="color: var(--quasar-text-secondary);"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform" id="user-menu-arrow"></i>
                            </button>

                            <!-- Quasar Minimalist Dropdown Menu -->
                            <div class="absolute right-0 mt-3 w-64 bg-white shadow-lg py-2 z-50 dropdown-menu" id="user-menu">
                                <div class="px-6 py-4" style="background: linear-gradient(135deg, var(--quasar-primary), var(--quasar-primary-hover)); border-bottom: 2px solid var(--quasar-accent);">
                                    <div class="font-bold text-white text-lg"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-sm text-blue-100"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs capitalize font-semibold mt-1 px-2 py-1 rounded" style="background: var(--quasar-accent); color: white; display: inline-block;"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-6 py-3 text-sm hover:bg-gray-50 transition-colors" style="color: var(--quasar-text-primary);">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(25, 118, 210, 0.1);">
                                        <i class="fas fa-user text-sm" style="color: var(--quasar-primary);"></i>
                                    </div>
                                    <span class="font-medium">Profile</span>
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-6 py-3 text-sm hover:bg-gray-50 transition-colors" style="color: var(--quasar-text-primary);">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(38, 166, 154, 0.1);">
                                        <i class="fas fa-cog text-sm" style="color: var(--quasar-secondary);"></i>
                                    </div>
                                    <span class="font-medium">Settings</span>
                                </a>
                                <div style="border-top: 1px solid var(--quasar-separator);" class="my-2"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-6 py-3 text-sm hover:bg-red-50 transition-colors" style="color: var(--quasar-danger);">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(244, 67, 54, 0.1);">
                                        <i class="fas fa-sign-out-alt text-sm" style="color: var(--quasar-danger);"></i>
                                    </div>
                                    <span class="font-medium">Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Quasar Improved Layout Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto" style="background: linear-gradient(135deg, var(--quasar-background) 0%, #f8f9fa 100%);">
                <!-- Content Container with Improved Layout -->
                <div class="min-h-full">
                    <!-- Page Header Section -->
                    <div class="bg-white shadow-sm border-b" style="border-color: var(--quasar-separator);">
                        <div class="max-w-7xl mx-auto px-6 py-6 lg:px-8">
                            <!-- Breadcrumb and Actions -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1 min-w-0">
                                    <nav class="flex mb-2" aria-label="Breadcrumb">
                                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                            <li class="inline-flex items-center">
                                                <a href="<?= base_url('dashboard') ?>" class="text-sm font-medium hover:text-blue-600 transition-colors" style="color: var(--quasar-text-secondary);">
                                                    <i class="fas fa-home mr-2"></i>Dashboard
                                                </a>
                                            </li>
                                            <?php if (isset($breadcrumb) && !empty($breadcrumb)): ?>
                                                <?php foreach ($breadcrumb as $item): ?>
                                                    <li>
                                                        <div class="flex items-center">
                                                            <i class="fas fa-chevron-right text-xs mx-2" style="color: var(--quasar-text-secondary);"></i>
                                                            <?php if (isset($item['url'])): ?>
                                                                <a href="<?= $item['url'] ?>" class="text-sm font-medium hover:text-blue-600 transition-colors" style="color: var(--quasar-text-secondary);"><?= $item['title'] ?></a>
                                                            <?php else: ?>
                                                                <span class="text-sm font-medium" style="color: var(--quasar-primary);"><?= $item['title'] ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="max-w-7xl mx-auto px-6 py-8 lg:px-8">
                        <!-- Flash Messages with Improved Styling -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="mb-8 px-6 py-5 rounded-xl shadow-lg border-l-4" role="alert" style="background: linear-gradient(135deg, #e8f5e8, #f1f8e9); border-color: var(--quasar-success); color: var(--quasar-success);">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-5 shadow-md" style="background: var(--quasar-success);">
                                        <i class="fas fa-check-circle text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-lg mb-1">Success!</h4>
                                        <p class="font-medium opacity-90"><?= session()->getFlashdata('success') ?></p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 p-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="mb-8 px-6 py-5 rounded-xl shadow-lg border-l-4" role="alert" style="background: linear-gradient(135deg, #fce8e6, #ffebee); border-color: var(--quasar-danger); color: var(--quasar-danger);">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-5 shadow-md" style="background: var(--quasar-danger);">
                                        <i class="fas fa-exclamation-circle text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-lg mb-1">Error!</h4>
                                        <p class="font-medium opacity-90"><?= session()->getFlashdata('error') ?></p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 p-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Page Content -->
                        <div class="space-y-8">
                            <?= $this->renderSection('content') ?>
                        </div>
                    </div>
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
