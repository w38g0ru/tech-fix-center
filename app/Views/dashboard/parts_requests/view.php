<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Parts Request #<?= $partsRequest['id'] ?></h1>
        <p class="mt-1 text-sm text-gray-600">View detailed information about this parts request</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="<?= base_url('dashboard/parts-requests') ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Parts Requests
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Request Details Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-6">Request Details</h3>

        <dl class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Item Name</dt>
                <dd class="text-sm text-gray-900 font-medium"><?= esc($partsRequest['item_name']) ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Brand</dt>
                <dd class="text-sm text-gray-900"><?= esc($partsRequest['brand']) ?: 'Not specified' ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Model</dt>
                <dd class="text-sm text-gray-900"><?= esc($partsRequest['model']) ?: 'Not specified' ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Quantity</dt>
                <dd class="text-sm text-gray-900 font-medium"><?= $partsRequest['quantity_requested'] ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Urgency</dt>
                <dd class="text-sm">
                    <?php
                    $urgencyClasses = [
                        'Low' => 'bg-gray-100 text-gray-800',
                        'Medium' => 'bg-blue-100 text-blue-800',
                        'High' => 'bg-yellow-100 text-yellow-800',
                        'Critical' => 'bg-red-100 text-red-800'
                    ];
                    ?>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $urgencyClasses[$partsRequest['urgency']] ?>">
                        <?= $partsRequest['urgency'] ?>
                    </span>
                </dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Status</dt>
                <dd class="text-sm">
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
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $statusClasses[$partsRequest['status']] ?>">
                        <?= $partsRequest['status'] ?>
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Request Information Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-6">Request Information</h3>

        <dl class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Technician</dt>
                <dd class="text-sm text-gray-900"><?= esc($partsRequest['technician_name']) ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Related Job</dt>
                <dd class="text-sm text-gray-900"><?= esc($partsRequest['job_device']) ?: 'No job specified' ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Requested By</dt>
                <dd class="text-sm text-gray-900"><?= esc($partsRequest['requested_by_name']) ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Requested Date</dt>
                <dd class="text-sm text-gray-900"><?= date('M d, Y H:i', strtotime($partsRequest['created_at'])) ?></dd>
            </div>

            <?php if ($partsRequest['approved_by_name']): ?>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Approved By</dt>
                <dd class="text-sm text-gray-900"><?= esc($partsRequest['approved_by_name']) ?></dd>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between">
                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Approved Date</dt>
                <dd class="text-sm text-gray-900"><?= date('M d, Y H:i', strtotime($partsRequest['approved_at'])) ?></dd>
            </div>
            <?php endif; ?>
        </dl>
    </div>
</div>

<!-- Additional Information -->
<?php if ($partsRequest['description']): ?>
<div class="bg-white rounded-lg shadow p-6 mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
    <div class="text-sm text-gray-700 leading-relaxed">
        <?= nl2br(esc($partsRequest['description'])) ?>
    </div>
</div>
<?php endif; ?>

<?php if ($partsRequest['notes']): ?>
<div class="bg-white rounded-lg shadow p-6 mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
    <div class="text-sm text-gray-700 leading-relaxed">
        <?= nl2br(esc($partsRequest['notes'])) ?>
    </div>
</div>
<?php endif; ?>

<?php if ($partsRequest['rejection_reason']): ?>
<div class="bg-white rounded-lg shadow p-6 mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Rejection Reason</h3>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400"></i>
            </div>
            <div class="ml-3">
                <div class="text-sm text-red-700 leading-relaxed">
                    <?= nl2br(esc($partsRequest['rejection_reason'])) ?>
                </div>
            </div>
        </div>
    </div>
</div>
                        </div>
                    </div>
                    <?php endif; ?>

<!-- Cost and Delivery Information -->
<?php if ($partsRequest['estimated_cost'] || $partsRequest['actual_cost'] || $partsRequest['supplier']): ?>
<div class="bg-white rounded-lg shadow p-6 mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-6">Cost & Delivery Information</h3>

    <dl class="space-y-4">
        <?php if ($partsRequest['estimated_cost']): ?>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Estimated Cost</dt>
            <dd class="text-sm text-gray-900 font-medium">Rs. <?= number_format($partsRequest['estimated_cost'], 2) ?></dd>
        </div>
        <?php endif; ?>

        <?php if ($partsRequest['actual_cost']): ?>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Actual Cost</dt>
            <dd class="text-sm text-gray-900 font-medium">Rs. <?= number_format($partsRequest['actual_cost'], 2) ?></dd>
        </div>
        <?php endif; ?>

        <?php if ($partsRequest['supplier']): ?>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Supplier</dt>
            <dd class="text-sm text-gray-900"><?= esc($partsRequest['supplier']) ?></dd>
        </div>
        <?php endif; ?>

        <?php if ($partsRequest['order_date']): ?>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Order Date</dt>
            <dd class="text-sm text-gray-900"><?= date('M d, Y', strtotime($partsRequest['order_date'])) ?></dd>
        </div>
        <?php endif; ?>

        <?php if ($partsRequest['expected_delivery_date']): ?>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Expected Delivery</dt>
            <dd class="text-sm text-gray-900"><?= date('M d, Y', strtotime($partsRequest['expected_delivery_date'])) ?></dd>
        </div>
        <?php endif; ?>

        <?php if ($partsRequest['actual_delivery_date']): ?>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Actual Delivery</dt>
            <dd class="text-sm text-gray-900"><?= date('M d, Y', strtotime($partsRequest['actual_delivery_date'])) ?></dd>
        </div>
        <?php endif; ?>
    </dl>
</div>
<?php endif; ?>

<!-- Action Buttons -->
<?php if (in_array($userRole, ['superadmin', 'admin']) && $partsRequest['status'] === 'Pending'): ?>
<div class="bg-white rounded-lg shadow p-6 mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-6">Actions</h3>

    <div class="flex flex-col sm:flex-row gap-4">
        <button type="button"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                onclick="approveRequest()">
            <i class="fas fa-check mr-2"></i>
            Approve Request
        </button>

        <button type="button"
                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                onclick="rejectRequest()">
            <i class="fas fa-times mr-2"></i>
            Reject Request
        </button>
    </div>
</div>
<?php endif; ?>

<!-- JavaScript for Actions -->
<script>
function approveRequest() {
    if (confirm('Are you sure you want to approve this parts request?')) {
        // Create and submit approval form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('dashboard/parts-requests/approve/' . $partsRequest['id']) ?>';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '<?= csrf_token() ?>';
        csrfInput.value = '<?= csrf_hash() ?>';

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function rejectRequest() {
    const reason = prompt('Please provide a reason for rejection:');
    if (reason && reason.trim() !== '') {
        // Create and submit rejection form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('dashboard/parts-requests/reject/' . $partsRequest['id']) ?>';

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
