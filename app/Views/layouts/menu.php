<?php
return [
    [
        'section' => 'Main Menu',
        'items' => [
            ['name' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'fas fa-tachometer-alt', 'access_level' => ['all']],
            ['name' => 'Jobs', 'url' => 'dashboard/jobs', 'icon' => 'fas fa-wrench', 'access_level' => ['admin', 'user']],
            ['name' => 'Customers', 'url' => 'dashboard/users', 'icon' => 'fas fa-users', 'access_level' => ['admin', 'user']],
        ],
    ],
    [
        'section' => 'Management',
        'items' => [
            ['name' => 'Inventory', 'url' => 'dashboard/inventory', 'icon' => 'fas fa-boxes', 'access_level' => ['user']],
            ['name' => 'Stock Management', 'url' => 'dashboard/movements', 'icon' => 'fas fa-warehouse', 'access_level' => ['admin']],
            ['name' => 'Reports', 'url' => 'dashboard/reports', 'icon' => 'fas fa-chart-bar', 'access_level' => ['admin', 'user']],
            ['name' => 'Photoproof', 'url' => 'dashboard/photos', 'icon' => 'fas fa-camera', 'access_level' => ['admin', 'technician']],
            ['name' => 'Dispatch', 'url' => 'dashboard/referred', 'icon' => 'fas fa-shipping-fast', 'access_level' => ['admin', 'user']],
            ['name' => 'Parts Requests', 'url' => 'dashboard/parts-requests', 'icon' => 'fas fa-tools', 'access_level' => ['technician']],
        ],
    ],
    [
        'section' => 'Administration',
        'items' => [
            ['name' => 'Service Centers', 'url' => 'dashboard/service-centers', 'icon' => 'fas fa-building', 'access_level' => ['admin']],
            ['name' => 'User Management', 'url' => 'dashboard/user-management', 'icon' => 'fas fa-users-cog', 'access_level' => ['admin']],
            ['name' => 'Bug Reports', 'url' => 'dashboard/bug-reports', 'icon' => 'fas fa-bug', 'access_level' => ['admin']],
        ],
    ],
];
