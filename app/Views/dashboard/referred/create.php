<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Create New Dispatch</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new dispatch item for external service</p>
    </div>
    <a href="<?= base_url('dashboard/referred') ?>"
       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all duration-200 shadow-lg shadow-gray-500/25">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Dispatch
    </a>
</div>

<div class="w-full">
    <div class="bg-white shadow-xl rounded-2xl border border-gray-100">
        <form action="<?= base_url('dashboard/referred/store') ?>" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8 space-y-8">
            <?= csrf_field() ?>

            <!-- Customer Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-3"></i>
                        Customer Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Enter customer details for the dispatch</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Customer Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="customer_name"
                               name="customer_name"
                               value="<?= old('customer_name') ?>"
                               required
                               placeholder="e.g., राम बहादुर श्रेष्ठ"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.customer_name') ? 'border-red-500' : '' ?>">
                        <?php if (session('errors.customer_name')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.customer_name') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Customer Phone -->
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Customer Phone
                        </label>
                        <input type="tel"
                               id="customer_phone"
                               name="customer_phone"
                               value="<?= old('customer_phone') ?>"
                               placeholder="e.g., 9841234567"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.customer_phone') ? 'border-red-500' : '' ?>">
                        <?php if (session('errors.customer_phone')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.customer_phone') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Device Information Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-mobile-alt text-green-600 mr-3"></i>
                        Device Information
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Specify device details and problem description</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Device Name -->
                    <div>
                        <label for="device_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Device Name
                        </label>
                        <input type="text"
                               id="device_name"
                               name="device_name"
                               value="<?= old('device_name') ?>"
                               placeholder="e.g., iPhone 12 Pro, MacBook Air M1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.device_name') ? 'border-red-500' : '' ?>">
                        <?php if (session('errors.device_name')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.device_name') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Problem Description -->
                    <div class="md:col-span-2 xl:col-span-3">
                        <label for="problem_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Problem Description
                        </label>
                        <textarea id="problem_description"
                                  name="problem_description"
                                  rows="4"
                                  placeholder="Describe the problem that requires external service..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.problem_description') ? 'border-red-500' : '' ?>"><?= old('problem_description') ?></textarea>
                        <?php if (session('errors.problem_description')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.problem_description') ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Service Center Section -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-building text-purple-600 mr-3"></i>
                        Service Center Assignment
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Select service center and dispatch details</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Referred To -->
                    <div>
                        <label for="service_center_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Referred To <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <select id="service_center_id"
                                    name="service_center_id"
                                    onchange="updateReferredTo()"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 <?= session('errors.service_center_id') ? 'border-red-500' : '' ?>">
                            <option value="">Select Service Center</option>
                            <?php if (!empty($serviceCenters)): ?>
                                <?php foreach ($serviceCenters as $center): ?>
                                    <option value="<?= $center['id'] ?>" <?= old('service_center_id') == $center['id'] ? 'selected' : '' ?>>
                                        <?= esc($center['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                            <button type="button"
                                    onclick="openServiceCenterModal()"
                                    class="px-3 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200"
                                    title="Add New Service Center">
                                <i class="fas fa-plus"></i>
                            </button>
                            <a href="<?= base_url('dashboard/service-centers') ?>"
                               target="_blank"
                               class="px-3 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                               title="Manage Service Centers">
                                <i class="fas fa-cog"></i>
                            </a>
                    </div>

                        <!-- Custom Referred To (fallback) -->
                        <div class="mt-2">
                            <input type="text"
                                   id="referred_to"
                                   name="referred_to"
                                   value="<?= old('referred_to') ?>"
                                   placeholder="Or enter custom service center name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm <?= session('errors.referred_to') ? 'border-red-500' : '' ?>">
                        </div>

                    <?php if (session('errors.service_center_id')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.service_center_id') ?></p>
                    <?php endif; ?>
                    <?php if (session('errors.referred_to')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.referred_to') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Select from dropdown or enter custom name</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Initial Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 <?= session('errors.status') ? 'border-red-500' : '' ?>">
                        <option value="">Select status</option>
                        <option value="Pending" <?= old('status') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Dispatched" <?= old('status') === 'Dispatched' ? 'selected' : '' ?>>Dispatched</option>
                        <option value="Completed" <?= old('status') === 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <?php if (session('errors.status')): ?>
                        <p class="mt-1 text-sm text-red-600"><?= session('errors.status') ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Most dispatches start as "Pending"</p>
                </div>
            </div>

            <!-- Dispatch Photos -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-camera text-blue-600 mr-2"></i>
                    <h3 class="text-sm font-medium text-blue-900">Dispatch Photoproofs</h3>
                </div>
                <p class="text-sm text-blue-700 mb-3">Take photos of the device before sending to service center</p>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-2">Upload Photos</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dispatch_photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-blue-300 border-dashed rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-camera text-blue-400 text-2xl mb-2"></i>
                                    <p class="mb-2 text-sm text-blue-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-blue-500">PNG, JPG, GIF up to 5MB each</p>
                                </div>
                                <input id="dispatch_photos"
                                       name="dispatch_photos[]"
                                       type="file"
                                       multiple
                                       accept="image/*"
                                       onchange="previewDispatchPhotos(this)"
                                       class="hidden" />
                            </label>
                        </div>
                    </div>

                    <!-- Photo Preview -->
                    <div id="dispatch_photo_preview" class="hidden">
                        <label class="block text-sm font-medium text-blue-900 mb-2">Selected Photos</label>
                        <div id="dispatch_preview_container" class="grid grid-cols-2 md:grid-cols-4 gap-2"></div>
                    </div>

                    <!-- Photo Description -->
                    <div>
                        <label for="photo_description" class="block text-sm font-medium text-blue-900 mb-1">Photo Description</label>
                        <textarea id="photo_description"
                                  name="photo_description"
                                  rows="2"
                                  placeholder="Describe the condition of the device..."
                                  class="w-full px-3 py-2 text-sm border border-blue-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Templates</h3>
                <div class="flex flex-wrap gap-2">
                    <button type="button"
                            onclick="setTemplate('iPhone', 'मदरबोर्ड रिपेयर चाहिन्छ', 'Apple Service Center')"
                            class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded-full hover:bg-blue-200">
                        iPhone Repair
                    </button>
                    <button type="button"
                            onclick="setTemplate('MacBook', 'लिक्विड डेमेज, डाटा रिकभरी', 'Mac Specialist')"
                            class="px-3 py-1 text-xs bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200">
                        MacBook Repair
                    </button>
                    <button type="button"
                            onclick="setTemplate('Samsung Galaxy', 'डिस्प्ले IC बिग्रिएको', 'Samsung Service Center')"
                            class="px-3 py-1 text-xs bg-green-100 text-green-800 rounded-full hover:bg-green-200">
                        Samsung Repair
                    </button>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?= base_url('dashboard/referred') ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Create Dispatch
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Service Center Modal -->
<div id="serviceCenterModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Add New Service Center</h3>
                <button type="button" onclick="closeServiceCenterModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="serviceCenterForm" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Service Center Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="modal_name"
                           name="name"
                           required
                           placeholder="e.g., Apple Service Center Kathmandu"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label for="modal_contact_person" class="block text-sm font-medium text-gray-700 mb-1">
                        Contact Person
                    </label>
                    <input type="text"
                           id="modal_contact_person"
                           name="contact_person"
                           placeholder="e.g., राम बहादुर श्रेष्ठ"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label for="modal_phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone Number
                    </label>
                    <input type="tel"
                           id="modal_phone"
                           name="phone"
                           placeholder="e.g., 01-4567890"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label for="modal_address" class="block text-sm font-medium text-gray-700 mb-1">
                        Address
                    </label>
                    <textarea id="modal_address"
                              name="address"
                              rows="2"
                              placeholder="e.g., न्यू रोड, काठमाडौं"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>

                <input type="hidden" name="status" value="Active">
            </form>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button"
                        onclick="closeServiceCenterModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button type="button"
                        onclick="saveServiceCenter()"
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>Save Service Center
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function setTemplate(device, problem, referredTo) {
    document.getElementById('device_name').value = device;
    document.getElementById('problem_description').value = problem;
    document.getElementById('referred_to').value = referredTo;
    document.getElementById('status').value = 'Pending';
}

function updateReferredTo() {
    const select = document.getElementById('service_center_id');
    const input = document.getElementById('referred_to');

    if (select.value) {
        const selectedOption = select.options[select.selectedIndex];
        input.value = selectedOption.text;
        input.readOnly = true;
        input.classList.add('bg-gray-100');
    } else {
        input.value = '';
        input.readOnly = false;
        input.classList.remove('bg-gray-100');
    }
}

function openServiceCenterModal() {
    document.getElementById('serviceCenterModal').classList.remove('hidden');
}

function closeServiceCenterModal() {
    document.getElementById('serviceCenterModal').classList.add('hidden');
    document.getElementById('serviceCenterForm').reset();
}

function saveServiceCenter() {
    const form = document.getElementById('serviceCenterForm');
    const formData = new FormData(form);

    fetch('<?= base_url('dashboard/service-centers/store') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add new option to dropdown
            const select = document.getElementById('service_center_id');
            const option = new Option(data.service_center.name, data.service_center.id);
            select.add(option);
            select.value = data.service_center.id;

            // Update referred_to field
            updateReferredTo();

            // Close modal
            closeServiceCenterModal();

            // Show success message
            alert('Service center added successfully!');
        } else {
            alert('Error: ' + (data.message || 'Failed to add service center'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding service center');
    });
}

function previewDispatchPhotos(input) {
    const previewDiv = document.getElementById('dispatch_photo_preview');
    const container = document.getElementById('dispatch_preview_container');

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
                             class="w-full h-20 object-cover rounded-lg border border-blue-200">
                        <div class="absolute bottom-1 left-1 right-1 bg-black bg-opacity-50 text-white text-xs p-1 rounded text-center">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </div>
                        <button type="button"
                                onclick="removePhoto(this, ${index})"
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

function removePhoto(button, index) {
    // Remove the preview
    button.parentElement.remove();

    // Check if any photos remain
    const container = document.getElementById('dispatch_preview_container');
    if (container.children.length === 0) {
        document.getElementById('dispatch_photo_preview').classList.add('hidden');
        document.getElementById('dispatch_photos').value = '';
    }
}
</script>

<?= $this->endSection() ?>
