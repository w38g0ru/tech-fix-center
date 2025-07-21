<?php

namespace App\Controllers;

use App\Models\AdminUserModel;

class Technicians extends BaseController
{
    protected $adminUserModel;

    public function __construct()
    {
        $this->adminUserModel = new AdminUserModel();

        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user can create technicians (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to access technicians.');
        }

        $search = $this->request->getGet('search');
        $perPage = 20; // Items per page

        if ($search) {
            $technicians = $this->adminUserModel->searchTechnicians($search, $perPage);
        } else {
            $technicians = $this->adminUserModel->getTechnicians($perPage);
        }

        // Get technician statistics
        $technicianStats = $this->adminUserModel->getTechnicianStats();

        $data = [
            'title' => 'Technicians',
            'technicians' => $technicians,
            'pager' => $this->adminUserModel->pager,
            'search' => $search,
            'technicianStats' => $technicianStats
        ];

        return view('dashboard/technicians/index', $data);
    }

    // Note: Technician creation is now handled through User Management
    // Use /dashboard/user-management/create to add new technicians

    public function view($id)
    {
        // Check if user can view technicians
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view technicians.');
        }

        $technician = $this->adminUserModel->where('role', 'technician')->find($id);

        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        $data = [
            'title' => 'Technician Details',
            'technician' => $technician
        ];

        return view('dashboard/technicians/view', $data);
    }

    // Note: Technician editing and deletion is now handled through User Management
    // Use /dashboard/user-management to edit or delete technicians
}
