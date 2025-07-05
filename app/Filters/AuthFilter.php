<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Load auth helper
        helper('auth');
        
        // Check if user is logged in
        if (!isLoggedIn()) {
            // Store the intended URL for redirect after login
            session()->set('redirect_url', current_url());
            
            // Redirect to login page
            return redirect()->to('/auth/login')->with('error', 'Please login to access this page.');
        }
        
        // Check for specific role requirements
        if ($arguments) {
            $requiredRoles = is_array($arguments) ? $arguments : [$arguments];
            
            if (!hasAnyRole($requiredRoles)) {
                return redirect()->to('/dashboard')->with('error', 'You do not have permission to access this page.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
