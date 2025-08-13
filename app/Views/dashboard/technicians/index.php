<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-cog text-white text-xl"></i>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-semibold text-gray-900">Technicians</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-user-cog mr-1"></i>
                        Management
                    </span>
                </div>
                <p class="text-sm text-gray-600">
                    View and manage technician accounts and performance
                </p>
            </div>
        </div>
        <div class="text-right">
            <?php helper('auth'); ?>
            <?php if (canCreateTechnician()): ?>
                <div class="text-sm text-gray-600 bg-blue-50 px-4 py-3 rounded-lg border border-blue-200">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    To add new technicians, use
                    <a href="<?= base_url('dashboard/user-management/create') ?>"
                       class="text-blue-600 hover:text-blue-800 font-medium underline">User Management</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Technician Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $technicianStats['total'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Total Technicians</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-green-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-check text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $technicianStats['active'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Active Technicians</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-orange-500/25 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-times text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?= $technicianStats['inactive'] ?></h3>
                <p class="text-sm font-medium text-gray-600">Inactive Technicians</p>
            </div>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <form method="GET" action="<?= base_url('dashboard/technicians') ?>" class="flex flex-col lg:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search Technicians</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text"
                       name="search"
                       value="<?= esc($search ?? '') ?>"
                       placeholder="Search by name, email, username, or phone..."
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
            </div>
        </div>
        <div class="flex items-end gap-3">
            <button type="submit"
                    class="px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200 flex items-center"
                    title="Search Technicians">
                <i class="fas fa-search"></i>
                <span class="hidden sm:inline sm:ml-2">Search</span>
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/technicians') ?>"
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Results Count -->
<?php if (!empty($search)): ?>
    <div class="mb-4">
        <p class="text-sm text-gray-600">
            <i class="fas fa-search mr-1"></i>
            Search results for "<strong><?= esc($search) ?></strong>"
            <?php if (isset($pager)): ?>
                - Showing <?= count($technicians) ?> technician(s)
            <?php endif; ?>
        </p>
    </div>
<?php endif; ?>

<!-- Technicians Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Technician
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact Info
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Job Statistics
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($technicians)): ?>
                    <?php foreach ($technicians as $technician): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                            <i class="fas fa-user-cog text-purple-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($technician['full_name']) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @<?= esc($technician['username']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php if (!empty($technician['email'])): ?>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            <a href="mailto:<?= esc($technician['email']) ?>"
                                               class="text-primary-600 hover:text-primary-700">
                                                <?= esc($technician['email']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($technician['phone'])): ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                                            <a href="tel:<?= esc($technician['phone']) ?>"
                                               class="text-primary-600 hover:text-primary-700">
                                                <?= esc($technician['phone']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (empty($technician['email']) && empty($technician['phone'])): ?>
                                        <span class="text-gray-400">No contact info</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php helper('auth'); ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getRoleColor('technician') ?>">
                                    <i class="<?= getRoleIcon('technician') ?> mr-1"></i>
                                    Technician
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusConfig = match($technician['status']) {
                                    'active' => ['bg-green-100 text-green-800', 'fas fa-check-circle', 'Active'],
                                    'inactive' => ['bg-gray-100 text-gray-800', 'fas fa-pause-circle', 'Inactive'],
                                    'suspended' => ['bg-red-100 text-red-800', 'fas fa-ban', 'Suspended'],
                                    default => ['bg-gray-100 text-gray-800', 'fas fa-question-circle', 'Unknown']
                                };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusConfig[0] ?>">
                                    <i class="<?= $statusConfig[1] ?> mr-1"></i>
                                    <?= $statusConfig[2] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= $technician['job_count'] ?? 0 ?> total
                                    </span>
                                    <?php if (isset($technician['pending_jobs']) && $technician['pending_jobs'] > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <?= $technician['pending_jobs'] ?> pending
                                        </span>
                                    <?php endif; ?>
                                    <?php if (isset($technician['in_progress_jobs']) && $technician['in_progress_jobs'] > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?= $technician['in_progress_jobs'] ?> active
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y', strtotime($technician['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/technicians/view/' . $technician['id']) ?>"
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (canCreateTechnician()): ?>
                                        <a href="<?= base_url('dashboard/user-management/edit/' . $technician['id']) ?>"
                                           class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50"
                                           title="Edit in User Management">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-user-cog text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No technicians found</p>
                                <p class="text-sm">Get started by adding your first technician.</p>
                                <a href="<?= base_url('dashboard/technicians/create') ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Technician
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager) && $pager): ?>
        <?= renderPagination($pager) ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
