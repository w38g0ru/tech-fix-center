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
        'last_login',
        'google_id',
        'profile_picture',
        'phone',
        'address',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[admin_users.username,id,{id}]',
        'email' => 'required|valid_email|max_length[255]|is_unique[admin_users.email,id,{id}]',
        'password' => 'required|min_length[8]|max_length[255]',
        'full_name' => 'required|min_length[2]|max_length[255]',
        'role' => 'required|in_list[superadmin,admin,technician,user]',
        'status' => 'required|in_list[active,inactive,suspended]',
        'phone' => 'permit_empty|max_length[20]',
        'address' => 'permit_empty|max_length[500]',
        'google_id' => 'permit_empty|max_length[100]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'alpha_numeric_punct' => 'Username can only contain letters, numbers, and basic punctuation',
            'min_length' => 'Username must be at least 3 characters long',
            'max_length' => 'Username cannot exceed 50 characters',
            'is_unique' => 'This username is already taken'
        ],
        'email' => [
            'required' => 'Email address is required',
            'valid_email' => 'Please enter a valid email address',
            'max_length' => 'Email address cannot exceed 255 characters',
            'is_unique' => 'This email address is already registered'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 8 characters long',
            'max_length' => 'Password cannot exceed 255 characters'
        ],
        'full_name' => [
            'required' => 'Full name is required',
            'min_length' => 'Full name must be at least 2 characters long',
            'max_length' => 'Full name cannot exceed 255 characters'
        ],
        'role' => [
            'required' => 'User role is required',
            'in_list' => 'Please select a valid user role'
        ],
        'status' => [
            'required' => 'User status is required',
            'in_list' => 'Please select a valid user status'
        ],
        'phone' => [
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'address' => [
            'max_length' => 'Address cannot exceed 500 characters'
        ]
    ];

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
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get user by username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get user by Google ID
     */
    public function getUserByGoogleId($googleId)
    {
        return $this->where('google_id', $googleId)->first();
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
                    ->where('status', 'active')
                    ->orderBy('full_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('status', 'active')
                    ->orderBy('full_name', 'ASC')
                    ->findAll();
    }

    /**
     * Update last login time
     */
    public function updateLastLogin($userId)
    {
        return $this->update($userId, [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Search users
     */
    public function searchUsers($search, $limit = 20)
    {
        return $this->groupStart()
                    ->like('full_name', $search)
                    ->orLike('email', $search)
                    ->orLike('username', $search)
                    ->groupEnd()
                    ->orderBy('full_name', 'ASC')
                    ->paginate($limit);
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        $total = $this->countAllResults(false);
        $active = $this->where('status', 'active')->countAllResults(false);
        $inactive = $this->where('status', 'inactive')->countAllResults(false);
        $suspended = $this->where('status', 'suspended')->countAllResults(false);

        $roleStats = [];
        $roles = ['superadmin', 'admin', 'technician', 'user'];

        foreach ($roles as $role) {
            $roleStats[$role] = $this->where('role', $role)
                                    ->where('status', 'active')
                                    ->countAllResults(false);
        }

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'suspended' => $suspended,
            'roles' => $roleStats
        ];
    }

    /**
     * Validate user credentials
     */
    public function validateCredentials($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if (!$user || $user['status'] !== 'active') {
            return false;
        }

        return password_verify($password, $user['password']) ? $user : false;
    }

    /**
     * Check if user has permission
     */
    public function hasPermission($userId, $permission)
    {
        $user = $this->find($userId);

        if (!$user || $user['status'] !== 'active') {
            return false;
        }

        // Define role permissions
        $permissions = [
            'superadmin' => ['*'], // All permissions
            'admin' => [
                'manage_users', 'manage_jobs', 'manage_inventory',
                'manage_technicians', 'view_reports', 'manage_parts_requests'
            ],
            'technician' => [
                'view_jobs', 'update_jobs', 'create_parts_requests', 'view_inventory'
            ],
            'user' => [
                'view_own_jobs'
            ]
        ];

        $userRole = $user['role'];

        // Superadmin has all permissions
        if ($userRole === 'superadmin') {
            return true;
        }

        return isset($permissions[$userRole]) && in_array($permission, $permissions[$userRole]);
    }

    /**
     * Get available roles
     */
    public function getAvailableRoles()
    {
        return [
            'superadmin' => 'Super Administrator',
            'admin' => 'Administrator',
            'technician' => 'Technician',
            'user' => 'User'
        ];
    }

    /**
     * Get available statuses
     */
    public function getAvailableStatuses()
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'suspended' => 'Suspended'
        ];
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
     * Get technicians only (users with role = 'technician')
     */
    public function getTechnicians($perPage = null)
    {
        $builder = $this->where('role', 'technician')
                        ->where('status', 'active')
                        ->orderBy('full_name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get available technicians (with least pending jobs)
     */
    public function getAvailableTechnicians($perPage = null)
    {
        $builder = $this->select('admin_users.*, COUNT(CASE WHEN jobs.status IN ("Pending", "In Progress") THEN 1 END) as active_jobs')
                        ->join('jobs', 'jobs.technician_id = admin_users.id', 'left')
                        ->where('admin_users.role', 'technician')
                        ->where('admin_users.status', 'active')
                        ->groupBy('admin_users.id')
                        ->orderBy('active_jobs', 'ASC')
                        ->orderBy('admin_users.full_name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Get technician statistics
     */
    public function getTechnicianStats()
    {
        $total = $this->where('role', 'technician')->countAllResults(false);
        $active = $this->where('role', 'technician')
                       ->where('status', 'active')
                       ->countAllResults(false);
        $inactive = $this->where('role', 'technician')
                         ->where('status', 'inactive')
                         ->countAllResults(false);

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'performance' => $this->getTechnicianPerformance()
        ];
    }

    /**
     * Get technician performance data
     */
    public function getTechnicianPerformance($limit = 10)
    {
        $jobModel = new \App\Models\JobModel();

        return $this->select('admin_users.id, admin_users.full_name as name,
                             COUNT(CASE WHEN jobs.status = "Completed" THEN jobs.id END) as completed_jobs,
                             COALESCE(SUM(CASE WHEN jobs.status = "Completed" THEN jobs.charge ELSE 0 END), 0) as total_revenue')
                    ->join('jobs', 'jobs.technician_id = admin_users.id', 'left')
                    ->where('admin_users.role', 'technician')
                    ->where('admin_users.status', 'active')
                    ->groupBy('admin_users.id, admin_users.full_name')
                    ->orderBy('completed_jobs', 'DESC')
                    ->orderBy('total_revenue', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Search technicians
     */
    public function searchTechnicians($search, $perPage = null)
    {
        $builder = $this->where('role', 'technician')
                        ->groupStart()
                        ->like('full_name', $search)
                        ->orLike('email', $search)
                        ->orLike('username', $search)
                        ->orLike('phone', $search)
                        ->groupEnd()
                        ->orderBy('full_name', 'ASC');

        if ($perPage !== null) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Create technician user (convenience method)
     */
    public function createTechnician($data)
    {
        // Ensure role is set to technician
        $data['role'] = 'technician';

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        // Generate username from full_name if not provided
        if (!isset($data['username']) && isset($data['full_name'])) {
            $data['username'] = $this->generateUsernameFromName($data['full_name']);
        }

        // Generate default password if not provided
        if (!isset($data['password'])) {
            $data['password'] = 'technician123'; // Default password
        }

        return $this->insert($data);
    }

    /**
     * Generate username from full name
     */
    private function generateUsernameFromName($fullName)
    {
        // Convert to lowercase and replace spaces with underscores
        $username = strtolower(str_replace(' ', '_', $fullName));

        // Remove special characters except underscores
        $username = preg_replace('/[^a-z0-9_]/', '', $username);

        // Check if username exists and add number if needed
        $originalUsername = $username;
        $counter = 1;

        while ($this->where('username', $username)->first()) {
            $username = $originalUsername . '_' . $counter;
            $counter++;
        }

        return $username;
    }
}
