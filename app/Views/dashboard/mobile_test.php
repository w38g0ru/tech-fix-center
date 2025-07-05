<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Mobile Test Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Mobile Navigation Test</h1>
        <p class="text-gray-600">This page helps test mobile navigation functionality.</p>
    </div>

    <!-- Navigation Test -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Navigation Test</h2>
        <div class="space-y-4">
            <div class="p-4 bg-blue-50 rounded-lg">
                <h3 class="font-medium text-blue-900">Desktop (Large Screens)</h3>
                <p class="text-sm text-blue-700">Sidebar should be always visible on the left</p>
            </div>
            
            <div class="p-4 bg-green-50 rounded-lg">
                <h3 class="font-medium text-green-900">Mobile (Small Screens)</h3>
                <p class="text-sm text-green-700">
                    • Tap hamburger menu (☰) to open sidebar<br>
                    • Tap outside sidebar or swipe left to close<br>
                    • Swipe right from left edge to open sidebar
                </p>
            </div>
        </div>
    </div>

    <!-- Touch Test Area -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Touch Test Area</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <button class="p-4 bg-primary-100 text-primary-800 rounded-lg hover:bg-primary-200 transition-colors">
                Test Button 1
            </button>
            <button class="p-4 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 transition-colors">
                Test Button 2
            </button>
            <button class="p-4 bg-orange-100 text-orange-800 rounded-lg hover:bg-orange-200 transition-colors">
                Test Button 3
            </button>
        </div>
    </div>

    <!-- Scrolling Test -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Scrolling Test</h2>
        <div class="space-y-4">
            <?php for ($i = 1; $i <= 20; $i++): ?>
                <div class="p-4 bg-gray-50 rounded border">
                    <h3 class="font-medium">Test Item <?= $i ?></h3>
                    <p class="text-sm text-gray-600">This is test content item number <?= $i ?>. The page should scroll smoothly on mobile devices.</p>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Device Info -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Device Information</h2>
        <div id="device-info" class="space-y-2 text-sm text-gray-600">
            <p>Loading device information...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Display device information
    const deviceInfo = document.getElementById('device-info');
    const info = [
        `Screen Width: ${window.screen.width}px`,
        `Screen Height: ${window.screen.height}px`,
        `Viewport Width: ${window.innerWidth}px`,
        `Viewport Height: ${window.innerHeight}px`,
        `Device Pixel Ratio: ${window.devicePixelRatio}`,
        `User Agent: ${navigator.userAgent}`,
        `Touch Support: ${('ontouchstart' in window) ? 'Yes' : 'No'}`,
        `Platform: ${navigator.platform}`
    ];
    
    deviceInfo.innerHTML = info.map(item => `<p>${item}</p>`).join('');
    
    // Update on resize
    window.addEventListener('resize', function() {
        const newInfo = [
            `Screen Width: ${window.screen.width}px`,
            `Screen Height: ${window.screen.height}px`,
            `Viewport Width: ${window.innerWidth}px`,
            `Viewport Height: ${window.innerHeight}px`,
            `Device Pixel Ratio: ${window.devicePixelRatio}`,
            `User Agent: ${navigator.userAgent}`,
            `Touch Support: ${('ontouchstart' in window) ? 'Yes' : 'No'}`,
            `Platform: ${navigator.platform}`
        ];
        deviceInfo.innerHTML = newInfo.map(item => `<p>${item}</p>`).join('');
    });
});
</script>

<?= $this->endSection() ?>
