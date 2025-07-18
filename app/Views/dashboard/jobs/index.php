<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Jobs</h1>
        <p class="mt-1 text-sm text-gray-600">Manage repair jobs and track progress</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('dashboard/jobs/create') ?>"
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Create Job
        </a>
    </div>
</div>

<!-- Job Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['total'] ?></p>
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
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['pending'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-cog"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">In Progress</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['in_progress'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-wrench"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Parts Pending</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['parts_pending'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-building"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Referred</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['referred_to_service'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-undo"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Returned</p>
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['returned'] ?></p>
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
                <p class="text-lg font-semibold text-gray-900"><?= $jobStats['completed'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="mb-6">
    <form method="GET" action="<?= base_url('dashboard/jobs') ?>" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" 
                   name="search" 
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search jobs by device, customer, or technician..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div class="flex gap-2">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Status</option>
                <option value="Pending" <?= ($status ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= ($status ?? '') === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Parts Pending" <?= ($status ?? '') === 'Parts Pending' ? 'selected' : '' ?>>Parts Pending</option>
                <option value="Referred to Service Center" <?= ($status ?? '') === 'Referred to Service Center' ? 'selected' : '' ?>>Referred to Service Center</option>
                <option value="Ready to Dispatch to Customer" <?= ($status ?? '') === 'Ready to Dispatch to Customer' ? 'selected' : '' ?>>Ready to Dispatch</option>
                <option value="Returned" <?= ($status ?? '') === 'Returned' ? 'selected' : '' ?>>Returned</option>
                <option value="Completed" <?= ($status ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search) || !empty($status)): ?>
                <a href="<?= base_url('dashboard/jobs') ?>" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Jobs Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
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
                        Technician
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
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
                <?php if (!empty($jobs)): ?>
                    <?php foreach ($jobs as $job): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= esc($job['device_name'] ?? 'N/A') ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Serial: <?= esc($job['serial_number'] ?? 'N/A') ?>
                                    </div>
                                    <?php if (!empty($job['problem'])): ?>
                                        <div class="text-xs text-gray-500 mt-1">
                                            <?= esc(substr($job['problem'], 0, 50)) ?><?= strlen($job['problem']) > 50 ? '...' : '' ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php
                                    // Use the JobModel method to get proper customer display name
                                    $jobModel = new \App\Models\JobModel();
                                    $customerDisplayName = $jobModel->getCustomerDisplayName($job);
                                    echo esc($customerDisplayName);
                                    ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php
                                    // Display mobile number based on customer type
                                    if (!empty($job['customer_name'])) {
                                        // Existing customer - show registered mobile
                                        echo esc($job['mobile_number'] ?? 'No phone');
                                    } elseif (!empty($job['walk_in_customer_mobile'])) {
                                        // Walk-in customer with mobile
                                        echo esc($job['walk_in_customer_mobile']);
                                    } else {
                                        // Walk-in customer without mobile
                                        echo 'No phone provided';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?= esc($job['technician_name'] ?? 'Unassigned') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClass = match($job['status']) {
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'In Progress' => 'bg-blue-100 text-blue-800',
                                    'Parts Pending' => 'bg-orange-100 text-orange-800',
                                    'Referred to Service Center' => 'bg-purple-100 text-purple-800',
                                    'Ready to Dispatch to Customer' => 'bg-indigo-100 text-indigo-800',
                                    'Returned' => 'bg-red-100 text-red-800',
                                    'Completed' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                    <?= esc($job['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y', strtotime($job['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>"
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>"
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php helper('auth'); ?>
                                    <?php if (canDeleteJob()): ?>
                                        <a href="<?= base_url('dashboard/jobs/delete/' . $job['id']) ?>"
                                           onclick="return confirm('Are you sure you want to delete this job?')"
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
                                <i class="fas fa-wrench text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No jobs found</p>
                                <p class="text-sm">Get started by creating your first job.</p>
                                <a href="<?= base_url('dashboard/jobs/create') ?>"
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create Job
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
