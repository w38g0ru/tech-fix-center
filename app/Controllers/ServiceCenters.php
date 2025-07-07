<?php

namespace App\Controllers;

use App\Models\ServiceCenterModel;

class ServiceCenters extends BaseController
{
    protected $serviceCenterModel;

    public function __construct()
    {
        $this->serviceCenterModel = new ServiceCenterModel();
        
        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $data = [
            'title' => 'Service Centers',
            'serviceCenters' => $this->serviceCenterModel->getServiceCentersWithJobCounts(),
            'stats' => $this->serviceCenterModel->getServiceCenterStats()
        ];

        return view('dashboard/service_centers/index', $data);
    }

    public function create()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $data = [
            'title' => 'Add New Service Center'
        ];

        return view('dashboard/service_centers/create', $data);
    }

    public function store()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        // Prepare service center data for model validation
        $serviceCenterData = [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status')
        ];

        // Validate using model validation rules
        if (!$this->serviceCenterModel->validate($serviceCenterData)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->serviceCenterModel->errors());
        }

        // Save service center
        if ($this->serviceCenterModel->save($serviceCenterData)) {
            return redirect()->to('/service-centers')
                           ->with('success', 'Service center added successfully!');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to add service center. Please try again.');
        }
    }

    public function edit($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $serviceCenter = $this->serviceCenterModel->find($id);
        
        if (!$serviceCenter) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Service center not found');
        }

        $data = [
            'title' => 'Edit Service Center',
            'serviceCenter' => $serviceCenter
        ];

        return view('dashboard/service_centers/edit', $data);
    }

    public function update($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $serviceCenter = $this->serviceCenterModel->find($id);
        
        if (!$serviceCenter) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Service center not found');
        }

        // Prepare service center data for model validation
        $serviceCenterData = [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status')
        ];

        // Validate using model validation rules
        if (!$this->serviceCenterModel->validate($serviceCenterData)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->serviceCenterModel->errors());
        }

        // Update service center
        if ($this->serviceCenterModel->update($id, $serviceCenterData)) {
            return redirect()->to('/service-centers')
                           ->with('success', 'Service center updated successfully!');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update service center. Please try again.');
        }
    }

    public function delete($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user has admin privileges
        if (!hasRole(['superadmin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $serviceCenter = $this->serviceCenterModel->find($id);
        
        if (!$serviceCenter) {
            return redirect()->to('/service-centers')
                           ->with('error', 'Service center not found.');
        }

        // Check if service center has associated jobs
        $jobModel = new \App\Models\JobModel();
        $jobCount = $jobModel->where('service_center_id', $id)->countAllResults();
        
        if ($jobCount > 0) {
            return redirect()->to('/service-centers')
                           ->with('error', 'Cannot delete service center. It has associated jobs.');
        }

        if ($this->serviceCenterModel->delete($id)) {
            return redirect()->to('/service-centers')
                           ->with('success', 'Service center deleted successfully!');
        } else {
            return redirect()->to('/service-centers')
                           ->with('error', 'Failed to delete service center. Please try again.');
        }
    }

    public function search()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $search = $this->request->getGet('search');
        
        if (empty($search)) {
            return redirect()->to('/service-centers');
        }

        $data = [
            'title' => 'Search Results - Service Centers',
            'serviceCenters' => $this->serviceCenterModel->searchServiceCenters($search),
            'search' => $search,
            'stats' => $this->serviceCenterModel->getServiceCenterStats()
        ];

        return view('dashboard/service_centers/index', $data);
    }
}
