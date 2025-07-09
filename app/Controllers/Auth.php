<?php

namespace App\Controllers;

use App\Models\AdminUserModel;

class Auth extends BaseController
{
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
    }

    /**
     * Show login form
     */
    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Login - TFC Dashboard'
        ];

        return view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function processLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Verify credentials
        $user = $this->adminUserModel->verifyCredentials($email, $password);

        if ($user) {
            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'user_type' => $user['user_type'],
                'isLoggedIn' => true
            ];

            session()->set($sessionData);

            // Set remember me cookie if requested
            if ($remember) {
                $cookieData = [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'token' => bin2hex(random_bytes(32))
                ];
                
                // Set cookie for 30 days
                setcookie('remember_token', json_encode($cookieData), time() + (30 * 24 * 60 * 60), '/');
            }

            // Check for intended redirect URL
            $redirectUrl = session()->get('redirect_url');
            if ($redirectUrl) {
                session()->remove('redirect_url');
            } else {
                $redirectUrl = $this->getRedirectUrl($user['role']);
            }

            return redirect()->to($redirectUrl)->with('success', 'Welcome back, ' . $user['name'] . '!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        // Clear session
        session()->destroy();

        // Clear remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        return redirect()->to(base_url('auth/login'))->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show forgot password form
     */
    public function forgotPassword()
    {
        $data = [
            'title' => 'Forgot Password - TFC Dashboard'
        ];

        return view('auth/forgot_password', $data);
    }

    /**
     * Process forgot password
     */
    public function processForgotPassword()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user = $this->adminUserModel->where('email', $email)->first();

        if ($user) {
            // Generate reset token (in a real app, you'd send this via email)
            $resetToken = bin2hex(random_bytes(32));
            
            // For demo purposes, we'll just show a success message
            // In production, you'd save the token and send an email
            return redirect()->back()->with('success', 'Password reset instructions have been sent to your email.');
        } else {
            return redirect()->back()->with('error', 'Email address not found.');
        }
    }

    /**
     * Check if user is authenticated
     */
    public function checkAuth()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Please login to access the dashboard.');
        }
    }

    /**
     * Get redirect URL based on user role
     */
    private function getRedirectUrl($role)
    {
        switch ($role) {
            case 'superadmin':
            case 'admin':
                return base_url('dashboard');
            case 'technician':
                return base_url('dashboard/jobs');
            case 'customer':
                return base_url('dashboard/jobs');
            default:
                return base_url('dashboard');
        }
    }

    /**
     * Auto-login from remember me cookie
     */
    public function autoLogin()
    {
        if (session()->get('isLoggedIn')) {
            return true;
        }

        if (isset($_COOKIE['remember_token'])) {
            $cookieData = json_decode($_COOKIE['remember_token'], true);
            
            if ($cookieData && isset($cookieData['user_id'])) {
                $user = $this->adminUserModel->find($cookieData['user_id']);
                
                if ($user && $user['status'] === 'active') {
                    // Set session data
                    $sessionData = [
                        'user_id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'user_type' => $user['user_type'],
                        'isLoggedIn' => true
                    ];

                    session()->set($sessionData);
                    return true;
                }
            }
        }

        return false;
    }
}
