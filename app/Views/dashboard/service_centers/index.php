<?= $this->extend('layouts/dashboard_simple') ?>

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
                    <a href="<?= base_url('dashboard/service-centers/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Service Center
                    </a>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Centers</span>
                                    <span class="info-box-number"><?= $stats['total'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Active Centers</span>
                                    <span class="info-box-number"><?= $stats['active'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-pause-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Inactive Centers</span>
                                    <span class="info-box-number"><?= $stats['inactive'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="<?= base_url('dashboard/service-centers/search') ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Search service centers..." 
                                           value="<?= isset($search) ? esc($search) : '' ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Service Centers Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact Person</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Jobs Count</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($serviceCenters)): ?>
                                    <?php foreach ($serviceCenters as $center): ?>
                                        <tr>
                                            <td><?= $center['id'] ?></td>
                                            <td>
                                                <strong><?= esc($center['name']) ?></strong>
                                                <?php if (!empty($center['address'])): ?>
                                                    <br><small class="text-muted"><?= esc($center['address']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($center['contact_person']) ?></td>
                                            <td><?= esc($center['phone']) ?></td>
                                            <td><?= esc($center['email']) ?></td>
                                            <td>
                                                <span class="badge badge-info"><?= $center['job_count'] ?? 0 ?></span>
                                            </td>
                                            <td>
                                                <?php if ($center['status'] === 'Active'): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('dashboard/service-centers/edit/' . $center['id']) ?>"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/service-centers/delete/' . $center['id']) ?>"
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Are you sure you want to delete this service center?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <?php if (isset($search)): ?>
                                                No service centers found matching "<?= esc($search) ?>".
                                            <?php else: ?>
                                                No service centers found. <a href="<?= base_url('dashboard/service-centers/create') ?>">Add the first one</a>.
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
<?= $this->endSection() ?>
