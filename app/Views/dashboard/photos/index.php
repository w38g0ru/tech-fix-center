<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-camera text-white text-xl"></i>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-semibold text-gray-900">Photoproof Gallery</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-camera mr-1"></i>
                        Media Management
                    </span>
                </div>
                <p class="text-sm text-gray-600">
                    Manage job and dispatch photoproofs
                </p>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2">
            <a href="<?= base_url('dashboard/photos/upload') ?>"
               class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
               title="Upload New Photoproof">
                <i class="fas fa-upload text-sm"></i>
                <span class="hidden md:inline md:ml-2 whitespace-nowrap">Upload Photoproof</span>
            </a>
        </div>
    </div>
</div>

<!-- Photo Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-camera"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total Photoproofs</p>
                <p class="text-lg font-semibold text-gray-900"><?= count($photos) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-wrench"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Job Photoproofs</p>
                <p class="text-lg font-semibold text-gray-900"><?= count(array_filter($photos, fn($p) => $p['photo_type'] === 'Job')) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Dispatch Photoproofs</p>
                <p class="text-lg font-semibold text-gray-900"><?= count(array_filter($photos, fn($p) => $p['photo_type'] === 'Dispatch')) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Inventory Photoproofs</p>
                <p class="text-lg font-semibold text-gray-900"><?= count(array_filter($photos, fn($p) => $p['photo_type'] === 'Inventory')) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Photo Gallery -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <?php if (!empty($photos)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6">
            <?php foreach ($photos as $photo): ?>
                <div class="relative group bg-gray-100 rounded-lg overflow-hidden">
                    <!-- Photo -->
                    <div class="aspect-square">
                        <img src="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                             alt="<?= esc($photo['description'] ?? 'Photo') ?>"
                             class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-200"
                             onclick="openPhotoModal('<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>', '<?= esc($photo['description'] ?? '') ?>')">
                    </div>
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex space-x-2">
                            <a href="<?= base_url('dashboard/photos/view/' . $photo['id']) ?>" 
                               class="p-2 bg-white rounded-full text-gray-700 hover:text-primary-600">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php helper('auth'); ?>
                            <?php if (canDeleteJob()): ?>
                                <a href="<?= base_url('dashboard/photos/delete/' . $photo['id']) ?>" 
                                   onclick="return confirm('Are you sure you want to delete this photo?')"
                                   class="p-2 bg-white rounded-full text-gray-700 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Photo Info -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3">
                        <div class="text-white">
                            <div class="flex items-center justify-between mb-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full <?= match($photo['photo_type']) {
                                    'Job' => 'bg-blue-100 text-blue-800',
                                    'Dispatch' => 'bg-orange-100 text-orange-800',
                                    'Received' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } ?>">
                                    <?= esc($photo['photo_type']) ?>
                                </span>
                                <span class="text-xs text-gray-300">
                                    <?= date('M j', strtotime($photo['uploaded_at'])) ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($photo['job_device'])): ?>
                                <p class="text-xs text-gray-300 truncate">
                                    Job: <?= esc($photo['job_device']) ?>
                                </p>
                                <?php if (!empty($photo['customer_name'])): ?>
                                    <p class="text-xs text-gray-300 truncate">
                                        Customer: <?= esc($photo['customer_name']) ?>
                                    </p>
                                <?php endif; ?>
                            <?php elseif (!empty($photo['referred_device'])): ?>
                                <p class="text-xs text-gray-300 truncate">
                                    Dispatch: <?= esc($photo['referred_device']) ?>
                                </p>
                                <?php if (!empty($photo['referred_customer'])): ?>
                                    <p class="text-xs text-gray-300 truncate">
                                        Customer: <?= esc($photo['referred_customer']) ?>
                                    </p>
                                <?php endif; ?>
                            <?php elseif (!empty($photo['inventory_device'])): ?>
                                <p class="text-xs text-gray-300 truncate">
                                    Item: <?= esc($photo['inventory_device']) ?>
                                </p>
                                <?php if (!empty($photo['inventory_brand'])): ?>
                                    <p class="text-xs text-gray-300 truncate">
                                        Brand: <?= esc($photo['inventory_brand']) ?>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if (!empty($photo['description'])): ?>
                                <p class="text-xs text-gray-300 truncate mt-1">
                                    <?= esc($photo['description']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="px-6 py-12 text-center">
            <div class="text-gray-500">
                <i class="fas fa-camera text-4xl mb-4"></i>
                <p class="text-lg font-medium">No photoproofs found</p>
                <p class="text-sm">Get started by uploading your first photoproofs.</p>
                <a href="<?= base_url('dashboard/photos/upload') ?>"
                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    <i class="fas fa-upload mr-2"></i>
                    Upload Photoproof
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if (isset($pager) && $pager): ?>
        <?= renderPagination($pager) ?>
    <?php endif; ?>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closePhotoModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <i class="fas fa-times text-2xl"></i>
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
