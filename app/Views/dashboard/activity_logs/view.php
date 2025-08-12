<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Activity Log Details</h1>
        <p class="mt-1 text-sm text-gray-600">Detailed information about this activity</p>
    </div>
    <a href="<?= base_url('dashboard/activity-logs') ?>"
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200 shadow-lg shadow-gray-500/25">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Activity Logs
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Activity Details -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6 lg:p-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Activity Information</h2>
            
            <div class="space-y-6">
                <!-- Activity Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Activity Type</label>
                    <?php
                    $activityColors = [
                        'login' => 'bg-green-100 text-green-800',
                        'logout' => 'bg-orange-100 text-orange-800',
                        'post' => 'bg-blue-100 text-blue-800',
                        'update' => 'bg-yellow-100 text-yellow-800',
                        'delete' => 'bg-red-100 text-red-800',
                        'view' => 'bg-purple-100 text-purple-800'
                    ];
                    $activityIcons = [
                        'login' => 'sign-in-alt',
                        'logout' => 'sign-out-alt',
                        'post' => 'plus-circle',
                        'update' => 'edit',
                        'delete' => 'trash',
                        'view' => 'eye'
                    ];
                    $colorClass = $activityColors[$activity['activity_type']] ?? 'bg-gray-100 text-gray-800';
                    $iconClass = $activityIcons[$activity['activity_type']] ?? 'database';
                    ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $colorClass ?>">
                        <i class="fas fa-<?= $iconClass ?> mr-2"></i>
                        <?= ucfirst($activity['activity_type']) ?>
                    </span>
                </div>

                <!-- Details -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Activity Details</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900"><?= esc($activity['details']) ?></p>
                    </div>
                </div>

                <!-- Date & Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Date & Time</label>
                    <p class="text-gray-900 font-medium">
                        <?= date('F j, Y \a\t g:i:s A', strtotime($activity['created_at'])) ?>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        <?= date('l, M j, Y', strtotime($activity['created_at'])) ?>
                    </p>
                </div>

                <!-- IP Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">IP Address</label>
                    <div class="flex items-center">
                        <i class="fas fa-globe text-gray-400 mr-2"></i>
                        <span class="text-gray-900 font-mono"><?= esc($activity['ip_address']) ?></span>
                    </div>
                </div>

                <!-- User Agent -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">User Agent</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-700 font-mono break-all">
                            <?= esc($activity['user_agent']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- User Information -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">User Information</h3>
            <div class="space-y-4">
                <!-- User Avatar & Name -->
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
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

                <!-- User Role -->
                <?php if (!empty($activity['role'])): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <?= ucfirst($activity['role']) ?>
                    </span>
                </div>
                <?php endif; ?>

                <!-- User ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">User ID</label>
                    <p class="text-sm text-gray-900 font-mono">#<?= $activity['user_id'] ?></p>
                </div>
            </div>
        </div>

        <!-- Activity Metadata -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Metadata</h3>
            <div class="space-y-3">
                <!-- Activity ID -->
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Activity ID:</span>
                    <span class="text-sm font-mono text-gray-900">#<?= $activity['id'] ?></span>
                </div>

                <!-- Timestamp -->
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Timestamp:</span>
                    <span class="text-sm font-mono text-gray-900"><?= $activity['created_at'] ?></span>
                </div>

                <!-- Time Ago -->
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Time Ago:</span>
                    <span class="text-sm text-gray-900">
                        <?php
                        $timeAgo = time() - strtotime($activity['created_at']);
                        if ($timeAgo < 60) {
                            echo $timeAgo . ' seconds ago';
                        } elseif ($timeAgo < 3600) {
                            echo floor($timeAgo / 60) . ' minutes ago';
                        } elseif ($timeAgo < 86400) {
                            echo floor($timeAgo / 3600) . ' hours ago';
                        } else {
                            echo floor($timeAgo / 86400) . ' days ago';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <?php if (in_array($userRole, ['superadmin', 'admin'])): ?>
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('dashboard/activity-logs?search=' . urlencode($activity['full_name'])) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    View User Activities
                </a>

                <a href="<?= base_url('dashboard/activity-logs?activity_type=' . $activity['activity_type']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200">
                    <i class="fas fa-filter mr-2"></i>
                    Filter by Type
                </a>

                <button onclick="window.print()"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition-all duration-200">
                    <i class="fas fa-print mr-2"></i>
                    Print Details
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
