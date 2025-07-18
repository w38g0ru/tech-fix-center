<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="card-header">
    <div>
        <h1 class="card-title">Inventory</h1>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Manage your inventory items and stock levels</p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <!-- Import/Export Buttons -->
        <a href="<?= base_url('dashboard/inventory/downloadTemplate') ?>" class="btn btn-success" title="Download CSV template for bulk import">
            <i class="fas fa-download"></i>Template
        </a>

        <a href="<?= base_url('dashboard/inventory/bulk-import') ?>" class="btn btn-primary" title="Import items from CSV/Excel file">
            <i class="fas fa-upload"></i>Import
        </a>

        <a href="<?= base_url('dashboard/inventory/export') ?>" class="btn btn-secondary" title="Export all inventory items to CSV">
            <i class="fas fa-file-export"></i>Export
        </a>

        <!-- Add Item Button -->
        <a href="<?= base_url('dashboard/inventory/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>Add Item
        </a>
    </div>
</div>

<!-- Inventory Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
            <i class="fas fa-boxes"></i>
        </div>
        <div class="stat-content">
            <h3><?= $inventoryStats['total_items'] ?></h3>
            <p>Total Items</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
            <i class="fas fa-cubes"></i>
        </div>
        <div class="stat-content">
            <h3><?= $inventoryStats['total_stock'] ?></h3>
            <p>Total Stock</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-content">
            <h3><?= $inventoryStats['low_stock'] ?></h3>
            <p>Low Stock</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-content">
            <h3><?= $inventoryStats['out_of_stock'] ?></h3>
            <p>Out of Stock</p>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="card">
    <form method="GET" action="<?= base_url('dashboard/inventory') ?>" style="display: flex; gap: 12px; align-items: end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 1; min-width: 250px; margin-bottom: 0;">
            <label class="form-label">Search Inventory</label>
            <input type="text"
                   name="search"
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search by device name, brand, or model..."
                   class="form-input">
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/inventory') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Inventory Table -->
<div style="overflow-x: auto;">
    <table class="table">
        <thead>
            <tr>
                <th>Item Details</th>
                <th>Brand & Model</th>
                <th>Stock Level</th>
                <th>Pricing</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 32px; height: 32px; background: rgba(255, 152, 0, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <i class="fas fa-box" style="color: #ff9800; font-size: 14px;"></i>
                                </div>
                                <div style="font-weight: 500;">
                                    <?= esc($item['device_name'] ?? 'N/A') ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <?= esc($item['brand'] ?? 'N/A') ?>
                            </div>
                            <div style="font-size: 12px; color: #666;">
                                <?= esc($item['model'] ?? 'N/A') ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $stockColor = '#059669';
                            $stockBg = 'rgba(5, 150, 105, 0.1)';
                            if ($item['total_stock'] <= 0) {
                                $stockColor = '#dc2626';
                                $stockBg = 'rgba(220, 38, 38, 0.1)';
                            } elseif ($item['total_stock'] <= 10) {
                                $stockColor = '#d97706';
                                $stockBg = 'rgba(217, 119, 6, 0.1)';
                            }
                            ?>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $stockBg ?>; color: <?= $stockColor ?>;">
                                <?= $item['total_stock'] ?> units
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($item['selling_price'])): ?>
                                <div style="font-weight: 500;">NPR <?= number_format($item['selling_price'], 2) ?></div>
                                <?php if (!empty($item['purchase_price'])): ?>
                                    <div style="font-size: 12px; color: #666;">Cost: NPR <?= number_format($item['purchase_price'], 2) ?></div>
                                <?php endif; ?>
                            <?php elseif (!empty($item['purchase_price'])): ?>
                                <div>NPR <?= number_format($item['purchase_price'], 2) ?></div>
                                <div style="font-size: 12px; color: #666;">Purchase price</div>
                            <?php else: ?>
                                <span style="color: #999;">No pricing</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $statusColor = '#059669';
                            $statusBg = 'rgba(5, 150, 105, 0.1)';
                            switch($item['status'] ?? 'Active') {
                                case 'Active':
                                    $statusColor = '#059669';
                                    $statusBg = 'rgba(5, 150, 105, 0.1)';
                                    break;
                                case 'Inactive':
                                    $statusColor = '#d97706';
                                    $statusBg = 'rgba(217, 119, 6, 0.1)';
                                    break;
                                case 'Discontinued':
                                    $statusColor = '#dc2626';
                                    $statusBg = 'rgba(220, 38, 38, 0.1)';
                                    break;
                                default:
                                    $statusColor = '#6b7280';
                                    $statusBg = 'rgba(107, 114, 128, 0.1)';
                            }
                            ?>
                            <span style="padding: 4px 8px; font-size: 12px; font-weight: 600; border-radius: 12px; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                <?= esc($item['status'] ?? 'Active') ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: end;">
                                <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>"
                                   style="color: #2563eb; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('dashboard/inventory/edit/' . $item['id']) ?>"
                                   style="color: #059669; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('dashboard/inventory/delete/' . $item['id']) ?>"
                                   onclick="return confirm('Are you sure you want to delete this item?')"
                                   style="color: #dc2626; padding: 4px; border-radius: 4px; text-decoration: none;"
                                   title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center;">
                        <div style="color: #666;">
                            <i class="fas fa-boxes" style="font-size: 48px; margin-bottom: 16px; color: #ccc;"></i>
                            <p style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">No inventory items found</p>
                            <p style="font-size: 14px; margin-bottom: 20px;">Get started by adding your first inventory item.</p>
                            <a href="<?= base_url('dashboard/inventory/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i>Add Item
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
