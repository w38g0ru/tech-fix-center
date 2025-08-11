<?php

namespace App\Controllers;

use App\Models\AdminUserModel;

class Auth extends BaseController
{
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();
        helper(['form', 'url', 'auth', 'session']);
    }

    /**
     * Show professional login form
     */
    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            $role = session()->get('role');
            $redirectUrl = $this->getRedirectUrl($role);
            return redirect()->to($redirectUrl)->with('info', 'You are already logged in.');
        }

        // Check if there's a redirect URL in session
        $intendedUrl = $this->request->getGet('redirect');
        if ($intendedUrl) {
            session()->set('redirect_url', $intendedUrl);
        }

        // Prepare data for the view
        $data = [
            'title' => 'Login - TeknoPhix'
        ];

        return view('auth/login', $data);
    }



    /**
     * Process login with professional security features
     */
    public function processLogin()
    {
        // Check if request is POST
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to(base_url('auth/login'))->with('error', 'Invalid request method.');
        }

        $clientIP = $this->request->getIPAddress();

        // Enhanced validation rules
        $rules = [
            'email' => [
                'label' => 'Email Address',
                'rules' => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required' => 'Email address is required.',
                    'valid_email' => 'Please enter a valid email address.',
                    'max_length' => 'Email address is too long.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[255]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 6 characters.',
                    'max_length' => 'Password is too long.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput(['email' => $this->request->getPost('email')])
                           ->with('errors', $this->validator->getErrors());
        }

        $email = trim(strtolower($this->request->getPost('email')));
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') ? true : false;

        // Log login attempt
        log_message('info', "Login attempt for email: {$email} from IP: {$clientIP}");

        // Verify credentials with enhanced security
        $user = $this->verifyUserCredentials($email, $password);

        if ($user) {
            try {
                // Set secure session using helper
                setSecureSession($user, $remember);



                // Update last login in database
                try {
                    $this->adminUserModel->update($user['id'], [
                        'last_login' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Failed to update last login: ' . $e->getMessage());
                    // Continue with login even if update fails
                }

                // Log successful login
                log_message('info', "Successful login for user ID: {$user['id']}, email: {$email}");

                // Log user activity
                helper('activity');
                log_login_activity($user['id'], "Successful login from IP: {$clientIP}");

                // Determine redirect URL
                $redirectUrl = $this->getRedirectUrl($user['role']);

                // Check for intended redirect URL
                $intendedUrl = session()->get('redirect_url');
                if ($intendedUrl && filter_var($intendedUrl, FILTER_VALIDATE_URL)) {
                    session()->remove('redirect_url');
                    $redirectUrl = $intendedUrl;
                }

                $userName = $user['name'] ?? $user['full_name'] ?? 'User';
                return redirect()->to($redirectUrl)
                               ->with('success', 'Welcome back, ' . esc($userName) . '! You have been successfully logged in.');

            } catch (\Exception $e) {
                log_message('error', 'Error during successful login processing: ' . $e->getMessage());
                return redirect()->back()
                               ->withInput(['email' => $email])
                               ->with('error', 'Login successful but there was an error setting up your session. Please try again.');
            }
        } else {
            // Log failed login
            log_message('warning', "Failed login attempt for email: {$email} from IP: {$clientIP}");

            return redirect()->back()
                           ->withInput(['email' => $email])
                           ->with('error', 'Invalid email address or password. Please check your credentials and try again.');
        }
    }

    /**
     * Professional logout with security cleanup
     */
    public function logout()
    {
        // Load auth helper
        helper('auth');
        helper('activity');

        // Get user ID before clearing session
        $userId = getUserId();
        $clientIP = $this->request->getIPAddress();

        // Log logout activity before clearing session
        if ($userId) {
            log_logout_activity($userId, "User logged out from IP: {$clientIP}");
        }

        // Use secure session helper for cleanup
        clearSecureSession();

        return redirect()->to(base_url('auth/login'))
                       ->with('success', 'You have been securely logged out. Thank you for using Tech Fix Center!');
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
            return redirect()->back()->with('success', 'Password reset instructions have been sent to your email.');
        } else {
            return redirect()->back()->with('error', 'Email address not found.');
        }
    }



    /**
     * Enhanced credential verification with security checks
     */
    private function verifyUserCredentials($email, $password)
    {
        $user = $this->adminUserModel->where('email', $email)
                                   ->where('status', 'active')
                                   ->first();

        if (!$user) {
            // Add small delay to prevent timing attacks
            usleep(100000); // 0.1 second
            return false;
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            return $user;
        }

        // Add delay for failed password verification
        usleep(100000); // 0.1 second
        return false;
    }





    /**
     * Get redirect URL based on user role
     */
    private function getRedirectUrl($role)
    {
        $roleRedirects = [
            'superadmin' => 'dashboard',
            'admin' => 'dashboard',
            'manager' => 'dashboard',
            'technician' => 'dashboard/jobs',
            'customer' => 'dashboard/jobs'
        ];

        $redirect = $roleRedirects[$role] ?? 'dashboard';
        return base_url($redirect);
    }




}
