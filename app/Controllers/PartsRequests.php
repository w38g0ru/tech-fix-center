<?php

namespace App\Controllers;

use App\Models\PartsRequestModel;
use App\Models\AdminUserModel;
use App\Models\JobModel;

class PartsRequests extends BaseController
{
    protected $partsRequestModel;
    protected $adminUserModel;
    protected $jobModel;

    public function __construct()
    {
        $this->partsRequestModel = new PartsRequestModel();
        $this->adminUserModel = new AdminUserModel();
        $this->jobModel = new JobModel();
        
        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $userRole = getUserRole();
        $userId = getUserId();
        $perPage = 20; // Items per page

        // Get parts requests based on user role
        if (in_array($userRole, ['superadmin', 'admin'])) {
            $partsRequests = $this->partsRequestModel->getPartsRequestsWithDetails($perPage);
        } elseif ($userRole === 'technician') {
            // Get technician ID from admin_users table
            $technicianId = $this->getTechnicianIdByUserId($userId);
            $partsRequests = $this->partsRequestModel->getPartsRequestsByTechnician($technicianId);
        } else {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied.');
        }

        // Calculate statistics
        $stats = [
            'total' => count($partsRequests),
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
            'received' => 0,
            'ordered' => 0,
            'cancelled' => 0
        ];

        foreach ($partsRequests as $request) {
            $status = strtolower($request['status']);
            if (isset($stats[$status])) {
                $stats[$status]++;
            }
        }

        $data = [
            'title' => 'Parts Requests',
            'partsRequests' => $partsRequests ?: [],
            'userRole' => $userRole,
            'stats' => $stats,
            'pager' => $this->partsRequestModel->pager
        ];

        return view('dashboard/parts_requests/index', $data);
    }

    public function create()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        // Only technicians can create parts requests
        if (!hasRole('technician')) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Only technicians can create parts requests.');
        }

        $data = [
            'title' => 'Create Parts Request',
            'technicians' => $this->adminUserModel->getTechnicians(),
            'jobs' => $this->jobModel->getJobsWithDetails(),
            'urgencyLevels' => $this->partsRequestModel->getUrgencyLevels()
        ];

        return view('dashboard/parts_requests/create', $data);
    }

    public function store()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        // Only technicians can create parts requests
        if (!hasRole('technician')) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Only technicians can create parts requests.');
        }

        // Prepare parts request data
        $partsRequestData = [
            'technician_id' => $this->request->getPost('technician_id'),
            'job_id' => $this->request->getPost('job_id') ?: null,
            'item_name' => $this->request->getPost('item_name'),
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'quantity_requested' => $this->request->getPost('quantity_requested'),
            'description' => $this->request->getPost('description'),
            'urgency' => $this->request->getPost('urgency'),
            'status' => 'Pending',
            'requested_by' => getUserId(),
            'notes' => $this->request->getPost('notes')
        ];

        // Validate using model validation rules
        if (!$this->partsRequestModel->validate($partsRequestData)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->partsRequestModel->errors());
        }

        // Save parts request
        if ($this->partsRequestModel->save($partsRequestData)) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('success', 'Parts request submitted successfully!');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to submit parts request. Please try again.');
        }
    }

    public function view($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $partsRequest = $this->partsRequestModel->getPartsRequestWithDetails($id);
        
        if (!$partsRequest) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parts request not found');
        }

        // Check access permissions
        $userRole = getUserRole();
        $userId = getUserId();
        
        if ($userRole === 'technician') {
            $technicianId = $this->getTechnicianIdByUserId($userId);
            if ($partsRequest['technician_id'] != $technicianId && $partsRequest['requested_by'] != $userId) {
                return redirect()->to(base_url('dashboard/parts-requests'))->with('error', 'Access denied.');
            }
        }

        $data = [
            'title' => 'Parts Request Details',
            'partsRequest' => $partsRequest,
            'userRole' => $userRole
        ];

        return view('dashboard/parts_requests/view', $data);
    }

    public function edit($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $userRole = getUserRole();
        $userId = getUserId();

        // Only technicians who created the request or admins can edit
        $partsRequest = $this->partsRequestModel->find($id);

        if (!$partsRequest) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Parts request not found.');
        }

        // Check permissions
        if ($userRole === 'technician') {
            $technicianId = $this->getTechnicianIdByUserId($userId);
            if ($partsRequest['technician_id'] != $technicianId) {
                return redirect()->to(base_url('dashboard/parts-requests'))
                               ->with('error', 'You can only edit your own parts requests.');
            }

            // Technicians can only edit pending requests
            if ($partsRequest['status'] !== 'Pending') {
                return redirect()->to(base_url('dashboard/parts-requests'))
                               ->with('error', 'You can only edit pending parts requests.');
            }
        } elseif (!in_array($userRole, ['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied.');
        }

        $data = [
            'title' => 'Edit Parts Request',
            'partsRequest' => $partsRequest,
            'technicians' => $this->adminUserModel->getTechnicians(),
            'jobs' => $this->jobModel->getJobsWithDetails(),
            'urgencyLevels' => $this->partsRequestModel->getUrgencyLevels(),
            'userRole' => $userRole
        ];

        return view('dashboard/parts_requests/edit', $data);
    }

    public function update($id)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to(base_url('auth/login'));
        }

        $userRole = getUserRole();
        $userId = getUserId();

        $partsRequest = $this->partsRequestModel->find($id);

        if (!$partsRequest) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Parts request not found.');
        }

        // Check permissions
        if ($userRole === 'technician') {
            $technicianId = $this->getTechnicianIdByUserId($userId);
            if ($partsRequest['technician_id'] != $technicianId || $partsRequest['status'] !== 'Pending') {
                return redirect()->to(base_url('dashboard/parts-requests'))
                               ->with('error', 'You can only edit your own pending parts requests.');
            }
        } elseif (!in_array($userRole, ['superadmin', 'admin'])) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied.');
        }

        // Validate input
        $rules = [
            'part_name' => 'required|max_length[255]',
            'part_number' => 'permit_empty|max_length[100]',
            'quantity' => 'required|integer|greater_than[0]',
            'urgency' => 'required|in_list[Low,Medium,High,Critical]',
            'estimated_cost' => 'permit_empty|decimal',
            'supplier_preference' => 'permit_empty|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'expected_delivery_date' => 'permit_empty|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'part_name' => $this->request->getPost('part_name'),
            'part_number' => $this->request->getPost('part_number'),
            'quantity' => $this->request->getPost('quantity'),
            'urgency' => $this->request->getPost('urgency'),
            'estimated_cost' => $this->request->getPost('estimated_cost'),
            'supplier_preference' => $this->request->getPost('supplier_preference'),
            'description' => $this->request->getPost('description'),
            'expected_delivery_date' => $this->request->getPost('expected_delivery_date'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Only admins can change job assignment
        if (in_array($userRole, ['superadmin', 'admin'])) {
            $updateData['job_id'] = $this->request->getPost('job_id');
            $updateData['technician_id'] = $this->request->getPost('technician_id');
        }

        if ($this->partsRequestModel->update($id, $updateData)) {
            // Log activity
            helper('activity');
            log_post_activity(getUserId(), "Updated parts request: {$updateData['part_name']}");

            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('success', 'Parts request updated successfully!');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update parts request. Please try again.');
        }
    }

    public function approve($id)
    {
        // Check if user is logged in and has admin privileges
        if (!isLoggedIn() || !hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('auth/login'));
        }

        $partsRequest = $this->partsRequestModel->find($id);
        
        if (!$partsRequest) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Parts request not found.');
        }

        if ($partsRequest['status'] !== 'Pending') {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Only pending requests can be approved.');
        }

        $updateData = [
            'status' => 'Approved',
            'approved_by' => getUserId(),
            'approved_at' => date('Y-m-d H:i:s'),
            'estimated_cost' => $this->request->getPost('estimated_cost'),
            'supplier' => $this->request->getPost('supplier'),
            'expected_delivery_date' => $this->request->getPost('expected_delivery_date'),
            'notes' => $this->request->getPost('notes')
        ];

        if ($this->partsRequestModel->update($id, $updateData)) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('success', 'Parts request approved successfully!');
        } else {
            return redirect()->back()
                           ->with('error', 'Failed to approve parts request. Please try again.');
        }
    }

    public function reject($id)
    {
        // Check if user is logged in and has admin privileges
        if (!isLoggedIn() || !hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('auth/login'));
        }

        $partsRequest = $this->partsRequestModel->find($id);

        if (!$partsRequest) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Parts request not found.');
        }

        if ($partsRequest['status'] !== 'Pending') {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Only pending requests can be rejected.');
        }

        $updateData = [
            'status' => 'Rejected',
            'approved_by' => getUserId(),
            'approved_at' => date('Y-m-d H:i:s'),
            'rejection_reason' => $this->request->getPost('rejection_reason')
        ];

        if ($this->partsRequestModel->update($id, $updateData)) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('success', 'Parts request rejected.');
        } else {
            return redirect()->back()
                           ->with('error', 'Failed to reject parts request. Please try again.');
        }
    }

    public function updateStatus($id)
    {
        // Check if user is logged in and has admin privileges
        if (!isLoggedIn() || !hasAnyRole(['superadmin', 'admin'])) {
            return redirect()->to(base_url('auth/login'));
        }

        $partsRequest = $this->partsRequestModel->find($id);

        if (!$partsRequest) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('error', 'Parts request not found.');
        }

        $newStatus = $this->request->getPost('status');
        $updateData = ['status' => $newStatus];

        // Add additional fields based on status
        if ($newStatus === 'Ordered') {
            $updateData['order_date'] = $this->request->getPost('order_date') ?: date('Y-m-d');
            $updateData['actual_cost'] = $this->request->getPost('actual_cost');
        } elseif ($newStatus === 'Received') {
            $updateData['actual_delivery_date'] = $this->request->getPost('actual_delivery_date') ?: date('Y-m-d');
        }

        if ($this->partsRequestModel->update($id, $updateData)) {
            return redirect()->to(base_url('dashboard/parts-requests'))
                           ->with('success', 'Parts request status updated successfully!');
        } else {
            return redirect()->back()
                           ->with('error', 'Failed to update status. Please try again.');
        }
    }

    private function getTechnicianIdByUserId($userId)
    {
        // Since technicians are now in admin_users table, just return the user ID
        // if the user has technician role
        $adminUser = $this->adminUserModel->where('id', $userId)
                                          ->where('role', 'technician')
                                          ->first();
        return $adminUser ? $adminUser['id'] : null;
    }
}
