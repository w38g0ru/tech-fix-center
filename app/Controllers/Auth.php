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
        helper(['form', 'url', 'auth', 'session', 'activity']);
    }

    /**
     * Show login form
     */
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            $role = session()->get('role');
            return redirect()->to($this->getRedirectUrl($role))->with('info', 'You are already logged in.');
        }

        $intendedUrl = $this->request->getGet('redirect');
        if ($intendedUrl) {
            session()->set('redirect_url', $intendedUrl);
        }

        $data = [
            'title' => 'Secure Login - TeknoPhix',
            'meta_description' => 'Secure login portal for TeknoPhix staff and administrators'
        ];

        return view('auth/login', $data);
    }

    public function index()
    {
        return $this->login();
    }

    /**
     * Process login
     */
    public function processLogin()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to(base_url('auth/login'))->with('error', 'Invalid request method.');
        }

        $clientIP = $this->request->getIPAddress();

        if ($this->isRateLimited($clientIP)) {
            return redirect()->back()->with('error', 'Too many login attempts. Please try again in 15 minutes.');
        }

        $rules = [
            'email' => 'required|valid_email|max_length[100]',
            'password' => 'required|min_length[6]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            $this->recordFailedAttempt($clientIP);
            return redirect()->back()
                           ->withInput(['email' => $this->request->getPost('email')])
                           ->with('errors', $this->validator->getErrors());
        }

        $email = trim(strtolower($this->request->getPost('email')));
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        $user = $this->verifyUserCredentials($email, $password);

        if ($user) {
            $this->clearFailedAttempts($clientIP);
            setSecureSession($user, $remember);

            // Set additional session data for access control
            session()->set('access_level', $user['role']);

            if ($remember) {
                $this->setRememberMeCookie($user);
            }

            $this->adminUserModel->update($user['id'], [
                'last_login' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            log_login_activity($user['id'], "Successful login from IP: {$clientIP}");

            $redirectUrl = $this->getRedirectUrl($user['role']);
            $intendedUrl = session()->get('redirect_url');
            if ($intendedUrl && filter_var($intendedUrl, FILTER_VALIDATE_URL)) {
                session()->remove('redirect_url');
                $redirectUrl = $intendedUrl;
            }

            $userName = $user['name'] ?? $user['full_name'] ?? 'User';
            return redirect()->to($redirectUrl)
                           ->with('success', 'Welcome back, ' . esc($userName) . '!');
        } else {
            $this->recordFailedAttempt($clientIP);
            return redirect()->back()
                           ->withInput(['email' => $email])
                           ->with('error', 'Invalid email address or password.');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $userId = getUserId();
        $clientIP = $this->request->getIPAddress();

        if ($userId) {
            log_logout_activity($userId, "User logged out from IP: {$clientIP}");
        }

        clearSecureSession();

        return redirect()->to(base_url('auth/login'))
                       ->with('success', 'You have been securely logged out.');
    }

    public function forgotPassword()
    {
        $data = ['title' => 'Forgot Password - TeknoPhix'];
        return view('auth/forgot_password', $data);
    }

    public function processForgotPassword()
    {
        if (!$this->validate(['email' => 'required|valid_email'])) {
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

    public function checkAuth()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Please login to access the dashboard.');
        }
    }

    private function verifyUserCredentials($email, $password)
    {
        $user = $this->adminUserModel->where('email', $email)
                                   ->where('status', 'active')
                                   ->first();

        if (!$user) {
            usleep(100000);
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        usleep(100000);
        return false;
    }

    private function isRateLimited($ip)
    {
        $cacheKey = 'login_attempts_' . md5($ip);
        $attempts = cache()->get($cacheKey);

        if ($attempts && $attempts['count'] >= $this->maxLoginAttempts) {
            $timeRemaining = $attempts['lockout_until'] - time();
            if ($timeRemaining > 0) {
                return true;
            }
        }

        return false;
    }

    private function recordFailedAttempt($ip)
    {
        $cacheKey = 'login_attempts_' . md5($ip);
        $attempts = cache()->get($cacheKey) ?: ['count' => 0, 'lockout_until' => 0];

        $attempts['count']++;

        if ($attempts['count'] >= $this->maxLoginAttempts) {
            $attempts['lockout_until'] = time() + $this->lockoutTime;
        }

        cache()->save($cacheKey, $attempts, $this->lockoutTime);
    }

    private function clearFailedAttempts($ip)
    {
        $cacheKey = 'login_attempts_' . md5($ip);
        cache()->delete($cacheKey);
    }

    private function setRememberMeCookie($user)
    {
        $token = bin2hex(random_bytes(32));
        $cookieData = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'token' => $token,
            'created' => time()
        ];

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

    private function getRedirectUrl($role)
    {
        $roleRedirects = [
            'superadmin' => 'dashboard',
            'admin' => 'dashboard',
            'manager' => 'dashboard',
            'technician' => 'dashboard/jobs',
            'customer' => 'dashboard/jobs'
        ];

        return base_url($roleRedirects[$role] ?? 'dashboard');
    }



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
                    $sessionData = [
                        'user_id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'access_level' => $user['role'],
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
                log_message('error', 'Google OAuth: Failed to retrieve user information from Google');
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Failed to retrieve user information from Google.');
            }

            log_message('info', 'Google OAuth: Retrieved user info for email: ' . $userInfo['email']);

            // Check if user exists in admin_user table
            $user = $this->adminUserModel->where('email', $userInfo['email'])->first();

            if (!$user) {
                log_message('warning', 'Google OAuth attempt with non-existent email: ' . $userInfo['email']);
                log_message('debug', 'Google OAuth: Available emails in database: ' . json_encode($this->adminUserModel->select('email')->findAll()));
                return redirect()->to(base_url('auth/login'))
                    ->with('error', 'Your Google account (' . $userInfo['email'] . ') is not authorized to access this system. Please contact an administrator.');
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
                'access_level' => $user['role'],
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

            // Log Google OAuth login activity
            $clientIP = $this->request->getIPAddress();
            log_login_activity($user['id'], "Successful Google OAuth login from IP: {$clientIP}");

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
