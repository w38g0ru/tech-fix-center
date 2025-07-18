<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Dispatch Details</h1>
        <p class="mt-1 text-sm text-gray-600">View dispatch item information and photos</p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/referred/edit/' . $referred['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
            <i class="fas fa-edit mr-2"></i>
            Edit Dispatch
        </a>
        <a href="<?= base_url('dashboard/referred') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Dispatch Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Dispatch Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">Dispatch ID</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">#<?= $referred['id'] ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Status</label>
                    <div class="mt-1">
                        <span class="px-3 py-1 text-sm font-medium rounded-full <?= match($referred['status']) {
                            'Pending' => 'bg-yellow-100 text-yellow-800',
                            'Dispatched' => 'bg-orange-100 text-orange-800',
                            'Completed' => 'bg-green-100 text-green-800',
                            default => 'bg-gray-100 text-gray-800'
                        } ?>">
                            <i class="<?= match($referred['status']) {
                                'Pending' => 'fas fa-clock',
                                'Dispatched' => 'fas fa-truck',
                                'Completed' => 'fas fa-check-circle',
                                default => 'fas fa-question-circle'
                            } ?> mr-1"></i>
                            <?= esc($referred['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500">Customer Name</label>
                    <p class="mt-1 text-sm text-gray-900"><?= esc($referred['customer_name']) ?></p>
                </div>
                
                <?php if (!empty($referred['customer_phone'])): ?>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone Number</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="tel:<?= esc($referred['customer_phone']) ?>" 
                               class="text-primary-600 hover:text-primary-700">
                                <?= esc($referred['customer_phone']) ?>
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Device Information -->
        <?php if (!empty($referred['device_name']) || !empty($referred['problem_description'])): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Device Information</h3>
                
                <?php if (!empty($referred['device_name'])): ?>
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-500">Device Name</label>
                        <p class="mt-1 text-sm text-gray-900"><?= esc($referred['device_name']) ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($referred['problem_description'])): ?>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Problem Description</label>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap"><?= esc($referred['problem_description']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Service Information -->
        <?php if (!empty($referred['referred_to'])): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Service Information</h3>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Referred To</label>
                    <p class="mt-1 text-sm text-gray-900"><?= esc($referred['referred_to']) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Dispatch Photos -->
        <?php if (!empty($photos)): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Dispatch Photoproofs</h3>
                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                        <?= count($photos) ?> photo(s)
                    </span>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php foreach ($photos as $photo): ?>
                        <div class="relative group">
                            <img src="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                                 alt="<?= esc($photo['description'] ?? 'Dispatch photo') ?>"
                                 class="w-full h-32 object-cover rounded-lg border cursor-pointer hover:opacity-75 transition-opacity"
                                 onclick="openPhotoModal('<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>', '<?= esc($photo['description'] ?? '') ?>')">
                            
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center rounded-lg">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="<?= base_url('dashboard/photos/view/' . $photo['id']) ?>" 
                                       class="p-2 bg-white rounded-full text-gray-700 hover:text-primary-600">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <?php if (!empty($photo['description'])): ?>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-2 rounded-b-lg">
                                    <p class="text-white text-xs truncate"><?= esc($photo['description']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                <!-- Status Update -->
                <form action="<?= base_url('dashboard/referred/updateStatus/' . $referred['id']) ?>" method="POST" class="space-y-3">
                    <?= csrf_field() ?>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            <option value="Pending" <?= $referred['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Dispatched" <?= $referred['status'] === 'Dispatched' ? 'selected' : '' ?>>Dispatched</option>
                            <option value="Completed" <?= $referred['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-md text-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>
                
                <!-- Add Photos -->
                <a href="<?= base_url('dashboard/photos/upload?type=Dispatch&referred_id=' . $referred['id']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-camera mr-2"></i>
                    Add Photoproofs
                </a>
                
                <!-- View All Photos -->
                <a href="<?= base_url('dashboard/photos/referred/' . $referred['id']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-images mr-2"></i>
                    View All Photos
                </a>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline</h3>
            
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-blue-600 text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Dispatch Created</p>
                        <p class="text-xs text-gray-500"><?= date('M j, Y \a\t g:i A', strtotime($referred['created_at'])) ?></p>
                    </div>
                </div>
                
                <?php if (count($photos) > 0): ?>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-camera text-green-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Photos Added</p>
                            <p class="text-xs text-gray-500"><?= count($photos) ?> photoproof(s)</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closePhotoModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2">
            <i class="fas fa-times text-xl"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        <div id="modalDescription" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <p class="text-white text-center"></p>
        </div>
    </div>
</div>

<script>
function openPhotoModal(src, description) {
    const modal = document.getElementById('photoModal');
    const image = document.getElementById('modalImage');
    const desc = document.getElementById('modalDescription');
    
    image.src = src;
    image.alt = description;
    desc.querySelector('p').textContent = description;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePhotoModal() {
    const modal = document.getElementById('photoModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePhotoModal();
    }
});

// Close modal on background click
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});
</script>

<?= $this->endSection() ?>
