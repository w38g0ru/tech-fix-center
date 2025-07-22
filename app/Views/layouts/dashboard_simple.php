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
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Ensure full viewport usage */
        .main-container {
            min-height: 100vh;
            width: 100vw;
        }

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

    <div class="flex min-h-screen main-container">
        <!-- Overlay -->
        <div class="overlay fixed inset-0 bg-black bg-opacity-50 z-40 opacity-0 invisible transition-all duration-300 lg:hidden" id="overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="sidebar fixed top-0 left-0 -translate-x-full lg:translate-x-0 w-60 h-full bg-gray-900 shadow-xl z-50 transition-transform duration-300 overflow-y-auto" id="sidebar">
            <!-- Logo -->
            <header class="flex items-center justify-between p-4 border-b border-gray-800 bg-gray-800 text-white">
                <h1 class="text-xl font-bold tracking-wide">
                    <?= htmlspecialchars($config->appShortName) ?>
                </h1>

                <!-- Mobile Close Button -->
                <button class="lg:hidden p-2 rounded-lg text-white hover:bg-white/10 transition-colors duration-200" onclick="closeSidebar()" id="sidebarCloseBtn">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </header>

            <!-- Navigation -->
            <nav class="py-6">
                <?php
                helper('menu');
                echo renderMenuItems('dark', true);
                ?>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 lg:ml-60 min-h-screen w-full bg-gray-50 overflow-x-hidden">
            <!-- Header -->
            <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 px-4 lg:px-8 py-4 sticky top-0 z-40">
                <div class="flex items-center justify-between">
                    <!-- Left Section: Menu + Title + Actions -->
                    <div class="flex items-center space-x-6">
                        <!-- Mobile Menu Button -->
                        <button class="menu-btn lg:hidden p-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 group" id="menuBtn" onclick="toggleSidebar()">
                            <span class="menu-icon block w-5 h-0.5 bg-gray-600 mb-1 rounded-full transition-all duration-300 group-hover:bg-gray-800"></span>
                            <span class="menu-icon block w-5 h-0.5 bg-gray-600 mb-1 rounded-full transition-all duration-300 group-hover:bg-gray-800"></span>
                            <span class="menu-icon block w-5 h-0.5 bg-gray-600 rounded-full transition-all duration-300 group-hover:bg-gray-800"></span>
                        </button>

                        <!-- Page Title -->
                        <div>
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
                        <div class="text-left mr-3">
                            <div class="text-sm font-semibold text-gray-900"><?= session('user_name') ?? 'User' ?></div>
                            <div class="text-xs text-gray-500">Administrator</div>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-colors duration-200"></i>
                    </button>

                    <div class="dropdown absolute top-full right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-200/50 min-w-64 opacity-0 invisible transform -translate-y-2 transition-all duration-200 z-50 overflow-hidden" id="userDropdown">
                        <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200/50">
                            <div class="font-semibold text-gray-900"><?= session('user_name') ?? 'User' ?></div>
                            <div class="text-sm text-gray-500 capitalize"><?= session('role') ?? 'User' ?></div>
                        </div>

                        <!-- User Section -->
                        <div class="py-2">
                            <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                <i class="fas fa-user w-4 mr-3 text-blue-500"></i>Profile
                            </a>
                            <?php if (in_array(session('role'), ['superadmin', 'admin'])): ?>
                            <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                                <i class="fas fa-cog w-4 mr-3 text-gray-500"></i>Settings
                            </a>
                            <?php endif; ?>
                        </div>

                        <!-- Support Section -->
                        <div class="border-t border-gray-100 py-2">
                            <a href="<?= base_url('dashboard/user-guide') ?>" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-all duration-200">
                                <i class="fas fa-question-circle w-4 mr-3 text-green-500"></i>User Guide
                            </a>
                            <a href="mailto:support@teknophix.com" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-all duration-200">
                                <i class="fas fa-life-ring w-4 mr-3 text-purple-500"></i>Support
                            </a>
                        </div>

                        <!-- Logout Section -->
                        <div class="border-t border-gray-100 py-2">
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
            </div>

            <!-- Content -->
            <div class="p-4 lg:p-8 w-full">
                <div class="max-w-7xl mx-auto w-full">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');

            // Toggle sidebar visibility using Tailwind classes
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }

            // Toggle overlay visibility
            if (overlay.classList.contains('opacity-0')) {
                overlay.classList.remove('opacity-0', 'invisible');
                overlay.classList.add('opacity-100', 'visible');
            } else {
                overlay.classList.remove('opacity-100', 'visible');
                overlay.classList.add('opacity-0', 'invisible');
            }

            menuBtn.classList.toggle('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');

            // Hide sidebar
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');

            // Hide overlay
            overlay.classList.remove('opacity-100', 'visible');
            overlay.classList.add('opacity-0', 'invisible');

            menuBtn.classList.remove('active');
        }

        // User menu toggle
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown.classList.contains('opacity-0')) {
                dropdown.classList.remove('opacity-0', 'invisible', '-translate-y-2');
                dropdown.classList.add('opacity-100', 'visible', 'translate-y-0');
            } else {
                dropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
                dropdown.classList.add('opacity-0', 'invisible', '-translate-y-2');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const userMenu = e.target.closest('.relative');
            const userDropdown = document.getElementById('userDropdown');
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.getElementById('menuBtn');
            const overlay = document.getElementById('overlay');

            // Close user dropdown if clicking outside
            if (!userMenu && userDropdown) {
                userDropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
                userDropdown.classList.add('opacity-0', 'invisible', '-translate-y-2');
            }

            // Close sidebar on mobile when clicking outside (but not on menu button or sidebar itself)
            if (window.innerWidth < 1024) {
                const clickedSidebar = e.target.closest('#sidebar');
                const clickedMenuBtn = e.target.closest('#menuBtn');
                const clickedOverlay = e.target.closest('#overlay');

                // If sidebar is open and click is outside sidebar and not on menu button
                if (sidebar && !sidebar.classList.contains('-translate-x-full') &&
                    !clickedSidebar && !clickedMenuBtn && !clickedOverlay) {
                    closeSidebar();
                }
            }
        });

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Close sidebar on mobile when clicking nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            // Ensure sidebar is hidden on mobile initially
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // Touch gesture support for mobile
        let touchStartX = 0;
        let touchStartY = 0;

        document.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        document.addEventListener('touchend', function(e) {
            if (window.innerWidth < 1024) {
                const touchEndX = e.changedTouches[0].clientX;
                const touchEndY = e.changedTouches[0].clientY;
                const deltaX = touchEndX - touchStartX;
                const deltaY = touchEndY - touchStartY;

                // Swipe right to open sidebar (from left edge)
                if (deltaX > 50 && Math.abs(deltaY) < 100 && touchStartX < 50) {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar && sidebar.classList.contains('-translate-x-full')) {
                        toggleSidebar();
                    }
                }

                // Swipe left to close sidebar
                if (deltaX < -50 && Math.abs(deltaY) < 100) {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                        closeSidebar();
                    }
                }
            }
        }, { passive: true });

        // Keyboard support
        document.addEventListener('keydown', function(e) {
            // Escape key to close sidebar on mobile
            if (e.key === 'Escape' && window.innerWidth < 1024) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            }
        });
    </script>
</body>
</html>