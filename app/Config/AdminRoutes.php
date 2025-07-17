<?php

/**
 * Admin Routes Configuration
 * 
 * This file contains all routes for the admin dashboard.
 * Include this file in your main Routes.php file.
 */

// Admin routes group with authentication middleware
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Dashboard routes
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/sales-chart', 'Dashboard::getSalesChartData');
    $routes->get('dashboard/user-growth', 'Dashboard::getUserGrowthData');
    $routes->get('dashboard/activity', 'Dashboard::getRecentActivity');
    
    // User management routes
    $routes->group('users', function($routes) {
        $routes->get('/', 'Users::index');
        $routes->post('data', 'Users::getData');
        $routes->post('create', 'Users::create');
        $routes->get('show/(:num)', 'Users::show/$1');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->delete('delete/(:num)', 'Users::delete/$1');
        $routes->get('export', 'Users::export');
    });
    
    // Reports routes
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Reports::index');
        $routes->get('analytics', 'Reports::analytics');
        $routes->get('sales', 'Reports::sales');
        $routes->get('users', 'Reports::users');
        $routes->get('export/(:alpha)', 'Reports::export/$1');
    });
    
    // Content management routes
    $routes->group('content', function($routes) {
        $routes->get('pages', 'Content::pages');
        $routes->get('posts', 'Content::posts');
        $routes->get('media', 'Content::media');
        $routes->post('upload', 'Content::upload');
    });
    
    // E-commerce routes
    $routes->group('products', function($routes) {
        $routes->get('/', 'Products::index');
        $routes->get('create', 'Products::create');
        $routes->post('store', 'Products::store');
        $routes->get('edit/(:num)', 'Products::edit/$1');
        $routes->post('update/(:num)', 'Products::update/$1');
        $routes->delete('delete/(:num)', 'Products::delete/$1');
    });
    
    $routes->group('orders', function($routes) {
        $routes->get('/', 'Orders::index');
        $routes->get('show/(:num)', 'Orders::show/$1');
        $routes->post('update-status/(:num)', 'Orders::updateStatus/$1');
    });
    
    $routes->group('categories', function($routes) {
        $routes->get('/', 'Categories::index');
        $routes->post('create', 'Categories::create');
        $routes->post('update/(:num)', 'Categories::update/$1');
        $routes->delete('delete/(:num)', 'Categories::delete/$1');
    });
    
    // Settings routes
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
    $routes->post('settings/upload-logo', 'Settings::uploadLogo');
    
    // Profile routes
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->post('profile/change-password', 'Profile::changePassword');
    $routes->post('profile/upload-avatar', 'Profile::uploadAvatar');
    
    // Notifications routes
    $routes->get('notifications', 'Notifications::index');
    $routes->post('notifications/mark-read/(:num)', 'Notifications::markAsRead/$1');
    $routes->post('notifications/mark-all-read', 'Notifications::markAllAsRead');
    
    // Activity log routes
    $routes->get('activity', 'Activity::index');
    $routes->get('activity/user/(:num)', 'Activity::userActivity/$1');
    
    // System routes
    $routes->group('system', function($routes) {
        $routes->get('info', 'System::info');
        $routes->get('logs', 'System::logs');
        $routes->get('backup', 'System::backup');
        $routes->post('clear-cache', 'System::clearCache');
    });
    
    // API routes for AJAX requests
    $routes->group('api', function($routes) {
        $routes->get('stats', 'Api::getStats');
        $routes->get('users/search', 'Api::searchUsers');
        $routes->get('notifications/unread', 'Api::getUnreadNotifications');
        $routes->post('upload/image', 'Api::uploadImage');
    });
    
    // Authentication routes
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::sendResetLink');
    $routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
    $routes->post('reset-password', 'Auth::updatePassword');
});

// Public admin assets (CSS, JS, images)
$routes->get('admin-assets/(:any)', function($file) {
    $filePath = FCPATH . 'admin-assets/' . $file;
    if (file_exists($filePath)) {
        $mimeType = mime_content_type($filePath);
        header('Content-Type: ' . $mimeType);
        readfile($filePath);
        exit;
    }
    throw new \CodeIgniter\Exceptions\PageNotFoundException();
});

// Admin middleware for authentication and authorization
// Add this to your app/Config/Filters.php

/*
class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        // Check if user has admin privileges
        $userRole = $session->get('user_role');
        if (!in_array($userRole, ['admin', 'super_admin'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
*/
