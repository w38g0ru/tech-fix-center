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
                    colors: {
                        'brand-fuchsia': '#D946EF',
                    }
                }
            }
        }
    </script>
    <style>
        /* Minimalist Button System */
        .btn {
            @apply inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2;
        }

        .btn-primary {
            @apply bg-fuchsia-600 text-white hover:bg-fuchsia-700 focus:ring-fuchsia-500;
        }

        .btn-secondary {
            @apply bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500;
        }

        .btn-outline {
            @apply border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-gray-500;
        }

        .btn-danger {
            @apply bg-red-600 text-white hover:bg-red-700 focus:ring-red-500;
        }

        .btn-success {
            @apply bg-green-600 text-white hover:bg-green-700 focus:ring-green-500;
        }

        .btn-sm {
            @apply px-3 py-1.5 text-xs;
        }

        .btn-lg {
            @apply px-6 py-3 text-base;
        }

        .btn-icon {
            @apply p-2;
        }

        .btn-full {
            @apply w-full justify-center;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


</head>
<body class="bg-gray-50 font-sans">

    <div class="flex min-h-screen main-container">
        <!-- Overlay -->
        <div class="overlay fixed inset-0 bg-black bg-opacity-50 z-40 opacity-0 invisible transition-all duration-300 lg:hidden" id="overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <div class="fixed top-0 left-0 -translate-x-full lg:translate-x-0 w-64 h-full bg-white border-r border-gray-200 shadow-sm z-50 transition-transform duration-300 overflow-y-auto" id="sidebar">
            <!-- Logo -->
            <header class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">T</span>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        <?= htmlspecialchars($config->appShortName) ?>
                    </h1>
                </div>

                <!-- Mobile Close Button -->
                <button class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-200" onclick="closeSidebar()" id="sidebarCloseBtn">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </header>

            <!-- Navigation -->
            <nav class="p-4">
                <?php
                helper('menu');
                echo renderMenuItems('light', true);
                ?>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 min-h-screen w-full bg-gray-50">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
                <div class="px-6 py-4 flex items-center justify-between">
                    <!-- Left Section: Menu + Title -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile Menu Button -->
                        <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" id="menuBtn" onclick="toggleSidebar()">
                            <div class="space-y-1">
                                <span class="block w-5 h-0.5 bg-gray-600"></span>
                                <span class="block w-5 h-0.5 bg-gray-600"></span>
                                <span class="block w-5 h-0.5 bg-gray-600"></span>
                            </div>
                        </button>

                        <!-- Page Title -->
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">T</span>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">
                                    <?= isset($title) ? $title : 'Dashboard' ?>
                                </h2>
                                <p class="text-sm text-gray-600">infoTech Suppliers & Traders</p>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 border border-gray-200" onclick="toggleUserMenu()">
                            <div class="w-8 h-8 bg-fuchsia-600 rounded-lg flex items-center justify-center text-white text-sm mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="text-left mr-3 hidden sm:block">
                                <div class="text-sm font-medium text-gray-900"><?= session('user_name') ?? 'User' ?></div>
                                <div class="text-xs text-gray-500">Administrator</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-colors duration-200"></i>
                        </button>

                        <div class="absolute top-full right-0 mt-2 bg-white rounded-lg shadow-lg border border-gray-200 min-w-56 opacity-0 invisible transform -translate-y-2 transition-all duration-200 z-50 overflow-hidden" id="userDropdown">
                            <div class="p-4 border-b border-gray-200">
                                <div class="font-medium text-gray-900"><?= session('user_name') ?? 'User' ?></div>
                                <div class="text-sm text-gray-500 capitalize"><?= session('role') ?? 'User' ?></div>
                            </div>

                            <!-- User Section -->
                            <div class="py-1">
                                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-user w-4 mr-3 text-gray-500"></i>Profile
                                </a>
                                <?php if (in_array(session('role'), ['superadmin', 'admin'])): ?>
                                <a href="<?= base_url('dashboard/settings') ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-cog w-4 mr-3 text-gray-500"></i>Settings
                                </a>
                                <?php endif; ?>
                            </div>

                            <!-- Support Section -->
                            <div class="border-t border-gray-200 py-1">
                                <a href="<?= base_url('dashboard/user-guide') ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-question-circle w-4 mr-3 text-gray-500"></i>User Guide
                                </a>
                                <a href="mailto:support@teknophix.com" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-life-ring w-4 mr-3 text-gray-500"></i>Support
                                </a>
                            </div>

                            <!-- Logout Section -->
                            <div class="border-t border-gray-200 py-1">
                                <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt w-4 mr-3"></i>Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
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

    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>