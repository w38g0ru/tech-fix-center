<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TFC Dashboard' ?> - Repair Shop CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Mobile optimizations */
        @media (max-width: 1023px) {
            body {
                -webkit-overflow-scrolling: touch;
            }

            /* Prevent zoom on input focus */
            input, select, textarea {
                font-size: 16px !important;
            }

            /* Improve touch targets */
            button, a {
                min-height: 44px;
                min-width: 44px;
            }

            /* Smooth transitions */
            .sidebar-transition {
                transition: transform 0.3s ease-in-out;
            }
        }

        /* Fix for Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }

        /* Ensure proper scrolling */
        .scroll-container {
            -webkit-overflow-scrolling: touch;
            overflow-y: auto;
        }

        /* Mobile-first responsive tables */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive table {
                min-width: 600px;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{
        sidebarOpen: false,
        userMenuOpen: false,
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            if (window.innerWidth < 1024) {
                document.body.style.overflow = this.sidebarOpen ? 'hidden' : '';
            }
        },
        toggleUserMenu() {
            this.userMenuOpen = !this.userMenuOpen;
        },
        closeSidebar() {
            this.sidebarOpen = false;
            document.body.style.overflow = '';
        }
    }"
    @close-sidebar.window="closeSidebar()"
    @open-sidebar.window="sidebarOpen = true"
    class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:z-auto sidebar-transition"
             x-cloak>
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-primary-600">
                <h1 class="text-xl font-bold text-white">TFC Dashboard</h1>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="<?= base_url('dashboard') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="<?= base_url('dashboard/jobs') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'jobs') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-wrench mr-3"></i>
                        Jobs
                    </a>
                    
                    <a href="<?= base_url('dashboard/users') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'users') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-users mr-3"></i>
                        Customers
                    </a>
                    

                    <a href="<?= base_url('dashboard/inventory') ?>" 
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'inventory') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-boxes mr-3"></i>
                        Inventory
                    </a>
                    
                    <a href="<?= base_url('dashboard/movements') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'movements') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-exchange-alt mr-3"></i>
                        Stock Movements
                    </a>

                    <a href="<?= base_url('dashboard/photos') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'photos') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-camera mr-3"></i>
                        Photoproof
                    </a>

                    <a href="<?= base_url('dashboard/referred') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'referred') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-shipping-fast mr-3"></i>
                        Dispatch
                    </a>

                    <?php helper('auth'); ?>
                    <?php if (canCreateTechnician()): ?>
                        <a href="<?= base_url('dashboard/technicians') ?>"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'technicians') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                            <i class="fas fa-user-cog mr-3"></i>
                            Technicians
                        </a>

                        <a href="<?= base_url('dashboard/user-management') ?>"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'user-management') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                            <i class="fas fa-users mr-3"></i>
                            User Management
                        </a>
                    <?php endif; ?>

                    <div class="border-t border-gray-200 my-4"></div>

                    <a href="<?= base_url('dashboard/user-guide') ?>"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'user-guide') !== false ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-600' : '' ?>">
                        <i class="fas fa-question-circle mr-3"></i>
                        User Guide
                    </a>


                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 flex-shrink-0">
                <div class="flex items-center justify-between px-4 py-4 lg:px-6">
                    <div class="flex items-center">
                        <button @click="toggleSidebar()"
                                class="text-gray-500 hover:text-gray-700 lg:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <h2 class="ml-2 text-lg font-semibold text-gray-800 lg:ml-0 lg:text-xl truncate">
                            <?= $title ?? 'Dashboard' ?>
                        </h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center text-gray-500 hover:text-gray-700">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <div class="relative">
                            <button @click="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2 rounded-md hover:bg-gray-100">
                                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="text-sm font-medium"><?= session()->get('full_name') ?? 'User' ?></span>
                                <i class="fas fa-chevron-down text-xs" :class="{ 'rotate-180': userMenuOpen }"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userMenuOpen"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 @click.away="userMenuOpen = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <div class="font-medium"><?= session()->get('full_name') ?? 'User' ?></div>
                                    <div class="text-xs text-gray-500"><?= session()->get('email') ?? '' ?></div>
                                    <div class="text-xs text-gray-500 capitalize"><?= session()->get('role') ?? '' ?></div>
                                </div>
                                <a href="<?= base_url('dashboard/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <a href="<?= base_url('dashboard/settings') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Settings
                                </a>
                                <div class="border-t"></div>
                                <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-4 py-6 lg:px-6 lg:py-8">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen"
         @click="closeSidebar()"
         @touchstart="closeSidebar()"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
    </div>

    <script>
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

        // Mobile navigation improvements
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent body scroll when sidebar is open on mobile
            const body = document.body;

            // Listen for sidebar state changes
            document.addEventListener('alpine:init', () => {
                Alpine.store('sidebar', {
                    open: false,
                    toggle() {
                        this.open = !this.open;
                        if (window.innerWidth < 1024) { // lg breakpoint
                            if (this.open) {
                                body.style.overflow = 'hidden';
                            } else {
                                body.style.overflow = '';
                            }
                        }
                    },
                    close() {
                        this.open = false;
                        body.style.overflow = '';
                    }
                });
            });

            // Close sidebar when clicking on navigation links on mobile
            const navLinks = document.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        // Trigger Alpine.js to close sidebar
                        const event = new CustomEvent('close-sidebar');
                        document.dispatchEvent(event);
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    body.style.overflow = '';
                }
            });

            // Improve touch handling for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            document.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - close sidebar
                        const event = new CustomEvent('close-sidebar');
                        document.dispatchEvent(event);
                    } else {
                        // Swipe right - open sidebar (only if near left edge)
                        if (touchStartX < 50 && window.innerWidth < 1024) {
                            const event = new CustomEvent('open-sidebar');
                            document.dispatchEvent(event);
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
