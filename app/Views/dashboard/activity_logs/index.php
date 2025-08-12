<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Activity Logs</h1>
        <p class="text-gray-600">
            <?php if (in_array($userRole, ['superadmin', 'admin'])): ?>
                Monitor all user activities and system events
            <?php else: ?>
                View your activity history and system interactions
            <?php endif; ?>
        </p>
    </div>
    <div class="mt-4 lg:mt-0 flex flex-wrap gap-3">
        <!-- Export Button (Admin Only) -->
        <?php if (in_array($userRole, ['superadmin', 'admin'])): ?>
        <a href="<?= base_url('dashboard/activity-logs/export') ?>"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors duration-200 shadow-sm border border-gray-300"
           title="Export activity logs to CSV">
            <i class="fas fa-file-export mr-2"></i>Export
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Activities -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Activities</p>
                <p class="text-3xl font-bold text-gray-900"><?= $stats['total_activities'] ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white"></i>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-500">Last 30 days</p>
    </div>

    <!-- Login Count -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Logins</p>
                <p class="text-3xl font-bold text-green-600"><?= $stats['login_count'] ?></p>
            </div>
            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-sign-in-alt text-white"></i>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-500">Login sessions</p>
    </div>

    <!-- Logout Count -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Logouts</p>
                <p class="text-3xl font-bold text-orange-600"><?= $stats['logout_count'] ?></p>
            </div>
            <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-sign-out-alt text-white"></i>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-500">Logout sessions</p>
    </div>

    <!-- Post Activities -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Data Posts</p>
                <p class="text-3xl font-bold text-purple-600"><?= $stats['post_count'] ?></p>
            </div>
            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-database text-white"></i>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-500">Data operations</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Activities</h3>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Search -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" 
                   id="search" 
                   name="search" 
                   value="<?= esc($search) ?>"
                   placeholder="Search activities..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Activity Type -->
        <div>
            <label for="activity_type" class="block text-sm font-medium text-gray-700 mb-1">Activity Type</label>
            <select id="activity_type" 
                    name="activity_type" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Types</option>
                <option value="login" <?= $activityType === 'login' ? 'selected' : '' ?>>Login</option>
                <option value="logout" <?= $activityType === 'logout' ? 'selected' : '' ?>>Logout</option>
                <option value="post" <?= $activityType === 'post' ? 'selected' : '' ?>>Data Post</option>
            </select>
        </div>

        <!-- Date From -->
        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
            <input type="date" 
                   id="date_from" 
                   name="date_from" 
                   value="<?= esc($dateFrom) ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Date To -->
        <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
            <input type="date" 
                   id="date_to" 
                   name="date_to" 
                   value="<?= esc($dateTo) ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Filter Button -->
        <div class="flex items-end">
            <button type="submit" 
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-all duration-200">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Activity Logs Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($activities)): ?>
                    <?php foreach ($activities as $activity): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($activity['full_name'] ?? 'Unknown User') ?>
                                        </div>
                                        <?php if (!empty($activity['email'])): ?>
                                            <div class="text-sm text-gray-500"><?= esc($activity['email']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $activityColors = [
                                    'login' => 'bg-green-100 text-green-800',
                                    'logout' => 'bg-orange-100 text-orange-800',
                                    'post' => 'bg-blue-100 text-blue-800'
                                ];
                                $colorClass = $activityColors[$activity['activity_type']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $colorClass ?>">
                                    <?= ucfirst($activity['activity_type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate" title="<?= esc($activity['details']) ?>">
                                    <?= esc($activity['details']) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($activity['ip_address']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y g:i A', strtotime($activity['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?= base_url('dashboard/activity-logs/view/' . $activity['id']) ?>"
                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-history text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No activity logs found</h3>
                                <p class="text-gray-500">No activities match your current filters.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager) && $pager): ?>
        <?php helper('pagination'); ?>
        <?= renderPagination($pager) ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
