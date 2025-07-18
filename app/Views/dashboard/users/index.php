<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="card-header">
    <div>
        <h1 class="card-title">Customers</h1>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Manage your repair shop customers</p>
    </div>
    <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i>Add Customer
    </a>
</div>

<!-- Search Bar -->
<div class="card">
    <form method="GET" action="<?= base_url('dashboard/users') ?>" style="display: flex; gap: 12px; align-items: end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <label class="form-label">Search Customers</label>
            <input type="text" 
                   name="search" 
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by name or mobile number..."
                   class="form-input">
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/users') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Customers Table -->
<div style="overflow-x: auto;">
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Mobile Number</th>
                <th>Type</th>
                <th>Jobs</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 32px; height: 32px; background: rgba(37, 99, 235, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <i class="fas fa-user" style="color: #2563eb; font-size: 14px;"></i>
                                </div>
                                <div style="font-weight: 500;">
                                    <?= esc($user['name']) ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <?= esc($user['mobile_number'] ?? 'N/A') ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $typeColor = $user['user_type'] === 'Registered' ? '#059669' : '#6b7280';
                            $typeBg = $user['user_type'] === 'Registered' ? 'rgba(5, 150, 105, 0.1)' : 'rgba(107, 114, 128, 0.1)';
                            ?>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $typeBg ?>; color: <?= $typeColor ?>;">
                                <?= esc($user['user_type']) ?>
                            </span>
                        </td>
                        <td>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                                <?= $user['job_count'] ?? 0 ?> jobs
                            </span>
                        </td>
                        <td style="font-size: 12px; color: #666;">
                            <?= date('M j, Y', strtotime($user['created_at'])) ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: end;">
                                <a href="<?= base_url('dashboard/users/edit/' . $user['id']) ?>" 
                                   style="color: #2563eb; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php helper('auth'); ?>
                                <?php if (canDeleteUser()): ?>
                                    <a href="<?= base_url('dashboard/users/delete/' . $user['id']) ?>" 
                                       onclick="return confirm('Are you sure you want to delete this customer?')"
                                       style="color: #dc2626; padding: 4px; border-radius: 4px; text-decoration: none;"
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center;">
                        <div style="color: #666;">
                            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                            <p style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">No customers found</p>
                            <p style="font-size: 14px; margin-bottom: 20px;">Get started by adding your first customer.</p>
                            <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i>Add Customer
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
