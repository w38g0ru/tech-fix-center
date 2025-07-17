<?php

namespace App\Controllers;

use App\Models\AdminUserModel;
use App\Libraries\GoogleOAuthService;

class Auth extends BaseController
{
    protected $adminUserModel;
    protected $maxLoginAttempts = 5;
    protected $lockoutTime = 900; // 15 minutes

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
            'title' => 'Secure Login - Tech Fix Center',
            'meta_description' => 'Secure login portal for Tech Fix Center staff and administrators',
            'show_demo_credentials' => ENVIRONMENT === 'development' || ENVIRONMENT === 'testing'
        ];

        return view('auth/login', $data);
    }

    /**
     * Alias for login method (for backward compatibility)
     */
    public function index()
    {
        return $this->login();
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

        // Rate limiting check (with fallback)
        $clientIP = $this->request->getIPAddress();
        try {
            if ($this->isRateLimited($clientIP)) {
                return redirect()->back()->with('error', 'Too many login attempts. Please try again in 15 minutes.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Rate limiting error: ' . $e->getMessage());
            // Continue with login if rate limiting fails
        }

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
            try {
                $this->recordFailedAttempt($clientIP);
            } catch (\Exception $e) {
                log_message('error', 'Failed to record login attempt: ' . $e->getMessage());
            }
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
                // Clear failed attempts on successful login
                $this->clearFailedAttempts($clientIP);

                // Set secure session using helper
                setSecureSession($user, $remember);

                // Handle remember me functionality
                if ($remember) {
                    $this->setRememberMeCookie($user);
                }

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
            // Record failed attempt
            try {
                $this->recordFailedAttempt($clientIP);
            } catch (\Exception $e) {
                log_message('error', 'Failed to record login attempt: ' . $e->getMessage());
            }

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
     * Check if IP is rate limited
     */
    private function isRateLimited($ip)
    {
        try {
            $cacheKey = 'login_attempts_' . md5($ip);
            $attempts = cache()->get($cacheKey);

            if ($attempts && $attempts['count'] >= $this->maxLoginAttempts) {
                $timeRemaining = $attempts['lockout_until'] - time();
                if ($timeRemaining > 0) {
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            // If cache fails, don't block login but log the error
            log_message('error', 'Cache error in rate limiting: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Record failed login attempt
     */
    private function recordFailedAttempt($ip)
    {
        try {
            $cacheKey = 'login_attempts_' . md5($ip);
            $attempts = cache()->get($cacheKey) ?: ['count' => 0, 'lockout_until' => 0];

            $attempts['count']++;

            if ($attempts['count'] >= $this->maxLoginAttempts) {
                $attempts['lockout_until'] = time() + $this->lockoutTime;
            }

            cache()->save($cacheKey, $attempts, $this->lockoutTime);
        } catch (\Exception $e) {
            // If cache fails, log the error but don't break login
            log_message('error', 'Cache error in recording failed attempt: ' . $e->getMessage());
        }
    }

    /**
     * Clear failed attempts on successful login
     */
    private function clearFailedAttempts($ip)
    {
        try {
            $cacheKey = 'login_attempts_' . md5($ip);
            cache()->delete($cacheKey);
        } catch (\Exception $e) {
            // If cache fails, log the error but don't break login
            log_message('error', 'Cache error in clearing failed attempts: ' . $e->getMessage());
        }
    }

    /**
     * Set secure remember me cookie
     */
    private function setRememberMeCookie($user)
    {
        $token = bin2hex(random_bytes(32));
        $cookieData = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'token' => $token,
            'created' => time()
        ];

        // Set secure cookie for 30 days
        $cookieOptions = [
            'expires' => time() + (30 * 24 * 60 * 60),
            'path' => '/',
            'domain' => '',
            'secure' => $this->request->isSecure(),
            'httponly' => true,
            'samesite' => 'Lax'
        ];

        setcookie('remember_token', json_encode($cookieData), $cookieOptions);
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

    /**
     * Redirect to Google OAuth
     */
    public function googleLogin()
    {
        try {
            // Check if Google OAuth is properly configured FIRST
            $config = new \Config\GoogleOAuth();
            if (!$config->isConfigured()) {
                log_message('error', 'Google OAuth not configured properly');
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Google authentication is not configured. Please contact administrator.');
            }

            // Only create the service if configuration is valid
            $googleOAuth = new GoogleOAuthService();
            $authUrl = $googleOAuth->getAuthUrl();

            if (empty($authUrl)) {
                throw new \Exception('Failed to generate Google OAuth URL');
            }

            return redirect()->to($authUrl);

        } catch (\Exception $e) {
            log_message('error', 'Google OAuth redirect error: ' . $e->getMessage());
            return redirect()->to(base_url('auth/login'))
                ->with('error', 'Google authentication is temporarily unavailable. Please try regular login.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            $code = $this->request->getGet('code');
            $error = $this->request->getGet('error');

            // Check for OAuth errors
            if ($error) {
                log_message('warning', 'Google OAuth error: ' . $error);
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Google authentication was cancelled or failed.');
            }

            if (!$code) {
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Invalid Google authentication response.');
            }

            // Get user info from Google
            $googleOAuth = new GoogleOAuthService();
            $userInfo = $googleOAuth->handleCallback($code);

            if (!$userInfo || !isset($userInfo['email'])) {
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Failed to retrieve user information from Google.');
            }

            // Check if user exists in admin_user table
            $user = $this->adminUserModel->where('email', $userInfo['email'])->first();

            if (!$user) {
                log_message('warning', 'Google OAuth attempt with non-existent email: ' . $userInfo['email']);
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Your Google account is not authorized to access this system. Please contact an administrator.');
            }

            // Check if user is active
            if ($user['status'] !== 'active') {
                log_message('warning', 'Google OAuth attempt with inactive account: ' . $userInfo['email']);
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Your account is inactive. Please contact an administrator.');
            }

            // Log successful Google login
            log_message('info', 'Successful Google OAuth login: ' . $user['email'] . ' (ID: ' . $user['id'] . ')');

            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'full_name' => $user['full_name'] ?? $user['name'] ?? $userInfo['name'],
                'name' => $user['name'] ?? $userInfo['name'],
                'role' => $user['role'],
                'google_id' => $userInfo['id'],
                'google_picture' => $userInfo['picture'] ?? null,
                'login_method' => 'google',
                'last_activity' => time(),
                'isLoggedIn' => true
            ];

            session()->set($sessionData);

            // Update last login time
            $this->adminUserModel->update($user['id'], [
                'last_login' => date('Y-m-d H:i:s'),
                'google_id' => $userInfo['id'] // Store Google ID for future reference
            ]);

            // Redirect to intended URL or dashboard
            $redirectUrl = session()->get('redirect_url') ?? $this->getRedirectUrl($user['role']);
            session()->remove('redirect_url');

            return redirect()->to($redirectUrl)
                ->with('success', 'Welcome back, ' . ($user['full_name'] ?? $user['name']) . '! You have been logged in via Google.');

        } catch (\Exception $e) {
            log_message('error', 'Google OAuth callback error: ' . $e->getMessage());
            return redirect()->to(base_url('auth/login'))
                ->with('error', 'An error occurred during Google authentication. Please try again or use regular login.');
        }
    }
}
