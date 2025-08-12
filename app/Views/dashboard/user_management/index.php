<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users-cog text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>
                <p class="text-sm text-gray-600">Manage all system users including admins, technicians, and customers</p>
            </div>
        </div>
        <div class="text-right flex items-center space-x-3">
            <button onclick="sendSms()"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                <i class="fas fa-sms mr-2"></i>Send SMS
            </button>
            <a href="<?= base_url('dashboard/technicians') ?>"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-user-cog mr-2"></i>Technicians
            </a>
            <a href="<?= base_url('dashboard/user-management/create') ?>"
               class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>Add New User
            </a>
        </div>
    </div>
</div>

<!-- User Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Users</p>
                <p class="text-lg font-semibold text-gray-900"><?= $userStats['total'] ?? count($users) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Active Users</p>
                <p class="text-lg font-semibold text-gray-900"><?= $userStats['active'] ?? count(array_filter($users, fn($u) => $u['status'] === 'active')) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-crown"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Admins</p>
                <p class="text-lg font-semibold text-gray-900"><?= ($userStats['superadmin'] ?? 0) + ($userStats['admin'] ?? 0) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-cog"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Technicians</p>
                <p class="text-lg font-semibold text-gray-900"><?= $userStats['technician'] ?? count(array_filter($users, fn($u) => $u['role'] === 'technician')) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="p-4 border-b border-gray-200">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="<?= esc($search ?? '') ?>"
                       placeholder="Search users by name, username, or email..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div>
                <select name="role" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Roles</option>
                    <option value="superadmin" <?= ($role ?? '') === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="admin" <?= ($role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="technician" <?= ($role ?? '') === 'technician' ? 'selected' : '' ?>>Technician</option>
                    <option value="user" <?= ($role ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <div>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="suspended" <?= ($status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                    <i class="fas fa-search mr-1"></i>Search
                </button>
                <a href="<?= base_url('dashboard/user-management') ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    <i class="fas fa-times mr-1"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Users Cards -->
<div class="space-y-4">
    <?php if (!empty($users)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($users as $user): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <!-- User Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900"><?= esc($user['full_name']) ?></h3>
                                <p class="text-sm text-gray-500">@<?= esc($user['username']) ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <a href="<?= base_url('dashboard/user-management/view/' . $user['id']) ?>"
                               class="text-blue-600 hover:text-blue-900 p-1.5 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                               title="View">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="<?= base_url('dashboard/user-management/edit/' . $user['id']) ?>"
                               class="text-purple-600 hover:text-purple-900 p-1.5 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                               title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <?php if ($user['role'] !== 'superadmin' || hasRole('superadmin')): ?>
                                <?php if ($user['id'] != session()->get('user_id')): ?>
                                    <a href="<?= base_url('dashboard/user-management/delete/' . $user['id']) ?>"
                                       onclick="return confirm('Are you sure you want to delete this user?')"
                                       class="text-red-600 hover:text-red-900 p-1.5 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                       title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="space-y-3">
                        <!-- Email -->
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <div class="mt-1">
                                <a href="mailto:<?= esc($user['email']) ?>"
                                   class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                    <?= esc($user['email']) ?>
                                </a>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Role:</span>
                            <?php
                            $roleConfig = match($user['role']) {
                                'superadmin' => ['bg-red-100 text-red-800', 'fas fa-crown', 'Super Admin'],
                                'admin' => ['bg-purple-100 text-purple-800', 'fas fa-shield-alt', 'Admin'],
                                'technician' => ['bg-green-100 text-green-800', 'fas fa-cog', 'Technician'],
                                'user' => ['bg-gray-100 text-gray-800', 'fas fa-user', 'User'],
                                default => ['bg-gray-100 text-gray-800', 'fas fa-question', 'Unknown']
                            };
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $roleConfig[0] ?>">
                                <i class="<?= $roleConfig[1] ?> mr-1"></i>
                                <?= $roleConfig[2] ?>
                            </span>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status:</span>
                            <?php
                            $statusConfig = match($user['status']) {
                                'active' => ['bg-green-100 text-green-800', 'fas fa-check-circle'],
                                'inactive' => ['bg-gray-100 text-gray-800', 'fas fa-pause-circle'],
                                'suspended' => ['bg-red-100 text-red-800', 'fas fa-ban'],
                                default => ['bg-gray-100 text-gray-800', 'fas fa-question-circle']
                            };
                            ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusConfig[0] ?>">
                                <i class="<?= $statusConfig[1] ?> mr-1"></i>
                                <?= ucfirst($user['status']) ?>
                            </span>
                        </div>

                        <!-- Last Login -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Last Login:</span>
                            <span class="text-sm text-gray-500">
                                <?php if (!empty($user['last_login'])): ?>
                                    <?= formatNepaliDateTime($user['last_login'], 'short') ?>
                                <?php else: ?>
                                    <span class="text-gray-400">कहिल्यै नभएको</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pager) && $pager): ?>
            <div class="mt-6">
                <?= renderPagination($pager) ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-16 text-center">
            <div class="text-gray-500">
                <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium mb-2 text-gray-900">No users found</p>
                <p class="text-sm mb-6">Get started by adding your first user.</p>
                <a href="<?= base_url('dashboard/user-management/create') ?>"
                   class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Add User
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function sendSms() {
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

    // Make AJAX request to send SMS
    fetch('<?= base_url('dashboard/sms/bulk') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
        },
        body: JSON.stringify({
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        // Reset button state
        button.disabled = false;
        button.innerHTML = originalText;

        if (data.status) {
            // Show success message
            showAlert(data.message || 'SMS sent successfully!', 'success');
        } else {
            // Show detailed error message
            let errorMsg = data.message || 'Unknown error occurred';
            if (data.code) {
                errorMsg += ` (Code: ${data.code})`;
            }
            showAlert('Failed to send SMS: ' + errorMsg, 'error');

            // Log detailed error for debugging
            if (data.debug) {
                console.error('SMS Error Details:', data.debug);
            }
        }
    })
    .catch(error => {
        // Reset button state
        button.disabled = false;
        button.innerHTML = originalText;

        console.error('Network/Server Error:', error);

        // Show appropriate error message based on error type
        let errorMessage = 'Network error occurred while sending SMS';
        if (error.name === 'TypeError') {
            errorMessage = 'Unable to connect to SMS service. Please check your internet connection.';
        } else if (error.message) {
            errorMessage = `SMS service error: ${error.message}`;
        }

        showAlert(errorMessage, 'error');
    });
}

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
        type === 'success'
            ? 'bg-green-50 border border-green-200 text-green-800'
            : 'bg-red-50 border border-red-200 text-red-800'
    }`;

    alertDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    // Add to page
    document.body.appendChild(alertDiv);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
<?= $this->endSection() ?>
