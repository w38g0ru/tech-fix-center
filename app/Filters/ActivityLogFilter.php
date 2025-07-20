<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ActivityLogFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Nothing to do before request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Load activity helper
        helper('activity');
        helper('auth');
        
        // Only log if user is logged in
        if (!isLoggedIn()) {
            return;
        }
        
        $userId = getUserId();
        if (!$userId) {
            return;
        }
        
        // Only log POST requests (data submissions)
        if ($request->getMethod() !== 'POST') {
            return;
        }
        
        // Get the current URI
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        // Skip certain POST requests that shouldn't be logged
        $skipPaths = [
            '/auth/processLogin',
            '/auth/processForgotPassword',
            '/auth/logout'
        ];
        
        foreach ($skipPaths as $skipPath) {
            if (strpos($path, $skipPath) !== false) {
                return;
            }
        }
        
        // Determine what was posted based on the URL
        $details = $this->generateActivityDetails($path, $request);
        
        // Log the POST activity
        if ($details) {
            log_post_activity($userId, $details);
        }
    }
    
    /**
     * Generate activity details based on the request path and data
     */
    private function generateActivityDetails(string $path, RequestInterface $request): ?string
    {
        // Remove leading slash and split path
        $pathParts = explode('/', trim($path, '/'));
        
        // Skip if path is too short
        if (count($pathParts) < 2) {
            return null;
        }
        
        $module = $pathParts[1] ?? '';
        $action = $pathParts[2] ?? '';
        
        // Generate details based on common patterns
        switch ($action) {
            case 'store':
                return $this->getStoreDetails($module, $request);
            case 'update':
                return $this->getUpdateDetails($module, $request, $pathParts);
            case 'approve':
            case 'reject':
            case 'complete':
            case 'cancel':
                return $this->getStatusChangeDetails($module, $action, $pathParts);
            default:
                // Generic POST activity
                return "Posted data to {$module}/{$action}";
        }
    }
    
    /**
     * Get details for store (create) operations
     */
    private function getStoreDetails(string $module, RequestInterface $request): string
    {
        $moduleNames = [
            'jobs' => 'job',
            'users' => 'user',
            'technicians' => 'technician',
            'inventory' => 'inventory item',
            'dispatch' => 'dispatch',
            'referred' => 'referred job',
            'movements' => 'inventory movement',
            'photos' => 'photo',
            'bug-reports' => 'bug report',
            'parts-requests' => 'parts request'
        ];
        
        $itemName = $moduleNames[$module] ?? $module;
        
        // Try to get a name or identifier from the POST data
        $postData = $request->getPost();
        $identifier = '';
        
        if (isset($postData['name'])) {
            $identifier = " '{$postData['name']}'";
        } elseif (isset($postData['title'])) {
            $identifier = " '{$postData['title']}'";
        } elseif (isset($postData['customer_name'])) {
            $identifier = " for customer '{$postData['customer_name']}'";
        } elseif (isset($postData['device_model'])) {
            $identifier = " for device '{$postData['device_model']}'";
        }
        
        return "Created new {$itemName}{$identifier}";
    }
    
    /**
     * Get details for update operations
     */
    private function getUpdateDetails(string $module, RequestInterface $request, array $pathParts): string
    {
        $moduleNames = [
            'jobs' => 'job',
            'users' => 'user',
            'technicians' => 'technician',
            'inventory' => 'inventory item',
            'dispatch' => 'dispatch',
            'referred' => 'referred job',
            'movements' => 'inventory movement',
            'photos' => 'photo',
            'bug-reports' => 'bug report',
            'parts-requests' => 'parts request'
        ];
        
        $itemName = $moduleNames[$module] ?? $module;
        $itemId = $pathParts[3] ?? '';
        
        return "Updated {$itemName}" . ($itemId ? " (ID: {$itemId})" : '');
    }
    
    /**
     * Get details for status change operations
     */
    private function getStatusChangeDetails(string $module, string $action, array $pathParts): string
    {
        $moduleNames = [
            'jobs' => 'job',
            'users' => 'user',
            'technicians' => 'technician',
            'inventory' => 'inventory item',
            'dispatch' => 'dispatch',
            'referred' => 'referred job',
            'movements' => 'inventory movement',
            'photos' => 'photo',
            'bug-reports' => 'bug report',
            'parts-requests' => 'parts request'
        ];
        
        $itemName = $moduleNames[$module] ?? $module;
        $itemId = $pathParts[3] ?? '';
        $actionName = ucfirst($action);
        
        return "{$actionName} {$itemName}" . ($itemId ? " (ID: {$itemId})" : '');
    }
}
