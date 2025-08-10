<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdminUserModel;
use App\Models\JobModel;
use App\Models\InventoryItemModel;
use App\Models\InventoryMovementModel;
use App\Models\ReferredModel;
use App\Models\ServiceCenterModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $adminUserModel;
    protected $jobModel;
    protected $inventoryModel;
    protected $movementModel;
    protected $referredModel;
    protected $serviceCenterModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->adminUserModel = new AdminUserModel();
        $this->jobModel = new JobModel();
        $this->inventoryModel = new InventoryItemModel();
        $this->movementModel = new InventoryMovementModel();
        $this->referredModel = new ReferredModel();
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
        // Get comprehensive dashboard data
        $jobStats = $this->jobModel->getJobStats();
        $jobsRequiringAttention = $this->jobModel->getJobsRequiringAttention();
        $referredStats = $this->referredModel->getReferredStats();

        $data = [
            'title' => 'Dashboard',
            'userStats' => $this->userModel->getUserStats(),
            'jobStats' => $jobStats,
            'inventoryStats' => $this->inventoryModel->getInventoryStats(),
            'technicianStats' => $this->adminUserModel->getTechnicianStats(),
            'referredStats' => $referredStats,
            'recentJobs' => $this->jobModel->getRecentJobs(5),
            'recentMovements' => $this->movementModel->getRecentMovements(5),
            'lowStockItems' => $this->inventoryModel->getLowStockItems(5, 10),
            'jobsRequiringAttention' => $jobsRequiringAttention,
            'overdueJobs' => $jobsRequiringAttention['overdue'] ?? [],
            'readyForDispatch' => $jobsRequiringAttention['ready_for_dispatch'] ?? [],
            'jobsAtServiceCenters' => $this->jobModel->getJobsAtServiceCenters(),
            'overdueFromServiceCenters' => $this->jobModel->getOverdueJobsFromServiceCenters()
        ];

        return view('dashboard/index', $data);
    }

    // Users Management
    public function users()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $search = $this->request->getGet('search');
        
        if ($search) {
            $users = $this->userModel->searchUsers($search);
        } else {
            $users = $this->userModel->getUsersWithJobCount();
        }

        $data = [
            'title' => 'Customers',
            'users' => $users,
            'search' => $search
        ];

        return view('dashboard/users/index', $data);
    }

    public function createUser()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $data = ['title' => 'Add New Customer'];
        return view('dashboard/users/create', $data);
    }

    public function storeUser()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'mobile_number' => 'permit_empty|min_length[10]|max_length[20]',
            'user_type' => 'required|in_list[Registered,Walk-in]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'mobile_number' => $this->request->getPost('mobile_number'),
            'user_type' => $this->request->getPost('user_type')
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to(base_url('dashboard/users'))->with('success', 'Customer added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add customer.');
        }
    }

    public function editUser($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Customer not found');
        }

        $data = [
            'title' => 'Edit Customer',
            'user' => $user
        ];

        return view('dashboard/users/edit', $data);
    }

    public function updateUser($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Customer not found');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'mobile_number' => 'permit_empty|min_length[10]|max_length[20]',
            'user_type' => 'required|in_list[Registered,Walk-in]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'mobile_number' => $this->request->getPost('mobile_number'),
            'user_type' => $this->request->getPost('user_type')
        ];

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/dashboard/users')->with('success', 'Customer updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update customer.');
        }
    }

    public function deleteUser($id)
    {
        // Check if user can delete users
        if (!canDeleteUser()) {
            return redirect()->to('/dashboard/users')->with('error', 'You do not have permission to delete customers.');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Customer not found');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/dashboard/users')->with('success', 'Customer deleted successfully!');
        } else {
            return redirect()->to('/dashboard/users')->with('error', 'Failed to delete customer.');
        }
    }

    // Technicians Management
    public function technicians()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $search = $this->request->getGet('search');
        
        if ($search) {
            $technicians = $this->adminUserModel->searchTechnicians($search);
        } else {
            $technicians = $this->adminUserModel->getAvailableTechnicians();
        }

        $data = [
            'title' => 'Technicians',
            'technicians' => $technicians,
            'search' => $search
        ];

        return view('dashboard/technicians/index', $data);
    }

    public function createTechnician()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user can create technicians
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard/technicians')->with('error', 'You do not have permission to create technicians.');
        }

        $data = ['title' => 'Add New Technician'];
        return view('dashboard/technicians/create', $data);
    }

    public function storeTechnician()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Check if user can create technicians
        if (!canCreateTechnician()) {
            return redirect()->to('/dashboard/technicians')->with('error', 'You do not have permission to create technicians.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'contact_number' => 'permit_empty|min_length[10]|max_length[20]',
            'role' => 'required|in_list[superadmin,admin,technician,user]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('contact_number'),
            'role' => $this->request->getPost('role')
        ];

        if ($this->adminUserModel->createTechnician($data)) {
            return redirect()->to('/dashboard/technicians')->with('success', 'Technician added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add technician.');
        }
    }

    public function editTechnician($id)
    {
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

    public function updateTechnician($id)
    {
        $technician = $this->adminUserModel->where('role', 'technician')->find($id);
        
        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'contact_number' => 'permit_empty|min_length[10]|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('contact_number')
        ];

        if ($this->adminUserModel->update($id, $data)) {
            return redirect()->to('/dashboard/technicians')->with('success', 'Technician updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update technician.');
        }
    }

    public function deleteTechnician($id)
    {
        $technician = $this->adminUserModel->where('role', 'technician')->find($id);

        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        if ($this->adminUserModel->delete($id)) {
            return redirect()->to('/dashboard/technicians')->with('success', 'Technician deleted successfully!');
        } else {
            return redirect()->to('/dashboard/technicians')->with('error', 'Failed to delete technician.');
        }
    }

    public function userGuide()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $data = ['title' => 'User Guide'];
        return view('dashboard/user_guide', $data);
    }



    public function profile()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $data = ['title' => 'Profile'];
        return view('dashboard/profile', $data);
    }

    public function settings()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $data = ['title' => 'Settings'];
        return view('dashboard/settings', $data);
    }

    /**
     * Quick dispatch action - mark job as ready for dispatch
     */
    public function quickDispatch($jobId)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $job = $this->jobModel->find($jobId);

        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }

        // Update job status to ready for dispatch
        if ($this->jobModel->update($jobId, ['status' => 'Ready to Dispatch to Customer'])) {
            return redirect()->back()->with('success', 'Job marked as ready for dispatch!');
        } else {
            return redirect()->back()->with('error', 'Failed to update job status.');
        }
    }

    /**
     * Quick action to refer job to service center
     */
    public function quickRefer($jobId)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $job = $this->jobModel->find($jobId);

        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }

        // Get available service centers
        $serviceCenters = $this->serviceCenterModel->getActiveServiceCenters();

        if (empty($serviceCenters)) {
            return redirect()->back()->with('error', 'No active service centers available.');
        }

        // Use the first available service center (or implement selection logic)
        $serviceCenterId = $serviceCenters[0]['id'];

        if ($this->jobModel->referToServiceCenter($jobId, $serviceCenterId)) {
            return redirect()->back()->with('success', 'Job referred to service center successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to refer job to service center.');
        }
    }

    /**
     * Dashboard API endpoint for real-time updates
     */
    public function apiStats()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $stats = [
            'jobStats' => $this->jobModel->getJobStats(),
            'userStats' => $this->userModel->getUserStats(),
            'referredStats' => $this->referredModel->getReferredStats(),
            'overdueCount' => count($this->jobModel->getJobsRequiringAttention()['overdue'] ?? []),
            'readyForDispatchCount' => count($this->jobModel->getJobsRequiringAttention()['ready_for_dispatch'] ?? []),
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return $this->response->setJSON($stats);
    }

}
