<?php

/**
 * Professional Session Management Helper
 * Provides secure session handling for Tech Fix Center
 */

if (!function_exists('isSessionValid')) {
    /**
     * Check if current session is valid and not expired
     */
    function isSessionValid()
    {
        if (!session()->get('isLoggedIn')) {
            return false;
        }

        // Check session timeout (30 minutes of inactivity)
        $lastActivity = session()->get('last_activity');
        if ($lastActivity && (time() - $lastActivity) > 1800) {
            session()->destroy();
            return false;
        }

        // Update last activity
        session()->set('last_activity', time());
        return true;
    }
}

if (!function_exists('refreshSession')) {
    /**
     * Refresh session data and extend timeout
     */
    function refreshSession()
    {
        if (session()->get('isLoggedIn')) {
            session()->set('last_activity', time());
            
            // Regenerate session ID every 15 minutes for security
            $sessionStart = session()->get('login_time');
            if ($sessionStart && (time() - $sessionStart) % 900 === 0) {
                session_regenerate_id(true);
            }
        }
    }
}

if (!function_exists('getSessionUser')) {
    /**
     * Get current user data from session
     */
    function getSessionUser()
    {
        if (!isSessionValid()) {
            return null;
        }

        return [
            'id' => session()->get('user_id'),
            'name' => session()->get('name') ?? 'User',
            'email' => session()->get('email'),
            'role' => session()->get('role'),
            'user_type' => session()->get('user_type') ?? 'Admin',
            'login_time' => session()->get('login_time'),
            'last_activity' => session()->get('last_activity')
        ];
    }
}

if (!function_exists('setSecureSession')) {
    /**
     * Set secure session data for authenticated user
     */
    function setSecureSession($user, $rememberMe = false)
    {
        $sessionData = [
            'user_id' => $user['id'],
            'name' => $user['name'] ?? $user['full_name'] ?? 'User',
            'email' => $user['email'],
            'role' => $user['role'],
            'user_type' => $user['user_type'] ?? 'Admin',
            'isLoggedIn' => true,
            'login_time' => time(),
            'last_activity' => time(),
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString()
        ];

        session()->set($sessionData);
        
        // Regenerate session ID for security
        session_regenerate_id(true);

        return true;
    }
}

if (!function_exists('clearSecureSession')) {
    /**
     * Securely clear all session data
     */
    function clearSecureSession()
    {
        // Log session destruction
        $userId = session()->get('user_id');
        if ($userId) {
            log_message('info', "Session cleared for user ID: {$userId}");
        }

        // Destroy session
        session()->destroy();

        // Clear any remember me cookies
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }

        // Regenerate session ID
        session_regenerate_id(true);
    }
}

if (!function_exists('checkSessionSecurity')) {
    /**
     * Check session security (IP and User Agent validation)
     */
    function checkSessionSecurity()
    {
        if (!session()->get('isLoggedIn')) {
            return true; // No session to validate
        }

        $currentIP = service('request')->getIPAddress();
        $currentUA = service('request')->getUserAgent()->getAgentString();
        
        $sessionIP = session()->get('ip_address');
        $sessionUA = session()->get('user_agent');

        // Check IP address (allow for dynamic IPs in same subnet)
        if ($sessionIP && $currentIP !== $sessionIP) {
            // Log potential session hijacking
            log_message('warning', "IP address mismatch for user " . session()->get('user_id') . ". Session: {$sessionIP}, Current: {$currentIP}");
            
            // For now, just log - in production you might want to force re-authentication
            // clearSecureSession();
            // return false;
        }

        // Check User Agent
        if ($sessionUA && $currentUA !== $sessionUA) {
            log_message('warning', "User Agent mismatch for user " . session()->get('user_id'));
        }

        return true;
    }
}

if (!function_exists('getSessionTimeRemaining')) {
    /**
     * Get remaining session time in seconds
     */
    function getSessionTimeRemaining()
    {
        if (!session()->get('isLoggedIn')) {
            return 0;
        }

        $lastActivity = session()->get('last_activity');
        if (!$lastActivity) {
            return 0;
        }

        $timeElapsed = time() - $lastActivity;
        $timeRemaining = 1800 - $timeElapsed; // 30 minutes timeout

        return max(0, $timeRemaining);
    }
}

if (!function_exists('extendSession')) {
    /**
     * Extend current session by updating last activity
     */
    function extendSession()
    {
        if (session()->get('isLoggedIn')) {
            session()->set('last_activity', time());
            return true;
        }
        return false;
    }
}

if (!function_exists('isSessionExpiringSoon')) {
    /**
     * Check if session is expiring soon (within 5 minutes)
     */
    function isSessionExpiringSoon()
    {
        $timeRemaining = getSessionTimeRemaining();
        return $timeRemaining > 0 && $timeRemaining <= 300; // 5 minutes
    }
}

if (!function_exists('getSessionInfo')) {
    /**
     * Get comprehensive session information for debugging
     */
    function getSessionInfo()
    {
        if (!session()->get('isLoggedIn')) {
            return null;
        }

        return [
            'user_id' => session()->get('user_id'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
            'login_time' => session()->get('login_time'),
            'last_activity' => session()->get('last_activity'),
            'time_remaining' => getSessionTimeRemaining(),
            'ip_address' => session()->get('ip_address'),
            'session_id' => session_id(),
            'is_expiring_soon' => isSessionExpiringSoon()
        ];
    }
}

if (!function_exists('getUserRole')) {
    /**
     * Get current user role from session
     *
     * @return string Current user role or 'guest' if not set
     */
    function getUserRole(): string
    {
        return session()->get('role') ?? 'guest';
    }
}

if (!function_exists('setUserRole')) {
    /**
     * Set user role in session (for testing/development)
     *
     * @param string $role User role (user, technician, admin, super_admin)
     * @return void
     */
    function setUserRole(string $role): void
    {
        $validRoles = ['user', 'technician', 'admin', 'super_admin'];

        if (in_array(strtolower($role), $validRoles)) {
            session()->set('role', strtolower($role));
        }
    }
}

if (!function_exists('hasAccessLevel')) {
    /**
     * Check if user has required access level
     *
     * @param string $requiredLevel Required access level
     * @return bool True if user has access
     */
    function hasAccessLevel(string $requiredLevel): bool
    {
        if ($requiredLevel === 'all') {
            return true;
        }

        $userRole = getUserRole();
        if ($userRole === 'guest') {
            return false;
        }

        // Define access level hierarchy
        $accessLevels = [
            'user' => 1,
            'technician' => 2,
            'admin' => 3,
            'super_admin' => 4
        ];

        $userLevel = $accessLevels[strtolower($userRole)] ?? 0;
        $requiredLevelValue = $accessLevels[$requiredLevel] ?? 999;

        return $userLevel >= $requiredLevelValue;
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Check if current user is admin or higher
     *
     * @return bool True if user is admin or super_admin
     */
    function isAdmin(): bool
    {
        return hasAccessLevel('admin');
    }
}

if (!function_exists('isTechnician')) {
    /**
     * Check if current user is technician or higher
     *
     * @return bool True if user is technician, admin, or super_admin
     */
    function isTechnician(): bool
    {
        return hasAccessLevel('technician');
    }
}
