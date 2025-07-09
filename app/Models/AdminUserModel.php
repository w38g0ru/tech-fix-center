<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table = 'admin_users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'full_name',
        'role',
        'status',
        'last_login'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[admin_users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[admin_users.email,id,{id}]',
        'full_name' => 'required|min_length[2]|max_length[100]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[superadmin,admin,technician,user]',
        'status' => 'permit_empty|in_list[active,inactive,suspended]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters',
            'max_length' => 'Username cannot exceed 50 characters',
            'is_unique' => 'Username already exists'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'Email already exists'
        ],
        'full_name' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 2 characters',
            'max_length' => 'Full name cannot exceed 100 characters'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters'
        ],
        'role' => [
            'required' => 'Role is required',
            'in_list' => 'Invalid role selected'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status selected'
        ]
    ];

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password before saving
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Verify user credentials
     */
    public function verifyCredentials($email, $password)
    {
        $user = $this->where('email', $email)
                     ->where('status', 'active')
                     ->first();

        if ($user && password_verify($password, $user['password'])) {
            // Update last login timestamp
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

            // Map full_name to name for compatibility
            $user['name'] = $user['full_name'];
            $user['user_type'] = 'Admin'; // Default for admin users

            return $user;
        }

        return false;
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
                    ->where('status', 'active')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    /**
     * Search users
     */
    public function searchUsers($search)
    {
        return $this->like('name', $search)
                    ->orLike('email', $search)
                    ->orLike('mobile_number', $search)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        $stats = [
            'total' => $this->countAll(),
            'active' => $this->where('status', 'active')->countAllResults(false),
            'inactive' => $this->where('status', 'inactive')->countAllResults(false),
            'superadmin' => $this->where('role', 'superadmin')->countAllResults(false),
            'admin' => $this->where('role', 'admin')->countAllResults(false),
            'manager' => $this->where('role', 'manager')->countAllResults(false),
            'technician' => $this->where('role', 'technician')->countAllResults(false),
            'customer' => $this->where('role', 'customer')->countAllResults(false)
        ];

        return $stats;
    }

    /**
     * Check if email exists
     */
    public function emailExists($email, $excludeId = null)
    {
        $builder = $this->where('email', $email);
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        return $builder->countAllResults() > 0;
    }

    /**
     * Get recent users
     */
    public function getRecentUsers($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Update user status
     */
    public function updateStatus($id, $status)
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return false;
        }

        return $this->update($id, ['status' => $status]);
    }

    /**
     * Change user password
     */
    public function changePassword($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }
}
