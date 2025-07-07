<?php

namespace App\Controllers;

use App\Models\TechnicianModel;

class Technicians extends BaseController
{
    protected $technicianModel;

    public function __construct()
    {
        $this->technicianModel = new TechnicianModel();

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

        $technicians = $this->technicianModel->findAll();

        $data = [
            'title' => 'Technicians',
            'technicians' => $technicians
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
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'contact_number' => $this->request->getPost('contact_number'),
            'role' => $this->request->getPost('role')
        ];

        // Additional validation: only superadmin can create superadmin
        if ($technicianData['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->back()->withInput()->with('error', 'Only super admins can create super admin accounts.');
        }

        // Validate using TechnicianModel
        if (!$this->technicianModel->validate($technicianData)) {
            return redirect()->back()->withInput()->with('errors', $this->technicianModel->errors());
        }

        $technicianData['created_at'] = date('Y-m-d H:i:s');

        if ($this->technicianModel->insert($technicianData)) {
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

        $technician = $this->technicianModel->find($id);
        
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

        $technician = $this->technicianModel->find($id);
        
        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        // Prepare technician data for model validation
        $technicianData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'contact_number' => $this->request->getPost('contact_number'),
            'role' => $this->request->getPost('role')
        ];

        // Additional validation: only superadmin can create/edit superadmin
        if ($technicianData['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->back()->withInput()->with('error', 'Only super admins can assign super admin role.');
        }

        // Validate using TechnicianModel
        if (!$this->technicianModel->validate($technicianData)) {
            return redirect()->back()->withInput()->with('errors', $this->technicianModel->errors());
        }

        if ($this->technicianModel->update($id, $technicianData)) {
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

        $technician = $this->technicianModel->find($id);
        
        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        // Prevent deletion of superadmin by non-superadmin
        if ($technician['role'] === 'superadmin' && !hasRole('superadmin')) {
            return redirect()->to('/dashboard/technicians')->with('error', 'Only super admins can delete super admin accounts.');
        }

        if ($this->technicianModel->delete($id)) {
            return redirect()->to('/dashboard/technicians')->with('success', 'Technician deleted successfully!');
        } else {
            return redirect()->to('/dashboard/technicians')->with('error', 'Failed to delete technician.');
        }
    }
}
