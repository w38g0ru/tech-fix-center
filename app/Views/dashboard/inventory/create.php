<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Inventory Item</h1>
        <p class="mt-1 text-sm text-gray-600">Add a new item to your inventory</p>
    </div>
    <div class="flex items-center justify-start lg:justify-end gap-2">
        <a href="<?= base_url('dashboard/inventory') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
           title="Back to Inventory">
            <i class="fas fa-arrow-left text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Inventory</span>
        </a>
    </div>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/inventory/store') ?>" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>
            
            <!-- Device Name -->
            <div>
                <label for="device_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Device Name
                </label>
                <input type="text" 
                       id="device_name" 
                       name="device_name" 
                       value="<?= old('device_name') ?>"
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
                       value="<?= old('brand') ?>"
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
                       value="<?= old('model') ?>"
                       placeholder="e.g., iPhone 12, Galaxy S21"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.model') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.model')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.model') ?></p>
                <?php endif; ?>
            </div>

            <!-- Stock and Order Level Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Initial Stock -->
                <div>
                    <label for="total_stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Initial Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="total_stock"
                           name="total_stock"
                           value="<?= old('total_stock', 0) ?>"
                           min="0"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.total_stock') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.total_stock')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.total_stock') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Starting quantity for this item</p>
                </div>

                <!-- Minimum Order Level -->
                <div>
                    <label for="minimum_order_level" class="block text-sm font-medium text-gray-700 mb-2">
                        Minimum Order Level
                    </label>
                    <input type="number"
                           id="minimum_order_level"
                           name="minimum_order_level"
                           value="<?= old('minimum_order_level') ?>"
                           min="0"
                           placeholder="5"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.minimum_order_level') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.minimum_order_level')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.minimum_order_level') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Reorder when stock reaches this level</p>
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
                           value="<?= old('purchase_price') ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.purchase_price') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.purchase_price')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.purchase_price') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Cost price for this item (optional)</p>
                </div>

                <!-- Selling Price -->
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Selling Price (NPR)
                    </label>
                    <input type="number"
                           id="selling_price"
                           name="selling_price"
                           value="<?= old('selling_price') ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.selling_price') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.selling_price')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.selling_price') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Retail price for this item (optional)</p>
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
                       value="<?= old('selling_price') ?>"
                       min="0"
                       step="0.01"
                       placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.selling_price') ? 'border-red-500' : '' ?>">
                <?php if (session('errors.selling_price')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.selling_price') ?></p>
                <?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Retail price for this item (optional)</p>
            </div>
            <?php endif; ?>

            <!-- Additional Fields Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category
                    </label>
                    <input type="text"
                           id="category"
                           name="category"
                           value="<?= old('category') ?>"
                           placeholder="e.g., Mobile Parts, Laptop Parts"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.category') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.category')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.category') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">
                        Supplier
                    </label>
                    <input type="text"
                           id="supplier"
                           name="supplier"
                           value="<?= old('supplier') ?>"
                           placeholder="e.g., Tech Supplier Ltd"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.supplier') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.supplier')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.supplier') ?></p>
                    <?php endif; ?>
                </div>
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
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.description') ? 'border-red-500' : '' ?>"><?= old('description') ?></textarea>
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
                    <option value="Active" <?= old('status', 'Active') === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= old('status') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="Discontinued" <?= old('status') === 'Discontinued' ? 'selected' : '' ?>>Discontinued</option>
                </select>
                <?php if (session('errors.status')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                <?php endif; ?>
            </div>

            <!-- Inventory Photos -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-camera text-green-600 mr-2"></i>
                    <h3 class="text-sm font-medium text-green-900">Inventory Item Photoproofs</h3>
                </div>
                <p class="text-sm text-green-700 mb-3">Upload photos of the inventory item for identification and reference</p>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-green-900 mb-2">Upload Photos</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="inventory_photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-green-300 border-dashed rounded-lg cursor-pointer bg-green-50 hover:bg-green-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-camera text-green-400 text-2xl mb-2"></i>
                                    <p class="mb-2 text-sm text-green-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-green-500">PNG, JPG, GIF up to 5MB each</p>
                                </div>
                                <input id="inventory_photos"
                                       name="inventory_photos[]"
                                       type="file"
                                       multiple
                                       accept="image/*"
                                       onchange="previewInventoryPhotos(this)"
                                       class="hidden" />
                            </label>
                        </div>
                    </div>

                    <!-- Photo Preview -->
                    <div id="inventory_photo_preview" class="hidden">
                        <label class="block text-sm font-medium text-green-900 mb-2">Selected Photos</label>
                        <div id="inventory_preview_container" class="grid grid-cols-2 md:grid-cols-4 gap-2"></div>
                    </div>

                    <!-- Photo Description -->
                    <div>
                        <label for="photo_description" class="block text-sm font-medium text-green-900 mb-1">Photo Description</label>
                        <textarea id="photo_description"
                                  name="photo_description"
                                  rows="2"
                                  placeholder="Describe the inventory item, condition, packaging, etc..."
                                  class="w-full px-3 py-2 text-sm border border-green-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Templates</h3>
                <div class="flex flex-wrap gap-2">
                    <button type="button"
                            onclick="setTemplate('iPhone Screen', 'Apple', 'iPhone 12')"
                            class="btn btn-sm btn-secondary">
                        iPhone Screen
                    </button>
                    <button type="button"
                            onclick="setTemplate('Samsung Battery', 'Samsung', 'Galaxy S21')"
                            class="btn btn-sm btn-secondary">
                        Samsung Battery
                    </button>
                    <button type="button"
                            onclick="setTemplate('Charging Cable', 'Generic', 'USB-C')"
                            class="btn btn-sm btn-secondary">
                        Charging Cable
                    </button>
                    <button type="button"
                            onclick="setTemplate('Phone Case', 'Generic', 'Universal')"
                            class="btn btn-sm btn-secondary">
                        Phone Case
                    </button>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-2 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/inventory') ?>"
                   class="inline-flex items-center justify-center min-w-0 px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                   title="Cancel and Return">
                    <i class="fas fa-times text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Cancel</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                        title="Add New Item">
                    <i class="fas fa-save text-sm"></i>
                    <span class="hidden md:inline md:ml-2 whitespace-nowrap">Add Item</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setTemplate(deviceName, brand, model) {
    document.getElementById('device_name').value = deviceName;
    document.getElementById('brand').value = brand;
    document.getElementById('model').value = model;
    document.getElementById('total_stock').focus();
}

function previewInventoryPhotos(input) {
    const previewDiv = document.getElementById('inventory_photo_preview');
    const container = document.getElementById('inventory_preview_container');

    // Clear previous previews
    container.innerHTML = '';

    if (input.files && input.files.length > 0) {
        previewDiv.classList.remove('hidden');

        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}"
                             alt="Preview ${index + 1}"
                             class="w-full h-20 object-cover rounded-lg border border-green-200">
                        <div class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-50 text-white text-xs p-1 rounded text-center">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </div>
                        <button type="button"
                                onclick="removeInventoryPhoto(this, ${index})"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            ×
                        </button>
                    `;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewDiv.classList.add('hidden');
    }
}

function removeInventoryPhoto(button, index) {
    // Remove the preview
    button.parentElement.remove();

    // Check if any photos remain
    const container = document.getElementById('inventory_preview_container');
    if (container.children.length === 0) {
        document.getElementById('inventory_photo_preview').classList.add('hidden');
        document.getElementById('inventory_photos').value = '';
    }
}
</script>

<?= $this->endSection() ?>
