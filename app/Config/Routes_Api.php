<?php

/**
 * API Routes Configuration
 * 
 * Clean, RESTful API routes for the Jobs management system
 * Follows REST conventions with proper HTTP methods
 */

// API v1 Routes Group
$routes->group('api/v1', ['namespace' => 'App\Controllers\Api'], function($routes) {
    
    // ========================================
    // JOBS API ROUTES
    // ========================================
    
    // RESTful resource routes for jobs
    $routes->resource('jobs', [
        'controller' => 'JobsController',
        'except' => ['new', 'edit'], // Exclude HTML form routes for API
        'filter' => 'auth' // Add authentication filter
    ]);
    
    // Additional job-specific routes
    $routes->group('jobs', function($routes) {
        
        // Job analytics and reporting
        $routes->get('attention', 'JobsController::attention', ['as' => 'api.jobs.attention']);
        $routes->get('metrics', 'JobsController::metrics', ['as' => 'api.jobs.metrics']);
        
        // Job actions
        $routes->post('(:num)/assign-technician', 'JobsController::assignTechnician/$1', ['as' => 'api.jobs.assign_technician']);
        $routes->post('(:num)/refer-service-center', 'JobsController::referToServiceCenter/$1', ['as' => 'api.jobs.refer_service_center']);
        
        // Job status updates
        $routes->patch('(:num)/status', 'JobsController::updateStatus/$1', ['as' => 'api.jobs.update_status']);
        
        // Job relationships
        $routes->get('(:num)/photos', 'JobsController::getPhotos/$1', ['as' => 'api.jobs.photos']);
        $routes->get('(:num)/inventory-movements', 'JobsController::getInventoryMovements/$1', ['as' => 'api.jobs.inventory_movements']);
        $routes->get('(:num)/parts-requests', 'JobsController::getPartsRequests/$1', ['as' => 'api.jobs.parts_requests']);
    });
    
    // ========================================
    // USERS API ROUTES
    // ========================================
    
    $routes->resource('users', [
        'controller' => 'UsersController',
        'except' => ['new', 'edit'],
        'filter' => 'auth'
    ]);
    
    $routes->group('users', function($routes) {
        $routes->get('(:num)/jobs', 'UsersController::getJobs/$1', ['as' => 'api.users.jobs']);
        $routes->get('(:num)/stats', 'UsersController::getStats/$1', ['as' => 'api.users.stats']);
        $routes->get('top-customers', 'UsersController::topCustomers', ['as' => 'api.users.top_customers']);
    });
    
    // ========================================
    // TECHNICIANS API ROUTES
    // ========================================
    
    $routes->resource('technicians', [
        'controller' => 'TechniciansController',
        'except' => ['new', 'edit'],
        'filter' => 'auth'
    ]);
    
    $routes->group('technicians', function($routes) {
        $routes->get('(:num)/jobs', 'TechniciansController::getJobs/$1', ['as' => 'api.technicians.jobs']);
        $routes->get('(:num)/workload', 'TechniciansController::getWorkload/$1', ['as' => 'api.technicians.workload']);
        $routes->get('(:num)/performance', 'TechniciansController::getPerformance/$1', ['as' => 'api.technicians.performance']);
        $routes->get('workload-summary', 'TechniciansController::workloadSummary', ['as' => 'api.technicians.workload_summary']);
    });
    
    // ========================================
    // SERVICE CENTERS API ROUTES
    // ========================================
    
    $routes->resource('service-centers', [
        'controller' => 'ServiceCentersController',
        'except' => ['new', 'edit'],
        'filter' => 'auth'
    ]);
    
    $routes->group('service-centers', function($routes) {
        $routes->get('(:num)/jobs', 'ServiceCentersController::getJobs/$1', ['as' => 'api.service_centers.jobs']);
        $routes->get('(:num)/referrals', 'ServiceCentersController::getReferrals/$1', ['as' => 'api.service_centers.referrals']);
        $routes->get('(:num)/stats', 'ServiceCentersController::getStats/$1', ['as' => 'api.service_centers.stats']);
        $routes->get('workload-summary', 'ServiceCentersController::workloadSummary', ['as' => 'api.service_centers.workload_summary']);
    });
    
    // ========================================
    // INVENTORY API ROUTES
    // ========================================
    
    $routes->resource('inventory', [
        'controller' => 'InventoryController',
        'except' => ['new', 'edit'],
        'filter' => 'auth'
    ]);
    
    $routes->group('inventory', function($routes) {
        $routes->get('(:num)/movements', 'InventoryController::getMovements/$1', ['as' => 'api.inventory.movements']);
        $routes->post('(:num)/move', 'InventoryController::moveStock/$1', ['as' => 'api.inventory.move']);
        $routes->get('low-stock', 'InventoryController::lowStock', ['as' => 'api.inventory.low_stock']);
        $routes->get('stats', 'InventoryController::stats', ['as' => 'api.inventory.stats']);
    });
    
    // ========================================
    // PARTS REQUESTS API ROUTES
    // ========================================
    
    $routes->resource('parts-requests', [
        'controller' => 'PartsRequestsController',
        'except' => ['new', 'edit'],
        'filter' => 'auth'
    ]);
    
    $routes->group('parts-requests', function($routes) {
        $routes->patch('(:num)/approve', 'PartsRequestsController::approve/$1', ['as' => 'api.parts_requests.approve']);
        $routes->patch('(:num)/reject', 'PartsRequestsController::reject/$1', ['as' => 'api.parts_requests.reject']);
        $routes->get('pending', 'PartsRequestsController::pending', ['as' => 'api.parts_requests.pending']);
        $routes->get('stats', 'PartsRequestsController::stats', ['as' => 'api.parts_requests.stats']);
    });
    
    // ========================================
    // PHOTOS API ROUTES
    // ========================================
    
    $routes->resource('photos', [
        'controller' => 'PhotosController',
        'except' => ['new', 'edit'],
        'filter' => 'auth'
    ]);
    
    $routes->group('photos', function($routes) {
        $routes->post('upload', 'PhotosController::upload', ['as' => 'api.photos.upload']);
        $routes->get('job/(:num)', 'PhotosController::getByJob/$1', ['as' => 'api.photos.by_job']);
        $routes->get('inventory/(:num)', 'PhotosController::getByInventory/$1', ['as' => 'api.photos.by_inventory']);
    });
    
    // ========================================
    // DASHBOARD & ANALYTICS API ROUTES
    // ========================================
    
    $routes->group('dashboard', function($routes) {
        $routes->get('stats', 'DashboardController::stats', ['as' => 'api.dashboard.stats']);
        $routes->get('recent-activities', 'DashboardController::recentActivities', ['as' => 'api.dashboard.recent_activities']);
        $routes->get('alerts', 'DashboardController::alerts', ['as' => 'api.dashboard.alerts']);
        $routes->get('performance', 'DashboardController::performance', ['as' => 'api.dashboard.performance']);
    });
    
    // ========================================
    // REPORTS API ROUTES
    // ========================================
    
    $routes->group('reports', function($routes) {
        $routes->get('jobs', 'ReportsController::jobs', ['as' => 'api.reports.jobs']);
        $routes->get('revenue', 'ReportsController::revenue', ['as' => 'api.reports.revenue']);
        $routes->get('technician-performance', 'ReportsController::technicianPerformance', ['as' => 'api.reports.technician_performance']);
        $routes->get('customer-analysis', 'ReportsController::customerAnalysis', ['as' => 'api.reports.customer_analysis']);
        $routes->get('inventory-usage', 'ReportsController::inventoryUsage', ['as' => 'api.reports.inventory_usage']);
    });
    
    // ========================================
    // SYSTEM API ROUTES
    // ========================================
    
    $routes->group('system', function($routes) {
        $routes->get('health', 'SystemController::health', ['as' => 'api.system.health']);
        $routes->get('version', 'SystemController::version', ['as' => 'api.system.version']);
        $routes->get('config', 'SystemController::config', ['as' => 'api.system.config']);
    });
});

// API Documentation route (outside versioning)
$routes->get('api/docs', 'App\Controllers\Api\DocsController::index', ['as' => 'api.docs']);

// API Status route
$routes->get('api/status', function() {
    return service('response')->setJSON([
        'status' => 'success',
        'message' => 'TeknoPhix API is running',
        'version' => '1.0.0',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}, ['as' => 'api.status']);
