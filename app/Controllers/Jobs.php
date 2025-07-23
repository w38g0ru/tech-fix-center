<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\AdminUserModel;
use App\Models\PhotoModel;
use App\Models\ServiceCenterModel;

class Jobs extends BaseController
{
    protected $jobModel;
    protected $userModel;
    protected $adminUserModel;
    protected $photoModel;
    protected $serviceCenterModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->userModel = new UserModel();
        $this->adminUserModel = new AdminUserModel();
        $this->photoModel = new PhotoModel();
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

        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $perPage = 20; // Items per page

        if ($search) {
            $jobs = $this->jobModel->searchJobs($search, $perPage);
        } elseif ($status) {
            $jobs = $this->jobModel->getJobsByStatus($status, $perPage);
        } else {
            $jobs = $this->jobModel->getJobsWithDetails($perPage);
        }

        $data = [
            'title' => 'Jobs',
            'jobs' => $jobs,
            'search' => $search,
            'status' => $status,
            'jobStats' => $this->jobModel->getJobStats(),
            'pager' => $this->jobModel->pager
        ];

        return view('dashboard/jobs/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Job',
            'users' => $this->userModel->findAll(),
            'technicians' => $this->adminUserModel->getAvailableTechnicians(),
            'serviceCenters' => $this->serviceCenterModel->getActiveServiceCenters(),
            'jobStatuses' => $this->jobModel->getJobStatuses(),
            'dispatchTypes' => $this->jobModel->getDispatchTypes()
        ];

        return view('dashboard/jobs/create', $data);
    }

    public function store()
    {
        // Get customer type and validate
        $customerType = $this->request->getPost('customer_type');
        $userId = $this->request->getPost('user_id') ?: null;
        $walkInCustomerName = $this->request->getPost('walk_in_customer_name');
        $walkInCustomerMobile = $this->request->getPost('walk_in_customer_mobile');

        // Validate customer type selection
        if (empty($customerType)) {
            return redirect()->back()->withInput()->with('error', 'Please select a customer type.');
        }

        // Validate based on customer type
        if ($customerType === 'existing' && empty($userId)) {
            return redirect()->back()->withInput()->with('error', 'Please select an existing customer.');
        }

        // For walk-in customers, clear user_id to avoid conflicts
        if ($customerType === 'walk_in') {
            $userId = null;
        }

        // Prepare job data for model validation
        $jobData = [
            'user_id' => $userId,
            'walk_in_customer_name' => $walkInCustomerName,
            'walk_in_customer_mobile' => $walkInCustomerMobile,
            'device_name' => $this->request->getPost('device_name'),
            'serial_number' => $this->request->getPost('serial_number'),
            'problem' => $this->request->getPost('problem'),
            'technician_id' => $this->request->getPost('technician_id') ?: null,
            'status' => $this->request->getPost('status'),
            'charge' => $this->request->getPost('charge') ?: null,
            'service_center_id' => $this->request->getPost('service_center_id') ?: null,
            'expected_return_date' => $this->request->getPost('expected_return_date') ?: null
        ];

        // Additional validation for service center when status is "Referred to Service Center"
        if ($jobData['status'] === 'Referred to Service Center' && empty($jobData['service_center_id'])) {
            return redirect()->back()->withInput()->with('error', 'Service center is required when status is "Referred to Service Center".');
        }

        // Validate using JobModel
        if (!$this->jobModel->validate($jobData)) {
            return redirect()->back()->withInput()->with('errors', $this->jobModel->errors());
        }

        // Additional validation for file uploads
        $fileRules = [
            'photo_description' => 'permit_empty|max_length[255]',
            'job_photos' => 'permit_empty|max_size[job_photos,5120]|is_image[job_photos]'
        ];

        if (!$this->validate($fileRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create the job first (use already validated data)
        $jobData['charge'] = $jobData['charge'] ?: 0.00;

        $jobId = $this->jobModel->insert($jobData);

        if (!$jobId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create job.');
        }

        // Handle photo uploads if any
        $uploadedFiles = $this->request->getFiles();
        $photoDescription = $this->request->getPost('photo_description');
        $uploadedCount = 0;
        $photoErrors = [];

        if (!empty($uploadedFiles['job_photos'])) {
            // Create upload directory if it doesn't exist
            $uploadPath = WRITEPATH . 'uploads/photos/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($uploadedFiles['job_photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate unique filename
                    $newName = $file->getRandomName();

                    try {
                        // Move file to upload directory
                        if ($file->move($uploadPath, $newName)) {
                            // Save to database
                            $photoData = [
                                'job_id' => $jobId,
                                'referred_id' => null,
                                'photo_type' => 'Job',
                                'file_name' => $newName,
                                'description' => $photoDescription,
                                'uploaded_at' => date('Y-m-d H:i:s')
                            ];

                            if ($this->photoModel->insert($photoData)) {
                                $uploadedCount++;
                            } else {
                                $photoErrors[] = "Failed to save photo record for {$file->getName()}";
                                // Delete the uploaded file if database insert failed
                                unlink($uploadPath . $newName);
                            }
                        } else {
                            $photoErrors[] = "Failed to upload {$file->getName()}";
                        }
                    } catch (\Exception $e) {
                        $photoErrors[] = "Error uploading {$file->getName()}: " . $e->getMessage();
                    }
                }
            }
        }

        // Prepare success message
        $message = 'Job created successfully!';
        if ($uploadedCount > 0) {
            $message .= " {$uploadedCount} photoproof(s) uploaded.";
        }
        if (!empty($photoErrors)) {
            $message .= " Photo upload issues: " . implode(', ', $photoErrors);
        }

        return redirect()->to('/dashboard/jobs')->with('success', $message);
    }

    public function view($id)
    {
        $job = $this->jobModel->getJobWithDetails($id);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $data = [
            'title' => 'Job Details',
            'job' => $job
        ];

        return view('dashboard/jobs/view', $data);
    }

    public function edit($id)
    {
        $job = $this->jobModel->find($id);

        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $data = [
            'title' => 'Edit Job',
            'job' => $job,
            'users' => $this->userModel->findAll(),
            'technicians' => $this->adminUserModel->getAvailableTechnicians(),
            'serviceCenters' => $this->serviceCenterModel->getActiveServiceCenters(),
            'jobStatuses' => $this->jobModel->getJobStatuses(),
            'dispatchTypes' => $this->jobModel->getDispatchTypes()
        ];

        return view('dashboard/jobs/edit', $data);
    }

    public function update($id)
    {
        $job = $this->jobModel->find($id);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        // Get customer type and validate
        $customerType = $this->request->getPost('customer_type');
        $userId = $this->request->getPost('user_id') ?: null;
        $walkInCustomerName = $this->request->getPost('walk_in_customer_name');
        $walkInCustomerMobile = $this->request->getPost('walk_in_customer_mobile');

        // Validate customer type selection
        if (empty($customerType)) {
            return redirect()->back()->withInput()->with('error', 'Please select a customer type.');
        }

        // Validate based on customer type
        if ($customerType === 'existing' && empty($userId)) {
            return redirect()->back()->withInput()->with('error', 'Please select an existing customer.');
        }

        // For walk-in customers, clear user_id to avoid conflicts
        if ($customerType === 'walk_in') {
            $userId = null;
        }

        // Prepare job data for model validation
        $jobData = [
            'user_id' => $userId,
            'walk_in_customer_name' => $walkInCustomerName,
            'walk_in_customer_mobile' => $walkInCustomerMobile,
            'device_name' => $this->request->getPost('device_name'),
            'serial_number' => $this->request->getPost('serial_number'),
            'problem' => $this->request->getPost('problem'),
            'technician_id' => $this->request->getPost('technician_id') ?: null,
            'status' => $this->request->getPost('status'),
            'charge' => $this->request->getPost('charge') ?: null,
            'service_center_id' => $this->request->getPost('service_center_id') ?: null,
            'expected_return_date' => $this->request->getPost('expected_return_date') ?: null
        ];

        // Additional validation for service center when status is "Referred to Service Center"
        if ($jobData['status'] === 'Referred to Service Center' && empty($jobData['service_center_id'])) {
            return redirect()->back()->withInput()->with('error', 'Service center is required when status is "Referred to Service Center".');
        }

        // Validate using JobModel
        if (!$this->jobModel->validate($jobData)) {
            return redirect()->back()->withInput()->with('errors', $this->jobModel->errors());
        }

        if ($this->jobModel->update($id, $jobData)) {
            return redirect()->to('/dashboard/jobs')->with('success', 'Job updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update job.');
        }
    }

    public function delete($id)
    {
        // Check if user can delete jobs
        if (!canDeleteJob()) {
            return redirect()->to('/dashboard/jobs')->with('error', 'You do not have permission to delete jobs.');
        }

        $job = $this->jobModel->find($id);

        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        if ($this->jobModel->delete($id)) {
            return redirect()->to('/dashboard/jobs')->with('success', 'Job deleted successfully!');
        } else {
            return redirect()->to('/dashboard/jobs')->with('error', 'Failed to delete job.');
        }
    }

    public function updateStatus($id)
    {
        $job = $this->jobModel->find($id);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['Pending', 'In Progress', 'Completed'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        if ($this->jobModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Job status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update job status.');
        }
    }
}
