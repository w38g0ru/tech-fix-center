<?php

namespace App\Models;

use CodeIgniter\Model;

class UserActivityLogModel extends Model
{
    protected $table = 'user_activity_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = ['user_id', 'activity_type', 'details', 'ip_address', 'user_agent'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null; // No updated_at field needed for logs

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'activity_type' => 'required|in_list[login,logout,post,update,delete,view]',
        'details' => 'permit_empty|string|max_length[1000]',
        'ip_address' => 'permit_empty|string|max_length[45]',
        'user_agent' => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be a valid integer'
        ],
        'activity_type' => [
            'required' => 'Activity type is required',
            'in_list' => 'Activity type must be login, logout, post, update, delete, or view'
        ],
        'details' => [
            'string' => 'Details must be a string',
            'max_length' => 'Details cannot exceed 1000 characters'
        ],
        'ip_address' => [
            'string' => 'IP address must be a string',
            'max_length' => 'IP address cannot exceed 45 characters'
        ],
        'user_agent' => [
            'string' => 'User agent must be a string'
        ]
    ];

    /**
     * Get activity logs for a specific user
     */
    public function getUserActivities($userId, $limit = 50, $offset = 0)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    /**
     * Get recent activities across all users
     */
    public function getRecentActivities($limit = 100, $offset = 0)
    {
        return $this->select('user_activity_logs.*, admin_users.full_name, admin_users.email')
                    ->join('admin_users', 'admin_users.id = user_activity_logs.user_id', 'left')
                    ->orderBy('user_activity_logs.created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    /**
     * Get activity statistics
     */
    public function getActivityStats($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));

        return [
            'total_activities' => $this->where('created_at >=', $startDate)->countAllResults(false),
            'login_count' => $this->where('activity_type', 'login')->where('created_at >=', $startDate)->countAllResults(false),
            'logout_count' => $this->where('activity_type', 'logout')->where('created_at >=', $startDate)->countAllResults(false),
            'post_count' => $this->whereIn('activity_type', ['post', 'update', 'delete'])->where('created_at >=', $startDate)->countAllResults(false),
            'view_count' => $this->where('activity_type', 'view')->where('created_at >=', $startDate)->countAllResults(false)
        ];
    }

    /**
     * Get activities with user details and filtering
     */
    public function getActivitiesWithDetails($filters = [], $perPage = 20)
    {
        $builder = $this->select('user_activity_logs.*, admin_users.full_name, admin_users.email')
                        ->join('admin_users', 'admin_users.id = user_activity_logs.user_id', 'left');

        // Apply filters
        if (!empty($filters['user_id'])) {
            $builder->where('user_activity_logs.user_id', $filters['user_id']);
        }

        if (!empty($filters['activity_type'])) {
            $builder->where('user_activity_logs.activity_type', $filters['activity_type']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                   ->like('user_activity_logs.details', $filters['search'])
                   ->orLike('admin_users.full_name', $filters['search'])
                   ->orLike('admin_users.email', $filters['search'])
                   ->groupEnd();
        }

        if (!empty($filters['date_from'])) {
            $builder->where('user_activity_logs.created_at >=', $filters['date_from'] . ' 00:00:00');
        }

        if (!empty($filters['date_to'])) {
            $builder->where('user_activity_logs.created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        return $builder->orderBy('user_activity_logs.created_at', 'DESC')
                      ->paginate($perPage);
    }

    /**
     * Clean old activity logs (older than specified days)
     */
    public function cleanOldLogs($days = 90)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        return $this->where('created_at <', $cutoffDate)->delete();
    }
}
