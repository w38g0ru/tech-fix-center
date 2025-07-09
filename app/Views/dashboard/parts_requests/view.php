<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $title ?> #<?= $partsRequest['id'] ?></h3>
                    <div class="card-tools">
                        <a href="/parts-requests" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Parts Requests
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Request Details</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Item Name:</strong></td>
                                    <td><?= esc($partsRequest['item_name']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Brand:</strong></td>
                                    <td><?= esc($partsRequest['brand']) ?: 'Not specified' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Model:</strong></td>
                                    <td><?= esc($partsRequest['model']) ?: 'Not specified' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Quantity:</strong></td>
                                    <td><?= $partsRequest['quantity_requested'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Urgency:</strong></td>
                                    <td>
                                        <?php
                                        $urgencyClass = [
                                            'Low' => 'secondary',
                                            'Medium' => 'info',
                                            'High' => 'warning',
                                            'Critical' => 'danger'
                                        ];
                                        ?>
                                        <span class="badge badge-<?= $urgencyClass[$partsRequest['urgency']] ?>">
                                            <?= $partsRequest['urgency'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'Pending' => 'warning',
                                            'Approved' => 'success',
                                            'Rejected' => 'danger',
                                            'Ordered' => 'primary',
                                            'Received' => 'success',
                                            'Cancelled' => 'secondary'
                                        ];
                                        ?>
                                        <span class="badge badge-<?= $statusClass[$partsRequest['status']] ?>">
                                            <?= $partsRequest['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Request Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Technician:</strong></td>
                                    <td><?= esc($partsRequest['technician_name']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Related Job:</strong></td>
                                    <td><?= esc($partsRequest['job_device']) ?: 'No job specified' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Requested By:</strong></td>
                                    <td><?= esc($partsRequest['requested_by_name']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Requested Date:</strong></td>
                                    <td><?= date('M d, Y H:i', strtotime($partsRequest['created_at'])) ?></td>
                                </tr>
                                <?php if ($partsRequest['approved_by_name']): ?>
                                <tr>
                                    <td><strong>Approved By:</strong></td>
                                    <td><?= esc($partsRequest['approved_by_name']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Approved Date:</strong></td>
                                    <td><?= date('M d, Y H:i', strtotime($partsRequest['approved_at'])) ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                    <?php if ($partsRequest['description']): ?>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Description</h5>
                            <p><?= nl2br(esc($partsRequest['description'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($partsRequest['notes']): ?>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Notes</h5>
                            <p><?= nl2br(esc($partsRequest['notes'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($partsRequest['rejection_reason']): ?>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Rejection Reason</h5>
                            <div class="alert alert-danger">
                                <?= nl2br(esc($partsRequest['rejection_reason'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Cost and Delivery Information -->
                    <?php if ($partsRequest['estimated_cost'] || $partsRequest['actual_cost'] || $partsRequest['supplier']): ?>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Cost & Delivery Information</h5>
                            <table class="table table-borderless">
                                <?php if ($partsRequest['estimated_cost']): ?>
                                <tr>
                                    <td><strong>Estimated Cost:</strong></td>
                                    <td>Rs. <?= number_format($partsRequest['estimated_cost'], 2) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($partsRequest['actual_cost']): ?>
                                <tr>
                                    <td><strong>Actual Cost:</strong></td>
                                    <td>Rs. <?= number_format($partsRequest['actual_cost'], 2) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($partsRequest['supplier']): ?>
                                <tr>
                                    <td><strong>Supplier:</strong></td>
                                    <td><?= esc($partsRequest['supplier']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($partsRequest['order_date']): ?>
                                <tr>
                                    <td><strong>Order Date:</strong></td>
                                    <td><?= date('M d, Y', strtotime($partsRequest['order_date'])) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($partsRequest['expected_delivery_date']): ?>
                                <tr>
                                    <td><strong>Expected Delivery:</strong></td>
                                    <td><?= date('M d, Y', strtotime($partsRequest['expected_delivery_date'])) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($partsRequest['actual_delivery_date']): ?>
                                <tr>
                                    <td><strong>Actual Delivery:</strong></td>
                                    <td><?= date('M d, Y', strtotime($partsRequest['actual_delivery_date'])) ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <?php if (in_array($userRole, ['superadmin', 'admin']) && $partsRequest['status'] === 'Pending'): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success" onclick="approveRequest()">
                                    <i class="fas fa-check"></i> Approve Request
                                </button>
                                <button type="button" class="btn btn-danger" onclick="rejectRequest()">
                                    <i class="fas fa-times"></i> Reject Request
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveRequest() {
    if (confirm('Approve this parts request?')) {
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
    const reason = prompt('Reason for rejection:');
    if (reason) {
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
        reasonInput.value = reason;

        form.appendChild(csrfInput);
        form.appendChild(reasonInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?= $this->endSection() ?>
