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
                    <h3 class="card-title"><?= $title ?></h3>
                    <div class="card-tools">
                        <a href="/inventory" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Inventory
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-8">
                            <h5>Upload Inventory File</h5>
                            <p class="text-muted">Upload a CSV or Excel file to bulk import inventory items.</p>
                            
                            <form action="/inventory/process-bulk-import" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                
                                <div class="form-group">
                                    <label for="import_file">Select File <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control-file" id="import_file" name="import_file" 
                                           accept=".csv,.xlsx,.xls" required>
                                    <small class="form-text text-muted">
                                        Supported formats: CSV, Excel (.xlsx, .xls). Maximum file size: 10MB.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Import Inventory
                                    </button>
                                    <a href="/inventory/export" class="btn btn-success">
                                        <i class="fas fa-download"></i> Download Sample Template
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <h5>File Format Requirements</h5>
                            <div class="alert alert-info">
                                <h6>Required Columns:</h6>
                                <ul class="mb-2">
                                    <li><strong>Device Name</strong> (Required)</li>
                                    <li><strong>Brand</strong></li>
                                    <li><strong>Model</strong></li>
                                    <li><strong>Total Stock</strong> (Required, Number)</li>
                                </ul>
                                
                                <h6>Optional Columns:</h6>
                                <ul class="mb-2">
                                    <li><strong>Purchase Price</strong> (Number)</li>
                                    <li><strong>Selling Price</strong> (Number)</li>
                                    <li><strong>Minimum Order Level</strong> (Number)</li>
                                    <li><strong>Category</strong></li>
                                    <li><strong>Description</strong></li>
                                    <li><strong>Supplier</strong></li>
                                    <li><strong>Status</strong> (Active/Inactive/Discontinued)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Sample CSV Format</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Device Name</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Total Stock</th>
                                            <th>Purchase Price</th>
                                            <th>Selling Price</th>
                                            <th>Minimum Order Level</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Supplier</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>iPhone Screen</td>
                                            <td>Apple</td>
                                            <td>iPhone 12</td>
                                            <td>50</td>
                                            <td>15000</td>
                                            <td>18000</td>
                                            <td>10</td>
                                            <td>Mobile Parts</td>
                                            <td>Original iPhone 12 screen replacement</td>
                                            <td>Tech Supplier Ltd</td>
                                            <td>Active</td>
                                        </tr>
                                        <tr>
                                            <td>Samsung Battery</td>
                                            <td>Samsung</td>
                                            <td>Galaxy S21</td>
                                            <td>25</td>
                                            <td>2500</td>
                                            <td>3000</td>
                                            <td>5</td>
                                            <td>Mobile Parts</td>
                                            <td>Original Samsung Galaxy S21 battery</td>
                                            <td>Mobile Parts Co</td>
                                            <td>Active</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Import Guidelines</h5>
                            <div class="alert alert-warning">
                                <ul class="mb-0">
                                    <li>Ensure the first row contains column headers exactly as shown above</li>
                                    <li>Device Name and Total Stock are required fields</li>
                                    <li>Numeric fields (prices, quantities) should contain only numbers</li>
                                    <li>Status field accepts: Active, Inactive, or Discontinued (defaults to Active)</li>
                                    <li>Empty cells in optional columns will be left blank</li>
                                    <li>Duplicate device names will be updated with new information</li>
                                    <li>Invalid rows will be skipped and reported in the import summary</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
