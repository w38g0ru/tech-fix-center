<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function roleCheck()
    {
        helper('auth');
        
        $data = [
            'title' => 'Role Debug Information',
            'isLoggedIn' => isLoggedIn(),
            'currentUser' => getCurrentUser(),
            'userRole' => getUserRole(),
            'sessionData' => session()->get(),
            'hasAdminRole' => hasRole('admin'),
            'hasSuperAdminRole' => hasRole('superadmin'),
            'hasAnyAdminRole' => hasAnyRole(['superadmin', 'admin']),
            'canCreateTechnician' => canCreateTechnician(),
        ];
        
        return view('debug/role_check', $data);
    }
    
    public function serviceCenter()
    {
        helper('auth');
        
        // Check if user is logged in
        if (!isLoggedIn()) {
            $data['error'] = 'User is not logged in';
        } else {
            $data['loginStatus'] = 'User is logged in';
        }
        
        // Check if user has admin privileges
        $hasAdminRole = hasRole('admin');
        $hasSuperAdminRole = hasRole('superadmin');
        $hasAnyAdminRole = hasAnyRole(['superadmin', 'admin']);
        
        $data = [
            'title' => 'Service Center Access Debug',
            'isLoggedIn' => isLoggedIn(),
            'currentUser' => getCurrentUser(),
            'userRole' => getUserRole(),
            'hasAdminRole' => $hasAdminRole,
            'hasSuperAdminRole' => $hasSuperAdminRole,
            'hasAnyAdminRole' => $hasAnyAdminRole,
            'shouldHaveAccess' => $hasAnyAdminRole,
            'redirectReason' => !$hasAnyAdminRole ? 'User does not have admin or superadmin role' : 'User should have access'
        ];
        
        return view('debug/service_center', $data);
    }
}
