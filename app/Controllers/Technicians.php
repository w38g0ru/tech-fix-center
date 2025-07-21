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

        $perPage = 20; // Items per page
        $technicians = $this->adminUserModel->getTechnicians($perPage);

        $data = [
            'title' => 'Technicians',
            'technicians' => $technicians,
            'pager' => $this->adminUserModel->pager
        ];

        return view('dashboard/technicians/index', $data);
    }

    public function create()
    {
        // Check if user can create technicians (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to create technicians.');
        }

        $data = ['title' => 'Add New Technician'];
        return view('dashboard/technicians/create', $data);
    }

    public function store()
    {
        // Check if user can create technicians (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to create technicians.');
        }

        // Prepare technician data for model validation
        $technicianData = [
            'full_name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('contact_number'),
            'role' => 'technician', // Always set to technician
            'status' => 'active',
            'password' => $this->request->getPost('password') ?: 'technician123'
        ];

        // Generate username from name if not provided
        if (!$this->request->getPost('username')) {
            $technicianData['username'] = $this->generateUsernameFromName($technicianData['full_name']);
        } else {
            $technicianData['username'] = $this->request->getPost('username');
        }

        // Validate using AdminUserModel
        if (!$this->adminUserModel->validate($technicianData)) {
            return redirect()->back()->withInput()->with('errors', $this->adminUserModel->errors());
        }

        if ($this->adminUserModel->insert($technicianData)) {
            // Log activity
            helper('activity');
            log_post_activity(getUserId(), "Created technician: {$technicianData['full_name']}");

            return redirect()->to('/dashboard/technicians')->with('success', 'Technician created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create technician.');
        }
    }

    public function view($id)
    {
        // Check if user can view technicians
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to view technicians.');
        }

        $technician = $this->technicianModel->find($id);
        
        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        $data = [
            'title' => 'Technician Details',
            'technician' => $technician
        ];

        return view('dashboard/technicians/view', $data);
    }

    public function edit($id)
    {
        // Check if user can create technicians (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to edit technicians.');
        }

        $technician = $this->adminUserModel->where('role', 'technician')->find($id);

        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        $data = [
            'title' => 'Edit Technician',
            'technician' => $technician
        ];

        return view('dashboard/technicians/edit', $data);
    }

    public function update($id)
    {
        // Check if user can create technicians (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to update technicians.');
        }

        $technician = $this->adminUserModel->where('role', 'technician')->find($id);

        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        // Prepare technician data for model validation
        $technicianData = [
            'full_name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('contact_number'),
            'username' => $this->request->getPost('username') ?: $technician['username'],
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $technicianData['password'] = $this->request->getPost('password');
        }

        // Validate using AdminUserModel (skip unique validation for current record)
        $this->adminUserModel->setValidationRule('email', 'required|valid_email|max_length[255]|is_unique[admin_users.email,id,' . $id . ']');
        $this->adminUserModel->setValidationRule('username', 'required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[admin_users.username,id,' . $id . ']');

        if (!$this->adminUserModel->validate($technicianData)) {
            return redirect()->back()->withInput()->with('errors', $this->adminUserModel->errors());
        }

        if ($this->adminUserModel->update($id, $technicianData)) {
            // Log activity
            helper('activity');
            log_post_activity(getUserId(), "Updated technician: {$technicianData['full_name']}");

            return redirect()->to('/dashboard/technicians')->with('success', 'Technician updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update technician.');
        }
    }

    public function delete($id)
    {
        // Check if user can create technicians (admin or superadmin only)
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to delete technicians.');
        }

        $technician = $this->adminUserModel->where('role', 'technician')->find($id);

        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        // Check if technician has active jobs
        $jobModel = new \App\Models\JobModel();
        $activeJobs = $jobModel->where('technician_id', $id)
                              ->whereIn('status', ['Pending', 'In Progress', 'Parts Pending'])
                              ->countAllResults();

        if ($activeJobs > 0) {
            return redirect()->to('/dashboard/technicians')->with('error', 'Cannot delete technician with active jobs. Please reassign or complete the jobs first.');
        }

        if ($this->adminUserModel->delete($id)) {
            // Log activity
            helper('activity');
            log_post_activity(getUserId(), "Deleted technician: {$technician['full_name']}");

            return redirect()->to('/dashboard/technicians')->with('success', 'Technician deleted successfully!');
        } else {
            return redirect()->to('/dashboard/technicians')->with('error', 'Failed to delete technician.');
        }
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

        while ($this->adminUserModel->where('username', $username)->first()) {
            $username = $originalUsername . '_' . $counter;
            $counter++;
        }

        return $username;
    }
}
