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
            return redirect()->to(base_url('auth/login'));
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied. Admin privileges required.');
        }

        $perPage = 20; // Items per page
        $serviceCenters = $this->serviceCenterModel->getServiceCentersWithJobCounts($perPage);

        $data = [
            'title' => 'Service Centers',
            'serviceCenters' => $serviceCenters,
            'stats' => $this->serviceCenterModel->getServiceCenterStats(),
            'pager' => $this->serviceCenterModel->pager
        ];

        return view('dashboard/service_centers/index', $data);
    }

    public function create()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied. Admin privileges required.');
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
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Authentication required']);
            }
            return redirect()->to(base_url('auth/login'));
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Access denied. Admin privileges required.']);
            }
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied. Admin privileges required.');
        }

        // Prepare service center data for model validation
        $serviceCenterData = [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status') ?: 'Active'
        ];

        // Validate using model validation rules
        if (!$this->serviceCenterModel->validate($serviceCenterData)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $this->serviceCenterModel->errors()
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->serviceCenterModel->errors());
        }

        // Save service center
        $serviceCenterId = $this->serviceCenterModel->insert($serviceCenterData);
        if ($serviceCenterId) {
            $serviceCenter = $this->serviceCenterModel->find($serviceCenterId);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Service center added successfully!',
                    'service_center' => $serviceCenter
                ]);
            }
            return redirect()->to('/dashboard/service-centers')
                           ->with('success', 'Service center added successfully!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to add service center. Please try again.']);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to add service center. Please try again.');
        }
    }

    public function edit($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied. Admin privileges required.');
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
            return redirect()->to(base_url('auth/login'));
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied. Admin privileges required.');
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
            return redirect()->to(base_url('dashboard/service-centers'))
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
            return redirect()->to(base_url('auth/login'));
        }

        // Check if user has admin privileges
        if (!hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied. Admin privileges required.');
        }

        $serviceCenter = $this->serviceCenterModel->find($id);

        if (!$serviceCenter) {
            return redirect()->to(base_url('dashboard/service-centers'))
                           ->with('error', 'Service center not found.');
        }

        // Check if service center has associated jobs
        $jobModel = new \App\Models\JobModel();
        $jobCount = $jobModel->where('service_center_id', $id)->countAllResults();

        if ($jobCount > 0) {
            return redirect()->to(base_url('dashboard/service-centers'))
                           ->with('error', 'Cannot delete service center. It has associated jobs.');
        }

        if ($this->serviceCenterModel->delete($id)) {
            return redirect()->to(base_url('dashboard/service-centers'))
                           ->with('success', 'Service center deleted successfully!');
        } else {
            return redirect()->to(base_url('dashboard/service-centers'))
                           ->with('error', 'Failed to delete service center. Please try again.');
        }
    }

    public function search()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $search = $this->request->getGet('search');
        
        if (empty($search)) {
            return redirect()->to(base_url('dashboard/service-centers'));
        }

        $perPage = 20; // Items per page
        $serviceCenters = $this->serviceCenterModel->searchServiceCenters($search, $perPage);

        $data = [
            'title' => 'Search Results - Service Centers',
            'serviceCenters' => $serviceCenters,
            'search' => $search,
            'stats' => $this->serviceCenterModel->getServiceCenterStats(),
            'pager' => $this->serviceCenterModel->pager
        ];

        return view('dashboard/service_centers/index', $data);
    }
}
