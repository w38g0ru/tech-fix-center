<?php

namespace App\Controllers;

use App\Models\AdminUserModel;

class UserManagement extends BaseController
{
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();

        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user can manage users (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to access user management.');
        }

        $search = $this->request->getGet('search');
        $role = $this->request->getGet('role');
        $status = $this->request->getGet('status');
        $perPage = 20; // Items per page

        // Apply filters
        if ($search) {
            $users = $this->adminUserModel->searchUsers($search, $perPage);
        } elseif ($role) {
            $users = $this->adminUserModel->where('role', $role)->paginate($perPage);
        } elseif ($status) {
            $users = $this->adminUserModel->where('status', $status)->paginate($perPage);
        } else {
            $users = $this->adminUserModel->orderBy('created_at', 'DESC')->paginate($perPage);
        }

        $data = [
            'title' => 'User Management',
            'users' => $users,
            'search' => $search,
            'role' => $role,
            'status' => $status,
            'userStats' => $this->adminUserModel->getUserStats(),
            'pager' => $this->adminUserModel->pager
        ];

        return view('dashboard/user_management/index', $data);
    }

    public function create()
    {
        // Check if user is logged in first
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login')->with('error', 'Please log in to access this page.');
        }

        // Check if user can create users (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to create users. Only admins and superadmins can create users.');
        }

        $data = ['title' => 'Create New User'];
        return view('dashboard/user_management/create', $data);
    }

    public function store()
    {
        // Check if user can create users (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to create users.');
        }

        // Prepare user data for model validation
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userData = [
            'username' => $this->generateUsername($email), // Generate username from email
            'full_name' => $this->request->getPost('name'),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Hash the password
            'phone' => $this->request->getPost('mobile_number'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        // Additional validation: only superadmin can create superadmin
        if ($userData['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->back()->withInput()->with('error', 'Only super admins can create super admin accounts.');
        }

        // Additional validation for confirm password (before hashing)
        $confirmPassword = $this->request->getPost('confirm_password');
        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Password confirmation does not match.');
        }

        // Create a copy for validation without hashed password
        $validationData = $userData;
        $validationData['password'] = $password; // Use original password for validation

        // Validate using AdminUserModel
        if (!$this->adminUserModel->validate($validationData)) {
            return redirect()->back()->withInput()->with('errors', $this->adminUserModel->errors());
        }

        $userData['created_at'] = date('Y-m-d H:i:s');

        // Debug logging
        log_message('debug', 'UserManagement::store - Attempting to create user: ' . json_encode($userData));

        if ($this->adminUserModel->insert($userData)) {
            return redirect()->to('/dashboard/user-management')->with('success', 'User created successfully!');
        } else {
            // Get detailed error information
            $errors = $this->adminUserModel->errors();
            if (!empty($errors)) {
                return redirect()->back()->withInput()->with('errors', $errors);
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create user. Please check all required fields and try again.');
            }
        }
    }

    public function view($id)
    {
        // Check if user can view users
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view users.');
        }

        $user = $this->adminUserModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'title' => 'User Details',
            'user' => $user
        ];

        return view('dashboard/user_management/view', $data);
    }

    public function edit($id)
    {
        // Check if user can edit users (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to edit users.');
        }

        $user = $this->adminUserModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('dashboard/user_management/edit', $data);
    }

    public function update($id)
    {
        // Check if user can edit users (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to update users.');
        }

        $user = $this->adminUserModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        // Prepare user data for model validation
        $email = $this->request->getPost('email');
        $userData = [
            'full_name' => $this->request->getPost('name'),
            'email' => $email,
            'phone' => $this->request->getPost('mobile_number'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];

        // Update username if email changed
        if ($email !== $user['email']) {
            $userData['username'] = $this->generateUsername($email);
        }

        // Password is optional for updates
        $password = $this->request->getPost('password');
        $originalPassword = $password; // Store original for validation
        if ($password) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            // Additional validation for confirm password
            $confirmPassword = $this->request->getPost('confirm_password');
            if ($password !== $confirmPassword) {
                return redirect()->back()->withInput()->with('error', 'Password confirmation does not match.');
            }
        }

        // Additional validation: only superadmin can create/edit superadmin
        if ($userData['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->back()->withInput()->with('error', 'Only super admins can assign super admin role.');
        }

        // Create validation data (use original password for validation if provided)
        $validationData = $userData;
        if ($originalPassword) {
            $validationData['password'] = $originalPassword;
        }

        // For updates, we need to modify validation rules to exclude current record
        $this->adminUserModel->setValidationRule('full_name', "required|min_length[2]|max_length[255]");
        $this->adminUserModel->setValidationRule('email', "required|valid_email|is_unique[admin_users.email,id,{$id}]");

        // Handle username validation if it's being updated
        if (isset($userData['username'])) {
            $this->adminUserModel->setValidationRule('username', "required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[admin_users.username,id,{$id}]");
        }

        // Make password optional for updates
        if (!$originalPassword) {
            $this->adminUserModel->setValidationRule('password', 'permit_empty');
        }

        // Validate using AdminUserModel
        if (!$this->adminUserModel->validate($validationData)) {
            return redirect()->back()->withInput()->with('errors', $this->adminUserModel->errors());
        }

        $userData['updated_at'] = date('Y-m-d H:i:s');

        // Debug logging
        log_message('debug', 'UserManagement::update - Attempting to update user ID ' . $id . ': ' . json_encode($userData));

        if ($this->adminUserModel->update($id, $userData)) {
            return redirect()->to('/dashboard/user-management')->with('success', 'User updated successfully!');
        } else {
            // Get detailed error information
            $errors = $this->adminUserModel->errors();
            if (!empty($errors)) {
                return redirect()->back()->withInput()->with('errors', $errors);
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update user. Please check all fields and try again.');
            }
        }
    }

    public function delete($id)
    {
        // Check if user can delete users (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to delete users.');
        }

        $user = $this->adminUserModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        // Prevent deletion of superadmin by non-superadmin
        if ($user['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->to('/dashboard/user-management')->with('error', 'Only super admins can delete super admin accounts.');
        }

        // Prevent self-deletion
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/dashboard/user-management')->with('error', 'You cannot delete your own account.');
        }

        if ($this->adminUserModel->delete($id)) {
            return redirect()->to('/dashboard/user-management')->with('success', 'User deleted successfully!');
        } else {
            return redirect()->to('/dashboard/user-management')->with('error', 'Failed to delete user.');
        }
    }

    public function updateStatus($id)
    {
        // Check if user can update user status
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to update user status.');
        }

        $user = $this->adminUserModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['active', 'inactive', 'suspended'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        // Prevent self-suspension/deactivation
        if ($user['id'] == session()->get('user_id') && $status !== 'active') {
            return redirect()->back()->with('error', 'You cannot deactivate or suspend your own account.');
        }

        if ($this->adminUserModel->updateStatus($id, $status)) {
            return redirect()->back()->with('success', 'User status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update user status.');
        }
    }

    public function sendSms()
    {
        // Step 1: Get all active users with valid phone numbers
        $users = $this->adminUserModel
                    ->where('status', 'active')
                    ->where('phone !=', '')
                    ->where('phone IS NOT NULL')
                    ->findAll();

        if (empty($users)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'No active users with valid phone numbers found.'
            ])->setStatusCode(404);
        }

        // Step 2: Extract phone numbers
        $phoneNumbers = array_column($users, 'phone');

        // Step 3: Compose SMS message
        $currentDateTime = date('l, F j, Y \a\t g:i A');
        $message = "Hi message from website sent on {$currentDateTime}. Sample message.";

        // Step 4: Send SMS to all numbers
        $sms = service('sms');
        $result = $sms->send($phoneNumbers, $message);

        // Step 5: Return response with appropriate HTTP status
        return $this->response->setJSON([
            'status'  => $result['status'],
            'message' => $result['message'] ?? ($result['status'] ? 'SMS sent successfully to all active users!' : 'Failed to send SMS'),
            'count'   => count($phoneNumbers),
            'code'    => $result['code'] ?? null,
            'debug'   => $result['raw'] ?? null  // Optional: remove for production
        ])->setStatusCode($result['status'] ? 200 : 400);
    }

    public function sendSmsToUser($id)
    {
        $validation = \Config\Services::validation();

        // Step 1: Validate ID is a positive integer (no leading zeros) using regex
        $validation->setRules([
            'id' => [
                'label' => 'User ID',
                'rules' => 'required|regex_match[/^[1-9][0-9]*$/]',
                'errors' => [
                    'regex_match' => 'The {field} must be a positive integer greater than zero without leading zeros.'
                ]
            ]
        ]);

        if (!$validation->run(['id' => $id])) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Invalid user ID.',
                'errors'  => $validation->getErrors()
            ])->setStatusCode(422);
        }

        // Step 2: Check if user exists, is active, and has a valid phone
        $user = $this->adminUserModel
                    ->where('id', $id)
                    ->where('status', 'active')
                    ->where('phone !=', '')
                    ->where('phone IS NOT NULL')
                    ->first();

        if (!$user) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'User not found, inactive, or missing valid phone number.'
            ])->setStatusCode(404);
        }

        // Step 3: Compose SMS message
        $currentDateTime = date('l, F j, Y \a\t g:i A');
        $message = "Hi {$user['full_name']}, message from website sent on {$currentDateTime}. Sample message.";

        // Step 4: Send SMS
        $sms = service('sms');
        $result = $sms->send($user['phone'], $message);

        // Step 5: Return response with appropriate HTTP status
        return $this->response->setJSON([
            'status'  => $result['status'],
            'message' => $result['message'],
            'code'    => $result['code'] ?? null,
            'debug'   => $result['raw'] ?? null  // Optional: remove for production
        ])->setStatusCode($result['status'] ? 200 : 400);
    }

    /**
     * Generate a unique username from email
     */
    private function generateUsername($email)
    {
        // Extract username part from email
        $baseUsername = strtolower(explode('@', $email)[0]);

        // Remove any non-alphanumeric characters except dots and underscores
        $baseUsername = preg_replace('/[^a-z0-9._]/', '', $baseUsername);

        // Check if username already exists
        $username = $baseUsername;
        $counter = 1;

        while ($this->adminUserModel->where('username', $username)->first()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
