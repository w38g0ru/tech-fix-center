<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="card-header">
    <div>
        <h1 class="card-title">Customers</h1>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Manage your repair shop customers</p>
    </div>
    <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i>Add Customer
    </a>
</div>

<!-- Search Bar -->
<div class="card">
    <form method="GET" action="<?= base_url('dashboard/users') ?>" style="display: flex; gap: 12px; align-items: end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <label class="form-label">Search Customers</label>
            <input type="text"
                   name="search"
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by name or mobile number..."
                   class="form-input">
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/users') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Customers Table -->
<div style="overflow-x: auto;">
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Mobile Number</th>
                <th>Type</th>
                <th>Jobs</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($user['name']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?= esc($user['mobile_number'] ?? 'N/A') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $user['user_type'] === 'Registered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                    <?= esc($user['user_type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?= $user['job_count'] ?? 0 ?> jobs
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y', strtotime($user['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/users/edit/' . $user['id']) ?>"
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php helper('auth'); ?>
                                    <?php if (canDeleteUser()): ?>
                                        <a href="<?= base_url('dashboard/users/delete/' . $user['id']) ?>"
                                           onclick="return confirm('Are you sure you want to delete this customer?')"
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
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No customers found</p>
                                <p class="text-sm">Get started by adding your first customer.</p>
                                <a href="<?= base_url('dashboard/users/create') ?>"
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Customer
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
