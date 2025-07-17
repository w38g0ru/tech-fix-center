<?php
// Get current user data (you would typically get this from session or database)
$currentUser = [
    'name' => session()->get('user_name') ?? 'John Doe',
    'email' => session()->get('user_email') ?? 'john@example.com',
    'avatar' => session()->get('user_avatar') ?? null,
    'role' => session()->get('user_role') ?? 'Administrator'
];

// Sample notifications (you would get these from database)
$notifications = [
    [
        'id' => 1,
        'type' => 'user',
        'icon' => 'fas fa-user-plus',
        'color' => 'text-green-500',
        'title' => 'New user registered',
        'message' => 'John Smith just signed up',
        'time' => '2 minutes ago',
        'read' => false
    ],
    [
        'id' => 2,
        'type' => 'order',
        'icon' => 'fas fa-shopping-cart',
        'color' => 'text-blue-500',
        'title' => 'New order received',
        'message' => 'Order #1234 has been placed',
        'time' => '5 minutes ago',
        'read' => false
    ],
    [
        'id' => 3,
        'type' => 'system',
        'icon' => 'fas fa-exclamation-triangle',
        'color' => 'text-yellow-500',
        'title' => 'System maintenance',
        'message' => 'Scheduled maintenance in 2 hours',
        'time' => '1 hour ago',
        'read' => true
    ]
];

$unreadCount = count(array_filter($notifications, fn($n) => !$n['read']));
?>

<!-- Top Navigation Bar -->
<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Side -->
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Button -->
            <button id="sidebar-toggle"
                    type="button"
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <!-- Page Title -->
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    <?= $title ?? 'Dashboard' ?>
                </h1>
                <?php if (isset($subtitle)): ?>
                    <p class="text-sm text-gray-500 dark:text-gray-400"><?= $subtitle ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- Search Bar -->
            <div class="hidden md:block relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       placeholder="Search..." 
                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
            </div>
            
            <!-- Dark Mode Toggle -->
            <button id="dark-mode-toggle" 
                    class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200"
                    title="Toggle dark mode">
                <i class="fas fa-moon text-lg"></i>
            </button>
            
            <!-- Notifications Dropdown -->
            <div class="relative dropdown">
                <button onclick="AdminDashboard.toggleDropdown('notifications-dropdown')" 
                        class="relative p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-bell text-lg"></i>
                    <?php if ($unreadCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">
                            <?= $unreadCount > 9 ? '9+' : $unreadCount ?>
                        </span>
                    <?php endif; ?>
                </button>
                
                <!-- Notifications Dropdown Menu -->
                <div id="notifications-dropdown" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 hidden">
                    <!-- Header -->
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            <span class="text-xs text-gray-500 dark:text-gray-400"><?= count($notifications) ?> total</span>
                        </div>
                    </div>
                    
                    <!-- Notifications List -->
                    <div class="max-h-64 overflow-y-auto scrollbar-thin">
                        <?php foreach ($notifications as $notification): ?>
                            <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 <?= !$notification['read'] ? 'bg-blue-50 dark:bg-blue-900/20' : '' ?>">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <i class="<?= $notification['icon'] ?> <?= $notification['color'] ?> text-sm"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            <?= $notification['title'] ?>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            <?= $notification['message'] ?>
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            <?= $notification['time'] ?>
                                        </p>
                                    </div>
                                    <?php if (!$notification['read']): ?>
                                        <div class="flex-shrink-0">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Footer -->
                    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="<?= base_url('admin/notifications') ?>" 
                           class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- User Profile Dropdown -->
            <div class="relative dropdown">
                <button onclick="AdminDashboard.toggleDropdown('user-dropdown')" 
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <!-- User Avatar -->
                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                        <?php if ($currentUser['avatar']): ?>
                            <img src="<?= $currentUser['avatar'] ?>" alt="<?= $currentUser['name'] ?>" class="w-8 h-8 rounded-full object-cover">
                        <?php else: ?>
                            <span class="text-white text-sm font-semibold">
                                <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- User Info (Hidden on mobile) -->
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= $currentUser['name'] ?></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?= $currentUser['role'] ?></p>
                    </div>
                    
                    <!-- Dropdown Arrow -->
                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>
                
                <!-- User Dropdown Menu -->
                <div id="user-dropdown" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 hidden">
                    <!-- User Info -->
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= $currentUser['name'] ?></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate"><?= $currentUser['email'] ?></p>
                    </div>
                    
                    <!-- Menu Items -->
                    <div class="py-2">
                        <a href="<?= base_url('admin/profile') ?>" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-user w-4 h-4 mr-3"></i>
                            Profile
                        </a>
                        <a href="<?= base_url('admin/settings') ?>" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-cog w-4 h-4 mr-3"></i>
                            Settings
                        </a>
                        <a href="<?= base_url('admin/help') ?>" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-question-circle w-4 h-4 mr-3"></i>
                            Help
                        </a>
                    </div>
                    
                    <!-- Logout -->
                    <div class="border-t border-gray-200 dark:border-gray-700 py-2">
                        <a href="<?= base_url('admin/logout') ?>" 
                           class="flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                            <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
