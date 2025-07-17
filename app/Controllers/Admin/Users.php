<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

/**
 * Admin Users Controller
 * 
 * Handles user management functionality including CRUD operations,
 * user roles, permissions, and user data export/import.
 */
class Users extends BaseController
{
    protected $userModel;
    protected $validation;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
    }
    
    /**
     * Display users list
     * 
     * @return string
     */
    public function index()
    {
        // Check authentication and permissions
        if (!$this->isAuthenticated() || !$this->hasAdminAccess()) {
            return redirect()->to('/admin/login');
        }
        
        // Prepare view data
        $data = [
            'title' => 'User Management',
            'subtitle' => 'Manage user accounts, roles, and permissions',
            'breadcrumb' => [
                ['title' => 'Users', 'icon' => 'fas fa-users']
            ],
            'userCount' => $this->userModel->countAll()
        ];
        
        return view('admin/users/index', $data);
    }
    
    /**
     * Get users data for DataTable (AJAX)
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getData()
    {
        // Validate AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Get request parameters
        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';
        $orderColumn = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDir = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        
        // Column mapping
        $columns = ['id', 'name', 'email', 'role', 'status', 'created_at'];
        $orderBy = $columns[$orderColumn] ?? 'name';
        
        // Build query
        $builder = $this->userModel->builder();
        
        // Apply search filter
        if (!empty($searchValue)) {
            $builder->groupStart()
                    ->like('name', $searchValue)
                    ->orLike('email', $searchValue)
                    ->orLike('role', $searchValue)
                    ->groupEnd();
        }
        
        // Get total records (before filtering)
        $totalRecords = $this->userModel->countAll();
        
        // Get filtered records count
        $filteredRecords = $builder->countAllResults(false);
        
        // Apply ordering and pagination
        $users = $builder->orderBy($orderBy, $orderDir)
                        ->limit($length, $start)
                        ->get()
                        ->getResultArray();
        
        // Format data for DataTable
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'status' => $user['status'],
                'created_at' => date('M j, Y', strtotime($user['created_at'])),
                'actions' => $this->generateActionButtons($user['id'])
            ];
        }
        
        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
    
    /**
     * Create new user
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function create()
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'role' => 'required|in_list[admin,manager,user]',
            'password' => 'required|min_length[8]'
        ];
        
        // Validate input
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Validation failed',
                'messages' => $this->validator->getErrors()
            ]);
        }
        
        // Prepare user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Insert user
        if ($this->userModel->insert($userData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'User created successfully'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Failed to create user'
            ]);
        }
    }
    
    /**
     * Update user
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id)
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Check if user exists
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }
        
        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role' => 'required|in_list[admin,manager,user]',
            'status' => 'required|in_list[active,inactive,pending]'
        ];
        
        // Add password validation if provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
        }
        
        // Validate input
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Validation failed',
                'messages' => $this->validator->getErrors()
            ]);
        }
        
        // Prepare update data
        $updateData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Add password if provided
        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        
        // Update user
        if ($this->userModel->update($id, $updateData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Failed to update user'
            ]);
        }
    }
    
    /**
     * Delete user
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id)
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Check if user exists
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }
        
        // Prevent deleting current user
        if ($id == session()->get('user_id')) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Cannot delete your own account'
            ]);
        }
        
        // Delete user
        if ($this->userModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Failed to delete user'
            ]);
        }
    }
    
    /**
     * Get user details
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function show($id)
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Get user
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }
        
        // Remove sensitive data
        unset($user['password']);
        
        return $this->response->setJSON($user);
    }
    
    /**
     * Export users to CSV
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function export()
    {
        // Get all users
        $users = $this->userModel->findAll();
        
        // Set headers for CSV download
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="users_' . date('Y-m-d') . '.csv"');
        
        // Create CSV content
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At']);
        
        // CSV data
        foreach ($users as $user) {
            fputcsv($output, [
                $user['id'],
                $user['name'],
                $user['email'],
                $user['role'],
                $user['status'],
                $user['created_at']
            ]);
        }
        
        fclose($output);
        return $this->response;
    }
    
    /**
     * Generate action buttons for user row
     * 
     * @param int $userId
     * @return string
     */
    private function generateActionButtons($userId)
    {
        return '
            <div class="flex items-center justify-end space-x-2">
                <button onclick="editUser(' . $userId . ')" class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteUser(' . $userId . ')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        ';
    }
    
    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    private function isAuthenticated()
    {
        // For demo purposes, always return true
        return true; // session()->get('isLoggedIn') === true;
    }

    /**
     * Check if user has admin access
     *
     * @return bool
     */
    private function hasAdminAccess()
    {
        // For demo purposes, always return true
        return true; // $userRole = session()->get('user_role'); return in_array($userRole, ['admin', 'super_admin']);
    }
}
