<?php

use App\Models\UserActivityLogModel;

if (!function_exists('log_activity')) {
    /**
     * Log user activity
     * 
     * @param string $type Activity type (login, logout, post)
     * @param int $userId User ID
     * @param string|null $details Optional details about the activity
     * @return bool Success status
     */
    function log_activity(string $type, int $userId, string $details = null): bool
    {
        try {
            $model = new UserActivityLogModel();
            
            $data = [
                'user_id' => $userId,
                'activity_type' => $type,
                'details' => $details,
                'ip_address' => service('request')->getIPAddress(),
                'user_agent' => service('request')->getUserAgent()->getAgentString(),
            ];
            
            return $model->insert($data) !== false;
        } catch (\Exception $e) {
            // Log the error but don't break the application
            log_message('error', 'Failed to log user activity: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('log_login_activity')) {
    /**
     * Log user login activity
     * 
     * @param int $userId User ID
     * @param string|null $details Optional login details
     * @return bool Success status
     */
    function log_login_activity(int $userId, string $details = null): bool
    {
        $defaultDetails = $details ?? 'User logged in successfully';
        return log_activity('login', $userId, $defaultDetails);
    }
}

if (!function_exists('log_logout_activity')) {
    /**
     * Log user logout activity
     * 
     * @param int $userId User ID
     * @param string|null $details Optional logout details
     * @return bool Success status
     */
    function log_logout_activity(int $userId, string $details = null): bool
    {
        $defaultDetails = $details ?? 'User logged out';
        return log_activity('logout', $userId, $defaultDetails);
    }
}

if (!function_exists('log_post_activity')) {
    /**
     * Log user data post activity
     * 
     * @param int $userId User ID
     * @param string $details Details about what was posted
     * @return bool Success status
     */
    function log_post_activity(int $userId, string $details): bool
    {
        return log_activity('post', $userId, $details);
    }
}

if (!function_exists('get_user_recent_activities')) {
    /**
     * Get recent activities for a user
     * 
     * @param int $userId User ID
     * @param int $limit Number of activities to retrieve
     * @return array Recent activities
     */
    function get_user_recent_activities(int $userId, int $limit = 10): array
    {
        try {
            $model = new UserActivityLogModel();
            return $model->getUserActivities($userId, $limit);
        } catch (\Exception $e) {
            log_message('error', 'Failed to get user activities: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('get_activity_stats')) {
    /**
     * Get activity statistics
     * 
     * @param int $days Number of days to look back
     * @return array Activity statistics
     */
    function get_activity_stats(int $days = 30): array
    {
        try {
            $model = new UserActivityLogModel();
            return $model->getActivityStats($days);
        } catch (\Exception $e) {
            log_message('error', 'Failed to get activity stats: ' . $e->getMessage());
            return [
                'total_activities' => 0,
                'login_count' => 0,
                'logout_count' => 0,
                'post_count' => 0
            ];
        }
    }
}

if (!function_exists('clean_old_activity_logs')) {
    /**
     * Clean old activity logs
     * 
     * @param int $days Number of days to keep logs
     * @return bool Success status
     */
    function clean_old_activity_logs(int $days = 90): bool
    {
        try {
            $model = new UserActivityLogModel();
            $deleted = $model->cleanOldLogs($days);
            
            if ($deleted > 0) {
                log_message('info', "Cleaned {$deleted} old activity log entries older than {$days} days");
            }
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Failed to clean old activity logs: ' . $e->getMessage());
            return false;
        }
    }
}
