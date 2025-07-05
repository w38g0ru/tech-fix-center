<?php

namespace App\Controllers;

use App\Models\InventoryMovementModel;
use App\Models\InventoryItemModel;
use App\Models\JobModel;

class Movements extends BaseController
{
    protected $movementModel;
    protected $inventoryModel;
    protected $jobModel;

    public function __construct()
    {
        $this->movementModel = new InventoryMovementModel();
        $this->inventoryModel = new InventoryItemModel();
        $this->jobModel = new JobModel();
    }

    public function index()
    {
        $movements = $this->movementModel->getMovementsWithDetails();

        $data = [
            'title' => 'Stock Movements',
            'movements' => $movements,
            'movementStats' => $this->movementModel->getMovementStats()
        ];

        return view('dashboard/movements/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Stock Movement',
            'inventoryItems' => $this->inventoryModel->findAll(),
            'jobs' => $this->jobModel->getJobsWithDetails()
        ];

        return view('dashboard/movements/create', $data);
    }

    public function store()
    {
        $rules = [
            'item_id' => 'required|is_natural_no_zero',
            'movement_type' => 'required|in_list[IN,OUT]',
            'quantity' => 'required|is_natural_no_zero',
            'job_id' => 'permit_empty|is_natural_no_zero'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if we have enough stock for OUT movement
        $itemId = $this->request->getPost('item_id');
        $movementType = $this->request->getPost('movement_type');
        $quantity = $this->request->getPost('quantity');

        if ($movementType === 'OUT') {
            $item = $this->inventoryModel->find($itemId);
            if ($item && $item['total_stock'] < $quantity) {
                return redirect()->back()->withInput()->with('error', 'Insufficient stock. Available: ' . $item['total_stock']);
            }
        }

        $data = [
            'item_id' => $itemId,
            'movement_type' => $movementType,
            'quantity' => $quantity,
            'job_id' => $this->request->getPost('job_id') ?: null
        ];

        if ($this->movementModel->insert($data)) {
            return redirect()->to('/dashboard/movements')->with('success', 'Stock movement recorded successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to record stock movement.');
        }
    }

    public function byItem($itemId)
    {
        $item = $this->inventoryModel->find($itemId);
        
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory item not found');
        }

        $movements = $this->movementModel->getMovementsByItem($itemId);

        $data = [
            'title' => 'Stock Movements - ' . $item['device_name'],
            'item' => $item,
            'movements' => $movements
        ];

        return view('dashboard/movements/by_item', $data);
    }

    public function byJob($jobId)
    {
        $job = $this->jobModel->getJobWithDetails($jobId);
        
        if (!$job) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Job not found');
        }

        $movements = $this->movementModel->getMovementsByJob($jobId);

        $data = [
            'title' => 'Stock Movements - Job #' . $jobId,
            'job' => $job,
            'movements' => $movements
        ];

        return view('dashboard/movements/by_job', $data);
    }
}
