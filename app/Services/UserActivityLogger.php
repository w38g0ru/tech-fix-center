<?php

namespace App\Services;

use App\Models\UserActivityLogModel;

class UserActivityLogger
{
    public static function log($activityType, $details = null)
    {
        $logModel = new UserActivityLogModel();

        $logModel->insert([
            'user_id'     => auth()->id() ?? null, // Or your auth logic
            'activity_type' => $activityType,
            'details'       => is_array($details) ? json_encode($details) : $details,
            'ip_address'    => service('request')->getIPAddress(),
            'user_agent'    => service('request')->getUserAgent(),
        ]);
    }
}
