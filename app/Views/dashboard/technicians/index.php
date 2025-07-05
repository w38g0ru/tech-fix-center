<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Technicians</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your repair shop technicians</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <?php helper('auth'); ?>
        <?php if (canCreateTechnician()): ?>
            <a href="<?= base_url('dashboard/technicians/create') ?>"
               class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i>
                Add Technician
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Search Bar -->
<div class="mb-6">
    <form method="GET" action="<?= base_url('dashboard/technicians') ?>" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" 
                   name="search" 
                   value="<?= esc($search ?? '') ?>"
                   placeholder="Search technicians by name, email, or contact number..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('dashboard/technicians') ?>" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Technicians Table -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Technician
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact Info
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Job Statistics
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($technicians)): ?>
                    <?php foreach ($technicians as $technician): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                            <i class="fas fa-user-cog text-purple-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($technician['name']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php if (!empty($technician['email'])): ?>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            <a href="mailto:<?= esc($technician['email']) ?>"
                                               class="text-primary-600 hover:text-primary-700">
                                                <?= esc($technician['email']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($technician['contact_number'])): ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                                            <a href="tel:<?= esc($technician['contact_number']) ?>"
                                               class="text-primary-600 hover:text-primary-700">
                                                <?= esc($technician['contact_number']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (empty($technician['email']) && empty($technician['contact_number'])): ?>
                                        <span class="text-gray-400">No contact info</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php helper('auth'); ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= getRoleColor($technician['role'] ?? 'technician') ?>">
                                    <i class="<?= getRoleIcon($technician['role'] ?? 'technician') ?> mr-1"></i>
                                    <?= ucfirst($technician['role'] ?? 'technician') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= $technician['job_count'] ?? 0 ?> total
                                    </span>
                                    <?php if (isset($technician['pending_jobs']) && $technician['pending_jobs'] > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <?= $technician['pending_jobs'] ?> pending
                                        </span>
                                    <?php endif; ?>
                                    <?php if (isset($technician['in_progress_jobs']) && $technician['in_progress_jobs'] > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?= $technician['in_progress_jobs'] ?> active
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y', strtotime($technician['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <?php if (canEditTechnician()): ?>
                                        <a href="<?= base_url('dashboard/technicians/edit/' . $technician['id']) ?>"
                                           class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (canCreateTechnician()): ?>
                                        <a href="<?= base_url('dashboard/technicians/delete/' . $technician['id']) ?>"
                                           onclick="return confirm('Are you sure you want to delete this technician?')"
                                           class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-user-cog text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No technicians found</p>
                                <p class="text-sm">Get started by adding your first technician.</p>
                                <a href="<?= base_url('dashboard/technicians/create') ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Technician
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
