<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Menu System Debug</h1>
            
            <!-- Current Session Info -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h2 class="text-lg font-semibold text-blue-800 mb-2">Current Session</h2>
                <?php 
                helper('session');
                $currentRole = getUserRole();
                ?>
                <p><strong>Role:</strong> <?= $currentRole ?></p>
                <p><strong>Is Admin:</strong> <?= isAdmin() ? 'Yes' : 'No' ?></p>
                <p><strong>Has Admin Access:</strong> <?= hasAccessLevel('admin') ? 'Yes' : 'No' ?></p>
                <p><strong>Has User Access:</strong> <?= hasAccessLevel('user') ? 'Yes' : 'No' ?></p>
            </div>

            <!-- Menu Configuration Debug -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Menu Configuration</h2>
                <?php
                use App\Config\MenuConfig;
                $menuItems = MenuConfig::getMenuItems();
                ?>
                
                <div class="space-y-4">
                    <?php foreach ($menuItems as $sectionIndex => $section): ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-700 mb-2">
                                Section: <?= $section['section'] ?>
                                <span class="text-sm text-gray-500">
                                    (Access: <?= $section['access_level'] ?? 'not set' ?>)
                                </span>
                            </h3>
                            
                            <!-- Section Access Check -->
                            <div class="mb-2 text-sm">
                                <strong>Section Accessible:</strong> 
                                <?php 
                                $sectionAccess = MenuConfig::hasAccessLevel($section['access_level'] ?? 'all');
                                echo $sectionAccess ? '✅ Yes' : '❌ No';
                                ?>
                            </div>
                            
                            <!-- Items -->
                            <div class="ml-4">
                                <?php foreach ($section['items'] as $itemIndex => $item): ?>
                                    <div class="py-1 text-sm">
                                        <strong><?= $item['name'] ?></strong>
                                        (Access: <?= $item['access_level'] ?? 'not set' ?>)
                                        - 
                                        <?php 
                                        $itemAccess = MenuConfig::hasAccessLevel($item['access_level'] ?? 'all');
                                        echo $itemAccess ? '✅ Accessible' : '❌ Not Accessible';
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Rendered Menu HTML -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Rendered Menu HTML</h2>
                <?php
                helper('menu');
                $menuHtml = renderMenuItems('light', true);
                ?>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <pre class="text-xs overflow-x-auto"><?= htmlspecialchars($menuHtml) ?></pre>
                </div>
            </div>

            <!-- Role Switching -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Role Switch</h2>
                <div class="flex space-x-2">
                    <a href="<?= base_url('test/set-role/guest') ?>" class="bg-gray-500 text-white px-3 py-1 rounded text-sm">Guest</a>
                    <a href="<?= base_url('test/set-role/user') ?>" class="bg-green-500 text-white px-3 py-1 rounded text-sm">User</a>
                    <a href="<?= base_url('test/set-role/technician') ?>" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">Technician</a>
                    <a href="<?= base_url('test/set-role/admin') ?>" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Admin</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
