<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - <?= $config->appName ?? 'AdminLTE Dashboard' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a'
                        },
                        sidebar: {
                            light: '#ffffff',
                            dark: '#1f2937'
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Dark mode scrollbar */
        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: #374151;
        }
        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }
        
        /* Mobile sidebar overlay */
        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
        
        /* Navigation hover effects */
        .nav-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        .dark .nav-item:hover {
            background-color: rgba(59, 130, 246, 0.2);
        }
        
        /* Active navigation item */
        .nav-item.active {
            background-color: rgba(59, 130, 246, 0.15);
            border-right: 3px solid #3b82f6;
        }
        
        .dark .nav-item.active {
            background-color: rgba(59, 130, 246, 0.25);
        }
        
        /* Dropdown animations */
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        }
        
        /* Card hover effects */
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Button animations */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            transition: all 0.2s ease-in-out;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <!-- Main Container -->
    <div class="flex h-full">
        <!-- Sidebar -->
        <?= $this->include('partials/admin/sidebar') ?>
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navigation -->
            <?= $this->include('partials/admin/navbar') ?>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="p-6">
                    <!-- Breadcrumb -->
                    <?php if (isset($breadcrumb) && !empty($breadcrumb)): ?>
                        <?= $this->include('partials/admin/breadcrumb', ['breadcrumb' => $breadcrumb]) ?>
                    <?php endif; ?>
                    
                    <!-- Flash Messages -->
                    <?= $this->include('partials/admin/flash_messages') ?>
                    
                    <!-- Page Content -->
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden sidebar-overlay"></div>
    
    <!-- JavaScript -->
    <script>
        // Dashboard State Management
        const AdminDashboard = {
            sidebarOpen: false,
            darkMode: localStorage.getItem('darkMode') === 'true',
            
            // Initialize dashboard
            init() {
                this.initDarkMode();
                this.initSidebar();
                this.initDropdowns();
                this.initEventListeners();
            },
            
            // Dark mode functionality
            initDarkMode() {
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                    this.updateDarkModeToggle(true);
                }
            },
            
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('darkMode', this.darkMode);
                document.documentElement.classList.toggle('dark');
                this.updateDarkModeToggle(this.darkMode);
            },
            
            updateDarkModeToggle(isDark) {
                const toggle = document.getElementById('dark-mode-toggle');
                if (toggle) {
                    const icon = toggle.querySelector('i');
                    if (isDark) {
                        icon.className = 'fas fa-sun';
                    } else {
                        icon.className = 'fas fa-moon';
                    }
                }
            },
            
            // Sidebar functionality
            initSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                // Handle window resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.closeSidebar();
                    }
                });
            },
            
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                this.updateSidebarDisplay();
            },
            
            closeSidebar() {
                this.sidebarOpen = false;
                this.updateSidebarDisplay();
            },
            
            updateSidebarDisplay() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (this.sidebarOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            },
            
            // Dropdown functionality
            initDropdowns() {
                document.addEventListener('click', (e) => {
                    // Close all dropdowns when clicking outside
                    if (!e.target.closest('.dropdown')) {
                        this.closeAllDropdowns();
                    }
                });
            },
            
            toggleDropdown(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                const isOpen = !dropdown.classList.contains('hidden');
                
                // Close all dropdowns first
                this.closeAllDropdowns();
                
                // Toggle the clicked dropdown
                if (!isOpen) {
                    dropdown.classList.remove('hidden');
                    dropdown.classList.add('dropdown-enter');
                    setTimeout(() => {
                        dropdown.classList.add('dropdown-enter-active');
                    }, 10);
                }
            },
            
            closeAllDropdowns() {
                const dropdowns = document.querySelectorAll('[id$="-dropdown"]');
                dropdowns.forEach(dropdown => {
                    dropdown.classList.add('hidden');
                    dropdown.classList.remove('dropdown-enter', 'dropdown-enter-active');
                });
            },
            
            // Event listeners
            initEventListeners() {
                // Sidebar toggle
                document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
                    this.toggleSidebar();
                });
                
                // Sidebar overlay click
                document.getElementById('sidebar-overlay')?.addEventListener('click', () => {
                    this.closeSidebar();
                });
                
                // Dark mode toggle
                document.getElementById('dark-mode-toggle')?.addEventListener('click', () => {
                    this.toggleDarkMode();
                });
                
                // Escape key to close dropdowns and sidebar
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.closeAllDropdowns();
                        if (window.innerWidth < 1024) {
                            this.closeSidebar();
                        }
                    }
                });
            }
        };
        
        // Initialize dashboard when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            AdminDashboard.init();
        });
    </script>
    
    <!-- Additional Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
