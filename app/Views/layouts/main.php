<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?? 'TeknoPhix - Professional Device Repair Management System' ?>">
    <title><?= $title ?? 'TeknoPhix' ?> | Professional Device Repair</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-fuchsia': '#D946EF',
                    }
                }
            }
        }
    </script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Additional Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="TeknoPhix">
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-fuchsia-600 text-white px-4 py-2 rounded-md text-sm font-medium z-50">
        Skip to main content
    </a>

    <!-- Navigation Header -->
    <header class="bg-white shadow-sm border-b border-gray-200" role="banner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <a href="<?= base_url() ?>" class="flex items-center space-x-2 text-gray-900 hover:text-fuchsia-600 transition-colors duration-200" aria-label="TeknoPhix Home">
                        <div class="w-8 h-8 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">T</span>
                        </div>
                        <span class="text-xl font-semibold">TeknoPhix</span>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="hidden md:flex items-center space-x-8" role="navigation" aria-label="Main navigation">
                    <a href="<?= base_url('jobs') ?>" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                        Jobs
                    </a>
                    <a href="<?= base_url('customers') ?>" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                        Customers
                    </a>
                    <a href="<?= base_url('technicians') ?>" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                        Technicians
                    </a>
                    <a href="<?= base_url('inventory') ?>" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                        Inventory
                    </a>
                </nav>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button type="button" class="text-gray-400 hover:text-gray-600 p-2 rounded-md transition-colors duration-200" aria-label="View notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5V3h0z"/>
                        </svg>
                    </button>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 text-sm font-medium">
                                <?= substr(session('user.name') ?? 'U', 0, 1) ?>
                            </span>
                        </div>
                        <span class="hidden sm:block text-sm font-medium text-gray-700">
                            <?= session('user.name') ?? 'User' ?>
                        </span>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button type="button" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors duration-200" aria-label="Open main menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main-content" class="flex-1" role="main">
        <!-- Page Header (if provided) -->
        <?php if (isset($pageHeader)): ?>
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <?= $pageHeader ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-green-50 border border-green-200 rounded-md p-4" role="alert">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            <?= session()->getFlashdata('success') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="bg-red-50 border border-red-200 rounded-md p-4" role="alert">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            <?= session()->getFlashdata('error') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <div class="text-sm text-gray-500">
                    © <?= date('Y') ?> TeknoPhix. Professional device repair management.
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-6">
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        Terms of Service
                    </a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        Support
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for mobile menu toggle (if needed) -->
    <script>
        // Simple mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Add any interactive functionality here if needed
            console.log('TeknoPhix layout loaded');
        });
    </script>
</body>
</html>
