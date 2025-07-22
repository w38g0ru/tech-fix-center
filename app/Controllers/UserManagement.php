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
        $userData = [
            'full_name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'phone' => $this->request->getPost('mobile_number'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        // Additional validation: only superadmin can create superadmin
        if ($userData['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->back()->withInput()->with('error', 'Only super admins can create super admin accounts.');
        }

        // Additional validation for confirm password
        $confirmPassword = $this->request->getPost('confirm_password');
        if ($userData['password'] !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Password confirmation does not match.');
        }

        // Validate using AdminUserModel
        if (!$this->adminUserModel->validate($userData)) {
            return redirect()->back()->withInput()->with('errors', $this->adminUserModel->errors());
        }

        $userData['created_at'] = date('Y-m-d H:i:s');

        if ($this->adminUserModel->insert($userData)) {
            return redirect()->to('/dashboard/user-management')->with('success', 'User created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create user.');
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
        $userData = [
            'full_name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('mobile_number'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];

        // Password is optional for updates
        $password = $this->request->getPost('password');
        if ($password) {
            $userData['password'] = $password;

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

        // For updates, we need to modify validation rules to exclude current record
        $this->adminUserModel->setValidationRule('full_name', "required|min_length[2]|max_length[255]");
        $this->adminUserModel->setValidationRule('email', "required|valid_email|is_unique[admin_users.email,id,{$id}]");

        // Make password optional for updates
        if (!$password) {
            $this->adminUserModel->setValidationRule('password', 'permit_empty');
        }

        // Validate using AdminUserModel
        if (!$this->adminUserModel->validate($userData)) {
            return redirect()->back()->withInput()->with('errors', $this->adminUserModel->errors());
        }

        $userData['updated_at'] = date('Y-m-d H:i:s');

        if ($this->adminUserModel->update($id, $userData)) {
            return redirect()->to('/dashboard/user-management')->with('success', 'User updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update user.');
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
}
