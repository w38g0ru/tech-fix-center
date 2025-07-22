<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>
        <p class="mt-1 text-sm text-gray-600">Manage all system users including admins, technicians, and customers</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <button onclick="sendSms()"
                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-sms mr-2"></i>
            Send SMS
        </button>
        <a href="<?= base_url('dashboard/technicians') ?>"
           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-user-cog mr-2"></i>
            Technicians
        </a>
        <a href="<?= base_url('dashboard/user-management/create') ?>"
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Add New User
        </a>
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

<!-- Users Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact Info
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Login
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($user['full_name']) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @<?= esc($user['username']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center mb-1">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        <a href="mailto:<?= esc($user['email']) ?>" 
                                           class="text-primary-600 hover:text-primary-700">
                                            <?= esc($user['email']) ?>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $roleConfig = match($user['role']) {
                                    'superadmin' => ['bg-red-100 text-red-800', 'fas fa-crown', 'Super Admin'],
                                    'admin' => ['bg-purple-100 text-purple-800', 'fas fa-shield-alt', 'Admin'],
                                    'technician' => ['bg-green-100 text-green-800', 'fas fa-cog', 'Technician'],
                                    'user' => ['bg-gray-100 text-gray-800', 'fas fa-user', 'User'],
                                    default => ['bg-gray-100 text-gray-800', 'fas fa-question', 'Unknown']
                                };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $roleConfig[0] ?>">
                                    <i class="<?= $roleConfig[1] ?> mr-1"></i>
                                    <?= $roleConfig[2] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusConfig = match($user['status']) {
                                    'active' => ['bg-green-100 text-green-800', 'fas fa-check-circle'],
                                    'inactive' => ['bg-gray-100 text-gray-800', 'fas fa-pause-circle'],
                                    'suspended' => ['bg-red-100 text-red-800', 'fas fa-ban'],
                                    default => ['bg-gray-100 text-gray-800', 'fas fa-question-circle']
                                };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusConfig[0] ?>">
                                    <i class="<?= $statusConfig[1] ?> mr-1"></i>
                                    <?= ucfirst($user['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if (!empty($user['last_login'])): ?>
                                    <?= date('M j, Y g:i A', strtotime($user['last_login'])) ?>
                                <?php else: ?>
                                    <span class="text-gray-400">Never</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= base_url('dashboard/user-management/view/' . $user['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('dashboard/user-management/edit/' . $user['id']) ?>" 
                                       class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($user['role'] !== 'superadmin' || hasRole('superadmin')): ?>
                                        <?php if ($user['id'] != session()->get('user_id')): ?>
                                            <a href="<?= base_url('dashboard/user-management/delete/' . $user['id']) ?>" 
                                               onclick="return confirm('Are you sure you want to delete this user?')"
                                               class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
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
                                <p class="text-lg font-medium">No users found</p>
                                <p class="text-sm">Get started by adding your first user.</p>
                                <a href="<?= base_url('dashboard/user-management/create') ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add User
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

<?= $this->section('scripts') ?>
<script>
function sendSms() {
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

    // Make AJAX request to send SMS
    fetch('<?= base_url('dashboard/user-management/send-sms') ?>', {
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
            // Show success message with count
            const count = data.count || 0;
            showAlert(`SMS sent successfully to ${count} user${count !== 1 ? 's' : ''}!`, 'success');
        } else {
            // Show error message
            showAlert('Failed to send SMS: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        // Reset button state
        button.disabled = false;
        button.innerHTML = originalText;

        console.error('Error:', error);
        showAlert('An error occurred while sending SMS', 'error');
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
