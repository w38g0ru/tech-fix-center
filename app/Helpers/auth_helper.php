<?php

if (!function_exists('getCurrentUser')) {
    /**
     * Get current logged in user from session
     */
    function getCurrentUser()
    {
        if (session()->get('isLoggedIn')) {
            return [
                'id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'full_name' => session()->get('full_name'),
                'role' => session()->get('role'),
                'isLoggedIn' => session()->get('isLoggedIn')
            ];
        }

        return null;
    }
}

if (!function_exists('hasRole')) {
    /**
     * Check if current user has specific role
     */
    function hasRole($role)
    {
        $user = getCurrentUser();
        return $user && $user['role'] === $role;
    }
}

if (!function_exists('hasAnyRole')) {
    /**
     * Check if current user has any of the specified roles
     */
    function hasAnyRole($roles)
    {
        $user = getCurrentUser();
        return $user && in_array($user['role'], $roles);
    }
}

if (!function_exists('isLoggedIn')) {
    /**
     * Check if user is logged in
     */
    function isLoggedIn()
    {
        return session()->get('isLoggedIn') === true;
    }
}

if (!function_exists('canCreateTechnician')) {
    /**
     * Check if user can create technicians (admin only)
     */
    function canCreateTechnician()
    {
        return hasAnyRole(['superadmin', 'admin']);
    }
}

if (!function_exists('canDeleteUser')) {
    /**
     * Check if user can delete users (admin only)
     */
    function canDeleteUser()
    {
        return hasAnyRole(['superadmin', 'admin']);
    }
}

if (!function_exists('canDeleteJob')) {
    /**
     * Check if user can delete jobs (admin only)
     */
    function canDeleteJob()
    {
        return hasAnyRole(['superadmin', 'admin']);
    }
}

if (!function_exists('canEditTechnician')) {
    /**
     * Check if user can edit technicians
     */
    function canEditTechnician()
    {
        return hasAnyRole(['superadmin', 'admin']);
    }
}

if (!function_exists('canViewAllJobs')) {
    /**
     * Check if user can view all jobs
     */
    function canViewAllJobs()
    {
        return hasAnyRole(['superadmin', 'admin']);
    }
}

if (!function_exists('canManageInventory')) {
    /**
     * Check if user can manage inventory
     */
    function canManageInventory()
    {
        return hasAnyRole(['superadmin', 'admin', 'technician']);
    }
}

if (!function_exists('getRoleColor')) {
    /**
     * Get color class for role badge
     */
    function getRoleColor($role)
    {
        return match($role) {
            'superadmin' => 'bg-red-100 text-red-800',
            'admin' => 'bg-purple-100 text-purple-800',
            'technician' => 'bg-blue-100 text-blue-800',
            'user' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}

if (!function_exists('getRoleIcon')) {
    /**
     * Get icon for role
     */
    function getRoleIcon($role)
    {
        return match($role) {
            'superadmin' => 'fas fa-crown',
            'admin' => 'fas fa-user-shield',
            'technician' => 'fas fa-user-cog',
            'user' => 'fas fa-user',
            default => 'fas fa-user'
        };
    }
}

if (!function_exists('getUserId')) {
    /**
     * Get current user ID
     */
    function getUserId()
    {
        return session()->get('user_id');
    }
}

if (!function_exists('getUserRole')) {
    /**
     * Get current user role
     */
    function getUserRole()
    {
        return session()->get('role');
    }
}

if (!function_exists('getUserName')) {
    /**
     * Get current user name
     */
    function getUserName()
    {
        return session()->get('name');
    }
}

if (!function_exists('getUserEmail')) {
    /**
     * Get current user email
     */
    function getUserEmail()
    {
        return session()->get('email');
    }
}

if (!function_exists('clearSecureSession')) {
    /**
     * Securely clear user session and logout
     */
    function clearSecureSession()
    {
        $session = session();

        // Log the logout action before clearing session
        $userId = $session->get('user_id');
        $username = $session->get('username') ?? $session->get('name');

        if ($userId) {
            log_message('info', "User logout: ID {$userId}, Username: {$username}");
        }

        // Clear any remember me cookies if they exist
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }

        // Check if session is active before trying to regenerate
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Clear all session data
            $session->destroy();
        } else {
            // If no active session, just clear any session variables
            if (isset($_SESSION)) {
                $_SESSION = [];
            }
        }

        return true;
    }
}

if (!function_exists('isSessionValid')) {
    /**
     * Check if current session is valid
     */
    function isSessionValid()
    {
        // Check if session is active
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }

        $session = session();

        // Check if session exists and has required data
        if (!$session->get('isLoggedIn') || !$session->get('user_id')) {
            return false;
        }

        // Check session timeout (optional - can be configured)
        $lastActivity = $session->get('last_activity');
        if ($lastActivity && (time() - $lastActivity > 7200)) { // 2 hours timeout
            // Clear expired session
            clearSecureSession();
            return false;
        }

        // Update last activity
        $session->set('last_activity', time());

        return true;
    }
}


