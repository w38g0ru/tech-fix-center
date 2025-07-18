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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        /* Layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: -260px;
            height: 100vh;
            transition: left 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.open {
            left: 0;
        }

        /* Desktop sidebar */
        @media (min-width: 768px) {
            .sidebar {
                position: static;
                left: 0;
            }
        }

        /* Logo */
        .logo {
            padding: 20px;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            margin-right: 12px;
        }

        .logo-text h1 {
            font-size: 16px;
            font-weight: 600;
        }

        .logo-text p {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Navigation */
        .nav {
            padding: 20px 0;
        }

        .nav-section {
            margin-bottom: 30px;
        }

        .nav-header {
            padding: 0 20px 8px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
            letter-spacing: 0.5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: #f8f9fa;
            color: #2563eb;
            border-left-color: #2563eb;
        }

        .nav-link.active {
            background: #2563eb;
            color: white;
            border-left-color: #1d4ed8;
        }

        .nav-link i {
            width: 18px;
            margin-right: 12px;
            text-align: center;
            font-size: 14px;
        }

        .nav-text {
            flex: 1;
        }

        .nav-title {
            font-weight: 500;
            font-size: 14px;
        }

        .nav-subtitle {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 1px;
        }

        .nav-link.active .nav-subtitle {
            opacity: 0.8;
        }

        /* Main content */
        .main {
            flex: 1;
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 768px) {
            .main {
                margin-left: 260px;
            }
        }

        /* Header */
        .header {
            background: white;
            padding: 16px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-btn {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.2s ease;
        }

        .menu-btn:hover {
            background: #f1f5f9;
        }

        .menu-icon {
            display: block;
            width: 18px;
            height: 2px;
            background: #555;
            margin: 3px 0;
            transition: all 0.3s ease;
            border-radius: 1px;
        }

        .menu-btn.active .menu-icon:nth-child(1) {
            transform: rotate(45deg) translate(4px, 4px);
        }

        .menu-btn.active .menu-icon:nth-child(2) {
            opacity: 0;
        }

        .menu-btn.active .menu-icon:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* User menu */
        .user-menu {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .user-btn:hover {
            background: #f1f5f9;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            background: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            margin-right: 8px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
            margin-right: 4px;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
            z-index: 1000;
            margin-top: 4px;
        }

        .dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 10px 16px;
            color: #555;
            text-decoration: none;
            transition: background 0.2s ease;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
        }

        .dropdown-item i {
            width: 16px;
            margin-right: 8px;
            font-size: 12px;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Content */
        .content {
            padding: 20px;
        }

        /* Hide menu button on desktop */
        @media (min-width: 768px) {
            .menu-btn {
                display: none;
            }
        }

        /* Mobile adjustments */
        @media (max-width: 767px) {
            .header {
                padding: 12px 16px;
            }

            .content {
                padding: 16px;
            }

            .user-name {
                display: none;
            }
        }

        /* Common UI Components */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-success {
            background: #059669;
            color: white;
        }

        .btn-success:hover {
            background: #047857;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn i {
            margin-right: 6px;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        /* Forms */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table th {
            background: #f9fafb;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .table tr:hover {
            background: #f9fafb;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            font-size: 20px;
        }

        .stat-content h3 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .stat-content p {
            font-size: 14px;
            color: #6b7280;
        }

        /* Responsive grid */
        .grid {
            display: grid;
            gap: 20px;
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Overlay -->
        <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="logo-text">
                    <h1><?= $config->appShortName ?></h1>
                    <p>Control Center</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="nav">
                <!-- Main Menu -->
                <div class="nav-section">
                    <div class="nav-header">Main Menu</div>
                    
                    <a href="<?= base_url('dashboard') ?>" 
                       class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <div class="nav-text">
                            <div class="nav-title">Dashboard</div>
                            <div class="nav-subtitle">Overview & Analytics</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>" 
                       class="nav-link <?= strpos(uri_string(), 'jobs') !== false ? 'active' : '' ?>">
                        <i class="fas fa-wrench"></i>
                        <div class="nav-text">
                            <div class="nav-title">Jobs</div>
                            <div class="nav-subtitle">Repair Management</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>" 
                       class="nav-link <?= strpos(uri_string(), 'users') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users"></i>
                        <div class="nav-text">
                            <div class="nav-title">Customers</div>
                            <div class="nav-subtitle">Client Database</div>
                        </div>
                    </a>
                </div>

                <!-- Management -->
                <div class="nav-section">
                    <div class="nav-header">Management</div>

                    <a href="<?= base_url('dashboard/inventory') ?>"
                       class="nav-link <?= strpos(uri_string(), 'inventory') !== false ? 'active' : '' ?>">
                        <i class="fas fa-boxes"></i>
                        <div class="nav-text">
                            <div class="nav-title">Inventory</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/reports') ?>"
                       class="nav-link <?= strpos(uri_string(), 'reports') !== false ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar"></i>
                        <div class="nav-text">
                            <div class="nav-title">Reports</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/movements') ?>"
                       class="nav-link <?= strpos(uri_string(), 'movements') !== false ? 'active' : '' ?>">
                        <i class="fas fa-exchange-alt"></i>
                        <div class="nav-text">
                            <div class="nav-title">Stock Movements</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/photos') ?>"
                       class="nav-link <?= strpos(uri_string(), 'photos') !== false ? 'active' : '' ?>">
                        <i class="fas fa-camera"></i>
                        <div class="nav-text">
                            <div class="nav-title">Photoproof</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/referred') ?>"
                       class="nav-link <?= strpos(uri_string(), 'referred') !== false ? 'active' : '' ?>">
                        <i class="fas fa-shipping-fast"></i>
                        <div class="nav-text">
                            <div class="nav-title">Dispatch</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/parts-requests') ?>"
                       class="nav-link <?= strpos(uri_string(), 'parts-requests') !== false ? 'active' : '' ?>">
                        <i class="fas fa-tools"></i>
                        <div class="nav-text">
                            <div class="nav-title">Parts Requests</div>
                        </div>
                    </a>
                </div>

                <!-- Admin -->
                <?php helper('auth'); ?>
                <?php if (canCreateTechnician()): ?>
                <div class="nav-section">
                    <div class="nav-header">Administration</div>

                    <a href="<?= base_url('dashboard/service-centers') ?>"
                       class="nav-link <?= strpos(uri_string(), 'service-centers') !== false ? 'active' : '' ?>">
                        <i class="fas fa-building"></i>
                        <div class="nav-text">
                            <div class="nav-title">Service Centers</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/technicians') ?>"
                       class="nav-link <?= strpos(uri_string(), 'technicians') !== false ? 'active' : '' ?>">
                        <i class="fas fa-user-cog"></i>
                        <div class="nav-text">
                            <div class="nav-title">Technicians</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/user-management') ?>"
                       class="nav-link <?= strpos(uri_string(), 'user-management') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users-cog"></i>
                        <div class="nav-text">
                            <div class="nav-title">User Management</div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Support -->
                <div class="nav-section">
                    <div class="nav-header">Support</div>

                    <a href="<?= base_url('dashboard/user-guide') ?>"
                       class="nav-link <?= strpos(uri_string(), 'user-guide') !== false ? 'active' : '' ?>">
                        <i class="fas fa-question-circle"></i>
                        <div class="nav-text">
                            <div class="nav-title">User Guide</div>
                        </div>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main">
            <!-- Header -->
            <div class="header">
                <div style="display: flex; align-items: center;">
                    <button class="menu-btn" id="menuBtn" onclick="toggleSidebar()">
                        <span class="menu-icon"></span>
                        <span class="menu-icon"></span>
                        <span class="menu-icon"></span>
                    </button>
                    <h2 style="margin-left: 12px; font-size: 18px; font-weight: 600; color: #333;">
                        <?= isset($title) ? $title : 'Dashboard' ?>
                    </h2>
                </div>

                <!-- User Menu -->
                <div class="user-menu">
                    <button class="user-btn" onclick="toggleUserMenu()">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="user-name"><?= session('user_name') ?? 'User' ?></span>
                        <i class="fas fa-chevron-down" style="font-size: 10px; color: #666;"></i>
                    </button>

                    <div class="dropdown" id="userDropdown">
                        <a href="<?= base_url('dashboard/profile') ?>" class="dropdown-item">
                            <i class="fas fa-user"></i>Profile
                        </a>
                        <a href="<?= base_url('dashboard/settings') ?>" class="dropdown-item">
                            <i class="fas fa-cog"></i>Settings
                        </a>
                        <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
            menuBtn.classList.toggle('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');

            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            menuBtn.classList.remove('active');
        }

        // User menu toggle
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');

            if (!userMenu.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close sidebar on mobile when clicking nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });
    </script>
</body>
</html>
