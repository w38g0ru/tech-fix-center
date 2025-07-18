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
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Minimal custom styles - everything else uses Tailwind */
        .sidebar {
            transition: left 0.3s ease;
        }

        .sidebar.open {
            left: 0;
        }

        .menu-icon {
            transition: all 0.3s ease;
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

        .dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .overlay.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Overlay -->
        <div class="overlay fixed inset-0 bg-black bg-opacity-50 z-40 opacity-0 invisible transition-all duration-300 lg:hidden" id="overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="sidebar fixed top-0 left-0 -translate-x-full lg:translate-x-0 w-64 h-full bg-white shadow-lg z-50 transition-transform duration-300 overflow-y-auto" id="sidebar">
            <!-- Logo -->
            <div class="bg-blue-600 text-white p-5 flex items-center">
                <div class="w-9 h-9 bg-white rounded-md flex items-center justify-center text-blue-600 mr-3">
                    <i class="fas fa-tools text-sm"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-base font-semibold"><?= $config->appShortName ?></h1>
                    <p class="text-xs opacity-80">Control Center</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="py-5">
                <!-- Main Menu -->
                <div class="mb-8">
                    <div class="px-5 pb-2 mb-3">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</h3>
                    </div>

                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-l-4 hover:border-blue-600 transition-all duration-200 <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'bg-blue-600 text-white border-l-4 border-blue-700' : 'border-l-4 border-transparent' ?>">
                        <i class="fas fa-tachometer-alt w-5 mr-3 text-center text-sm"></i>
                        <div class="flex-1">
                            <div class="font-medium text-sm">Dashboard</div>
                            <div class="text-xs opacity-70 mt-0.5">Overview & Analytics</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-l-4 hover:border-blue-600 transition-all duration-200 <?= strpos(uri_string(), 'jobs') !== false ? 'bg-blue-600 text-white border-l-4 border-blue-700' : 'border-l-4 border-transparent' ?>">
                        <i class="fas fa-wrench w-5 mr-3 text-center text-sm"></i>
                        <div class="flex-1">
                            <div class="font-medium text-sm">Jobs</div>
                            <div class="text-xs opacity-70 mt-0.5">Repair Management</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-l-4 hover:border-blue-600 transition-all duration-200 <?= strpos(uri_string(), 'users') !== false ? 'bg-blue-600 text-white border-l-4 border-blue-700' : 'border-l-4 border-transparent' ?>">
                        <i class="fas fa-users w-5 mr-3 text-center text-sm"></i>
                        <div class="flex-1">
                            <div class="font-medium text-sm">Customers</div>
                            <div class="text-xs opacity-70 mt-0.5">Client Database</div>
                        </div>
                    </a>
                </div>

                <!-- Management -->
                <div class="mb-8">
                    <div class="px-5 pb-2 mb-3">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</h3>
                    </div>

                    <a href="<?= base_url('dashboard/inventory') ?>"
                       class="nav-link flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-l-4 hover:border-blue-600 transition-all duration-200 <?= strpos(uri_string(), 'inventory') !== false ? 'bg-blue-600 text-white border-l-4 border-blue-700' : 'border-l-4 border-transparent' ?>">
                        <i class="fas fa-boxes w-5 mr-3 text-center text-sm"></i>
                        <div class="flex-1">
                            <div class="font-medium text-sm">Inventory</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/reports') ?>"
                       class="nav-link flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-l-4 hover:border-blue-600 transition-all duration-200 <?= strpos(uri_string(), 'reports') !== false ? 'bg-blue-600 text-white border-l-4 border-blue-700' : 'border-l-4 border-transparent' ?>">
                        <i class="fas fa-chart-bar w-5 mr-3 text-center text-sm"></i>
                        <div class="flex-1">
                            <div class="font-medium text-sm">Reports</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/technicians') ?>"
                       class="nav-link flex items-center px-5 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-l-4 hover:border-blue-600 transition-all duration-200 <?= strpos(uri_string(), 'technicians') !== false ? 'bg-blue-600 text-white border-l-4 border-blue-700' : 'border-l-4 border-transparent' ?>">
                        <i class="fas fa-user-cog w-5 mr-3 text-center text-sm"></i>
                        <div class="flex-1">
                            <div class="font-medium text-sm">Technicians</div>
                        </div>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 min-h-screen w-full">
            <!-- Header -->
            <div class="bg-white shadow-sm px-4 lg:px-6 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <button class="menu-btn lg:hidden p-2 rounded-md hover:bg-gray-100 transition-colors duration-200" id="menuBtn" onclick="toggleSidebar()">
                        <span class="menu-icon block w-5 h-0.5 bg-gray-600 mb-1 rounded"></span>
                        <span class="menu-icon block w-5 h-0.5 bg-gray-600 mb-1 rounded"></span>
                        <span class="menu-icon block w-5 h-0.5 bg-gray-600 rounded"></span>
                    </button>
                    <h2 class="ml-3 text-lg font-semibold text-gray-900">
                        <?= isset($title) ? $title : 'Dashboard' ?>
                    </h2>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    <button class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" onclick="toggleUserMenu()">
                        <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs mr-2">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="hidden sm:block text-sm font-medium mr-1"><?= session('user_name') ?? 'User' ?></span>
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>

                    <div class="dropdown absolute top-full right-0 mt-1 bg-white rounded-lg shadow-lg min-w-48 opacity-0 invisible transform -translate-y-2 transition-all duration-200 z-50" id="userDropdown">
                        <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-user w-4 mr-3"></i>Profile
                        </a>
                        <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-cog w-4 mr-3"></i>Settings
                        </a>
                        <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-sign-out-alt w-4 mr-3"></i>Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 lg:p-6">
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

            sidebar.classList.toggle('translate-x-0');
            overlay.classList.toggle('show');
            menuBtn.classList.toggle('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');

            sidebar.classList.remove('translate-x-0');
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
            const userMenu = document.querySelector('.relative');
            const dropdown = document.getElementById('userDropdown');

            if (userMenu && !userMenu.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close sidebar on mobile when clicking nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    </script>
</body>
</html>

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
