<?php

namespace App\Config;

class MenuConfig
{
    /**
     * Main navigation menu configuration
     *
     * Structure:
     * - section: Menu section name
     * - access_level: Required access level for the entire section
     * - items: Array of menu items
     *   - name: Display name
     *   - url: Route URL
     *   - icon: FontAwesome icon class
     *   - color: Icon color class
     *   - subtitle: Optional subtitle for main menu items
     *   - active_check: URI string to check for active state
     *   - access_level: Required access level for this menu item
     *
     * Access Levels:
     * - 'all': Available to all authenticated users
     * - 'user': Regular users and above
     * - 'technician': Technicians and above
     * - 'admin': Admin users only
     * - 'super_admin': Super admin only
     */
    public static function getMenuItems(): array
    {
        return [
            // Main Menu Section
            [
                'section' => 'Main Menu',
                'access_level' => 'all',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'url' => 'dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                        'color' => 'text-blue-600',
                        'subtitle' => 'Overview & Analytics',
                        'active_check' => ['dashboard', ''],
                        'gradient' => 'from-blue-500 to-blue-600',
                        'access_level' => 'all'
                    ],
                    [
                        'name' => 'Jobs',
                        'url' => 'dashboard/jobs',
                        'icon' => 'fas fa-wrench',
                        'color' => 'text-green-600',
                        'subtitle' => 'Repair Management',
                        'active_check' => ['jobs'],
                        'exclude_check' => ['parts-requests'],
                        'gradient' => 'from-green-500 to-green-600',
                        'access_level' => 'user'
                    ],
                    [
                        'name' => 'Customers',
                        'url' => 'dashboard/users',
                        'icon' => 'fas fa-users',
                        'color' => 'text-purple-600',
                        'subtitle' => 'Client Database',
                        'active_check' => ['users'],
                        'exclude_check' => ['user-management'],
                        'gradient' => 'from-purple-500 to-purple-600',
                        'access_level' => 'user'
                    ]
                ]
            ],

            // Management Section
            [
                'section' => 'Management',
                'access_level' => 'user',
                'items' => [
                    [
                        'name' => 'Inventory',
                        'url' => 'dashboard/inventory',
                        'icon' => 'fas fa-boxes',
                        'color' => 'text-orange-600',
                        'active_check' => ['inventory'],
                        'gradient' => 'from-orange-500 to-orange-600',
                        'access_level' => 'user'
                    ],
                    [
                        'name' => 'Stock Management',
                        'url' => 'dashboard/movements',
                        'icon' => 'fas fa-warehouse',
                        'color' => 'text-indigo-600',
                        'active_check' => ['movements'],
                        'gradient' => 'from-indigo-500 to-indigo-600',
                        'access_level' => 'technician'
                    ],
                    [
                        'name' => 'Reports',
                        'url' => 'dashboard/reports',
                        'icon' => 'fas fa-chart-bar',
                        'color' => 'text-blue-600',
                        'active_check' => ['reports'],
                        'gradient' => 'from-blue-500 to-blue-600',
                        'access_level' => 'technician'
                    ],
                    [
                        'name' => 'Photoproof',
                        'url' => 'dashboard/photos',
                        'icon' => 'fas fa-camera',
                        'color' => 'text-purple-600',
                        'active_check' => ['photos'],
                        'gradient' => 'from-purple-500 to-purple-600',
                        'access_level' => 'user'
                    ],
                    [
                        'name' => 'Dispatch',
                        'url' => 'dashboard/referred',
                        'icon' => 'fas fa-shipping-fast',
                        'color' => 'text-orange-600',
                        'active_check' => ['referred'],
                        'gradient' => 'from-orange-500 to-orange-600',
                        'access_level' => 'technician'
                    ],
                    [
                        'name' => 'Parts Requests',
                        'url' => 'dashboard/parts-requests',
                        'icon' => 'fas fa-tools',
                        'color' => 'text-red-600',
                        'active_check' => ['parts-requests'],
                        'gradient' => 'from-red-500 to-red-600',
                        'access_level' => 'user'
                    ]
                ]
            ],

            // Administration Section
            [
                'section' => 'Administration',
                'access_level' => 'admin',
                'items' => [
                    [
                        'name' => 'Service Centers',
                        'url' => 'dashboard/service-centers',
                        'icon' => 'fas fa-building',
                        'color' => 'text-blue-600',
                        'active_check' => ['service-centers'],
                        'gradient' => 'from-blue-500 to-blue-600',
                        'access_level' => 'admin'
                    ],
                    [
                        'name' => 'Technicians',
                        'url' => 'dashboard/technicians',
                        'icon' => 'fas fa-user-cog',
                        'color' => 'text-green-600',
                        'active_check' => ['technicians'],
                        'gradient' => 'from-green-500 to-green-600',
                        'access_level' => 'admin'
                    ],
                    [
                        'name' => 'User Management',
                        'url' => 'dashboard/user-management',
                        'icon' => 'fas fa-users-cog',
                        'color' => 'text-purple-600',
                        'active_check' => ['user-management'],
                        'gradient' => 'from-purple-500 to-purple-600',
                        'access_level' => 'admin'
                    ]
                ]
            ],

            // User Section
            [
                'section' => 'User',
                'access_level' => 'all',
                'items' => [
                    [
                        'name' => 'Profile',
                        'url' => 'dashboard/profile',
                        'icon' => 'fas fa-user',
                        'color' => 'text-blue-600',
                        'active_check' => ['profile'],
                        'gradient' => 'from-blue-500 to-blue-600',
                        'access_level' => 'all'
                    ],
                    [
                        'name' => 'Settings',
                        'url' => 'dashboard/settings',
                        'icon' => 'fas fa-cog',
                        'color' => 'text-gray-600',
                        'active_check' => ['settings'],
                        'gradient' => 'from-gray-500 to-gray-600',
                        'access_level' => 'admin'
                    ]
                ]
            ],

            // Support Section
            [
                'section' => 'Support',
                'access_level' => 'all',
                'items' => [
                    [
                        'name' => 'User Guide',
                        'url' => 'dashboard/user-guide',
                        'icon' => 'fas fa-question-circle',
                        'color' => 'text-green-600',
                        'active_check' => ['user-guide'],
                        'gradient' => 'from-green-500 to-green-600',
                        'access_level' => 'all'
                    ]
                ]
            ]
        ];
    }

    /**
     * Check if menu item is active based on current URI
     */
    public static function isActive(array $activeCheck, array $excludeCheck = []): bool
    {
        $currentUri = uri_string();
        
        // Check exclusions first
        if (!empty($excludeCheck)) {
            foreach ($excludeCheck as $exclude) {
                if (strpos($currentUri, $exclude) !== false) {
                    return false;
                }
            }
        }
        
        // Check active conditions
        foreach ($activeCheck as $check) {
            if ($check === '' && ($currentUri === 'dashboard' || $currentUri === '')) {
                return true;
            }
            if ($check !== '' && strpos($currentUri, $check) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user has required access level
     */
    public static function hasAccessLevel(string $requiredLevel): bool
    {
        if ($requiredLevel === 'all') {
            return true;
        }

        $userRole = session()->get('role');
        if (!$userRole) {
            return false;
        }

        // Define access level hierarchy
        $accessLevels = [
            'user' => 1,
            'technician' => 2,
            'admin' => 3,
            'super_admin' => 4
        ];

        $userLevel = $accessLevels[strtolower($userRole)] ?? 0;
        $requiredLevelValue = $accessLevels[$requiredLevel] ?? 999;

        return $userLevel >= $requiredLevelValue;
    }

    /**
     * Get user role from session
     */
    public static function getUserRole(): string
    {
        return session()->get('role') ?? 'guest';
    }

    /**
     * Check if user is admin or higher
     */
    public static function isAdmin(): bool
    {
        return self::hasAccessLevel('admin');
    }

    /**
     * Check if user is technician or higher
     */
    public static function isTechnician(): bool
    {
        return self::hasAccessLevel('technician');
    }
}
