<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $title ?></h3>
                    <div class="card-tools">
                        <a href="/parts-requests" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Parts Requests
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('dashboard/parts-requests/store') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="technician_id">Technician <span class="text-danger">*</span></label>
                                    <select class="form-control" id="technician_id" name="technician_id" required>
                                        <option value="">Select Technician</option>
                                        <?php foreach ($technicians as $technician): ?>
                                            <option value="<?= $technician['id'] ?>" 
                                                    <?= old('technician_id') == $technician['id'] ? 'selected' : '' ?>>
                                                <?= esc($technician['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="job_id">Related Job (Optional)</label>
                                    <select class="form-control" id="job_id" name="job_id">
                                        <option value="">Select Job</option>
                                        <?php foreach ($jobs as $job): ?>
                                            <option value="<?= $job['id'] ?>" 
                                                    <?= old('job_id') == $job['id'] ? 'selected' : '' ?>>
                                                <?= esc($job['device_name']) ?> - <?= esc($job['customer_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_name">Item Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="item_name" name="item_name" 
                                           value="<?= old('item_name') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity_requested">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="quantity_requested" name="quantity_requested" 
                                           value="<?= old('quantity_requested', 1) ?>" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand" 
                                           value="<?= old('brand') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" class="form-control" id="model" name="model" 
                                           value="<?= old('model') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="urgency">Urgency Level <span class="text-danger">*</span></label>
                            <select class="form-control" id="urgency" name="urgency" required>
                                <?php foreach ($urgencyLevels as $level): ?>
                                    <option value="<?= $level ?>" 
                                            <?= old('urgency', 'Medium') === $level ? 'selected' : '' ?>>
                                        <?= $level ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Describe the part needed and its purpose..."><?= old('description') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="notes">Additional Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" 
                                      placeholder="Any additional information..."><?= old('notes') ?></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Request
                            </button>
                            <a href="/parts-requests" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
