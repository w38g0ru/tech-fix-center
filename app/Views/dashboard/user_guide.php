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
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
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
            <a href="#parts-requests" class="text-center p-3 bg-cyan-50 rounded-lg hover:bg-cyan-100 transition-colors">
                <i class="fas fa-cogs text-2xl text-cyan-600 mb-2"></i>
                <p class="text-sm font-medium text-cyan-800">Parts Requests</p>
            </a>
            <a href="#photos" class="text-center p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors">
                <i class="fas fa-camera text-2xl text-pink-600 mb-2"></i>
                <p class="text-sm font-medium text-pink-800">Photos</p>
            </a>
            <a href="#user-roles" class="text-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <i class="fas fa-users-cog text-2xl text-yellow-600 mb-2"></i>
                <p class="text-sm font-medium text-yellow-800">User Roles</p>
            </a>
            <a href="#support" class="text-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-life-ring text-2xl text-gray-600 mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Support</p>
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

    <!-- Parts Requests Section -->
    <div id="parts-requests" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-cogs text-blue-600 mr-2"></i>
            Parts Requests Management
        </h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Overview</h3>
                <p class="text-gray-600 mb-4">The Parts Requests module allows technicians to request parts for repairs and administrators to approve or reject these requests.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-medium text-blue-900 mb-2">For Technicians</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Create new parts requests with detailed specifications</li>
                        <li>• View own request history and status</li>
                        <li>• Track request progress from pending to received</li>
                        <li>• Add detailed descriptions and notes</li>
                        <li>• Specify urgency levels (Low, Medium, High, Critical)</li>
                        <li>• Link requests to specific jobs</li>
                    </ul>
                </div>

                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-medium text-green-900 mb-2">For Administrators</h4>
                    <ul class="text-sm text-green-800 space-y-1">
                        <li>• View all parts requests across all technicians</li>
                        <li>• Approve or reject requests with reasons</li>
                        <li>• Add cost estimates and supplier information</li>
                        <li>• Track delivery dates and actual costs</li>
                        <li>• Monitor request statistics and trends</li>
                        <li>• Generate parts request reports</li>
                    </ul>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Request Status Types</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        <span class="text-sm text-gray-600">Awaiting approval</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                        <span class="text-sm text-gray-600">Ready for ordering</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Ordered</span>
                        <span class="text-sm text-gray-600">Parts ordered from supplier</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Received</span>
                        <span class="text-sm text-gray-600">Parts delivered and available</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        <span class="text-sm text-gray-600">Request denied with reason</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Cancelled</span>
                        <span class="text-sm text-gray-600">Request cancelled</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Creating a Parts Request</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <ol class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                        <li>Navigate to Parts Requests → Create Request</li>
                        <li>Fill in item details (name, brand, model, quantity)</li>
                        <li>Select urgency level based on job priority</li>
                        <li>Add detailed description of the part needed</li>
                        <li>Link to specific job if applicable</li>
                        <li>Submit request for administrator review</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Management Section -->
    <div id="photos" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-camera text-purple-600 mr-2"></i>
            Photo Management System
        </h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Photo Categories</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <h4 class="font-medium text-orange-900 mb-2">Job Photos</h4>
                        <p class="text-sm text-orange-800 mb-2">Document repair progress and results</p>
                        <ul class="text-xs text-orange-700 space-y-1">
                            <li>• Before repair condition</li>
                            <li>• Work in progress</li>
                            <li>• Completed repair</li>
                            <li>• Quality assurance</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-medium text-blue-900 mb-2">Inventory Photos</h4>
                        <p class="text-sm text-blue-800 mb-2">Visual catalog of parts and products</p>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Product documentation</li>
                            <li>• Condition assessment</li>
                            <li>• Quality verification</li>
                            <li>• Catalog reference</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-medium text-green-900 mb-2">Dispatch Photos</h4>
                        <p class="text-sm text-green-800 mb-2">Delivery and shipping documentation</p>
                        <ul class="text-xs text-green-700 space-y-1">
                            <li>• Package condition</li>
                            <li>• Delivery confirmation</li>
                            <li>• Shipping documentation</li>
                            <li>• Customer handover</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Upload Guidelines & Best Practices</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="font-medium text-yellow-900 mb-2">Technical Requirements</h4>
                        <ul class="text-sm text-yellow-800 space-y-1">
                            <li>• Maximum file size: 5MB per image</li>
                            <li>• Supported formats: JPG, PNG, GIF</li>
                            <li>• Recommended resolution: 1920x1080 or higher</li>
                            <li>• Images automatically optimized for storage</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Quality Guidelines</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Use good lighting for clear visibility</li>
                            <li>• Include multiple angles when relevant</li>
                            <li>• Add descriptive captions for context</li>
                            <li>• Organize photos chronologically</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Roles Section -->
    <div id="user-roles" class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            <i class="fas fa-users-cog text-red-600 mr-2"></i>
            User Roles & Permissions
        </h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Role-Based Access Control</h3>
                <p class="text-gray-600 mb-4">The system uses role-based permissions to ensure users only access features appropriate to their responsibilities.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-red-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-crown text-red-600 mr-2"></i>
                        <h3 class="text-lg font-semibold text-red-800">Super Admin</h3>
                    </div>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>• Complete system access and control</li>
                        <li>• User management and role assignment</li>
                        <li>• System settings and configuration</li>
                        <li>• All CRUD operations on all modules</li>
                        <li>• Advanced reporting and analytics</li>
                        <li>• Database management and backups</li>
                        <li>• Service center management</li>
                        <li>• System maintenance and updates</li>
                    </ul>
                </div>

                <div class="border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-shield text-purple-600 mr-2"></i>
                        <h3 class="text-lg font-semibold text-purple-800">Admin</h3>
                    </div>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>• Most system features with some restrictions</li>
                        <li>• Job and customer management</li>
                        <li>• Inventory and parts management</li>
                        <li>• Technician management and assignment</li>
                        <li>• Parts request approval/rejection</li>
                        <li>• Standard reporting features</li>
                        <li>• Photo management and organization</li>
                        <li>• Service center coordination</li>
                    </ul>
                </div>

                <div class="border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-cog text-blue-600 mr-2"></i>
                        <h3 class="text-lg font-semibold text-blue-800">Technician</h3>
                    </div>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>• Job management and status updates</li>
                        <li>• Parts request creation and tracking</li>
                        <li>• Inventory viewing and stock movements</li>
                        <li>• Photo upload for job documentation</li>
                        <li>• Own profile management</li>
                        <li>• Job progress reporting</li>
                        <li>• Customer communication notes</li>
                        <li>• Work order completion</li>
                    </ul>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user text-gray-600 mr-2"></i>
                        <h3 class="text-lg font-semibold text-gray-800">Manager</h3>
                    </div>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>• Job oversight and management</li>
                        <li>• Customer relationship management</li>
                        <li>• Inventory monitoring and reporting</li>
                        <li>• Team performance tracking</li>
                        <li>• Report generation and analysis</li>
                        <li>• Service center coordination</li>
                        <li>• Quality assurance oversight</li>
                        <li>• Resource allocation planning</li>
                    </ul>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Permission Matrix</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feature</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Super Admin</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Manager</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">User Management</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-eye text-blue-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-times text-red-600"></i></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Job Management</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-edit text-yellow-600"></i></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Parts Requests</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-eye text-blue-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-plus text-green-600"></i></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Inventory Management</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-eye text-blue-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-eye text-blue-600"></i></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Service Centers</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-check text-green-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-times text-red-600"></i></td>
                                <td class="px-6 py-4 whitespace-nowrap text-center"><i class="fas fa-times text-red-600"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex items-center space-x-6 text-sm">
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-check text-green-600"></i>
                        <span class="text-gray-600">Full Access</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-edit text-yellow-600"></i>
                        <span class="text-gray-600">Edit Own</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-eye text-blue-600"></i>
                        <span class="text-gray-600">View Only</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-plus text-green-600"></i>
                        <span class="text-gray-600">Create Only</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-times text-red-600"></i>
                        <span class="text-gray-600">No Access</span>
                    </div>
                </div>
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
