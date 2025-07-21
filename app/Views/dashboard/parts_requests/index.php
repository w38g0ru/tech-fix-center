<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Parts Requests</h1>
        <p class="mt-1 text-sm text-gray-600">Manage and track parts requests for repairs</p>
    </div>
    <?php if ($userRole === 'technician'): ?>
        <div class="mt-4 sm:mt-0">
            <a href="<?= base_url('dashboard/parts-requests/create') ?>"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Request Parts
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <!-- Total Requests -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-list text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Total</p>
                <p class="text-xl font-semibold text-gray-900"><?= $stats['total'] ?></p>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Pending</p>
                <p class="text-xl font-semibold text-gray-900"><?= $stats['pending'] ?></p>
            </div>
        </div>
    </div>

    <!-- Approved Requests -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Approved</p>
                <p class="text-xl font-semibold text-gray-900"><?= $stats['approved'] ?></p>
            </div>
        </div>
    </div>
    <!-- Ordered Requests -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-shopping-cart text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Ordered</p>
                <p class="text-xl font-semibold text-gray-900"><?= $stats['ordered'] ?></p>
            </div>
        </div>
    </div>

    <!-- Received Requests -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-emerald-100 text-emerald-600">
                <i class="fas fa-box text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Received</p>
                <p class="text-xl font-semibold text-gray-900"><?= $stats['received'] ?></p>
            </div>
        </div>
    </div>

    <!-- Rejected Requests -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-times text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Rejected</p>
                <p class="text-xl font-semibold text-gray-900"><?= $stats['rejected'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Parts Requests Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Parts Requests</h3>
        <p class="mt-1 text-sm text-gray-600">A list of all parts requests in the system</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Details</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgency</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($partsRequests)): ?>
                    <?php foreach ($partsRequests as $request): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #<?= $request['id'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($request['item_name']) ?></div>
                                <?php if (!empty($request['brand'])): ?>
                                    <div class="text-sm text-gray-500"><?= esc($request['brand']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= esc($request['technician_name']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if (!empty($request['job_device'])): ?>
                                    <?= esc($request['job_device']) ?>
                                <?php else: ?>
                                    <span class="text-gray-400">No job</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= $request['quantity_requested'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $urgencyClasses = [
                                    'Low' => 'bg-gray-100 text-gray-800',
                                    'Medium' => 'bg-blue-100 text-blue-800',
                                    'High' => 'bg-yellow-100 text-yellow-800',
                                    'Critical' => 'bg-red-100 text-red-800'
                                ];
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $urgencyClasses[$request['urgency']] ?>">
                                    <?= $request['urgency'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClasses = [
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Approved' => 'bg-green-100 text-green-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    'Ordered' => 'bg-blue-100 text-blue-800',
                                    'Received' => 'bg-emerald-100 text-emerald-800',
                                    'Cancelled' => 'bg-gray-100 text-gray-800'
                                ];
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $statusClasses[$request['status']] ?>">
                                    <?= $request['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('M d, Y', strtotime($request['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?= base_url('dashboard/parts-requests/view/' . $request['id']) ?>"
                                       class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded transition-colors duration-200"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php
                                    // Show edit button for technicians (own pending requests) or admins
                                    $canEdit = false;
                                    if (in_array($userRole, ['superadmin', 'admin'])) {
                                        $canEdit = true;
                                    } elseif ($userRole === 'technician' && $request['status'] === 'Pending') {
                                        // Check if this is the technician's own request
                                        $canEdit = true; // We'll check ownership in the controller
                                    }
                                    ?>

                                    <?php if ($canEdit && $request['status'] === 'Pending'): ?>
                                        <a href="<?= base_url('dashboard/parts-requests/edit/' . $request['id']) ?>"
                                           class="inline-flex items-center px-2 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-medium rounded transition-colors duration-200"
                                           title="Edit Request">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (in_array($userRole, ['superadmin', 'admin']) && $request['status'] === 'Pending'): ?>
                                        <button type="button"
                                                class="inline-flex items-center px-2 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded transition-colors duration-200"
                                                onclick="approveRequest(<?= $request['id'] ?>)"
                                                title="Approve Request">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button"
                                                class="inline-flex items-center px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded transition-colors duration-200"
                                                onclick="rejectRequest(<?= $request['id'] ?>)"
                                                title="Reject Request">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No parts requests found</h3>
                                <p class="text-gray-500 mb-4">Get started by creating your first parts request.</p>
                                <?php if ($userRole === 'technician'): ?>
                                    <a href="<?= base_url('dashboard/parts-requests/create') ?>"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Create First Request
                                    </a>
                                <?php endif; ?>
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

<!-- JavaScript for Actions -->
<script>
function approveRequest(id) {
    if (confirm('Are you sure you want to approve this parts request?')) {
        // Create and submit approval form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('dashboard/parts-requests/approve/') ?>' + id;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '<?= csrf_token() ?>';
        csrfInput.value = '<?= csrf_hash() ?>';

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function rejectRequest(id) {
    const reason = prompt('Please provide a reason for rejection:');
    if (reason && reason.trim() !== '') {
        // Create and submit rejection form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('dashboard/parts-requests/reject/') ?>' + id;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '<?= csrf_token() ?>';
        csrfInput.value = '<?= csrf_hash() ?>';

        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'rejection_reason';
        reasonInput.value = reason.trim();

        form.appendChild(csrfInput);
        form.appendChild(reasonInput);
        document.body.appendChild(form);
        form.submit();
    } else if (reason !== null) {
        alert('Please provide a valid reason for rejection.');
    }
}
</script>
<?= $this->endSection() ?>
