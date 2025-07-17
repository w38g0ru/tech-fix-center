<?php
// Breadcrumb component for admin dashboard
// Usage: <?= $this->include('partials/admin/breadcrumb', ['breadcrumb' => $breadcrumb]) ?>
?>

<!-- Breadcrumb Navigation -->
<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm">
        <!-- Home/Dashboard -->
        <li>
            <a href="<?= base_url('admin/dashboard') ?>" 
               class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                <i class="fas fa-home"></i>
                <span class="sr-only">Dashboard</span>
            </a>
        </li>
        
        <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
            <?php foreach ($breadcrumb as $index => $item): ?>
                <li class="flex items-center">
                    <!-- Separator -->
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    
                    <?php if (isset($item['url']) && $index < count($breadcrumb) - 1): ?>
                        <!-- Linked breadcrumb item -->
                        <a href="<?= $item['url'] ?>" 
                           class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                            <?php if (isset($item['icon'])): ?>
                                <i class="<?= $item['icon'] ?> mr-1"></i>
                            <?php endif; ?>
                            <?= esc($item['title']) ?>
                        </a>
                    <?php else: ?>
                        <!-- Current page (no link) -->
                        <span class="text-gray-900 dark:text-white font-medium">
                            <?php if (isset($item['icon'])): ?>
                                <i class="<?= $item['icon'] ?> mr-1"></i>
                            <?php endif; ?>
                            <?= esc($item['title']) ?>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ol>
</nav>
