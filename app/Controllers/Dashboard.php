<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TechnicianModel;
use App\Models\JobModel;
use App\Models\InventoryItemModel;
use App\Models\InventoryMovementModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $technicianModel;
    protected $jobModel;
    protected $inventoryModel;
    protected $movementModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->technicianModel = new TechnicianModel();
        $this->jobModel = new JobModel();
        $this->inventoryModel = new InventoryItemModel();
        $this->movementModel = new InventoryMovementModel();

        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }
        $data = [
            'title' => 'Dashboard',
            'userStats' => $this->userModel->getUserStats(),
            'jobStats' => $this->jobModel->getJobStats(),
            'inventoryStats' => $this->inventoryModel->getInventoryStats(),
            'technicianStats' => $this->technicianModel->getTechnicianStats(),
            'recentJobs' => $this->jobModel->getRecentJobs(5),
            'recentMovements' => $this->movementModel->getRecentMovements(5),
            'lowStockItems' => $this->inventoryModel->getLowStockItems(10)
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
            $technicians = $this->technicianModel->searchTechnicians($search);
        } else {
            $technicians = $this->technicianModel->getTechniciansWithJobCount();
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
            'name' => $this->request->getPost('name'),
            'contact_number' => $this->request->getPost('contact_number'),
            'role' => $this->request->getPost('role')
        ];

        if ($this->technicianModel->insert($data)) {
            return redirect()->to('/dashboard/technicians')->with('success', 'Technician added successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add technician.');
        }
    }

    public function editTechnician($id)
    {
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

    public function updateTechnician($id)
    {
        $technician = $this->technicianModel->find($id);
        
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
            'name' => $this->request->getPost('name'),
            'contact_number' => $this->request->getPost('contact_number')
        ];

        if ($this->technicianModel->update($id, $data)) {
            return redirect()->to('/dashboard/technicians')->with('success', 'Technician updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update technician.');
        }
    }

    public function deleteTechnician($id)
    {
        $technician = $this->technicianModel->find($id);
        
        if (!$technician) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Technician not found');
        }

        if ($this->technicianModel->delete($id)) {
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

    public function mobileTest()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $data = ['title' => 'Mobile Test'];
        return view('dashboard/mobile_test', $data);
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


}
