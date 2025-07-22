<?php

namespace App\Controllers;

use App\Models\PhotoModel;
use App\Models\JobModel;
use App\Models\ReferredModel;
use App\Models\InventoryItemModel;

class Photos extends BaseController
{
    protected $photoModel;
    protected $jobModel;
    protected $referredModel;
    protected $inventoryModel;

    public function __construct()
    {
        $this->photoModel = new PhotoModel();
        $this->jobModel = new JobModel();
        $this->referredModel = new ReferredModel();
        $this->inventoryModel = new InventoryItemModel();

        // Load auth helper
        helper(['auth', 'filesystem']);
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $perPage = 20; // Items per page
        $photos = $this->photoModel->getPhotosWithDetails($perPage);

        $data = [
            'title' => 'Photoproof Gallery',
            'photos' => $photos,
            'pager' => $this->photoModel->pager
        ];

        return view('dashboard/photos/index', $data);
    }

    public function upload()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Get URL parameters for pre-selection
        $preSelectedType = $this->request->getGet('type');
        $preSelectedJobId = $this->request->getGet('job_id');
        $preSelectedReferredId = $this->request->getGet('referred_id');
        $preSelectedInventoryId = $this->request->getGet('inventory_id');

        $data = [
            'title' => 'Upload Photoproof',
            'jobs' => $this->jobModel->getJobsWithDetails(), // Keep all for dropdown
            'referred' => $this->referredModel->findAll(), // Keep all for dropdown
            'inventory' => $this->inventoryModel->findAll(), // Keep all for dropdown
            'preSelectedType' => $preSelectedType,
            'preSelectedJobId' => $preSelectedJobId,
            'preSelectedReferredId' => $preSelectedReferredId,
            'preSelectedInventoryId' => $preSelectedInventoryId
        ];

        return view('dashboard/photos/upload', $data);
    }

    public function store()
    {
        $photoType = $this->request->getPost('photo_type');
        $jobId = $this->request->getPost('job_id');
        $referredId = $this->request->getPost('referred_id');

        // Basic validation rules
        $rules = [
            'photo_type' => 'required|in_list[Job,Dispatch,Received,Inventory]',
            'description' => 'permit_empty|max_length[255]',
            'job_id' => 'permit_empty|is_natural_no_zero',
            'referred_id' => 'permit_empty|is_natural_no_zero',
            'inventory_id' => 'permit_empty|is_natural_no_zero',
            'photos' => 'uploaded[photos]|max_size[photos,5120]|is_image[photos]'
        ];

        // Additional validation based on photo type
        $inventoryId = $this->request->getPost('inventory_id');
        $errors = [];
        if ($photoType === 'Job' && empty($jobId)) {
            $errors['job_id'] = 'Job selection is required for Job photoproofs';
        }
        if (($photoType === 'Dispatch' || $photoType === 'Received') && empty($referredId)) {
            $errors['referred_id'] = 'Dispatch item selection is required for Dispatch/Received photoproofs';
        }
        if ($photoType === 'Inventory' && empty($inventoryId)) {
            $errors['inventory_id'] = 'Inventory item selection is required for Inventory photoproofs';
        }

        if (!$this->validate($rules) || !empty($errors)) {
            $validationErrors = array_merge($this->validator->getErrors(), $errors);
            return redirect()->back()->withInput()->with('errors', $validationErrors);
        }

        $uploadedFiles = $this->request->getFiles();
        $photoType = $this->request->getPost('photo_type');
        $description = $this->request->getPost('description');
        $jobId = $this->request->getPost('job_id') ?: null;
        $referredId = $this->request->getPost('referred_id') ?: null;

        // Create upload directory if it doesn't exist
        $uploadPath = WRITEPATH . 'uploads/photos/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $uploadedCount = 0;
        $errors = [];

        foreach ($uploadedFiles['photos'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Generate unique filename
                $newName = $file->getRandomName();
                
                try {
                    // Move file to upload directory
                    if ($file->move($uploadPath, $newName)) {
                        // Save to database
                        $photoData = [
                            'job_id' => $jobId,
                            'referred_id' => $referredId,
                            'inventory_id' => $inventoryId,
                            'photo_type' => $photoType,
                            'file_name' => $newName,
                            'description' => $description,
                            'uploaded_at' => date('Y-m-d H:i:s')
                        ];

                        if ($this->photoModel->insert($photoData)) {
                            $uploadedCount++;
                        } else {
                            $errors[] = "Failed to save photo record for {$file->getName()}";
                            // Delete the uploaded file if database insert failed
                            unlink($uploadPath . $newName);
                        }
                    } else {
                        $errors[] = "Failed to upload {$file->getName()}";
                    }
                } catch (\Exception $e) {
                    $errors[] = "Error uploading {$file->getName()}: " . $e->getMessage();
                }
            } else {
                $errors[] = "Invalid file: {$file->getName()}";
            }
        }

        if ($uploadedCount > 0) {
            $message = "Successfully uploaded {$uploadedCount} photo(s)";
            if (!empty($errors)) {
                $message .= " with some errors: " . implode(', ', $errors);
            }
            return redirect()->to('/dashboard/photos')->with('success', $message);
        } else {
            return redirect()->back()->withInput()->with('error', 'No photos were uploaded. ' . implode(', ', $errors));
        }
    }

    public function view($id)
    {
        $photo = $this->photoModel->getPhotoWithDetails($id);

        if (!$photo) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Photo not found');
        }

        $data = [
            'title' => 'Photoproof Details',
            'photo' => $photo
        ];

        return view('dashboard/photos/view', $data);
    }

    public function serve($filename)
    {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        $filepath = WRITEPATH . 'uploads/photos/' . $filename;

        if (!file_exists($filepath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Photo not found');
        }

        // Verify file is an image
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invalid file type');
        }

        // Get file info
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filepath);
        finfo_close($finfo);

        // Set headers
        $this->response->setHeader('Content-Type', $mimeType);
        $this->response->setHeader('Content-Length', filesize($filepath));
        $this->response->setHeader('Cache-Control', 'public, max-age=31536000');
        $this->response->setHeader('Last-Modified', gmdate('D, d M Y H:i:s', filemtime($filepath)) . ' GMT');

        // Output file
        readfile($filepath);
        exit;
    }

    public function delete($id)
    {
        // Check permissions
        if (!canDeleteJob()) { // Using same permission as job deletion
            return redirect()->to('/dashboard/photos')->with('error', 'You do not have permission to delete photos.');
        }

        $photo = $this->photoModel->find($id);
        
        if (!$photo) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Photo not found');
        }

        // Delete file from filesystem
        $filepath = WRITEPATH . 'uploads/photos/' . $photo['file_name'];
        if (file_exists($filepath)) {
            unlink($filepath);
        }

        // Delete from database
        if ($this->photoModel->delete($id)) {
            return redirect()->to('/dashboard/photos')->with('success', 'Photo deleted successfully!');
        } else {
            return redirect()->to('/dashboard/photos')->with('error', 'Failed to delete photo.');
        }
    }

    public function byJob($jobId)
    {
        $job = $this->jobModel->getJobWithDetails($jobId);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $photos = $this->photoModel->getPhotosByJob($jobId);

        $data = [
            'title' => 'Job Photos - #' . $jobId,
            'job' => $job,
            'photos' => $photos
        ];

        return view('dashboard/photos/by_job', $data);
    }

    public function byReferred($referredId)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $referred = $this->referredModel->find($referredId);

        if (!$referred) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Referred item not found');
        }

        $perPage = 20; // Items per page
        $photos = $this->photoModel->getPhotosByReferred($referredId, $perPage);

        $data = [
            'title' => 'Dispatch Photos - #' . $referredId,
            'referred' => $referred,
            'photos' => $photos,
            'pager' => $this->photoModel->pager
        ];

        return view('dashboard/photos/by_referred', $data);
    }
}
