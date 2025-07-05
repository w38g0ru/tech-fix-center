<?php

namespace App\Controllers;

use App\Models\InventoryItemModel;
use App\Models\InventoryMovementModel;
use App\Models\PhotoModel;

class Inventory extends BaseController
{
    protected $inventoryModel;
    protected $movementModel;
    protected $photoModel;

    public function __construct()
    {
        $this->inventoryModel = new InventoryItemModel();
        $this->movementModel = new InventoryMovementModel();
        $this->photoModel = new PhotoModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        
        if ($search) {
            $items = $this->inventoryModel->searchItems($search);
        } else {
            $items = $this->inventoryModel->getItemsWithMovements();
        }

        $data = [
            'title' => 'Inventory',
            'items' => $items,
            'search' => $search,
            'inventoryStats' => $this->inventoryModel->getInventoryStats()
        ];

        return view('dashboard/inventory/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Add New Inventory Item'];
        return view('dashboard/inventory/create', $data);
    }

    public function store()
    {
        $rules = [
            'device_name' => 'permit_empty|max_length[100]',
            'brand' => 'permit_empty|max_length[100]',
            'model' => 'permit_empty|max_length[100]',
            'total_stock' => 'required|is_natural',
            'photo_description' => 'permit_empty|max_length[255]',
            'inventory_photos' => 'permit_empty|max_size[inventory_photos,5120]|is_image[inventory_photos]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create the inventory item first
        $data = [
            'device_name' => $this->request->getPost('device_name'),
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'total_stock' => $this->request->getPost('total_stock')
        ];

        $inventoryId = $this->inventoryModel->insert($data);

        if (!$inventoryId) {
            return redirect()->back()->withInput()->with('error', 'Failed to add inventory item.');
        }

        // Handle photo uploads if any
        $uploadedFiles = $this->request->getFiles();
        $photoDescription = $this->request->getPost('photo_description');
        $uploadedCount = 0;
        $photoErrors = [];

        if (!empty($uploadedFiles['inventory_photos'])) {
            // Create upload directory if it doesn't exist
            $uploadPath = WRITEPATH . 'uploads/photos/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($uploadedFiles['inventory_photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate unique filename
                    $newName = $file->getRandomName();

                    try {
                        // Move file to upload directory
                        if ($file->move($uploadPath, $newName)) {
                            // Save to database
                            $photoData = [
                                'job_id' => null,
                                'referred_id' => null,
                                'inventory_id' => $inventoryId,
                                'photo_type' => 'Inventory',
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
        $message = 'Inventory item added successfully!';
        if ($uploadedCount > 0) {
            $message .= " {$uploadedCount} photoproof(s) uploaded.";
        }
        if (!empty($photoErrors)) {
            $message .= " Photo upload issues: " . implode(', ', $photoErrors);
        }

        return redirect()->to('/dashboard/inventory')->with('success', $message);
    }

    public function edit($id)
    {
        $item = $this->inventoryModel->find($id);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $data = [
            'title' => 'Edit Inventory Item',
            'item' => $item
        ];

        return view('dashboard/inventory/edit', $data);
    }

    public function update($id)
    {
        $item = $this->inventoryModel->find($id);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $rules = [
            'device_name' => 'permit_empty|max_length[100]',
            'brand' => 'permit_empty|max_length[100]',
            'model' => 'permit_empty|max_length[100]',
            'total_stock' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'device_name' => $this->request->getPost('device_name'),
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'total_stock' => $this->request->getPost('total_stock')
        ];

        if ($this->inventoryModel->update($id, $data)) {
            return redirect()->to('/dashboard/inventory')->with('success', 'Inventory item updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update inventory item.');
        }
    }

    public function delete($id)
    {
        $item = $this->inventoryModel->find($id);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        if ($this->inventoryModel->delete($id)) {
            return redirect()->to('/dashboard/inventory')->with('success', 'Inventory item deleted successfully!');
        } else {
            return redirect()->to('/dashboard/inventory')->with('error', 'Failed to delete inventory item.');
        }
    }

    public function view($id)
    {
        $item = $this->inventoryModel->find($id);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $movements = $this->movementModel->getMovementsByItem($id);

        $data = [
            'title' => 'Inventory Item Details',
            'item' => $item,
            'movements' => $movements
        ];

        return view('dashboard/inventory/view', $data);
    }
}
