<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Role Switcher - Menu Testing</h1>
            
            <!-- Current Role Display -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h2 class="text-lg font-semibold text-blue-800 mb-2">Current Session Info</h2>
                <?php 
                helper('session');
                $currentRole = getUserRole();
                $sessionInfo = getSessionInfo();
                ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <strong>Current Role:</strong> 
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm font-medium">
                            <?= ucfirst($currentRole) ?>
                        </span>
                    </div>
                    <div>
                        <strong>Access Level:</strong>
                        <?php if (hasAccessLevel('admin')): ?>
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">Admin Access</span>
                        <?php elseif (hasAccessLevel('technician')): ?>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">Technician Access</span>
                        <?php elseif (hasAccessLevel('user')): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">User Access</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm">Guest Access</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Role Switching Buttons -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Switch User Role</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="<?= base_url('test/set-role/guest') ?>" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-center transition-colors">
                        Guest
                    </a>
                    <a href="<?= base_url('test/set-role/user') ?>" 
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-center transition-colors">
                        User
                    </a>
                    <a href="<?= base_url('test/set-role/technician') ?>" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-center transition-colors">
                        Technician
                    </a>
                    <a href="<?= base_url('test/set-role/admin') ?>" 
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-center transition-colors">
                        Admin
                    </a>
                </div>
            </div>

            <!-- Menu Access Matrix -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Menu Access Matrix</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Menu Item</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Guest</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Technician</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            use App\Config\MenuConfig;
                            $menuItems = MenuConfig::getMenuItems();
                            
                            foreach ($menuItems as $section) {
                                foreach ($section['items'] as $item) {
                                    $accessLevel = $item['access_level'] ?? 'all';
                                    echo '<tr>';
                                    echo '<td class="px-4 py-2 text-sm font-medium text-gray-900">' . $item['name'] . '</td>';
                                    
                                    // Check access for each role
                                    $roles = ['guest', 'user', 'technician', 'admin'];
                                    foreach ($roles as $role) {
                                        $hasAccess = false;
                                        if ($accessLevel === 'all') {
                                            $hasAccess = true;
                                        } else {
                                            $levels = ['user' => 1, 'technician' => 2, 'admin' => 3];
                                            $roleLevel = $levels[$role] ?? 0;
                                            $requiredLevel = $levels[$accessLevel] ?? 999;
                                            $hasAccess = $roleLevel >= $requiredLevel;
                                        }
                                        
                                        $icon = $hasAccess ? '✅' : '❌';
                                        $bgColor = $hasAccess ? 'bg-green-50' : 'bg-red-50';
                                        echo '<td class="px-4 py-2 text-center text-sm ' . $bgColor . '">' . $icon . '</td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Instructions</h3>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Click on any role button above to switch your session role</li>
                    <li>• Check the sidebar menu to see how it changes based on your role</li>
                    <li>• The access matrix shows which menu items are available to each role</li>
                    <li>• Higher roles inherit access from lower roles (Admin can access everything)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
