<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Business Overview</h1>
            <p class="mt-2 text-sm text-gray-600">
                Comprehensive insights into your repair business performance
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-4">
            <select class="block px-3 py-2 border border-gray-300 rounded-md bg-white text-sm focus:outline-none focus:ring-1 focus:ring-fuchsia-500 focus:border-fuchsia-500">
                <option>Last 7 days</option>
                <option>Last 30 days</option>
                <option>Last 3 months</option>
                <option>This year</option>
            </select>
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Report
            </button>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                <p class="text-2xl font-semibold text-gray-900">NPR 8,45,230</p>
                <div class="flex items-center mt-1">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">+18.2% from last period</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Completed -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Jobs Completed</p>
                <p class="text-2xl font-semibold text-gray-900">156</p>
                <div class="flex items-center mt-1">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">+12.5% completion rate</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Turnaround -->
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
                <p class="text-sm font-medium text-gray-600">Avg. Turnaround</p>
                <p class="text-2xl font-semibold text-gray-900">2.8 days</p>
                <div class="flex items-center mt-1">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">-0.5 days improvement</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Retention -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-fuchsia-100 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Customer Retention</p>
                <p class="text-2xl font-semibold text-gray-900">87%</p>
                <div class="flex items-center mt-1">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">+3.2% from last quarter</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Revenue Trend</h3>
            <p class="text-sm text-gray-500">Monthly revenue over the past 6 months</p>
        </div>
        <div class="px-6 py-4">
            <!-- Placeholder for chart -->
            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Revenue chart would be displayed here</p>
                    <p class="text-xs text-gray-400 mt-1">Integration with Chart.js or similar library</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Status Distribution -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Job Status Distribution</h3>
            <p class="text-sm text-gray-500">Current status of all active jobs</p>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-4">
                <!-- Pending -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Pending</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-3">28 jobs</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-400 h-2 rounded-full" style="width: 35%"></div>
                        </div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">In Progress</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-3">42 jobs</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 52%"></div>
                        </div>
                    </div>
                </div>

                <!-- Parts Pending -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Parts Pending</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-3">15 jobs</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 19%"></div>
                        </div>
                    </div>
                </div>

                <!-- Ready for Dispatch -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Ready for Dispatch</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-3">23 jobs</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 29%"></div>
                        </div>
                    </div>
                </div>

                <!-- Referred -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-fuchsia-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Referred</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-3">12 jobs</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-fuchsia-500 h-2 rounded-full" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Top Performing Technicians -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Top Performers</h3>
            <p class="text-sm text-gray-500">Based on completion rate and customer satisfaction</p>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-fuchsia-500 to-pink-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">1</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Ram Sharma</p>
                            <p class="text-xs text-gray-500">98% completion rate</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">45 jobs</p>
                        <p class="text-xs text-green-600">+8 this week</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sita Poudel</p>
                            <p class="text-xs text-gray-500">95% completion rate</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">38 jobs</p>
                        <p class="text-xs text-green-600">+5 this week</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">3</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Hari Thapa</p>
                            <p class="text-xs text-gray-500">92% completion rate</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">32 jobs</p>
                        <p class="text-xs text-green-600">+3 this week</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
            <p class="text-sm text-gray-500">Latest updates from your repair operations</p>
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
                                        <p class="text-sm text-gray-500">Job <span class="font-medium text-gray-900">#JOB-045</span> completed by <span class="font-medium text-gray-900">Ram Sharma</span></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        2 minutes ago
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">New job <span class="font-medium text-gray-900">#JOB-046</span> created for <span class="font-medium text-gray-900">Samsung Galaxy repair</span></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        15 minutes ago
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">New customer <span class="font-medium text-gray-900">Priya Sharma</span> registered</p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        1 hour ago
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

<?= $this->endSection() ?>
