<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
<<<<<<< HEAD
$routes->get('/', function() {
    helper('auth');
    if (isLoggedIn()) {
        return redirect()->to('/dashboard');
    } else {
        return redirect()->to('/auth/login');
    }
});

// Authentication Routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/processLogin', 'Auth::processLogin');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/processForgotPassword', 'Auth::processForgotPassword');

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

    // Technicians Routes
    $routes->get('technicians', 'Technicians::index');
    $routes->get('technicians/create', 'Technicians::create');
    $routes->post('technicians/store', 'Technicians::store');
    $routes->get('technicians/view/(:num)', 'Technicians::view/$1');
    $routes->get('technicians/edit/(:num)', 'Technicians::edit/$1');
    $routes->post('technicians/update/(:num)', 'Technicians::update/$1');
    $routes->get('technicians/delete/(:num)', 'Technicians::delete/$1');

    // User Management Routes
    $routes->get('user-management', 'UserManagement::index');
    $routes->get('user-management/create', 'UserManagement::create');
    $routes->post('user-management/store', 'UserManagement::store');
    $routes->get('user-management/view/(:num)', 'UserManagement::view/$1');
    $routes->get('user-management/edit/(:num)', 'UserManagement::edit/$1');
    $routes->post('user-management/update/(:num)', 'UserManagement::update/$1');
    $routes->get('user-management/delete/(:num)', 'UserManagement::delete/$1');
    $routes->post('user-management/updateStatus/(:num)', 'UserManagement::updateStatus/$1');

    // User Guide Route
    $routes->get('user-guide', 'Dashboard::userGuide');

    // Profile and Settings Routes
    $routes->get('profile', 'Dashboard::profile');
    $routes->get('settings', 'Dashboard::settings');

    // Mobile Test Route (for debugging)
    $routes->get('mobile-test', 'Dashboard::mobileTest');


});
=======
$routes->get('/', 'Home::index');
>>>>>>> 5fa8307 (Initial commit)
