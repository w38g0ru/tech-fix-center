<?php
// Flash messages component for admin dashboard
// Displays success, error, warning, and info messages from session
?>

<!-- Flash Messages -->
<div class="mb-6 space-y-4">
    <!-- Success Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 dark:text-green-300 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                        Success!
                    </h3>
                    <div class="mt-1 text-sm text-green-700 dark:text-green-300">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="inline-flex text-green-400 dark:text-green-300 hover:text-green-600 dark:hover:text-green-100 transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Error Message -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 dark:text-red-300 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        Error!
                    </h3>
                    <div class="mt-1 text-sm text-red-700 dark:text-red-300">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="inline-flex text-red-400 dark:text-red-300 hover:text-red-600 dark:hover:text-red-100 transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Warning Message -->
    <?php if (session()->getFlashdata('warning')): ?>
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400 dark:text-yellow-300 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        Warning!
                    </h3>
                    <div class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                        <?= session()->getFlashdata('warning') ?>
                    </div>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="inline-flex text-yellow-400 dark:text-yellow-300 hover:text-yellow-600 dark:hover:text-yellow-100 transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Info Message -->
    <?php if (session()->getFlashdata('info')): ?>
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 dark:text-blue-300 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Information
                    </h3>
                    <div class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                        <?= session()->getFlashdata('info') ?>
                    </div>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="inline-flex text-blue-400 dark:text-blue-300 hover:text-blue-600 dark:hover:text-blue-100 transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Validation Errors -->
    <?php if (session()->getFlashdata('errors')): ?>
        <?php $errors = session()->getFlashdata('errors'); ?>
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 dark:text-red-300 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                        Validation Errors
                    </h3>
                    <div class="mt-2">
                        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                            <?php if (is_array($errors)): ?>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li><?= esc($errors) ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="inline-flex text-red-400 dark:text-red-300 hover:text-red-600 dark:hover:text-red-100 transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    // Auto-hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.querySelectorAll('[role="alert"]');
        flashMessages.forEach(function(message) {
            setTimeout(function() {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    message.remove();
                }, 300);
            }, 5000);
        });
    });
</script>
