<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Dispatch Photos</h1>
        <p class="mt-1 text-sm text-gray-600">
            Photos for dispatch item: <span class="font-medium"><?= esc($referred['customer_name']) ?> - <?= esc($referred['device_name']) ?></span>
        </p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/photos/upload?type=referred&referred_id=' . $referred['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-colors">
            <i class="fas fa-camera mr-2"></i>
            Upload Photos
        </a>
        <a href="<?= base_url('dashboard/referred/view/' . $referred['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dispatch
        </a>
    </div>
</div>

<!-- Dispatch Info Card -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Customer</h3>
            <p class="mt-1 text-sm text-gray-900"><?= esc($referred['customer_name']) ?></p>
            <?php if (!empty($referred['customer_phone'])): ?>
                <p class="text-sm text-gray-600"><?= esc($referred['customer_phone']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Device</h3>
            <p class="mt-1 text-sm text-gray-900"><?= esc($referred['device_name']) ?></p>
            <?php if (!empty($referred['serial_number'])): ?>
                <p class="text-sm text-gray-600">S/N: <?= esc($referred['serial_number']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Status</h3>
            <p class="mt-1">
                <?php
                $statusClass = match($referred['status']) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'in_progress' => 'bg-blue-100 text-blue-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                };
                ?>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                    <?= esc($referred['status']) ?>
                </span>
            </p>
        </div>
    </div>
</div>

<!-- Photos Grid -->
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">
            Photos (<?= count($photos) ?>)
        </h3>
    </div>
    
    <div class="p-6">
        <?php if (empty($photos)): ?>
            <!-- No Photos State -->
            <div class="text-center py-12">
                <i class="fas fa-camera text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No photos uploaded</h3>
                <p class="text-gray-600 mb-6">Upload photos to document this dispatch item.</p>
                <a href="<?= base_url('dashboard/photos/upload?type=referred&referred_id=' . $referred['id']) ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-colors">
                    <i class="fas fa-camera mr-2"></i>
                    Upload First Photo
                </a>
            </div>
        <?php else: ?>
            <!-- Photos Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($photos as $photo): ?>
                    <div class="relative group bg-gray-50 rounded-lg overflow-hidden">
                        <!-- Photo -->
                        <div class="aspect-w-1 aspect-h-1">
                            <img src="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                                 alt="<?= esc($photo['description'] ?? 'Dispatch photo') ?>"
                                 class="w-full h-48 object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                 onclick="openPhotoModal('<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>', '<?= esc($photo['description'] ?? '') ?>', '<?= esc($photo['photo_type']) ?>')">
                        </div>
                        
                        <!-- Photo Info -->
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                    <?= esc($photo['photo_type']) ?>
                                </span>
                                <span class="text-xs text-gray-400">
                                    <?= date('M j, Y', strtotime($photo['uploaded_at'])) ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($photo['description'])): ?>
                                <p class="text-sm text-gray-700 line-clamp-2">
                                    <?= esc($photo['description']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Actions -->
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="flex space-x-1">
                                <a href="<?= base_url('dashboard/photos/view/' . $photo['id']) ?>" 
                                   class="inline-flex items-center justify-center w-8 h-8 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full text-gray-600 hover:text-blue-600 transition-colors"
                                   title="View Details">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <button onclick="downloadPhoto('<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>', '<?= esc($photo['file_name']) ?>')"
                                        class="inline-flex items-center justify-center w-8 h-8 bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full text-gray-600 hover:text-green-600 transition-colors"
                                        title="Download">
                                    <i class="fas fa-download text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="px-6 pb-6">
            <?php
            helper('pagination');
            echo renderPagination($pager, 'custom_simple', false);
            ?>
        </div>
    <?php endif; ?>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closePhotoModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Photo</h3>
                <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="text-center">
                <img id="modalImage" src="" alt="" class="max-w-full max-h-96 mx-auto rounded-lg">
                <p id="modalDescription" class="mt-4 text-sm text-gray-600"></p>
            </div>
        </div>
    </div>
</div>

<script>
function openPhotoModal(imageSrc, description, type) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalDescription').textContent = description || 'No description';
    document.getElementById('modalTitle').textContent = type ? type.charAt(0).toUpperCase() + type.slice(1) + ' Photo' : 'Photo';
    document.getElementById('photoModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function downloadPhoto(url, filename) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePhotoModal();
    }
});
</script>

<?= $this->endSection() ?>
