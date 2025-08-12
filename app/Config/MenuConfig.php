<?php

return [
    // Main Dashboard
    [
        'label' => 'Dashboard',
        'url' => 'dashboard',
        'roles' => ['admin', 'user', 'technician', 'superadmin'],
        'icon' => 'fas fa-home fa-lg mr-2'
    ],
    [
        'label' => 'Jobs',
        'url' => 'dashboard/jobs',
        'roles' => ['admin', 'user', 'technician'],
        'icon' => 'fas fa-wrench fa-lg mr-2'
    ],
    [
        'label' => 'Customers',
        'url' => 'dashboard/users',
        'roles' => ['admin', 'user', 'technician'],
        'icon' => 'fas fa-users fa-lg mr-2'
    ],

    // Management Section
    [
        'label' => 'Inventory',
        'url' => 'dashboard/inventory',
        'roles' => ['admin', 'user', 'technician'],
        'icon' => 'fas fa-boxes fa-lg mr-2'
    ],
    [
        'label' => 'Stock Management',
        'url' => 'dashboard/movements',
        'roles' => ['admin', 'technician'],
        'icon' => 'fas fa-warehouse fa-lg mr-2'
    ],
    [
        'label' => 'Reports',
        'url' => 'dashboard/reports',
        'roles' => ['admin'],
        'icon' => 'fas fa-chart-bar fa-lg mr-2'
    ],
    [
        'label' => 'Photoproof',
        'url' => 'dashboard/photos',
        'roles' => ['admin', 'user', 'technician'],
        'icon' => 'fas fa-camera fa-lg mr-2'
    ],
    [
        'label' => 'Dispatch',
        'url' => 'dashboard/referred',
        'roles' => ['admin', 'technician'],
        'icon' => 'fas fa-shipping-fast fa-lg mr-2'
    ],
    [
        'label' => 'Parts Requests',
        'url' => 'dashboard/parts-requests',
        'roles' => ['admin', 'user', 'technician'],
        'icon' => 'fas fa-tools fa-lg mr-2'
    ],

    // Activity Logs
    [
        'label' => 'Activity Logs',
        'url' => 'dashboard/activity-logs',
        'roles' => ['admin', 'technician', 'superadmin'],
        'icon' => 'fas fa-history fa-lg mr-2'
    ],

    // Administration Section
    [
        'label' => 'Service Centers',
        'url' => 'dashboard/service-centers',
        'roles' => ['admin', 'superadmin'],
        'icon' => 'fas fa-building fa-lg mr-2'
    ],
    [
        'label' => 'User Management',
        'url' => 'dashboard/user-management',
        'roles' => ['admin', 'superadmin'],
        'icon' => 'fas fa-users-cog fa-lg mr-2'
    ],
    [
        'label' => 'Bug Reports',
        'url' => 'dashboard/bug-reports',
        'roles' => ['admin', 'superadmin'],
        'icon' => 'fas fa-bug fa-lg mr-2'
    ]
];
