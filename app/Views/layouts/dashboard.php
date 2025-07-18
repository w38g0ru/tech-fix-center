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

        /* Simple Tailwind-based Sidebar */
        .sidebar {
            transition: all 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            width: 4rem; /* w-16 */
        }

        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .nav-subtitle,
        .sidebar.collapsed .nav-header,
        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
        }

        /* Simple hamburger animation */
        .hamburger-line {
            transition: all 0.3s ease;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Simple overlay - handled by Tailwind classes */

        /* Simple dropdown menu */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
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

        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .nav-link[title] {
            position: relative;
        }

        .sidebar.collapsed .nav-link[title]:hover::after {
            content: attr(title);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: var(--quasar-dark);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            z-index: 1000;
            opacity: 1;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: tooltipFadeIn 0.2s ease-out;
        }

        .sidebar.collapsed .nav-link[title]:hover::before {
            content: '';
            position: absolute;
            left: calc(100% + 6px);
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: var(--quasar-dark);
            z-index: 1000;
            opacity: 1;
            animation: tooltipFadeIn 0.2s ease-out;
        }

        /* Tooltip animation */
        @keyframes tooltipFadeIn {
            from {
                opacity: 0;
                transform: translateY(-50%) translateX(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(-50%) translateX(0);
            }
        }

        /* Hide tooltips when not collapsed */
        .sidebar:not(.collapsed) .nav-link[title]:hover::after,
        .sidebar:not(.collapsed) .nav-link[title]:hover::before {
            display: none;
        }

        /* Status indicators */
        .status-active { color: #059669; }
        .status-pending { color: #f59e0b; }
        .status-inactive { color: #dc2626; }

        /* Smooth transitions for layout changes */
        .main-content {
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Improve sidebar scrolling */
        .sidebar {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Improve focus states for accessibility */
        .nav-link:focus {
            outline: 2px solid var(--quasar-primary);
            outline-offset: 2px;
        }

        /* Loading state for navigation */
        .nav-link.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .nav-link.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 1rem;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body style="background-color: var(--quasar-background);" class="text-gray-800">
    <div class="flex h-screen overflow-hidden" id="app-container" style="background: var(--quasar-background);">
        <!-- Mobile Overlay -->
        <div class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:z-auto lg:w-60 sidebar" id="sidebar">

            <!-- Logo Section -->
            <div class="flex items-center h-12 px-4 border-b border-gray-200">
                <div class="flex items-center">
                    <h1 class="text-lg font-semibold text-gray-900"><?= $config->appShortName ?></h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-6 overflow-y-auto">
                <?php
                helper('menu');
                echo renderMenuItems('light', true);
                ?>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden main-content lg:ml-60" style="transition: margin-left 0.28s cubic-bezier(0.4, 0, 0.2, 1);">
            <!-- Quasar Improved Layout Header -->
            <header class="bg-white shadow-sm border-b flex-shrink-0 relative" style="border-color: var(--quasar-separator); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <!-- Header Background Gradient -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 opacity-30"></div>

                <div class="relative flex items-center justify-between px-6 py-5 lg:px-8">
                    <div class="flex items-center flex-1">
                        <!-- Hamburger Menu Button -->
                        <button onclick="toggleSidebarCollapse()" id="sidebar-toggle-btn"
                                class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 hamburger">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path class="hamburger-line" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Desktop Collapse Button -->
                        <button onclick="toggleSidebarCollapse()" id="desktop-toggle-btn"
                                class="hidden lg:block p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8M4 18h16"></path>
                            </svg>
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
        // Dashboard State Management with Collapsible Navigation
        const DashboardState = {
            sidebarOpen: false,
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            userMenuOpen: false
        };

        // Initialize sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');

            if (DashboardState.sidebarCollapsed && window.innerWidth >= 1024) {
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('lg:w-60');
                sidebar.classList.add('w-16');
            }
        });

        // Toggle sidebar collapse/expand (main function)
        function toggleSidebarCollapse() {
            const sidebar = document.getElementById('sidebar');

            if (window.innerWidth < 1024) {
                // Mobile behavior - toggle sidebar visibility
                toggleSidebar();
                return;
            }

            // Desktop behavior - toggle collapse state
            DashboardState.sidebarCollapsed = !DashboardState.sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', DashboardState.sidebarCollapsed);

            if (DashboardState.sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('lg:w-60');
                sidebar.classList.add('w-16');
            } else {
                sidebar.classList.remove('collapsed', 'w-16');
                sidebar.classList.add('lg:w-60');
            }
        }

        // Mobile sidebar toggle
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
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
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

            // Handle window resize with collapsible support
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const hamburger = document.getElementById('sidebar-toggle-btn');

                if (window.innerWidth >= 1024) {
                    // Desktop mode
                    document.body.style.overflow = '';
                    closeSidebar(); // Close mobile sidebar if open

                    // Restore collapsed state if it was set
                    if (DashboardState.sidebarCollapsed) {
                        sidebar.classList.add('collapsed');
                        hamburger.classList.add('active');
                    } else {
                        sidebar.classList.remove('collapsed');
                        hamburger.classList.remove('active');
                    }
                } else {
                    // Mobile mode - remove collapsed state
                    sidebar.classList.remove('collapsed');
                    if (!DashboardState.sidebarOpen) {
                        hamburger.classList.remove('active');
                    }
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

                // Ctrl/Cmd + B for sidebar collapse toggle (desktop)
                if ((e.ctrlKey || e.metaKey) && e.key === 'b' && window.innerWidth >= 1024) {
                    e.preventDefault();
                    toggleSidebarCollapse();
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

        // Navigation loading state
        function setNavLinkLoading(link, loading = true) {
            if (loading) {
                link.classList.add('loading');
            } else {
                link.classList.remove('loading');
            }
        }

        // Add loading states to navigation links
        function initNavigationLoading() {
            document.querySelectorAll('.nav-link[href]').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't add loading state for same page links
                    if (this.href === window.location.href) {
                        return;
                    }

                    setNavLinkLoading(this, true);

                    // Remove loading state after a timeout (fallback)
                    setTimeout(() => {
                        setNavLinkLoading(this, false);
                    }, 5000);
                });
            });
        }

        // Initialize navigation loading on page load
        document.addEventListener('DOMContentLoaded', function() {
            initNavigationLoading();
        });

        // Make functions globally available
        window.toggleSidebar = toggleSidebar;
        window.toggleSidebarCollapse = toggleSidebarCollapse;
        window.closeSidebar = closeSidebar;
        window.toggleUserMenu = toggleUserMenu;
        window.closeUserMenu = closeUserMenu;
        window.showNotification = showNotification;
        window.setNavLinkLoading = setNavLinkLoading;
    </script>
</body>
</html>
