<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900"><?= $title ?></h1>
        <p class="mt-1 text-sm text-gray-600">Create a new parts request</p>
    </div>
    <a href="<?= base_url('dashboard/parts-requests') ?>"
       class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
       title="Back to Parts Requests">
        <i class="fas fa-arrow-left text-sm"></i>
        <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Parts Requests</span>
    </a>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/parts-requests/store') ?>" method="POST" class="p-6 lg:p-8 space-y-8">

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
                                                <?= esc($technician['full_name']) ?>
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
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Request
                            </button>
                            <a href="/parts-requests" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
