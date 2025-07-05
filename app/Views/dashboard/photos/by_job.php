<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Job Photoproofs - #<?= $job['id'] ?></h1>
        <p class="mt-1 text-sm text-gray-600">
            <?= esc($job['device_name']) ?>
            <?php if (!empty($job['customer_name'])): ?>
                - <?= esc($job['customer_name']) ?>
            <?php endif; ?>
        </p>
    </div>
    <div class="flex space-x-2">
        <a href="<?= base_url('dashboard/photos/upload?type=Job&job_id=' . $job['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
            <i class="fas fa-camera mr-2"></i>
            Add Photoproofs
        </a>
        <a href="<?= base_url('dashboard/jobs/view/' . $job['id']) ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Job
        </a>
    </div>
</div>

<!-- Job Summary -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Summary</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-500">Job ID</label>
            <p class="mt-1 text-sm text-gray-900">#<?= $job['id'] ?></p>
        </div>
        
        <div>
            <label class="text-sm font-medium text-gray-500">Device</label>
            <p class="mt-1 text-sm text-gray-900"><?= esc($job['device_name']) ?></p>
        </div>
        
        <?php if (!empty($job['customer_name'])): ?>
            <div>
                <label class="text-sm font-medium text-gray-500">Customer</label>
                <p class="mt-1 text-sm text-gray-900"><?= esc($job['customer_name']) ?></p>
            </div>
        <?php endif; ?>
        
        <div>
            <label class="text-sm font-medium text-gray-500">Status</label>
            <div class="mt-1">
                <span class="px-2 py-1 text-xs font-medium rounded-full <?= match($job['status']) {
                    'Pending' => 'bg-yellow-100 text-yellow-800',
                    'In Progress' => 'bg-blue-100 text-blue-800',
                    'Completed' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800'
                } ?>">
                    <?= esc($job['status']) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Photo Gallery -->
<div class="bg-white shadow rounded-lg">
    <?php if (!empty($photos)): ?>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Job Photoproofs</h3>
                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                    <?= count($photos) ?> photo(s)
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($photos as $photo): ?>
                    <div class="relative group bg-gray-100 rounded-lg overflow-hidden">
                        <!-- Photo -->
                        <div class="aspect-square">
                            <img src="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                                 alt="<?= esc($photo['description'] ?? 'Job photo') ?>"
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
                                       onclick="return confirm('Are you sure you want to delete this photoproof?')"
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
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                        <?= esc($photo['photo_type']) ?>
                                    </span>
                                    <span class="text-xs text-gray-300">
                                        <?= date('M j', strtotime($photo['uploaded_at'])) ?>
                                    </span>
                                </div>
                                
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
        </div>
    <?php else: ?>
        <div class="px-6 py-12 text-center">
            <div class="text-gray-500">
                <i class="fas fa-camera text-4xl mb-4"></i>
                <p class="text-lg font-medium">No photoproofs found for this job</p>
                <p class="text-sm">Get started by uploading your first photoproofs.</p>
                <a href="<?= base_url('dashboard/photos/upload?type=Job&job_id=' . $job['id']) ?>" 
                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                    <i class="fas fa-camera mr-2"></i>
                    Add Photoproofs
                </a>
            </div>
        </div>
    <?php endif; ?>
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
