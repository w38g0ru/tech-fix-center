<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\InventoryItemModel;
use App\Models\AdminUserModel;
use App\Models\InventoryMovementModel;

class Reports extends BaseController
{
    protected $jobModel;
    protected $userModel;
    protected $inventoryModel;
    protected $adminUserModel;
    protected $movementModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->userModel = new UserModel();
        $this->inventoryModel = new InventoryItemModel();
        $this->adminUserModel = new AdminUserModel();
        $this->movementModel = new InventoryMovementModel();

        // Load auth helper
        helper('auth');
    }

    public function index()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        // Get date range from request
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-01'); // First day of current month
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-t'); // Last day of current month

        // Get report data
        $data = [
            'title' => 'Reports & Analytics',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'jobStats' => $this->getJobStats($startDate, $endDate),
            'customerStats' => $this->getCustomerStats($startDate, $endDate),
            'inventoryStats' => $this->getInventoryStats(),
            'technicianStats' => $this->getTechnicianStats($startDate, $endDate),
            'revenueStats' => $this->getRevenueStats($startDate, $endDate),
            'monthlyData' => $this->getMonthlyData(),
        ];

        return view('dashboard/reports/index', $data);
    }

    private function getJobStats($startDate, $endDate)
    {
        $totalJobs = $this->jobModel->where('created_at >=', $startDate)
                                   ->where('created_at <=', $endDate . ' 23:59:59')
                                   ->countAllResults();

        $completedJobs = $this->jobModel->where('status', 'Completed')
                                       ->where('created_at >=', $startDate)
                                       ->where('created_at <=', $endDate . ' 23:59:59')
                                       ->countAllResults();

        $pendingJobs = $this->jobModel->where('status', 'Pending')
                                     ->where('created_at >=', $startDate)
                                     ->where('created_at <=', $endDate . ' 23:59:59')
                                     ->countAllResults();

        $inProgressJobs = $this->jobModel->where('status', 'In Progress')
                                        ->where('created_at >=', $startDate)
                                        ->where('created_at <=', $endDate . ' 23:59:59')
                                        ->countAllResults();

        return [
            'total' => $totalJobs,
            'completed' => $completedJobs,
            'pending' => $pendingJobs,
            'in_progress' => $inProgressJobs,
            'completion_rate' => $totalJobs > 0 ? round(($completedJobs / $totalJobs) * 100, 1) : 0
        ];
    }

    private function getCustomerStats($startDate, $endDate)
    {
        $totalCustomers = $this->userModel->countAllResults();

        $newCustomers = $this->userModel->where('created_at >=', $startDate)
                                       ->where('created_at <=', $endDate . ' 23:59:59')
                                       ->countAllResults();

        $registeredCustomers = $this->userModel->where('user_type', 'Registered')->countAllResults();

        return [
            'total' => $totalCustomers,
            'new' => $newCustomers,
            'active' => $registeredCustomers
        ];
    }

    private function getInventoryStats()
    {
        $totalItems = $this->inventoryModel->countAllResults();
        $totalStock = $this->inventoryModel->selectSum('total_stock')->first()['total_stock'] ?? 0;
        $lowStock = $this->inventoryModel->where('total_stock <=', 'minimum_order_level', false)->countAllResults();
        $outOfStock = $this->inventoryModel->where('total_stock', 0)->countAllResults();

        return [
            'total_items' => $totalItems,
            'total_stock' => $totalStock,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock
        ];
    }

    private function getTechnicianStats($startDate, $endDate)
    {
        $totalTechnicians = $this->adminUserModel->where('role', 'technician')->countAllResults();
        
        // Get technician performance (jobs completed)
        $technicianPerformance = $this->jobModel->select('technician_id, COUNT(*) as jobs_completed')
                                               ->where('status', 'Completed')
                                               ->where('created_at >=', $startDate)
                                               ->where('created_at <=', $endDate . ' 23:59:59')
                                               ->groupBy('technician_id')
                                               ->findAll();

        return [
            'total' => $totalTechnicians,
            'performance' => $technicianPerformance
        ];
    }

    private function getRevenueStats($startDate, $endDate)
    {
        // Calculate revenue from completed jobs using 'charge' column
        $revenueData = $this->jobModel->select('SUM(charge) as total_revenue, COUNT(*) as completed_jobs')
                                     ->where('status', 'Completed')
                                     ->where('created_at >=', $startDate)
                                     ->where('created_at <=', $endDate . ' 23:59:59')
                                     ->first();

        $totalRevenue = $revenueData['total_revenue'] ?? 0;
        $completedJobs = $revenueData['completed_jobs'] ?? 0;
        $averageJobValue = $completedJobs > 0 ? $totalRevenue / $completedJobs : 0;

        return [
            'total_revenue' => $totalRevenue,
            'completed_jobs' => $completedJobs,
            'average_job_value' => $averageJobValue
        ];
    }

    private function getMonthlyData()
    {
        // Get last 6 months data
        $monthlyJobs = [];
        $monthlyRevenue = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthStart = $month . '-01';
            $monthEnd = date('Y-m-t', strtotime($monthStart));
            
            $jobs = $this->jobModel->where('created_at >=', $monthStart)
                                  ->where('created_at <=', $monthEnd . ' 23:59:59')
                                  ->countAllResults();
            
            $revenue = $this->jobModel->select('SUM(charge) as revenue')
                                    ->where('status', 'Completed')
                                    ->where('created_at >=', $monthStart)
                                    ->where('created_at <=', $monthEnd . ' 23:59:59')
                                    ->first()['revenue'] ?? 0;
            
            $monthlyJobs[] = [
                'month' => date('M Y', strtotime($monthStart)),
                'jobs' => $jobs
            ];
            
            $monthlyRevenue[] = [
                'month' => date('M Y', strtotime($monthStart)),
                'revenue' => $revenue
            ];
        }

        return [
            'jobs' => $monthlyJobs,
            'revenue' => $monthlyRevenue
        ];
    }

    public function export()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        $type = $this->request->getGet('type') ?: 'jobs';
        $format = $this->request->getGet('format') ?: 'csv';
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-t');

        switch ($type) {
            case 'jobs':
                return $this->exportJobs($format, $startDate, $endDate);
            case 'customers':
                return $this->exportCustomers($format, $startDate, $endDate);
            case 'inventory':
                return $this->exportInventory($format);
            default:
                return redirect()->back()->with('error', 'Invalid export type');
        }
    }

    private function exportJobs($format, $startDate, $endDate)
    {
        $jobs = $this->jobModel->select('jobs.*, users.name as customer_name')
                              ->join('users', 'users.id = jobs.user_id', 'left')
                              ->where('jobs.created_at >=', $startDate)
                              ->where('jobs.created_at <=', $endDate . ' 23:59:59')
                              ->findAll();

        if ($format === 'csv') {
            $filename = 'jobs_report_' . date('Y-m-d') . '.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $output = fopen('php://output', 'w');

            // CSV headers
            fputcsv($output, ['ID', 'Customer', 'Walk-in Customer', 'Device', 'Problem', 'Status', 'Charge', 'Created Date']);

            foreach ($jobs as $job) {
                $customerName = $job['customer_name'] ?: $job['walk_in_customer_name'];
                fputcsv($output, [
                    $job['id'],
                    $customerName,
                    $job['walk_in_customer_name'],
                    $job['device_name'],
                    $job['problem'],
                    $job['status'],
                    $job['charge'],
                    $job['created_at']
                ]);
            }

            fclose($output);
            exit;
        }

        return redirect()->back()->with('error', 'Export format not supported');
    }

    private function exportCustomers($format, $startDate, $endDate)
    {
        $customers = $this->userModel->where('created_at >=', $startDate)
                                   ->where('created_at <=', $endDate . ' 23:59:59')
                                   ->findAll();

        if ($format === 'csv') {
            $filename = 'customers_report_' . date('Y-m-d') . '.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $output = fopen('php://output', 'w');

            fputcsv($output, ['ID', 'Name', 'Mobile Number', 'User Type', 'Created Date']);

            foreach ($customers as $customer) {
                fputcsv($output, [
                    $customer['id'],
                    $customer['name'],
                    $customer['mobile_number'],
                    $customer['user_type'],
                    $customer['created_at']
                ]);
            }

            fclose($output);
            exit;
        }

        return redirect()->back()->with('error', 'Export format not supported');
    }

    private function exportInventory($format)
    {
        $items = $this->inventoryModel->findAll();

        if ($format === 'csv') {
            $filename = 'inventory_report_' . date('Y-m-d') . '.csv';
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            
            fputcsv($output, ['ID', 'Device Name', 'Brand', 'Model', 'Stock', 'Purchase Price', 'Selling Price', 'Status']);
            
            foreach ($items as $item) {
                fputcsv($output, [
                    $item['id'],
                    $item['device_name'],
                    $item['brand'],
                    $item['model'],
                    $item['total_stock'],
                    $item['purchase_price'],
                    $item['selling_price'],
                    $item['status']
                ]);
            }
            
            fclose($output);
            exit;
        }
        
        return redirect()->back()->with('error', 'Export format not supported');
    }
}
