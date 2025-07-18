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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-gentle': 'bounceGentle 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        bounceGentle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
        <div class="sidebar fixed top-0 left-0 -translate-x-full lg:translate-x-0 w-64 h-full bg-gradient-to-b from-gray-900 to-gray-800 shadow-2xl z-50 transition-transform duration-300 overflow-y-auto" id="sidebar">
            <!-- Logo -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 flex items-center border-b border-blue-500/20">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-white mr-3 shadow-lg">
                    <i class="fas fa-tools text-lg"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-lg font-bold tracking-wide"><?= $config->appShortName ?></h1>
                    <p class="text-xs text-blue-100 font-medium">Control Center</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="py-6 px-3">
                <!-- Main Menu -->
                <div class="mb-8">
                    <div class="px-3 pb-3 mb-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Main Menu</h3>
                    </div>

                    <a href="<?= base_url('dashboard') ?>"
                       class="nav-link group flex items-center px-3 py-3 mb-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25' : '' ?>">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?>">
                            <i class="fas fa-tachometer-alt text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-sm">Dashboard</div>
                            <div class="text-xs opacity-75 mt-0.5">Overview & Analytics</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/jobs') ?>"
                       class="nav-link group flex items-center px-3 py-3 mb-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 <?= strpos(uri_string(), 'jobs') !== false ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg shadow-green-500/25' : '' ?>">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 <?= strpos(uri_string(), 'jobs') !== false ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?>">
                            <i class="fas fa-wrench text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-sm">Jobs</div>
                            <div class="text-xs opacity-75 mt-0.5">Repair Management</div>
                        </div>
                    </a>

                    <a href="<?= base_url('dashboard/users') ?>"
                       class="nav-link group flex items-center px-3 py-3 mb-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 <?= strpos(uri_string(), 'users') !== false ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg shadow-purple-500/25' : '' ?>">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 <?= strpos(uri_string(), 'users') !== false ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' ?>">
                            <i class="fas fa-users text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-sm">Customers</div>
                            <div class="text-xs opacity-75 mt-0.5">Client Database</div>
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
        <div class="flex-1 lg:ml-64 min-h-screen w-full bg-gray-50">
            <!-- Header -->
            <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 px-4 lg:px-8 py-4 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center">
                    <button class="menu-btn lg:hidden p-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 group" id="menuBtn" onclick="toggleSidebar()">
                        <span class="menu-icon block w-5 h-0.5 bg-gray-600 mb-1 rounded-full transition-all duration-300 group-hover:bg-gray-800"></span>
                        <span class="menu-icon block w-5 h-0.5 bg-gray-600 mb-1 rounded-full transition-all duration-300 group-hover:bg-gray-800"></span>
                        <span class="menu-icon block w-5 h-0.5 bg-gray-600 rounded-full transition-all duration-300 group-hover:bg-gray-800"></span>
                    </button>
                    <div class="ml-3">
                        <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                            <?= isset($title) ? $title : 'Dashboard' ?>
                        </h2>
                        <p class="text-sm text-gray-500 mt-0.5">Welcome back to TeknoPhix</p>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    <button class="flex items-center px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-all duration-200 group border border-gray-200/50" onclick="toggleUserMenu()">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white text-sm mr-3 shadow-lg shadow-blue-500/25">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="hidden sm:block text-left mr-3">
                            <div class="text-sm font-semibold text-gray-900"><?= session('user_name') ?? 'User' ?></div>
                            <div class="text-xs text-gray-500">Administrator</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-colors duration-200"></i>
                    </button>

                    <div class="dropdown absolute top-full right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-200/50 min-w-56 opacity-0 invisible transform -translate-y-2 transition-all duration-200 z-50 overflow-hidden" id="userDropdown">
                        <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200/50">
                            <div class="font-semibold text-gray-900"><?= session('user_name') ?? 'User' ?></div>
                            <div class="text-sm text-gray-500">Administrator</div>
                        </div>
                        <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                            <i class="fas fa-user w-4 mr-3 text-blue-500"></i>Profile Settings
                        </a>
                        <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                            <i class="fas fa-cog w-4 mr-3 text-blue-500"></i>Preferences
                        </a>
                        <div class="border-t border-gray-200/50"></div>
                        <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                            <i class="fas fa-sign-out-alt w-4 mr-3"></i>Sign Out
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 lg:p-8 max-w-7xl mx-auto">
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
