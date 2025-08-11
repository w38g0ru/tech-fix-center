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

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }
        return view('auth/login', ['title' => 'Login']);
    }



    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email and password are required.');
        }

        $user = $this->adminUserModel->where('email', $email)->where('status', 'active')->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
                'name' => $user['name'] ?? $user['full_name'],
                'isLoggedIn' => true
            ]);

            $this->adminUserModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

            return redirect()->to(base_url('dashboard'))->with('success', 'Login successful!');
        }

        return redirect()->back()->withInput(['email' => $email])->with('error', 'Invalid credentials.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'))->with('success', 'Logged out successfully!');
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
