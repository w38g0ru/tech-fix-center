<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb Navigation -->
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?= base_url('jobs') ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-fuchsia-600 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Jobs
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="ml-1 md:ml-2 text-sm font-medium text-gray-500">#JOB-001</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Page Header -->
<div class="mb-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Job #JOB-001</h1>
            <p class="mt-2 text-sm text-gray-600">
                iPhone 12 Pro - Screen Replacement
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Job
            </button>
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Update Status
            </button>
        </div>
    </div>
</div>

<!-- Status Alert -->
<div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">
                Job In Progress
            </h3>
            <div class="mt-2 text-sm text-yellow-700">
                <p>This job is currently being worked on by Ram Sharma. Expected completion: Jan 26, 2025</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Job Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Job Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Job Information</h3>
            </div>
            <div class="px-6 py-4">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Device</dt>
                        <dd class="mt-1 text-sm text-gray-900">iPhone 12 Pro</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Serial Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">ABC123456789</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Problem Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">Screen is cracked and touch is not responding properly. Customer dropped the device.</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estimated Charge</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">NPR 15,000</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">Jan 24, 2025 10:30 AM</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Expected Return</dt>
                        <dd class="mt-1 text-sm text-gray-900">Jan 26, 2025</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-medium text-lg">JD</span>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">John Doe</h4>
                        <p class="text-sm text-gray-500">Registered Customer</p>
                    </div>
                </div>
                <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">+977 9841234567</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">john.doe@email.com</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">Kathmandu, Nepal</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Job Timeline -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Job Timeline</h3>
            </div>
            <div class="px-6 py-4">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Job created and assigned to <span class="font-medium text-gray-900">Ram Sharma</span></p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            Jan 24, 10:30 AM
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Status updated to <span class="font-medium text-gray-900">In Progress</span></p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            Jan 24, 2:15 PM
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="relative">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-fuchsia-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Technician started working on the device</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            Jan 25, 9:00 AM
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Sidebar -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Current Status</h3>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-center">
                    <span class="inline-flex px-3 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        In Progress
                    </span>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Progress: 60% Complete
                    </p>
                    <div class="mt-2 bg-gray-200 rounded-full h-2">
                        <div class="bg-fuchsia-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Technician -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Assigned Technician</h3>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-gray-600 font-medium">RS</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Ram Sharma</p>
                        <p class="text-sm text-gray-500">Senior Technician</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Contact Technician
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="px-6 py-4 space-y-3">
                <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                    Mark as Complete
                </button>
                <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                    Add Photos
                </button>
                <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                    Request Parts
                </button>
                <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                    Send SMS Update
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
