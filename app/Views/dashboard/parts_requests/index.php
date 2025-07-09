<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?= $title ?></h3>
                    <?php if ($userRole === 'technician'): ?>
                        <a href="/parts-requests/create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Request Parts
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-list"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number"><?= $stats['total'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending</span>
                                    <span class="info-box-number"><?= $stats['pending'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Approved</span>
                                    <span class="info-box-number"><?= $stats['approved'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ordered</span>
                                    <span class="info-box-number"><?= $stats['ordered'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Received</span>
                                    <span class="info-box-number"><?= $stats['received'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rejected</span>
                                    <span class="info-box-number"><?= $stats['rejected'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parts Requests Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Technician</th>
                                    <th>Job</th>
                                    <th>Quantity</th>
                                    <th>Urgency</th>
                                    <th>Status</th>
                                    <th>Requested Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($partsRequests)): ?>
                                    <?php foreach ($partsRequests as $request): ?>
                                        <tr>
                                            <td><?= $request['id'] ?></td>
                                            <td>
                                                <strong><?= esc($request['item_name']) ?></strong>
                                                <?php if (!empty($request['brand'])): ?>
                                                    <br><small class="text-muted"><?= esc($request['brand']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($request['technician_name']) ?></td>
                                            <td>
                                                <?php if (!empty($request['job_device'])): ?>
                                                    <?= esc($request['job_device']) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No job</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $request['quantity_requested'] ?></td>
                                            <td>
                                                <?php
                                                $urgencyClass = [
                                                    'Low' => 'secondary',
                                                    'Medium' => 'info',
                                                    'High' => 'warning',
                                                    'Critical' => 'danger'
                                                ];
                                                ?>
                                                <span class="badge badge-<?= $urgencyClass[$request['urgency']] ?>">
                                                    <?= $request['urgency'] ?>
                                                </span>
                                            </td>
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
                                                <span class="badge badge-<?= $statusClass[$request['status']] ?>">
                                                    <?= $request['status'] ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($request['created_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('dashboard/parts-requests/view/' . $request['id']) ?>"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if (in_array($userRole, ['superadmin', 'admin']) && $request['status'] === 'Pending'): ?>
                                                        <button type="button" class="btn btn-sm btn-success" 
                                                                onclick="approveRequest(<?= $request['id'] ?>)">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" 
                                                                onclick="rejectRequest(<?= $request['id'] ?>)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No parts requests found.
                                            <?php if ($userRole === 'technician'): ?>
                                                <a href="<?= base_url('dashboard/parts-requests/create') ?>">Create the first request</a>.
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveRequest(id) {
    // Add approval modal or form here
    if (confirm('Approve this parts request?')) {
        // Submit approval form
        window.location.href = '<?= base_url('dashboard/parts-requests/approve/') ?>' + id;
    }
}

function rejectRequest(id) {
    // Add rejection modal or form here
    const reason = prompt('Reason for rejection:');
    if (reason) {
        // Submit rejection form with reason
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
        reasonInput.value = reason;

        form.appendChild(csrfInput);
        form.appendChild(reasonInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?= $this->endSection() ?>
