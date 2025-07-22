<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function() {
    helper('auth');
    if (isLoggedIn()) {
        return redirect()->to(base_url('dashboard'));
    } else {
        return redirect()->to(base_url('auth/login'));
    }
});

// Authentication Routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/processLogin', 'Auth::processLogin');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/processForgotPassword', 'Auth::processForgotPassword');

// Google OAuth Routes
$routes->get('auth/google', 'Auth::googleLogin');
$routes->get('auth/google/callback', 'Auth::callback');

// Public photo serving route (no authentication required)
$routes->get('photos/serve/(:any)', 'Photos::serve/$1');

// Dashboard Routes (Protected by Auth in Controllers)
$routes->group('dashboard', function($routes) {
    $routes->get('/', 'Dashboard::index');

    // Users/Customers Routes
    $routes->get('users', 'Dashboard::users');
    $routes->get('users/create', 'Dashboard::createUser');
    $routes->post('users/store', 'Dashboard::storeUser');
    $routes->get('users/edit/(:num)', 'Dashboard::editUser/$1');
    $routes->post('users/update/(:num)', 'Dashboard::updateUser/$1');
    $routes->get('users/delete/(:num)', 'Dashboard::deleteUser/$1');



    // Jobs Routes
    $routes->get('jobs', 'Jobs::index');
    $routes->get('jobs/create', 'Jobs::create');
    $routes->post('jobs/store', 'Jobs::store');
    $routes->get('jobs/view/(:num)', 'Jobs::view/$1');
    $routes->get('jobs/edit/(:num)', 'Jobs::edit/$1');
    $routes->post('jobs/update/(:num)', 'Jobs::update/$1');
    $routes->get('jobs/delete/(:num)', 'Jobs::delete/$1');
    $routes->post('jobs/updateStatus/(:num)', 'Jobs::updateStatus/$1');

    // Inventory Routes
    $routes->get('inventory', 'Inventory::index');
    $routes->get('inventory/create', 'Inventory::create');
    $routes->post('inventory/store', 'Inventory::store');
    $routes->get('inventory/edit/(:num)', 'Inventory::edit/$1');
    $routes->post('inventory/update/(:num)', 'Inventory::update/$1');
    $routes->get('inventory/delete/(:num)', 'Inventory::delete/$1');
    $routes->get('inventory/view/(:num)', 'Inventory::view/$1');
    $routes->get('inventory/bulk-import', 'Inventory::bulkImport');
    $routes->post('inventory/process-bulk-import', 'Inventory::processBulkImport');
    $routes->get('inventory/export', 'Inventory::exportInventory');
    $routes->get('inventory/downloadTemplate', 'Inventory::downloadTemplate');

    // Reports Routes
    $routes->get('reports', 'Reports::index');
    $routes->get('reports/export', 'Reports::export');

    // Parts Requests Routes
    $routes->get('parts-requests', 'PartsRequests::index');
    $routes->get('parts-requests/create', 'PartsRequests::create');
    $routes->post('parts-requests/store', 'PartsRequests::store');
    $routes->get('parts-requests/view/(:num)', 'PartsRequests::view/$1');
    $routes->get('parts-requests/edit/(:num)', 'PartsRequests::edit/$1');
    $routes->post('parts-requests/update/(:num)', 'PartsRequests::update/$1');
    $routes->post('parts-requests/approve/(:num)', 'PartsRequests::approve/$1');
    $routes->post('parts-requests/reject/(:num)', 'PartsRequests::reject/$1');
    $routes->post('parts-requests/update-status/(:num)', 'PartsRequests::updateStatus/$1');

    // Inventory Movements Routes
    $routes->get('movements', 'Movements::index');
    $routes->get('movements/create', 'Movements::create');
    $routes->post('movements/store', 'Movements::store');
    $routes->get('movements/item/(:num)', 'Movements::byItem/$1');
    $routes->get('movements/job/(:num)', 'Movements::byJob/$1');

    // Photos Routes
    $routes->get('photos', 'Photos::index');
    $routes->get('photos/upload', 'Photos::upload');
    $routes->post('photos/store', 'Photos::store');
    $routes->get('photos/view/(:num)', 'Photos::view/$1');
    $routes->get('photos/serve/(:any)', 'Photos::serve/$1');
    $routes->get('photos/delete/(:num)', 'Photos::delete/$1');
    $routes->get('photos/job/(:num)', 'Photos::byJob/$1');
    $routes->get('photos/referred/(:num)', 'Photos::byReferred/$1');

    // Referred (Dispatch) Routes
    $routes->get('referred', 'Referred::index');
    $routes->get('referred/create', 'Referred::create');
    $routes->post('referred/store', 'Referred::store');
    $routes->get('referred/view/(:num)', 'Referred::view/$1');
    $routes->get('referred/edit/(:num)', 'Referred::edit/$1');
    $routes->post('referred/update/(:num)', 'Referred::update/$1');
    $routes->get('referred/delete/(:num)', 'Referred::delete/$1');
    $routes->post('referred/updateStatus/(:num)', 'Referred::updateStatus/$1');

    // Service Centers Routes
    $routes->get('service-centers', 'ServiceCenters::index');
    $routes->get('service-centers/create', 'ServiceCenters::create');
    $routes->post('service-centers/store', 'ServiceCenters::store');
    $routes->get('service-centers/edit/(:num)', 'ServiceCenters::edit/$1');
    $routes->post('service-centers/update/(:num)', 'ServiceCenters::update/$1');
    $routes->get('service-centers/delete/(:num)', 'ServiceCenters::delete/$1');
    $routes->get('service-centers/search', 'ServiceCenters::search');

    // Technicians Routes (View Only - Create/Edit via User Management)
    $routes->get('technicians', 'Technicians::index');
    $routes->get('technicians/view/(:num)', 'Technicians::view/$1');

    // User Management Routes
    $routes->get('user-management', 'UserManagement::index');
    $routes->get('user-management/create', 'UserManagement::create');
    $routes->post('user-management/store', 'UserManagement::store');
    $routes->get('user-management/view/(:num)', 'UserManagement::view/$1');
    $routes->get('user-management/edit/(:num)', 'UserManagement::edit/$1');
    $routes->post('user-management/update/(:num)', 'UserManagement::update/$1');
    $routes->get('user-management/delete/(:num)', 'UserManagement::delete/$1');
    $routes->post('user-management/updateStatus/(:num)', 'UserManagement::updateStatus/$1');

    // Bug Reports Routes (Admin Only)
    $routes->get('bug-reports', 'BugReports::index');
    $routes->get('bug-reports/create', 'BugReports::create');
    $routes->post('bug-reports/store', 'BugReports::store');
    $routes->get('bug-reports/view/(:num)', 'BugReports::view/$1');
    $routes->get('bug-reports/edit/(:num)', 'BugReports::edit/$1');
    $routes->post('bug-reports/update/(:num)', 'BugReports::update/$1');
    $routes->get('bug-reports/delete/(:num)', 'BugReports::delete/$1');
    $routes->get('bug-reports/serve/(:any)', 'BugReports::serve/$1');

    // User Guide Route
    $routes->get('user-guide', 'Dashboard::userGuide');

    // Profile and Settings Routes
    $routes->get('profile', 'Dashboard::profile');
    $routes->get('settings', 'Dashboard::settings');

});

// Include Admin Routes
require_once APPPATH . 'Config/AdminRoutes.php';
