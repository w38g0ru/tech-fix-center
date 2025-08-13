<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Inventory Item</h1>
        <p class="mt-1 text-sm text-gray-600">Update inventory item details</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="<?= base_url('dashboard/inventory/view/' . $item['id']) ?>"
           class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
           title="View Item">
            <i class="fas fa-eye text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">View Item</span>
        </a>
        <a href="<?= base_url('dashboard/inventory') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
           title="Back to Inventory">
            <i class="fas fa-arrow-left text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Inventory</span>
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm"><?= session()->getFlashdata('error') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="max-w-2xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/inventory/update/' . $item['id']) ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
            <!-- Device Name -->
            <div>
                <label for="device_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Device Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="device_name" 
                       name="device_name" 
                       value="<?= old('device_name', $item['device_name']) ?>"
                       placeholder="e.g., iPhone Screen, Samsung Battery"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.device_name') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.device_name')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.device_name') ?></p>
                <?php endif; ?>
            </div>

            <!-- Brand -->
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                    Brand
                </label>
                <input type="text" 
                       id="brand" 
                       name="brand" 
                       value="<?= old('brand', $item['brand']) ?>"
                       placeholder="e.g., Apple, Samsung, Generic"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.brand') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.brand')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.brand') ?></p>
                <?php endif; ?>
            </div>

            <!-- Model -->
            <div>
                <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                    Model
                </label>
                <input type="text" 
                       id="model" 
                       name="model" 
                       value="<?= old('model', $item['model']) ?>"
                       placeholder="e.g., iPhone 12, Galaxy S21"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.model') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.model')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.model') ?></p>
                <?php endif; ?>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Category
                </label>
                <input type="text" 
                       id="category" 
                       name="category" 
                       value="<?= old('category', $item['category']) ?>"
                       placeholder="e.g., Mobile Parts, Laptop Parts"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.category') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.category')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.category') ?></p>
                <?php endif; ?>
            </div>

            <!-- Stock and Pricing Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Total Stock -->
                <div>
                    <label for="total_stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Total Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="total_stock" 
                           name="total_stock" 
                           value="<?= old('total_stock', $item['total_stock']) ?>"
                           min="0"
                           placeholder="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.total_stock') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.total_stock')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.total_stock') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Minimum Order Level -->
                <div>
                    <label for="minimum_order_level" class="block text-sm font-medium text-gray-700 mb-2">
                        Minimum Order Level
                    </label>
                    <input type="number" 
                           id="minimum_order_level" 
                           name="minimum_order_level" 
                           value="<?= old('minimum_order_level', $item['minimum_order_level']) ?>"
                           min="0"
                           placeholder="5"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.minimum_order_level') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.minimum_order_level')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.minimum_order_level') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pricing Row -->
            <?php if (hasAnyRole(['superadmin', 'admin'])): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Purchase Price -->
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Purchase Price (NPR)
                    </label>
                    <input type="number"
                           id="purchase_price"
                           name="purchase_price"
                           value="<?= old('purchase_price', $item['purchase_price']) ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.purchase_price') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.purchase_price')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.purchase_price') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Selling Price -->
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Selling Price (NPR)
                    </label>
                    <input type="number"
                           id="selling_price"
                           name="selling_price"
                           value="<?= old('selling_price', $item['selling_price']) ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.selling_price') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.selling_price')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.selling_price') ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <!-- Selling Price Only for Non-Admin Users -->
            <div>
                <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">
                    Selling Price (NPR)
                </label>
                <input type="number"
                       id="selling_price"
                       name="selling_price"
                       value="<?= old('selling_price', $item['selling_price']) ?>"
                       min="0"
                       step="0.01"
                       placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.selling_price') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.selling_price')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.selling_price') ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Supplier -->
            <div>
                <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">
                    Supplier
                </label>
                <input type="text" 
                       id="supplier" 
                       name="supplier" 
                       value="<?= old('supplier', $item['supplier']) ?>"
                       placeholder="e.g., Tech Supplier Ltd"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.supplier') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.supplier')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.supplier') ?></p>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          placeholder="Enter item description..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.description') ? 'border-red-500' : '' ?>"><?= old('description', $item['description']) ?></textarea>
                <?php if (session('errors.description')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.description') ?></p>
                <?php endif; ?>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.status') ? 'border-red-500' : '' ?>">
                    <option value="Active" <?= old('status', $item['status']) === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= old('status', $item['status']) === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="Discontinued" <?= old('status', $item['status']) === 'Discontinued' ? 'selected' : '' ?>>Discontinued</option>
                </select>
                <?php if (session('errors.status')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                <?php endif; ?>
            </div>

            <!-- Photo Upload -->
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                    Item Photo
                </label>
                <input type="file" 
                       id="photo" 
                       name="photo" 
                       accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="mt-1 text-sm text-gray-500">Upload a photo of the inventory item (optional)</p>
                <?php if (session('errors.photo')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.photo') ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Update Item
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
