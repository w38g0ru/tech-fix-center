<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Customer Management</h1>
                <p class="text-sm text-gray-600">Manage your repair shop customers and their information</p>
            </div>
        </div>
        <div class="text-right">
            <a href="<?= base_url('dashboard/users/create') ?>"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>Add New Customer
            </a>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <form method="GET" action="<?= base_url('dashboard/users') ?>" class="flex flex-col lg:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search Customers</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text"
                       name="search"
                       value="<?= esc($search ?? '') ?>"
                       placeholder="Search by name or mobile number..."
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
            </div>
        </div>
        <div class="flex items-end gap-3">
            <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/users') ?>"
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Customers Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile Number</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jobs</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="font-medium text-gray-900">
                                        <?= esc($user['name']) ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">
                                    <?= esc($user['mobile_number'] ?? 'N/A') ?>
                                </div>
                        </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($user['user_type'] === 'Registered'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <?= esc($user['user_type']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <?= esc($user['user_type']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?= $user['job_count'] ?? 0 ?> jobs
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= formatNepaliDate($user['created_at'], 'short') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/users/edit/' . $user['id']) ?>"
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php helper('auth'); ?>
                                    <?php if (canDeleteUser()): ?>
                                        <a href="<?= base_url('dashboard/users/delete/' . $user['id']) ?>"
                                           onclick="return confirm('Are you sure you want to delete this customer?')"
                                           class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                           title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium mb-2 text-gray-900">No customers found</p>
                                <p class="text-sm mb-6">Get started by adding your first customer.</p>
                                <a href="<?= base_url('dashboard/users/create') ?>"
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
                                    <i class="fas fa-plus mr-2"></i>Add Customer
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
