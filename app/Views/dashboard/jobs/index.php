<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="card-header">
    <div>
        <h1 class="card-title">Jobs</h1>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Manage repair jobs and track progress</p>
    </div>
    <a href="<?= base_url('dashboard/jobs/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i>Create Job
    </a>
</div>

<!-- Job Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-content">
            <h3><?= $jobStats['total'] ?></h3>
            <p>Total Jobs</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3><?= $jobStats['pending'] ?></h3>
            <p>Pending</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
            <i class="fas fa-cog"></i>
        </div>
        <div class="stat-content">
            <h3><?= $jobStats['in_progress'] ?></h3>
            <p>In Progress</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3><?= $jobStats['completed'] ?></h3>
            <p>Completed</p>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card">
    <form method="GET" action="<?= base_url('dashboard/jobs') ?>" style="display: flex; gap: 12px; align-items: end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <label class="form-label">Search Jobs</label>
            <input type="text" 
                   name="search" 
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by customer, device, or serial number..."
                   class="form-input">
        </div>
        <div class="form-group" style="min-width: 150px; margin-bottom: 0;">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="Pending" <?= ($status ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= ($status ?? '') === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Completed" <?= ($status ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
                <option value="Parts Pending" <?= ($status ?? '') === 'Parts Pending' ? 'selected' : '' ?>>Parts Pending</option>
                <option value="Referred to Service" <?= ($status ?? '') === 'Referred to Service' ? 'selected' : '' ?>>Referred</option>
                <option value="Returned" <?= ($status ?? '') === 'Returned' ? 'selected' : '' ?>>Returned</option>
            </select>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>Search
            </button>
            <?php if (!empty($search) || !empty($status)): ?>
                <a href="<?= base_url('dashboard/jobs') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Jobs Table -->
<div style="overflow-x: auto;">
    <table class="table">
        <thead>
            <tr>
                <th>Job Details</th>
                <th>Customer</th>
                <th>Device</th>
                <th>Technician</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($jobs)): ?>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td>
                            <div style="font-weight: 500; color: #2563eb;">
                                Job #<?= $job['id'] ?>
                            </div>
                            <div style="font-size: 12px; color: #666; margin-top: 2px;">
                                <?= esc(substr($job['problem'], 0, 50)) ?><?= strlen($job['problem']) > 50 ? '...' : '' ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'N/A') ?>
                            </div>
                            <?php if (!empty($job['walk_in_customer_mobile'])): ?>
                                <div style="font-size: 12px; color: #666;">
                                    <?= esc($job['walk_in_customer_mobile']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <?= esc($job['device_name']) ?>
                            </div>
                            <div style="font-size: 12px; color: #666;">
                                <?= esc($job['serial_number']) ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <?= esc($job['technician_name'] ?? 'Unassigned') ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $statusColor = '#6b7280';
                            $statusBg = 'rgba(107, 114, 128, 0.1)';
                            switch($job['status']) {
                                case 'Completed':
                                    $statusColor = '#059669';
                                    $statusBg = 'rgba(5, 150, 105, 0.1)';
                                    break;
                                case 'In Progress':
                                    $statusColor = '#2563eb';
                                    $statusBg = 'rgba(37, 99, 235, 0.1)';
                                    break;
                                case 'Pending':
                                    $statusColor = '#d97706';
                                    $statusBg = 'rgba(217, 119, 6, 0.1)';
                                    break;
                                case 'Parts Pending':
                                    $statusColor = '#ff9800';
                                    $statusBg = 'rgba(255, 152, 0, 0.1)';
                                    break;
                                case 'Referred to Service':
                                    $statusColor = '#9333ea';
                                    $statusBg = 'rgba(147, 51, 234, 0.1)';
                                    break;
                                case 'Returned':
                                    $statusColor = '#dc2626';
                                    $statusBg = 'rgba(220, 38, 38, 0.1)';
                                    break;
                            }
                            ?>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                <?= esc($job['status']) ?>
                            </span>
                        </td>
                        <td style="font-size: 12px; color: #666;">
                            <?= date('M j, Y', strtotime($job['created_at'])) ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: end;">
                                <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>" 
                                   style="color: #2563eb; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('dashboard/jobs/edit/' . $job['id']) ?>" 
                                   style="color: #059669; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center;">
                        <div style="color: #666;">
                            <i class="fas fa-wrench" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                            <p style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">No jobs found</p>
                            <p style="font-size: 14px; margin-bottom: 20px;">Get started by creating your first repair job.</p>
                            <a href="<?= base_url('dashboard/jobs/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i>Create Job
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
