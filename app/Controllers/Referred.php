<?php

namespace App\Controllers;

use App\Models\ReferredModel;
use App\Models\PhotoModel;

class Referred extends BaseController
{
    protected $referredModel;
    protected $photoModel;

    public function __construct()
    {
        $this->referredModel = new ReferredModel();
        $this->photoModel = new PhotoModel();
        
        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        
        if ($search) {
            $referred = $this->referredModel->searchReferred($search);
        } elseif ($status) {
            $referred = $this->referredModel->getReferredByStatus($status);
        } else {
            $referred = $this->referredModel->getReferredWithPhotos();
        }

        $data = [
            'title' => 'Dispatch Management',
            'referred' => $referred,
            'search' => $search,
            'status' => $status,
            'referredStats' => $this->referredModel->getReferredStats()
        ];

        return view('dashboard/referred/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Create New Dispatch'];
        return view('dashboard/referred/create', $data);
    }

    public function store()
    {
        $rules = [
            'customer_name' => 'required|min_length[2]|max_length[100]',
            'customer_phone' => 'permit_empty|min_length[10]|max_length[20]',
            'device_name' => 'permit_empty|max_length[100]',
            'problem_description' => 'permit_empty',
            'referred_to' => 'permit_empty|max_length[100]',
            'status' => 'required|in_list[Pending,Dispatched,Completed]',
            'photo_description' => 'permit_empty|max_length[255]',
            'dispatch_photos' => 'permit_empty|max_size[dispatch_photos,5120]|is_image[dispatch_photos]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create the dispatch item first
        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'device_name' => $this->request->getPost('device_name'),
            'problem_description' => $this->request->getPost('problem_description'),
            'referred_to' => $this->request->getPost('referred_to'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $referredId = $this->referredModel->insert($data);

        if (!$referredId) {
            return redirect()->back()->withInput()->with('error', 'Failed to create dispatch item.');
        }

        // Handle photo uploads if any
        $uploadedFiles = $this->request->getFiles();
        $photoDescription = $this->request->getPost('photo_description');
        $uploadedCount = 0;
        $photoErrors = [];

        if (!empty($uploadedFiles['dispatch_photos'])) {
            // Create upload directory if it doesn't exist
            $uploadPath = WRITEPATH . 'uploads/photos/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($uploadedFiles['dispatch_photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate unique filename
                    $newName = $file->getRandomName();

                    try {
                        // Move file to upload directory
                        if ($file->move($uploadPath, $newName)) {
                            // Save to database
                            $photoData = [
                                'job_id' => null,
                                'referred_id' => $referredId,
                                'photo_type' => 'Dispatch',
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
        $message = 'Dispatch item created successfully!';
        if ($uploadedCount > 0) {
            $message .= " {$uploadedCount} photoproof(s) uploaded.";
        }
        if (!empty($photoErrors)) {
            $message .= " Photo upload issues: " . implode(', ', $photoErrors);
        }

        return redirect()->to('/dashboard/referred')->with('success', $message);
    }

    public function view($id)
    {
        $referred = $this->referredModel->find($id);
        
        if (!$referred) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Dispatch item not found');
        }

        $photos = $this->photoModel->getPhotosByReferred($id);

        $data = [
            'title' => 'Dispatch Details',
            'referred' => $referred,
            'photos' => $photos
        ];

        return view('dashboard/referred/view', $data);
    }

    public function edit($id)
    {
        $referred = $this->referredModel->find($id);
        
        if (!$referred) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Dispatch item not found');
        }

        $data = [
            'title' => 'Edit Dispatch Item',
            'referred' => $referred
        ];

        return view('dashboard/referred/edit', $data);
    }

    public function update($id)
    {
        $referred = $this->referredModel->find($id);
        
        if (!$referred) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Dispatch item not found');
        }

        $rules = [
            'customer_name' => 'required|min_length[2]|max_length[100]',
            'customer_phone' => 'permit_empty|min_length[10]|max_length[20]',
            'device_name' => 'permit_empty|max_length[100]',
            'problem_description' => 'permit_empty',
            'referred_to' => 'permit_empty|max_length[100]',
            'status' => 'required|in_list[Pending,Dispatched,Completed]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'device_name' => $this->request->getPost('device_name'),
            'problem_description' => $this->request->getPost('problem_description'),
            'referred_to' => $this->request->getPost('referred_to'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->referredModel->update($id, $data)) {
            return redirect()->to('/dashboard/referred')->with('success', 'Dispatch item updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update dispatch item.');
        }
    }

    public function delete($id)
    {
        // Check permissions
        if (!canDeleteJob()) { // Using same permission as job deletion
            return redirect()->to('/dashboard/referred')->with('error', 'You do not have permission to delete dispatch items.');
        }

        $referred = $this->referredModel->find($id);
        
        if (!$referred) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Dispatch item not found');
        }

        // Delete associated photos first
        $photos = $this->photoModel->getPhotosByReferred($id);
        foreach ($photos as $photo) {
            $filepath = WRITEPATH . 'uploads/photos/' . $photo['file_name'];
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            $this->photoModel->delete($photo['id']);
        }

        if ($this->referredModel->delete($id)) {
            return redirect()->to('/dashboard/referred')->with('success', 'Dispatch item deleted successfully!');
        } else {
            return redirect()->to('/dashboard/referred')->with('error', 'Failed to delete dispatch item.');
        }
    }

    public function updateStatus($id)
    {
        $referred = $this->referredModel->find($id);
        
        if (!$referred) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Dispatch item not found');
        }

        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['Pending', 'Dispatched', 'Completed'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        if ($this->referredModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Dispatch status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update dispatch status.');
        }
    }
}
