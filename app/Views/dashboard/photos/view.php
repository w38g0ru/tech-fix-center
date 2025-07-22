<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Photoproof Details</h1>
        <p class="mt-1 text-sm text-gray-600">View photoproof information and details</p>
    </div>
    <div class="flex space-x-2">
        <?php helper('auth'); ?>
        <?php if (canDeleteJob()): ?>
            <a href="<?= base_url('dashboard/photos/delete/' . $photo['id']) ?>" 
               onclick="return confirm('Are you sure you want to delete this photo?')"
               class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                <i class="fas fa-trash mr-2"></i>
                Delete Photo
            </a>
        <?php endif; ?>
        <a href="<?= base_url('dashboard/photos') ?>" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Gallery
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Photo Display -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="aspect-video bg-gray-100 flex items-center justify-center">
                <img src="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                     alt="<?= esc($photo['description'] ?? 'Photo') ?>"
                     class="max-w-full max-h-full object-contain cursor-pointer"
                     onclick="openFullscreen(this)">
            </div>
            
            <?php if (!empty($photo['description'])): ?>
                <div class="p-4 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-700"><?= esc($photo['description']) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Photo Information -->
    <div class="space-y-6">
        <!-- Basic Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Photo Information</h3>
            
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-500">Photo Type</label>
                    <div class="mt-1">
                        <span class="px-2 py-1 text-sm font-medium rounded-full <?= match($photo['photo_type']) {
                            'Job' => 'bg-blue-100 text-blue-800',
                            'Dispatch' => 'bg-orange-100 text-orange-800',
                            'Received' => 'bg-green-100 text-green-800',
                            default => 'bg-gray-100 text-gray-800'
                        } ?>">
                            <i class="<?= match($photo['photo_type']) {
                                'Job' => 'fas fa-wrench',
                                'Dispatch' => 'fas fa-shipping-fast',
                                'Received' => 'fas fa-check-circle',
                                default => 'fas fa-camera'
                            } ?> mr-1"></i>
                            <?= esc($photo['photo_type']) ?>
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">अपलोड मिति</label>
                    <p class="mt-1 text-sm text-gray-900"><?= formatNepaliDateTime($photo['uploaded_at'], 'medium') ?></p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">File Name</label>
                    <p class="mt-1 text-sm text-gray-900 font-mono"><?= esc($photo['file_name']) ?></p>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        <?php if (!empty($photo['job_id']) || !empty($photo['referred_id'])): ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <?= !empty($photo['job_id']) ? 'Related Job' : 'Related Dispatch' ?>
                </h3>

                <?php if (!empty($photo['job_id'])): ?>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Job ID</label>
                            <p class="mt-1 text-sm text-gray-900">#<?= $photo['job_id'] ?></p>
                        </div>

                        <?php if (!empty($photo['job_device'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Device</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['job_device']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['job_serial'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Serial Number</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['job_serial']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['customer_name'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Customer</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['customer_name']) ?></p>
                                <?php if (!empty($photo['customer_phone'])): ?>
                                    <p class="text-xs text-gray-500"><?= esc($photo['customer_phone']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['technician_name'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Technician</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['technician_name']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['job_status'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?= match($photo['job_status']) {
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'In Progress' => 'bg-blue-100 text-blue-800',
                                        'Completed' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } ?>">
                                        <?= esc($photo['job_status']) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="pt-3">
                            <a href="<?= base_url('dashboard/jobs/view/' . $photo['job_id']) ?>"
                               class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                View Job Details
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Dispatch ID</label>
                            <p class="mt-1 text-sm text-gray-900">#<?= $photo['referred_id'] ?></p>
                        </div>

                        <?php if (!empty($photo['referred_customer'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Customer</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['referred_customer']) ?></p>
                                <?php if (!empty($photo['referred_phone'])): ?>
                                    <p class="text-xs text-gray-500"><?= esc($photo['referred_phone']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['referred_device'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Device</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['referred_device']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['referred_to'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Referred To</label>
                                <p class="mt-1 text-sm text-gray-900"><?= esc($photo['referred_to']) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($photo['referred_status'])): ?>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?= match($photo['referred_status']) {
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Dispatched' => 'bg-orange-100 text-orange-800',
                                        'Completed' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } ?>">
                                        <?= esc($photo['referred_status']) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="pt-3">
                            <a href="<?= base_url('dashboard/referred/view/' . $photo['referred_id']) ?>"
                               class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                View Dispatch Details
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            
            <div class="space-y-3">
                <a href="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                   target="_blank"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Open in New Tab
                </a>
                
                <a href="<?= base_url('dashboard/photos/serve/' . $photo['file_name']) ?>" 
                   download
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-download mr-2"></i>
                    Download Photo
                </a>
                
                <?php if ($photo['job_id']): ?>
                    <a href="<?= base_url('dashboard/photos/job/' . $photo['job_id']) ?>" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-images mr-2"></i>
                        View All Job Photos
                    </a>
                <?php endif; ?>
                
                <?php if ($photo['referred_id']): ?>
                    <a href="<?= base_url('dashboard/photos/referred/' . $photo['referred_id']) ?>" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-images mr-2"></i>
                        View All Dispatch Photos
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Modal -->
<div id="fullscreenModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
    <div class="relative max-w-full max-h-full">
        <button onclick="closeFullscreen()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2">
            <i class="fas fa-times text-xl"></i>
        </button>
        <img id="fullscreenImage" src="" alt="" class="max-w-full max-h-full object-contain">
    </div>
</div>

<script>
function openFullscreen(img) {
    const modal = document.getElementById('fullscreenModal');
    const fullscreenImg = document.getElementById('fullscreenImage');
    
    fullscreenImg.src = img.src;
    fullscreenImg.alt = img.alt;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    const modal = document.getElementById('fullscreenModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFullscreen();
    }
});

// Close modal on background click
document.getElementById('fullscreenModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFullscreen();
    }
});
</script>

<?= $this->endSection() ?>
