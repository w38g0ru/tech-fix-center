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

<!-- Customers Cards -->
<div class="space-y-4">
    <?php if (!empty($users)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($users as $user): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <!-- Customer Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900"><?= esc($user['name']) ?></h3>
                                <p class="text-sm text-gray-500">Customer ID: #<?= $user['id'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
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
                    </div>

                    <!-- Customer Details -->
                    <div class="space-y-3">
                        <!-- Mobile Number -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Mobile:</span>
                            <span class="text-sm font-medium text-gray-900">
                                <?= esc($user['mobile_number'] ?? 'N/A') ?>
                            </span>
                        </div>

                        <!-- Customer Type -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Type:</span>
                            <?php if ($user['user_type'] === 'Registered'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <?= esc($user['user_type']) ?>
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <?= esc($user['user_type']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Jobs Count -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Jobs:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?= $user['job_count'] ?? 0 ?> jobs
                            </span>
                        </div>

                        <!-- Created Date -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Created:</span>
                            <span class="text-sm text-gray-500">
                                <?= formatNepaliDate($user['created_at'], 'short') ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-16 text-center">
            <div class="text-gray-500">
                <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium mb-2 text-gray-900">No customers found</p>
                <p class="text-sm mb-6">Get started by adding your first customer.</p>
                <a href="<?= base_url('dashboard/users/create') ?>"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Add Customer
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
