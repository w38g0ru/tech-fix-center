<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ActivityLogFilter implements FilterInterface
{
    private array $modules = [
        'jobs'           => 'job',
        'users'          => 'user',
        'technicians'    => 'technician',
        'inventory'      => 'inventory item',
        'dispatch'       => 'dispatch',
        'referred'       => 'referred job',
        'movements'      => 'inventory movement',
        'photos'         => 'photo',
        'bug-reports'    => 'bug report',
        'parts-requests' => 'parts request'
    ];

    private array $skipPaths = [
        'auth/processLogin',
        'auth/processForgotPassword',
        'auth/logout'
    ];

    public function before(RequestInterface $request, $arguments = null) {}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        helper(['activity', 'auth']);

        if (!isLoggedIn() || $request->getMethod() !== 'POST') return;

        $path = trim($request->getUri()->getPath(), '/');
        foreach ($this->skipPaths as $skip) {
            if (stripos($path, $skip) !== false) return;
        }

        $parts      = explode('/', $path);
        $module     = $this->modules[$parts[1] ?? ''] ?? ($parts[1] ?? '');
        $action     = $parts[2] ?? '';
        $id         = $parts[3] ?? '';
        $identifier = $this->getIdentifier($request);

        $details = match ($action) {
            'store'   => "Created new {$module}{$identifier}",
            'update'  => "Updated {$module}" . ($id ? " (ID: {$id})" : ''),
            'approve', 'reject', 'complete', 'cancel'
                      => ucfirst($action) . " {$module}" . ($id ? " (ID: {$id})" : ''),
            default   => "Posted data to {$parts[1]}/{$action}"
        };

        log_post_activity(getUserId(), $details);
    }

    private function getIdentifier(RequestInterface $request): string
    {
        foreach (['name', 'title', 'customer_name', 'device_model'] as $field) {
            if ($value = $request->getPost($field)) {
                return " '{$value}'";
            }
        }
        return '';
    }
}
