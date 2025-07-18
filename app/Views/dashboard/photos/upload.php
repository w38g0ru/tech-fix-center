<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Upload Photoproof</h1>
        <p class="mt-1 text-sm text-gray-600">Upload photoproofs for jobs or dispatch items</p>
    </div>
    <a href="<?= base_url('dashboard/photos') ?>" 
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Gallery
    </a>
</div>

<div class="max-w-4xl">
    <div class="bg-white shadow rounded-lg">
        <form action="<?= base_url('dashboard/photos/store') ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            <?= csrf_field() ?>
            
            <!-- Photo Type -->
            <div>
                <label for="photo_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Photo Type <span class="text-red-500">*</span>
                </label>
                <select id="photo_type"
                        name="photo_type"
                        required
                        onchange="toggleRelatedFields()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.photo_type') ? 'border-red-500' : '' ?>">
                    <option value="">Select photoproof type</option>
                    <option value="Job" <?= (old('photo_type') === 'Job' || $preSelectedType === 'Job') ? 'selected' : '' ?>>📱 Job Photoproof (Link to Job)</option>
                    <option value="Dispatch" <?= (old('photo_type') === 'Dispatch' || $preSelectedType === 'Dispatch') ? 'selected' : '' ?>>📦 Dispatch Photoproof (Link to Dispatch)</option>
                    <option value="Received" <?= (old('photo_type') === 'Received' || $preSelectedType === 'Received') ? 'selected' : '' ?>>✅ Received Photoproof (Link to Dispatch)</option>
                    <option value="Inventory" <?= (old('photo_type') === 'Inventory' || $preSelectedType === 'Inventory') ? 'selected' : '' ?>>📦 Inventory Photoproof (Link to Inventory)</option>
                </select>
                <?php if (session('errors.photo_type')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.photo_type') ?></p>
                <?php endif; ?>

                <!-- Selection Guide -->
                <div id="selection_guide" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md" style="display: none;">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Next Step
                            </h3>
                            <div class="mt-1 text-sm text-blue-700">
                                <p id="guide_text">Select a photoproof type to continue</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    <strong>📱 Job Photoproof:</strong> Before/after photos of repair work (requires job selection)<br>
                    <strong>📦 Dispatch Photoproof:</strong> Photos when sending items to external service (requires dispatch selection)<br>
                    <strong>✅ Received Photoproof:</strong> Photos when items return from external service (requires dispatch selection)<br>
                    <strong>📦 Inventory Photoproof:</strong> Photos of inventory items for identification (requires inventory selection)
                </p>
            </div>

            <!-- Related Item Selection (shown based on photo type) -->
            <div id="related_item_section" style="display: none;">
                <!-- Related Job -->
                <div id="job_field" style="display: none;">
                    <label for="job_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Related Job <span class="text-red-500">*</span>
                    </label>
                    <select id="job_id"
                            name="job_id"
                            onchange="showJobDetails()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.job_id') ? 'border-red-500' : '' ?>">
                        <option value="">Select a job</option>
                        <?php if (!empty($jobs)): ?>
                            <?php foreach ($jobs as $job): ?>
                                <option value="<?= $job['id'] ?>"
                                        data-device="<?= esc($job['device_name']) ?>"
                                        data-customer="<?= esc($job['customer_name'] ?? '') ?>"
                                        data-status="<?= esc($job['status']) ?>"
                                        <?= (old('job_id') == $job['id'] || $preSelectedJobId == $job['id']) ? 'selected' : '' ?>>
                                    Job #<?= $job['id'] ?> - <?= esc($job['device_name']) ?>
                                    <?php if (!empty($job['customer_name'])): ?>
                                        (<?= esc($job['customer_name']) ?>)
                                    <?php endif; ?>
                                    - Status: <?= esc($job['status']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (session('errors.job_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.job_id') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Select the job this photoproof is related to</p>
                </div>

                <!-- Related Referred Item -->
                <div id="referred_field" style="display: none;">
                    <label for="referred_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Related Dispatch Item <span class="text-red-500">*</span>
                    </label>
                    <select id="referred_id"
                            name="referred_id"
                            onchange="showDispatchDetails()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.referred_id') ? 'border-red-500' : '' ?>">
                        <option value="">Select a dispatch item</option>
                        <?php if (!empty($referred)): ?>
                            <?php foreach ($referred as $item): ?>
                                <option value="<?= $item['id'] ?>"
                                        data-customer="<?= esc($item['customer_name']) ?>"
                                        data-device="<?= esc($item['device_name'] ?? '') ?>"
                                        data-status="<?= esc($item['status']) ?>"
                                        data-referred-to="<?= esc($item['referred_to'] ?? '') ?>"
                                        <?= (old('referred_id') == $item['id'] || $preSelectedReferredId == $item['id']) ? 'selected' : '' ?>>
                                    Dispatch #<?= $item['id'] ?> - <?= esc($item['customer_name']) ?>
                                    <?php if (!empty($item['device_name'])): ?>
                                        (<?= esc($item['device_name']) ?>)
                                    <?php endif; ?>
                                    - Status: <?= esc($item['status']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (session('errors.referred_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.referred_id') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Select the dispatch item this photoproof is related to</p>
                </div>

                <!-- Related Inventory Item -->
                <div id="inventory_field" style="display: none;">
                    <label for="inventory_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Related Inventory Item <span class="text-red-500">*</span>
                    </label>
                    <select id="inventory_id"
                            name="inventory_id"
                            onchange="showInventoryDetails()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.inventory_id') ? 'border-red-500' : '' ?>">
                        <option value="">Select an inventory item</option>
                        <?php if (!empty($inventory)): ?>
                            <?php foreach ($inventory as $item): ?>
                                <option value="<?= $item['id'] ?>"
                                        data-device="<?= esc($item['device_name']) ?>"
                                        data-brand="<?= esc($item['brand'] ?? '') ?>"
                                        data-model="<?= esc($item['model'] ?? '') ?>"
                                        data-stock="<?= esc($item['total_stock']) ?>"
                                        <?= (old('inventory_id') == $item['id'] || $preSelectedInventoryId == $item['id']) ? 'selected' : '' ?>>
                                    Item #<?= $item['id'] ?> - <?= esc($item['device_name']) ?>
                                    <?php if (!empty($item['brand'])): ?>
                                        (<?= esc($item['brand']) ?>)
                                    <?php endif; ?>
                                    - Stock: <?= esc($item['total_stock']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (session('errors.inventory_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.inventory_id') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Select the inventory item this photoproof is related to</p>
                </div>

                <!-- No Link Option -->
                <div id="no_link_field" style="display: none;">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    No linking required
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>This photoproof will be uploaded without linking to any specific job or dispatch item.</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                          placeholder="Optional description for the photoproofs..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.description') ? 'border-red-500' : '' ?>"><?= old('description') ?></textarea>
                <?php if (session('errors.description')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.description') ?></p>
                <?php endif; ?>
            </div>

            <!-- File Upload -->
            <div>
                <label for="photos" class="block text-sm font-medium text-gray-700 mb-2">
                    Photoproofs <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Upload photoproofs</span>
                                <input id="photos" 
                                       name="photos[]" 
                                       type="file" 
                                       multiple 
                                       accept="image/*"
                                       required
                                       onchange="previewFiles(this)"
                                       class="sr-only">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB each</p>
                    </div>
                </div>
                <?php if (session('errors.photos')): ?>
                    <p class="mt-1 text-sm text-red-600"><?= session('errors.photos') ?></p>
                <?php endif; ?>
            </div>

            <!-- Photo Preview -->
            <div id="photo-preview" class="hidden">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Selected Photoproofs</h3>
                <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/photos') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-primary-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i class="fas fa-upload mr-2"></i>
                    Upload Photoproof
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleRelatedFields() {
    const photoType = document.getElementById('photo_type').value;
    const relatedSection = document.getElementById('related_item_section');
    const jobField = document.getElementById('job_field');
    const referredField = document.getElementById('referred_field');
    const inventoryField = document.getElementById('inventory_field');
    const noLinkField = document.getElementById('no_link_field');
    const selectionGuide = document.getElementById('selection_guide');
    const guideText = document.getElementById('guide_text');

    // Hide all fields first
    relatedSection.style.display = 'none';
    jobField.style.display = 'none';
    referredField.style.display = 'none';
    inventoryField.style.display = 'none';
    noLinkField.style.display = 'none';
    selectionGuide.style.display = 'none';

    // Clear required attributes
    document.getElementById('job_id').removeAttribute('required');
    document.getElementById('referred_id').removeAttribute('required');
    document.getElementById('inventory_id').removeAttribute('required');

    // Show relevant field based on photo type
    if (photoType === 'Job') {
        relatedSection.style.display = 'block';
        jobField.style.display = 'block';
        selectionGuide.style.display = 'block';
        guideText.textContent = 'Now select which job this photoproof is related to';
        document.getElementById('job_id').setAttribute('required', 'required');
    } else if (photoType === 'Dispatch' || photoType === 'Received') {
        relatedSection.style.display = 'block';
        referredField.style.display = 'block';
        selectionGuide.style.display = 'block';
        guideText.textContent = 'Now select which dispatch item this photoproof is related to';
        document.getElementById('referred_id').setAttribute('required', 'required');
    } else if (photoType === 'Inventory') {
        relatedSection.style.display = 'block';
        inventoryField.style.display = 'block';
        selectionGuide.style.display = 'block';
        guideText.textContent = 'Now select which inventory item this photoproof is related to';
        document.getElementById('inventory_id').setAttribute('required', 'required');
    } else if (photoType) {
        // If a photo type is selected but doesn't require linking
        relatedSection.style.display = 'block';
        noLinkField.style.display = 'block';
        selectionGuide.style.display = 'block';
        guideText.textContent = 'This photoproof type doesn\'t require linking to specific items';
    } else {
        selectionGuide.style.display = 'block';
        guideText.textContent = 'Select a photoproof type to continue';
    }
}

function previewFiles(input) {
    const previewDiv = document.getElementById('photo-preview');
    const container = document.getElementById('preview-container');
    
    // Clear previous previews
    container.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        previewDiv.classList.remove('hidden');
        
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview ${index + 1}" 
                             class="w-full h-24 object-cover rounded-lg border">
                        <div class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-50 text-white text-xs p-1 rounded text-center">
                            ${file.name}
                        </div>
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

function showJobDetails() {
    const jobSelect = document.getElementById('job_id');
    const selectedOption = jobSelect.options[jobSelect.selectedIndex];

    if (selectedOption.value) {
        const device = selectedOption.getAttribute('data-device');
        const customer = selectedOption.getAttribute('data-customer');
        const status = selectedOption.getAttribute('data-status');

        const guideText = document.getElementById('guide_text');
        guideText.innerHTML = `Selected Job: <strong>${device}</strong><br>Customer: ${customer}<br>Status: ${status}`;
    }
}

function showDispatchDetails() {
    const dispatchSelect = document.getElementById('referred_id');
    const selectedOption = dispatchSelect.options[dispatchSelect.selectedIndex];

    if (selectedOption.value) {
        const customer = selectedOption.getAttribute('data-customer');
        const device = selectedOption.getAttribute('data-device');
        const status = selectedOption.getAttribute('data-status');
        const referredTo = selectedOption.getAttribute('data-referred-to');

        const guideText = document.getElementById('guide_text');
        guideText.innerHTML = `Selected Dispatch: <strong>${customer}</strong><br>Device: ${device}<br>Status: ${status}<br>Referred to: ${referredTo}`;
    }
}

function showInventoryDetails() {
    const inventorySelect = document.getElementById('inventory_id');
    const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];

    if (selectedOption.value) {
        const device = selectedOption.getAttribute('data-device');
        const brand = selectedOption.getAttribute('data-brand');
        const model = selectedOption.getAttribute('data-model');
        const stock = selectedOption.getAttribute('data-stock');

        const guideText = document.getElementById('guide_text');
        guideText.innerHTML = `Selected Item: <strong>${device}</strong><br>Brand: ${brand}<br>Model: ${model}<br>Stock: ${stock}`;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleRelatedFields();

    // Show details if items are pre-selected (from old input)
    showJobDetails();
    showDispatchDetails();
    showInventoryDetails();
});
</script>

<?= $this->endSection() ?>
