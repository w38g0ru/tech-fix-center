<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-teal-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-warehouse text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Stock Movements</h1>
                <p class="text-sm text-gray-600">Track inventory stock movements (IN/OUT)</p>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2">
            <a href="<?= base_url('dashboard/movements/create') ?>"
               class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
               title="Add Stock Movement">
                <i class="fas fa-plus text-sm"></i>
                <span class="hidden md:inline md:ml-2 whitespace-nowrap">Add Stock</span>
            </a>
        </div>
    </div>
</div>

<!-- Movement Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-2xl transition-all duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg shadow-green-500/25">
                <i class="fas fa-arrow-down text-lg"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Stock Added</p>
                <p class="text-2xl font-bold text-gray-900"><?= $movementStats['total_in'] ?></p>
                <p class="text-xs text-green-600 font-medium">Total IN movements</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-2xl transition-all duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg shadow-red-500/25">
                <i class="fas fa-arrow-up text-lg"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Stock Used</p>
                <p class="text-2xl font-bold text-gray-900"><?= $movementStats['total_out'] ?></p>
                <p class="text-xs text-red-600 font-medium">Total OUT movements</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-2xl transition-all duration-200">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25">
                <i class="fas fa-exchange-alt text-lg"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Net Movement</p>
                <p class="text-2xl font-bold text-gray-900"><?= $movementStats['net_movement'] ?></p>
                <p class="text-xs text-blue-600 font-medium">IN minus OUT</p>
            </div>
        </div>
    </div>
</div>

<!-- Movements Table -->
<div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
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
                                   class="mt-4 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Stock
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
