<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Stock Movements</h1>
        <p class="mt-1 text-sm text-gray-600">Track inventory stock movements (IN/OUT)</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('dashboard/movements/create') ?>" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Add Movement
        </a>
    </div>
</div>

<!-- Movement Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total IN</p>
                <p class="text-lg font-semibold text-gray-900"><?= $movementStats['total_in'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total OUT</p>
                <p class="text-lg font-semibold text-gray-900"><?= $movementStats['total_out'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-balance-scale"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Net Movement</p>
                <p class="text-lg font-semibold text-gray-900"><?= $movementStats['net_movement'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Movements Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Item
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Movement
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Related Job
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($movements)): ?>
                    <?php foreach ($movements as $movement): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= esc($movement['device_name'] ?? 'N/A') ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= esc($movement['brand']) ?> <?= esc($movement['model']) ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $movement['movement_type'] === 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas fa-arrow-<?= $movement['movement_type'] === 'IN' ? 'down' : 'up' ?> mr-1"></i>
                                    <?= $movement['movement_type'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= $movement['quantity'] ?> units
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($movement['job_device'])): ?>
                                    <div class="text-sm text-gray-900">
                                        <?= esc($movement['job_device']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= esc($movement['customer_name'] ?? 'N/A') ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-sm text-gray-500">No job linked</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y g:i A', strtotime($movement['moved_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-exchange-alt text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No stock movements found</p>
                                <p class="text-sm">Get started by recording your first stock movement.</p>
                                <a href="<?= base_url('dashboard/movements/create') ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Movement
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
