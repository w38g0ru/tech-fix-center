<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="stats-grid">
    <!-- Total Jobs -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
            <i class="fas fa-wrench"></i>
        </div>
        <div class="stat-content">
            <h3><?= $jobStats['total'] ?></h3>
            <p>Total Jobs</p>
            <div style="margin-top: 8px; font-size: 12px;">
                <span style="color: #059669; font-weight: 500;"><?= $jobStats['completed'] ?> Completed</span>
                <span style="color: #d97706; font-weight: 500; margin-left: 16px;"><?= $jobStats['pending'] ?> Pending</span>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3><?= $userStats['total'] ?></h3>
            <p>Total Customers</p>
            <div style="margin-top: 8px; font-size: 12px;">
                <span style="color: #2563eb; font-weight: 500;"><?= $userStats['registered'] ?> Registered</span>
                <span style="color: #6b7280; font-weight: 500; margin-left: 16px;"><?= $userStats['walk_in'] ?> Walk-in</span>
            </div>
        </div>
    </div>

    <!-- Total Technicians -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(147, 51, 234, 0.1); color: #9333ea;">
            <i class="fas fa-user-cog"></i>
        </div>
        <div class="stat-content">
            <h3><?= $technicianStats['total'] ?></h3>
            <p>Total Technicians</p>
            <div style="margin-top: 8px; font-size: 12px;">
                <span style="color: #059669; font-weight: 500;">Active technicians</span>
            </div>
        </div>
    </div>

    <!-- Inventory Items -->
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #ff9800;">
            <i class="fas fa-boxes"></i>
        </div>
        <div class="stat-content">
            <h3><?= $inventoryStats['total_items'] ?></h3>
            <p>Inventory Items</p>
            <div style="margin-top: 8px; font-size: 12px;">
                <span style="color: #dc2626; font-weight: 500;"><?= $inventoryStats['low_stock'] ?> Low Stock</span>
                <span style="color: #6b7280; font-weight: 500; margin-left: 16px;"><?= $inventoryStats['total_stock'] ?> Total Stock</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-2" style="margin-top: 30px;">
    <!-- Recent Jobs -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Jobs</h3>
            <a href="<?= base_url('dashboard/jobs') ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                <i class="fas fa-eye"></i>View All
            </a>
        </div>
        
        <?php if (!empty($recentJobs)): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentJobs as $job): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 500;">
                                        <?= esc($job['customer_name'] ?? $job['walk_in_customer_name'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;"><?= esc($job['device_name']) ?></div>
                                    <div style="font-size: 12px; color: #666;"><?= esc($job['serial_number']) ?></div>
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
                                    }
                                    ?>
                                    <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                        <?= esc($job['status']) ?>
                                    </span>
                                </td>
                                <td style="font-size: 12px; color: #666;">
                                    <?= date('M j, Y', strtotime($job['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #666;">
                <i class="fas fa-wrench" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                <p>No recent jobs found</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Low Stock Items -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Low Stock Items</h3>
            <a href="<?= base_url('dashboard/inventory') ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                <i class="fas fa-eye"></i>View All
            </a>
        </div>
        
        <?php if (!empty($lowStockItems)): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lowStockItems as $item): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 500;"><?= esc($item['device_name']) ?></div>
                                    <div style="font-size: 12px; color: #666;"><?= esc($item['brand']) ?> <?= esc($item['model']) ?></div>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #dc2626;">
                                        <?= $item['total_stock'] ?> units
                                    </span>
                                </td>
                                <td>
                                    <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                                        Low Stock
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #666;">
                <i class="fas fa-boxes" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                <p>All items are well stocked</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <h3 class="card-title">Quick Actions</h3>
    </div>
    
    <div class="grid grid-4" style="padding: 20px;">
        <a href="<?= base_url('dashboard/jobs/create') ?>" class="btn btn-primary" style="justify-content: center; padding: 16px;">
            <i class="fas fa-plus"></i>Create Job
        </a>
        
        <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-success" style="justify-content: center; padding: 16px;">
            <i class="fas fa-user-plus"></i>Add Customer
        </a>
        
        <a href="<?= base_url('dashboard/inventory/create') ?>" class="btn btn-secondary" style="justify-content: center; padding: 16px;">
            <i class="fas fa-box"></i>Add Item
        </a>
        
        <a href="<?= base_url('dashboard/reports') ?>" class="btn btn-primary" style="justify-content: center; padding: 16px; background: #9333ea;">
            <i class="fas fa-chart-bar"></i>View Reports
        </a>
    </div>
</div>

<?= $this->endSection() ?>
