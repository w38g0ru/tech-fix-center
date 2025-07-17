<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

/**
 * Admin Dashboard Controller
 * 
 * Handles the main admin dashboard functionality including
 * statistics, charts data, and overview information.
 */
class Dashboard extends BaseController
{
    /**
     * Display the admin dashboard
     * 
     * @return string
     */
    public function index()
    {
        // Check if user is authenticated and has admin privileges
        if (!$this->isAuthenticated() || !$this->hasAdminAccess()) {
            return redirect()->to('/admin/login');
        }
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Prepare view data
        $data = [
            'title' => 'Dashboard',
            'subtitle' => 'Welcome to your admin dashboard',
            'stats' => $stats,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt']
            ]
        ];
        
        return view('admin/dashboard', $data);
    }
    
    /**
     * Get dashboard statistics
     * 
     * @return array
     */
    private function getDashboardStats()
    {
        // In a real application, you would fetch these from your database
        // For demo purposes, we're using static data
        
        return [
            'total_users' => $this->getUserCount(),
            'total_sales' => $this->getTotalSales(),
            'total_orders' => $this->getOrderCount(),
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'growth_percentage' => [
                'users' => 12,
                'sales' => 8,
                'orders' => -3,
                'revenue' => 15
            ]
        ];
    }
    
    /**
     * Get total user count
     * 
     * @return int
     */
    private function getUserCount()
    {
        // Example: return $this->userModel->countAll();
        return 1234;
    }
    
    /**
     * Get total sales amount
     * 
     * @return float
     */
    private function getTotalSales()
    {
        // Example: return $this->orderModel->getTotalSales();
        return 45678.90;
    }
    
    /**
     * Get total order count
     * 
     * @return int
     */
    private function getOrderCount()
    {
        // Example: return $this->orderModel->countAll();
        return 892;
    }
    
    /**
     * Get monthly revenue
     * 
     * @return float
     */
    private function getMonthlyRevenue()
    {
        // Example: return $this->orderModel->getMonthlyRevenue();
        return 23456.78;
    }
    
    /**
     * Get chart data for sales
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getSalesChartData()
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Get date range from request
        $period = $this->request->getGet('period') ?? '7days';
        
        // Generate sample data (in real app, fetch from database)
        $data = $this->generateSalesChartData($period);
        
        return $this->response->setJSON($data);
    }
    
    /**
     * Get chart data for user growth
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getUserGrowthData()
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Get date range from request
        $period = $this->request->getGet('period') ?? 'year';
        
        // Generate sample data (in real app, fetch from database)
        $data = $this->generateUserGrowthData($period);
        
        return $this->response->setJSON($data);
    }
    
    /**
     * Generate sales chart data
     * 
     * @param string $period
     * @return array
     */
    private function generateSalesChartData($period)
    {
        switch ($period) {
            case '7days':
                return [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [1200, 1900, 3000, 5000, 2000, 3000, 4500]
                ];
            case '30days':
                // Generate 30 days of data
                $labels = [];
                $data = [];
                for ($i = 29; $i >= 0; $i--) {
                    $labels[] = date('M j', strtotime("-{$i} days"));
                    $data[] = rand(1000, 5000);
                }
                return ['labels' => $labels, 'data' => $data];
            default:
                return [
                    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    'data' => [1200, 1900, 3000, 5000, 2000, 3000, 4500]
                ];
        }
    }
    
    /**
     * Generate user growth data
     * 
     * @param string $period
     * @return array
     */
    private function generateUserGrowthData($period)
    {
        switch ($period) {
            case 'year':
                return [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'data' => [65, 59, 80, 81, 56, 95, 120, 140, 110, 130, 150, 180]
                ];
            case 'last_year':
                return [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'data' => [45, 39, 60, 61, 36, 75, 100, 120, 90, 110, 130, 160]
                ];
            default:
                return [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'data' => [65, 59, 80, 81, 56, 95]
                ];
        }
    }
    
    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    private function isAuthenticated()
    {
        // For demo purposes, always return true
        // In production, check session or JWT token
        return true; // session()->get('isLoggedIn') === true;
    }

    /**
     * Check if user has admin access
     *
     * @return bool
     */
    private function hasAdminAccess()
    {
        // For demo purposes, always return true
        // In production, check user role
        return true; // $userRole = session()->get('user_role'); return in_array($userRole, ['admin', 'super_admin']);
    }
    
    /**
     * Get recent activity data
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getRecentActivity()
    {
        // Validate request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }
        
        // Get recent activity (in real app, fetch from database)
        $activities = [
            [
                'user' => 'John Doe',
                'action' => 'created a new user account',
                'time' => '2 minutes ago',
                'icon' => 'fas fa-user-plus',
                'color' => 'text-green-500'
            ],
            [
                'user' => 'Jane Smith',
                'action' => 'updated product inventory',
                'time' => '5 minutes ago',
                'icon' => 'fas fa-box',
                'color' => 'text-blue-500'
            ],
            [
                'user' => 'Admin',
                'action' => 'processed order #1234',
                'time' => '10 minutes ago',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'text-purple-500'
            ]
        ];
        
        return $this->response->setJSON($activities);
    }
}
