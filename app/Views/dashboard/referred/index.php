<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-semibold text-gray-900">Dispatch Management</h1>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $isAdmin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                <i class="fas <?= $isAdmin ? 'fa-crown' : 'fa-user' ?> mr-1"></i>
                <?= ucfirst($userRole) ?> Access
            </span>
        </div>
        <p class="mt-1 text-sm text-gray-600">
            <?= $isAdmin ? 'Full dispatch management with admin privileges' : 'View and manage dispatch operations' ?>
        </p>
    </div>
    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
        <?php if ($isAdmin): ?>
            <button onclick="showBulkActions()" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                <i class="fas fa-tasks mr-2"></i>
                Bulk Actions
            </button>
        <?php endif; ?>
        <a href="<?= base_url('dashboard/referred/create') ?>"
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Create Dispatch
        </a>
    </div>
</div>

<!-- Quick Actions for Jobs Ready for Dispatch -->
<?php if (!empty($readyForDispatch)): ?>
<div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-shipping-fast text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Jobs Ready for Dispatch</h2>
                <p class="text-sm text-gray-600"><?= count($readyForDispatch) ?> job(s) ready to be dispatched to customers</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach (array_slice($readyForDispatch, 0, 6) as $job): ?>
        <div class="bg-white rounded-lg border border-blue-200 p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-900">Job #<?= $job['id'] ?></span>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Ready
                </span>
            </div>
            <div class="text-sm text-gray-600 mb-3">
                <div><strong>Device:</strong> <?= esc($job['device_name']) ?></div>
                <div><strong>Customer:</strong> <?= esc($job['walk_in_customer_name'] ?: 'Walk-in Customer') ?></div>
                <?php if (!empty($job['walk_in_customer_mobile'])): ?>
                <div><strong>Mobile:</strong> <?= esc($job['walk_in_customer_mobile']) ?></div>
                <?php endif; ?>
            </div>
            <div class="flex items-center space-x-2">
                <form method="POST" action="<?= base_url('dashboard/referred/quick-dispatch/' . $job['id']) ?>" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit"
                            onclick="return confirm('Mark this job as dispatched to customer?')"
                            class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded text-xs font-medium text-white hover:bg-green-700 transition ease-in-out duration-150">
                        <i class="fas fa-check mr-1"></i>
                        Dispatch
                    </button>
                </form>
                <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-600 border border-transparent rounded text-xs font-medium text-white hover:bg-gray-700 transition ease-in-out duration-150">
                    <i class="fas fa-eye mr-1"></i>
                    View
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (count($readyForDispatch) > 6): ?>
    <div class="mt-4 text-center">
        <a href="<?= base_url('dashboard/jobs?status=Ready to Dispatch to Customer') ?>"
           class="text-blue-600 hover:text-blue-700 text-sm font-medium">
            View all <?= count($readyForDispatch) ?> jobs ready for dispatch →
        </a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Dispatch Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Dispatches</p>
                <p class="text-lg font-semibold text-gray-900"><?= $referredStats['total'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-lg font-semibold text-gray-900"><?= $referredStats['pending'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-truck"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Dispatched</p>
                <p class="text-lg font-semibold text-gray-900"><?= $referredStats['dispatched'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Completed</p>
                <p class="text-lg font-semibold text-gray-900"><?= $referredStats['completed'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="mb-6">
    <form method="GET" action="<?= base_url('dashboard/referred') ?>" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" 
                   name="search" 
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by customer name, phone, or device..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div class="flex gap-2">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Status</option>
                <option value="Pending" <?= ($status ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Dispatched" <?= ($status ?? '') === 'Dispatched' ? 'selected' : '' ?>>Dispatched</option>
                <option value="Completed" <?= ($status ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
            <button type="submit" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search) || !empty($status)): ?>
                <a href="<?= base_url('dashboard/referred') ?>" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Dispatch Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer & Device
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Referred To
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Photos
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
                <?php if (!empty($referred)): ?>
                    <?php foreach ($referred as $item): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= esc($item['customer_name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= esc($item['customer_phone'] ?? 'N/A') ?>
                                    </div>
                                    <?php if (!empty($item['device_name'])): ?>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Device: <?= esc($item['device_name']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?= esc($item['referred_to'] ?? 'Not specified') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClass = match($item['status']) {
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Dispatched' => 'bg-orange-100 text-orange-800',
                                    'Completed' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                    <?= esc($item['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-camera text-gray-400 mr-1"></i>
                                    <span class="text-sm text-gray-600"><?= $item['photo_count'] ?? 0 ?></span>
                                    <?php if (($item['photo_count'] ?? 0) > 0): ?>
                                        <a href="<?= base_url('dashboard/photos/referred/' . $item['id']) ?>" 
                                           class="ml-2 text-primary-600 hover:text-primary-700 text-xs">
                                            View
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= formatNepaliDate($item['created_at'], 'short') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/referred/view/' . $item['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('dashboard/referred/edit/' . $item['id']) ?>" 
                                       class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php helper('auth'); ?>
                                    <?php if (canDeleteJob()): ?>
                                        <a href="<?= base_url('dashboard/referred/delete/' . $item['id']) ?>" 
                                           onclick="return confirm('Are you sure you want to delete this dispatch item?')"
                                           class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-shipping-fast text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No dispatch items found</p>
                                <p class="text-sm">Get started by creating your first dispatch item.</p>
                                <a href="<?= base_url('dashboard/referred/create') ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create Dispatch
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
