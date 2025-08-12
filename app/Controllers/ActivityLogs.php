<?php

namespace App\Controllers;

use App\Models\UserActivityLogModel;
use CodeIgniter\Controller;

class ActivityLogs extends BaseController
{
    protected $activityModel;

    public function __construct()
    {
        $this->activityModel = new UserActivityLogModel();
        helper(['auth', 'activity']);
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $userRole = getUserRole();
        $userId = getUserId();
        $perPage = 20; // Items per page

        // Get search and filter parameters
        $search = $this->request->getGet('search');
        $activityType = $this->request->getGet('activity_type');
        $dateFrom = $this->request->getGet('date_from');
        $dateTo = $this->request->getGet('date_to');

        // Build query based on user role
        $builder = $this->activityModel->select('user_activity_logs.*, admin_users.full_name, admin_users.email')
                                      ->join('admin_users', 'admin_users.id = user_activity_logs.user_id', 'left');

        // Role-based filtering
        if (!in_array($userRole, ['superadmin', 'admin'])) {
            // Non-admin users can only see their own activities
            $builder->where('user_activity_logs.user_id', $userId);
        }

        // Apply filters
        if ($search) {
            $builder->groupStart()
                   ->like('user_activity_logs.details', $search)
                   ->orLike('admin_users.full_name', $search)
                   ->orLike('admin_users.email', $search)
                   ->groupEnd();
        }

        if ($activityType) {
            $builder->where('user_activity_logs.activity_type', $activityType);
        }

        if ($dateFrom) {
            $builder->where('user_activity_logs.created_at >=', $dateFrom . ' 00:00:00');
        }

        if ($dateTo) {
            $builder->where('user_activity_logs.created_at <=', $dateTo . ' 23:59:59');
        }

        // Get paginated results
        $activities = $builder->orderBy('user_activity_logs.created_at', 'DESC')
                             ->paginate($perPage);

        // Get statistics
        $stats = $this->getActivityStats($userRole, $userId);

        $data = [
            'title' => 'Activity Logs',
            'activities' => $activities ?: [],
            'userRole' => $userRole,
            'stats' => $stats,
            'search' => $search,
            'activityType' => $activityType,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'pager' => $this->activityModel->pager
        ];

        return view('dashboard/activity_logs/index', $data);
    }

    public function view($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $userRole = getUserRole();
        $userId = getUserId();

        // Get activity with user details
        $activity = $this->activityModel->select('user_activity_logs.*, admin_users.full_name, admin_users.email, admin_users.role')
                                       ->join('admin_users', 'admin_users.id = user_activity_logs.user_id', 'left')
                                       ->where('user_activity_logs.id', $id)
                                       ->first();

        if (!$activity) {
            return redirect()->to('/dashboard/activity-logs')->with('error', 'Activity log not found.');
        }

        // Role-based access control
        if (!in_array($userRole, ['superadmin', 'admin']) && $activity['user_id'] != $userId) {
            return redirect()->to('/dashboard/activity-logs')->with('error', 'Access denied.');
        }

        $data = [
            'title' => 'Activity Log Details',
            'activity' => $activity,
            'userRole' => $userRole
        ];

        return view('dashboard/activity_logs/view', $data);
    }

    public function export()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Only admin users can export
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard/activity-logs')->with('error', 'Access denied. Admin privileges required for export.');
        }

        $userRole = getUserRole();
        $userId = getUserId();

        // Get all activities based on role
        $builder = $this->activityModel->select('user_activity_logs.*, admin_users.full_name, admin_users.email')
                                      ->join('admin_users', 'admin_users.id = user_activity_logs.user_id', 'left');

        if (!in_array($userRole, ['superadmin', 'admin'])) {
            $builder->where('user_activity_logs.user_id', $userId);
        }

        $activities = $builder->orderBy('user_activity_logs.created_at', 'DESC')->findAll();

        // Set headers for CSV download
        $filename = 'activity_logs_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Write CSV headers
        $headers = [
            'ID',
            'User Name',
            'Email',
            'Activity Type',
            'Details',
            'IP Address',
            'User Agent',
            'Date & Time'
        ];
        fputcsv($output, $headers);

        // Write data rows
        foreach ($activities as $activity) {
            $row = [
                $activity['id'],
                $activity['full_name'] ?? 'Unknown User',
                $activity['email'] ?? '',
                ucfirst($activity['activity_type']),
                $activity['details'],
                $activity['ip_address'],
                $activity['user_agent'],
                $activity['created_at']
            ];
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    private function getActivityStats($userRole, $userId)
    {
        $builder = $this->activityModel;

        // Role-based filtering for stats
        if (!in_array($userRole, ['superadmin', 'admin'])) {
            $builder = $builder->where('user_id', $userId);
        }

        $startDate = date('Y-m-d H:i:s', strtotime('-30 days'));

        return [
            'total_activities' => $builder->where('created_at >=', $startDate)->countAllResults(false),
            'login_count' => $builder->where('activity_type', 'login')->where('created_at >=', $startDate)->countAllResults(false),
            'logout_count' => $builder->where('activity_type', 'logout')->where('created_at >=', $startDate)->countAllResults(false),
            'post_count' => $builder->where('activity_type', 'post')->where('created_at >=', $startDate)->countAllResults(false)
        ];
    }
}
