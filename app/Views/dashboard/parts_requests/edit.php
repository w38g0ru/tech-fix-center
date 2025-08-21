<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Parts Request</h1>
        <p class="mt-1 text-sm text-gray-600">Update parts request details and specifications</p>
    </div>
    <div class="flex items-center justify-start lg:justify-end gap-2">
        <a href="<?= base_url('dashboard/parts-requests') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
           title="Back to Parts Requests">
            <i class="fas fa-arrow-left text-sm"></i>
            <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Parts Requests</span>
        </a>
    </div>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/parts-requests/update/' . $partsRequest['id']) ?>" method="POST" class="p-6 lg:p-8 space-y-8">
        <?= csrf_field() ?>

        <!-- Part Information Section -->
        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-cogs text-blue-600 mr-3"></i>
                    Part Information
                </h3>
                <p class="text-sm text-gray-600 mt-1">Specify the part details and requirements</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Part Name -->
                <div>
                    <label for="item_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Part Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="item_name"
                           name="item_name"
                           value="<?= old('item_name', $partsRequest['item_name']) ?>"
                           required
                           placeholder="Enter part name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.item_name') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.item_name')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.item_name') ?></p>
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
                           value="<?= old('brand', $partsRequest['brand']) ?>"
                           placeholder="Enter brand name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.brand') ? 'border-red-500' : '' ?>">
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
                           value="<?= old('model', $partsRequest['model']) ?>"
                           placeholder="Enter model number"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.model') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.model')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.model') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity_requested" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="quantity_requested"
                           name="quantity_requested"
                           value="<?= old('quantity_requested', $partsRequest['quantity_requested']) ?>"
                           min="1"
                           required
                           placeholder="Enter quantity"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.quantity_requested') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.quantity_requested')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.quantity_requested') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Request Details Section -->
        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-clipboard-list text-green-600 mr-3"></i>
                    Request Details
                </h3>
                <p class="text-sm text-gray-600 mt-1">Specify urgency, cost, and supplier information</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <!-- Urgency -->
                <div>
                    <label for="urgency" class="block text-sm font-medium text-gray-700 mb-2">
                        Urgency <span class="text-red-500">*</span>
                    </label>
                    <select id="urgency"
                            name="urgency"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.urgency') ? 'border-red-500' : '' ?>">
                        <option value="">Select urgency level</option>
                        <?php foreach ($urgencyLevels as $level): ?>
                            <option value="<?= $level ?>" <?= old('urgency', $partsRequest['urgency']) === $level ? 'selected' : '' ?>>
                                <?= $level ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.urgency')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.urgency') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Estimated Cost -->
                <div>
                    <label for="estimated_cost" class="block text-sm font-medium text-gray-700 mb-2">
                        Estimated Cost (NPR)
                    </label>
                    <input type="number"
                           id="estimated_cost"
                           name="estimated_cost"
                           value="<?= old('estimated_cost', $partsRequest['estimated_cost']) ?>"
                           step="0.01"
                           min="0"
                           placeholder="Enter estimated cost"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.estimated_cost') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.estimated_cost')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.estimated_cost') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Expected Delivery Date -->
                <div>
                    <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Expected Delivery Date
                    </label>
                    <input type="date"
                           id="expected_delivery_date"
                           name="expected_delivery_date"
                           value="<?= old('expected_delivery_date', $partsRequest['expected_delivery_date']) ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.expected_delivery_date') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.expected_delivery_date')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.expected_delivery_date') ?></p>
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
                           value="<?= old('supplier', $partsRequest['supplier']) ?>"
                           placeholder="Enter supplier name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.supplier') ? 'border-red-500' : '' ?>">
                    <?php if (session('errors.supplier')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.supplier') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Admin Assignment Section -->
        <?php if (in_array($userRole, ['superadmin', 'admin'])): ?>
        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-user-shield text-purple-600 mr-3"></i>
                    Assignment & Management
                </h3>
                <p class="text-sm text-gray-600 mt-1">Admin-only fields for job and technician assignment</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Assignment -->
                <div>
                    <label for="job_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Related Job
                    </label>
                    <select id="job_id"
                            name="job_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.job_id') ? 'border-red-500' : '' ?>">
                        <option value="">Select Job (Optional)</option>
                        <?php foreach ($jobs as $job): ?>
                            <option value="<?= $job['id'] ?>" <?= old('job_id', $partsRequest['job_id']) == $job['id'] ? 'selected' : '' ?>>
                                Job #<?= $job['id'] ?> - <?= esc($job['customer_name']) ?> (<?= esc($job['device_name']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.job_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.job_id') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Technician Assignment -->
                <div>
                    <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Assigned Technician
                    </label>
                    <select id="technician_id"
                            name="technician_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.technician_id') ? 'border-red-500' : '' ?>">
                        <option value="">Select Technician</option>
                        <?php foreach ($technicians as $technician): ?>
                            <option value="<?= $technician['id'] ?>" <?= old('technician_id', $partsRequest['technician_id']) == $technician['id'] ? 'selected' : '' ?>>
                                <?= esc($technician['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.technician_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.technician_id') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Additional Information Section -->
        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-sticky-note text-orange-600 mr-3"></i>
                    Additional Information
                </h3>
                <p class="text-sm text-gray-600 mt-1">Provide any additional details or notes</p>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description/Notes
                </label>
                <textarea id="description"
                          name="description"
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.description') ? 'border-red-500' : '' ?>"
                          placeholder="Additional details about the part request..."><?= old('description', $partsRequest['description']) ?></textarea>
                <?php if (session('errors.description')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.description') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
            <a href="<?= base_url('dashboard/parts-requests') ?>"
               class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
            <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 border border-transparent rounded-xl text-sm font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-lg shadow-green-500/25 transition-all duration-200">
                <i class="fas fa-save mr-2"></i>
                Update Parts Request
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
