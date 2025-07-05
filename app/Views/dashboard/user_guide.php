<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">TFC Dashboard User Guide</h1>
        <p class="text-lg text-gray-600">Complete guide to using your Repair Shop Management System</p>
    </div>

    <!-- Quick Navigation -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Navigation</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="#getting-started" class="text-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-play-circle text-2xl text-blue-600 mb-2"></i>
                <p class="text-sm font-medium text-blue-800">Getting Started</p>
            </a>
            <a href="#dashboard" class="text-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-tachometer-alt text-2xl text-green-600 mb-2"></i>
                <p class="text-sm font-medium text-green-800">Dashboard</p>
            </a>
            <a href="#customers" class="text-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <i class="fas fa-users text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-medium text-purple-800">Customers</p>
            </a>
            <a href="#jobs" class="text-center p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                <i class="fas fa-wrench text-2xl text-orange-600 mb-2"></i>
                <p class="text-sm font-medium text-orange-800">Jobs</p>
            </a>
            <a href="#technicians" class="text-center p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                <i class="fas fa-user-cog text-2xl text-indigo-600 mb-2"></i>
                <p class="text-sm font-medium text-indigo-800">Technicians</p>
            </a>
            <a href="#inventory" class="text-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                <i class="fas fa-boxes text-2xl text-red-600 mb-2"></i>
                <p class="text-sm font-medium text-red-800">Inventory</p>
            </a>
        </div>
    </div>

    <!-- Getting Started Section -->
    <div id="getting-started" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-play-circle text-blue-600 mr-2"></i>
            Getting Started
        </h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome to TFC Dashboard</h3>
                <p class="text-gray-600 mb-4">TFC Dashboard is a comprehensive repair shop management system designed to help you manage customers, jobs, technicians, and inventory efficiently.</p>
                
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Tip:</strong> The dashboard is fully responsive and works on desktop, tablet, and mobile devices.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">System Requirements</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Modern web browser (Chrome, Firefox, Safari, Edge)</li>
                    <li>Internet connection for optimal performance</li>
                    <li>JavaScript enabled</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Navigation</h3>
                <p class="text-gray-600 mb-2">Use the sidebar navigation to access different sections:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li><strong>Dashboard:</strong> Overview and statistics</li>
                    <li><strong>Jobs:</strong> Manage repair jobs</li>
                    <li><strong>Customers:</strong> Customer database</li>
                    <li><strong>Technicians:</strong> Technician management</li>
                    <li><strong>Inventory:</strong> Stock management</li>
                    <li><strong>Stock Movements:</strong> Track inventory changes</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Dashboard Section -->
    <div id="dashboard" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-tachometer-alt text-green-600 mr-2"></i>
            Dashboard Overview
        </h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Statistics Cards</h3>
                <p class="text-gray-600 mb-4">The dashboard displays key metrics at a glance:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900">Total Jobs</h4>
                        <p class="text-sm text-gray-600">Shows total number of repair jobs with breakdown by status</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900">Total Customers</h4>
                        <p class="text-sm text-gray-600">Displays registered and walk-in customer counts</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900">Technicians</h4>
                        <p class="text-sm text-gray-600">Number of active technicians in your shop</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900">Inventory Items</h4>
                        <p class="text-sm text-gray-600">Total items with low stock alerts</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Recent Activity</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li><strong>Recent Jobs:</strong> Latest 5 repair jobs with status</li>
                    <li><strong>Low Stock Alert:</strong> Items running low on inventory</li>
                    <li><strong>Stock Movements:</strong> Recent inventory changes</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Customers Section -->
    <div id="customers" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-users text-purple-600 mr-2"></i>
            Customer Management
        </h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Adding New Customers</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-2">
                    <li>Click "Add Customer" button on the Customers page</li>
                    <li>Fill in customer details:
                        <ul class="list-disc list-inside ml-6 mt-1">
                            <li><strong>Name:</strong> Customer's full name (required)</li>
                            <li><strong>Mobile Number:</strong> Contact number (optional)</li>
                            <li><strong>Type:</strong> Registered or Walk-in</li>
                        </ul>
                    </li>
                    <li>Click "Save Customer" to add to database</li>
                </ol>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Customer Types</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-medium text-green-900">Registered Customers</h4>
                        <p class="text-sm text-green-700">Regular customers with accounts who return frequently</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-medium text-gray-900">Walk-in Customers</h4>
                        <p class="text-sm text-gray-700">One-time or occasional customers</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Managing Customers</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li><strong>Search:</strong> Use the search bar to find customers by name or mobile number</li>
                    <li><strong>Edit:</strong> Click the edit icon to update customer information</li>
                    <li><strong>Delete:</strong> Click the delete icon to remove customers (with confirmation)</li>
                    <li><strong>Job Count:</strong> View how many jobs each customer has</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Jobs Section -->
    <div id="jobs" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-wrench text-orange-600 mr-2"></i>
            Job Management
        </h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Creating New Jobs</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-2">
                    <li>Click "Create Job" button on the Jobs page</li>
                    <li>Fill in job details:
                        <ul class="list-disc list-inside ml-6 mt-1">
                            <li><strong>Customer:</strong> Select existing customer (optional)</li>
                            <li><strong>Device Name:</strong> Type of device (e.g., iPhone 12)</li>
                            <li><strong>Serial Number:</strong> Device serial/IMEI</li>
                            <li><strong>Problem:</strong> Detailed description of the issue</li>
                            <li><strong>Technician:</strong> Assign to available technician</li>
                            <li><strong>Status:</strong> Initial status (usually Pending)</li>
                        </ul>
                    </li>
                    <li>Click "Create Job" to save</li>
                </ol>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Job Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <h4 class="font-medium text-yellow-900">Pending</h4>
                        <p class="text-sm text-yellow-700">Job received, waiting to start</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h4 class="font-medium text-blue-900">In Progress</h4>
                        <p class="text-sm text-blue-700">Currently being worked on</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-medium text-green-900">Completed</h4>
                        <p class="text-sm text-green-700">Repair finished, ready for pickup</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Job Features</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li><strong>Search & Filter:</strong> Find jobs by device, customer, or technician</li>
                    <li><strong>Status Filter:</strong> View jobs by status (Pending, In Progress, Completed)</li>
                    <li><strong>Quick Status Update:</strong> Change job status from the view page</li>
                    <li><strong>Print Details:</strong> Print job information for records</li>
                    <li><strong>Stock Tracking:</strong> Link inventory movements to jobs</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Technicians Section -->
    <div id="technicians" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-user-cog text-indigo-600 mr-2"></i>
            Technician Management
        </h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Adding Technicians</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-2">
                    <li>Click "Add Technician" button</li>
                    <li>Enter technician details:
                        <ul class="list-disc list-inside ml-6 mt-1">
                            <li><strong>Name:</strong> Technician's full name (required)</li>
                            <li><strong>Contact Number:</strong> Phone number (optional)</li>
                        </ul>
                    </li>
                    <li>Click "Save Technician"</li>
                </ol>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Technician Statistics</h3>
                <p class="text-gray-600 mb-2">The system tracks various metrics for each technician:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li><strong>Total Jobs:</strong> All jobs assigned to the technician</li>
                    <li><strong>Pending Jobs:</strong> Jobs waiting to be started</li>
                    <li><strong>Active Jobs:</strong> Jobs currently in progress</li>
                    <li><strong>Completed Jobs:</strong> Successfully finished repairs</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Workload Management</h3>
                <p class="text-gray-600">When creating jobs, technicians are sorted by workload to help distribute work evenly. Technicians with fewer active jobs appear first in the assignment list.</p>
            </div>
        </div>
    </div>

    <!-- Inventory Section -->
    <div id="inventory" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-boxes text-red-600 mr-2"></i>
            Inventory Management
        </h2>
        
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Adding Inventory Items</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-2">
                    <li>Click "Add Item" button on Inventory page</li>
                    <li>Fill in item details:
                        <ul class="list-disc list-inside ml-6 mt-1">
                            <li><strong>Device Name:</strong> Type of part/accessory</li>
                            <li><strong>Brand:</strong> Manufacturer name</li>
                            <li><strong>Model:</strong> Specific model compatibility</li>
                            <li><strong>Initial Stock:</strong> Starting quantity</li>
                        </ul>
                    </li>
                    <li>Click "Add Item" to save</li>
                </ol>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Stock Level Indicators</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-medium text-green-900">Good Stock</h4>
                        <p class="text-sm text-green-700">More than 10 units available</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <h4 class="font-medium text-yellow-900">Low Stock</h4>
                        <p class="text-sm text-yellow-700">10 or fewer units remaining</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <h4 class="font-medium text-red-900">Out of Stock</h4>
                        <p class="text-sm text-red-700">0 units available</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Stock Movements</h3>
                <p class="text-gray-600 mb-2">Track inventory changes with two types of movements:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-medium text-green-900">IN Movements</h4>
                        <p class="text-sm text-green-700">Adding stock (purchases, returns, restocking)</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <h4 class="font-medium text-red-900">OUT Movements</h4>
                        <p class="text-sm text-red-700">Using stock (repairs, sales, damaged items)</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Recording Stock Movements</h3>
                <ol class="list-decimal list-inside text-gray-600 space-y-2">
                    <li>Go to Stock Movements page</li>
                    <li>Click "Add Movement"</li>
                    <li>Select inventory item</li>
                    <li>Choose movement type (IN or OUT)</li>
                    <li>Enter quantity</li>
                    <li>Optionally link to a specific job</li>
                    <li>Click "Record Movement"</li>
                </ol>
                
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Note:</strong> Stock levels are automatically updated when movements are recorded. The system prevents OUT movements that would result in negative stock.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips and Best Practices -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
            Tips & Best Practices
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Daily Operations</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Check dashboard for pending jobs each morning</li>
                    <li>Update job status as work progresses</li>
                    <li>Record stock movements immediately when parts are used</li>
                    <li>Review low stock alerts weekly</li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Data Management</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Use detailed problem descriptions for better tracking</li>
                    <li>Keep customer information updated</li>
                    <li>Link stock movements to jobs when possible</li>
                    <li>Regular backup of important data</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Support Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-life-ring text-blue-600 mr-2"></i>
            Support & Help
        </h2>
        
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Need Help?</h3>
                <p class="text-gray-600">If you encounter any issues or need assistance:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-1 mt-2">
                    <li>Check this user guide for detailed instructions</li>
                    <li>Look for tooltips and help text throughout the system</li>
                    <li>Contact your system administrator</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-2">System Information</h4>
                <p class="text-sm text-gray-600">TFC Dashboard - Repair Shop Management System</p>
                <p class="text-sm text-gray-600">Built with CodeIgniter 4 and Tailwind CSS</p>
            </div>
        </div>
    </div>
</div>

<style>
/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Highlight sections when linked */
:target {
    animation: highlight 2s ease-in-out;
}

@keyframes highlight {
    0% { background-color: rgba(59, 130, 246, 0.1); }
    100% { background-color: transparent; }
}
</style>

<?= $this->endSection() ?>
