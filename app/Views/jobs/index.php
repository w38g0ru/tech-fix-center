<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Jobs Management</h1>
            <p class="mt-2 text-sm text-gray-600">
                Manage and track device repair jobs efficiently
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create New Job
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                <p class="text-2xl font-semibold text-gray-900">247</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">In Progress</p>
                <p class="text-2xl font-semibold text-gray-900">42</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Completed</p>
                <p class="text-2xl font-semibold text-gray-900">189</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Overdue</p>
                <p class="text-2xl font-semibold text-gray-900">16</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
            <label for="search" class="sr-only">Search jobs</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-fuchsia-500 focus:border-fuchsia-500 text-sm" placeholder="Search by device, customer, or job ID...">
            </div>
        </div>

        <!-- Status Filter -->
        <div>
            <label for="status" class="sr-only">Filter by status</label>
            <select id="status" name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-sm focus:outline-none focus:ring-1 focus:ring-fuchsia-500 focus:border-fuchsia-500">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="overdue">Overdue</option>
            </select>
        </div>

        <!-- Technician Filter -->
        <div>
            <label for="technician" class="sr-only">Filter by technician</label>
            <select id="technician" name="technician" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-sm focus:outline-none focus:ring-1 focus:ring-fuchsia-500 focus:border-fuchsia-500">
                <option value="">All Technicians</option>
                <option value="1">Ram Sharma</option>
                <option value="2">Sita Poudel</option>
                <option value="3">Hari Thapa</option>
            </select>
        </div>
    </div>
</div>

<!-- Jobs Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Recent Jobs</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Job Details
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Technician
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Due Date
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Job Row 1 -->
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">#JOB-001</div>
                            <div class="text-sm text-gray-500">iPhone 12 Pro - Screen Replacement</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">John Doe</div>
                            <div class="text-sm text-gray-500">9841234567</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            In Progress
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Ram Sharma
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Jan 26, 2025
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="text-fuchsia-600 hover:text-fuchsia-900 transition-colors duration-200">
                            View
                        </button>
                    </td>
                </tr>

                <!-- Sample Job Row 2 -->
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">#JOB-002</div>
                            <div class="text-sm text-gray-500">Samsung Galaxy S21 - Battery Issue</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">Jane Smith</div>
                            <div class="text-sm text-gray-500">Walk-in Customer</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Ready for Dispatch
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Sita Poudel
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Jan 25, 2025
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="text-fuchsia-600 hover:text-fuchsia-900 transition-colors duration-200">
                            View
                        </button>
                    </td>
                </tr>

                <!-- Sample Job Row 3 -->
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">#JOB-003</div>
                            <div class="text-sm text-gray-500">MacBook Air - Keyboard Repair</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">Raj Patel</div>
                            <div class="text-sm text-gray-500">9851234567</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            Overdue
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Unassigned
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                        Jan 23, 2025
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="text-fuchsia-600 hover:text-fuchsia-900 transition-colors duration-200">
                            View
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white px-6 py-3 border-t border-gray-200 flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            <button type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                Previous
            </button>
            <button type="button" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                Next
            </button>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">247</span> results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <button type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        1
                    </button>
                    <button type="button" class="bg-fuchsia-50 border-fuchsia-500 text-fuchsia-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                        2
                    </button>
                    <button type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        3
                    </button>
                    <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors duration-200">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
