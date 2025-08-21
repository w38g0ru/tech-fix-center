<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">User Details</h1>
        <p class="mt-1 text-sm text-gray-600">View user information and account details</p>
    </div>
    <div class="flex space-x-2">
        <?php if (!empty($user['phone'])): ?>
        <button onclick="sendSmsToUser(<?= $user['id'] ?>)"
                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-sms mr-2"></i>
            Send SMS
        </button>
        <?php endif; ?>
        <a href="<?= base_url('dashboard/user-management/edit/' . $user['id']) ?>"
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
            <i class="fas fa-edit mr-2"></i>
            Edit User
        </a>
        <a href="<?= base_url('dashboard/user-management') ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">User ID</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">#<?= $user['id'] ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Full Name</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?= esc($user['full_name']) ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Username</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">@<?= esc($user['username']) ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Email Address</label>
                    <p class="mt-1">
                        <a href="mailto:<?= esc($user['email']) ?>"
                           class="text-primary-600 hover:text-primary-700 font-medium">
                            <?= esc($user['email']) ?>
                        </a>
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Phone Number</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        <?php if (!empty($user['phone'])): ?>
                            <a href="tel:<?= esc($user['phone']) ?>"
                               class="text-primary-600 hover:text-primary-700 font-medium">
                                <?= esc($user['phone']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400">Not provided</span>
                        <?php endif; ?>
                    </p>
                </div>

                <?php if (!empty($user['address'])): ?>
                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-500">Address</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?= esc($user['address']) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">Current Status</label>
                    <div class="mt-1">
                        <?php
                        $statusConfig = match($user['status']) {
                            'active' => ['bg-green-100 text-green-800', 'fas fa-check-circle', 'Active'],
                            'inactive' => ['bg-gray-100 text-gray-800', 'fas fa-pause-circle', 'Inactive'],
                            'suspended' => ['bg-red-100 text-red-800', 'fas fa-ban', 'Suspended'],
                            default => ['bg-gray-100 text-gray-800', 'fas fa-question-circle', 'Unknown']
                        };
                        ?>
                        <span class="px-3 py-1 text-sm font-medium rounded-full <?= $statusConfig[0] ?>">
                            <i class="<?= $statusConfig[1] ?> mr-1"></i>
                            <?= $statusConfig[2] ?>
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Last Login</label>
                    <p class="mt-1 text-sm text-gray-900">
                        <?php if (!empty($user['last_login'])): ?>
                            <?= formatNepaliDateTime($user['last_login'], 'medium') ?>
                        <?php else: ?>
                            <span class="text-gray-400">कहिल्यै लगइन गरेको छैन</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">खाता सिर्जना</p>
                        <p class="text-sm text-gray-500"><?= formatNepaliDateTime($user['created_at'], 'medium') ?></p>
                    </div>
                </div>
                
                <?php if (!empty($user['updated_at'])): ?>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-yellow-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">प्रोफाइल अपडेट</p>
                            <p class="text-sm text-gray-500"><?= formatNepaliDateTime($user['updated_at'], 'medium') ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($user['last_login'])): ?>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-sign-in-alt text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">अन्तिम लगइन</p>
                            <p class="text-sm text-gray-500"><?= formatNepaliDateTime($user['last_login'], 'medium') ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Role Information -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Role & Permissions</h3>
            
            <div class="text-center">
                <?php
                $roleConfig = match($user['role']) {
                    'superadmin' => ['bg-red-100 text-red-800', 'fas fa-crown', 'Super Admin', 'Full system access'],
                    'admin' => ['bg-purple-100 text-purple-800', 'fas fa-shield-alt', 'Admin', 'Can manage users and jobs'],
                    'technician' => ['bg-green-100 text-green-800', 'fas fa-cog', 'Technician', 'Can manage jobs and inventory'],
                    'user' => ['bg-gray-100 text-gray-800', 'fas fa-user', 'User', 'Limited access'],
                    default => ['bg-gray-100 text-gray-800', 'fas fa-question', 'Unknown', 'Unknown permissions']
                };
                ?>
                
                <div class="w-16 h-16 mx-auto mb-3 rounded-full <?= str_replace('text-', 'bg-', str_replace('100', '200', explode(' ', $roleConfig[0])[0])) ?> flex items-center justify-center">
                    <i class="<?= $roleConfig[1] ?> text-2xl <?= explode(' ', $roleConfig[0])[1] ?>"></i>
                </div>
                
                <h4 class="text-lg font-semibold text-gray-900"><?= $roleConfig[2] ?></h4>
                <p class="text-sm text-gray-600 mt-1"><?= $roleConfig[3] ?></p>
                
                <div class="mt-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full <?= $roleConfig[0] ?>">
                        <i class="<?= $roleConfig[1] ?> mr-1"></i>
                        <?= $roleConfig[2] ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Statistics</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">खाता उमेर</span>
                    <span class="text-sm font-medium text-gray-900">
                        <?php
                        $created = new DateTime($user['created_at']);
                        $now = new DateTime();
                        $diff = $now->diff($created);
                        echo $diff->days . ' दिन';
                        ?>
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">लगइन संख्या</span>
                    <span class="text-sm font-medium text-gray-900">
                        <?= !empty($user['last_login']) ? '1+' : '0' ?>
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">प्रोफाइल अपडेट</span>
                    <span class="text-sm font-medium text-gray-900">
                        <?= !empty($user['updated_at']) ? '1+' : '0' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                <?php if (!empty($user['phone'])): ?>
                <button onclick="sendSmsToUser(<?= $user['id'] ?>)"
                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-purple-300 rounded-md text-sm font-medium text-purple-700 hover:bg-purple-50">
                    <i class="fas fa-sms mr-2"></i>
                    Send SMS to <?= esc($user['full_name']) ?>
                </button>
                <?php else: ?>
                <div class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-400 cursor-not-allowed">
                    <i class="fas fa-sms mr-2"></i>
                    No Phone Number
                </div>
                <?php endif; ?>

                <a href="mailto:<?= esc($user['email']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Email
                </a>

                <a href="<?= base_url('dashboard/user-management/edit/' . $user['id']) ?>"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-edit mr-2"></i>
                    Edit User
                </a>
                
                <?php if ($user['status'] === 'active'): ?>
                    <form action="<?= base_url('dashboard/user-management/updateStatus/' . $user['id']) ?>" method="POST" class="w-full">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="suspended">
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to suspend this user?')"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50">
                            <i class="fas fa-ban mr-2"></i>
                            Suspend User
                        </button>
                    </form>
                <?php else: ?>
                    <form action="<?= base_url('dashboard/user-management/updateStatus/' . $user['id']) ?>" method="POST" class="w-full">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="active">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 hover:bg-green-50">
                            <i class="fas fa-check mr-2"></i>
                            Activate User
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function sendSmsToUser(userId) {
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

    // Make AJAX request to send SMS to specific user
    fetch('<?= base_url('dashboard/sms/user/') ?>' + userId, {
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
            showAlert(data.message || 'SMS sent successfully to user!', 'success');
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
