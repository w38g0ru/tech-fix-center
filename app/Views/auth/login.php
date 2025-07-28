<?php
$config = config('App');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= $config->appName ?></title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $config->appDescription ?>">
    <meta name="author" content="<?= $config->companyName ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <!-- External Resources -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <style>
        /* Minimalist Design Theme - Matching Dashboard */
        :root {
            --primary: #1976d2;
            --primary-hover: #1565c0;
            --secondary: #26a69a;
            --accent: #9c27b0;
            --warning: #ff9800;
            --danger: #f44336;
            --success: #4caf50;
            --info: #2196f3;
            --dark: #1d1d1d;
            --light: #fafafa;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .form-input {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .form-input:focus {
            outline: none;
            border-color: #D946EF;
            box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.1);
        }

        .btn-primary {
            background: #D946EF;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #C026D3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(217, 70, 239, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            background: white;
            color: #374151;
            border: 1px solid #D1D5DB;
        }

        .btn-outline:hover {
            background: #F9FAFB;
            border-color: #9CA3AF;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }

        .alert-error {
            background: #ffebee;
            border: 1px solid #ffcdd2;
            color: #c62828;
        }

        .alert-success {
            background: #e8f5e8;
            border: 1px solid #c8e6c9;
            color: #2e7d32;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md mx-auto">
        <!-- Login Container -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-fuchsia-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-2xl">T</span>
                </div>
                <h1 class="text-2xl font-semibold text-gray-900 mb-2"><?= $config->appShortName ?></h1>
                <p class="text-sm text-gray-600">Sign in to your account</p>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span class="text-sm text-red-700"><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-sm text-green-700"><?= esc(session()->getFlashdata('success')) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if (session('errors')): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-red-700 mb-2">Please fix the following errors:</p>
                            <ul class="text-sm text-red-600 space-y-1">
                                <?php foreach (session('errors') as $error): ?>
                                    <li>• <?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('auth/processLogin') ?>" method="POST" id="loginForm" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email"
                               id="email"
                               name="email"
                               value="<?= old('email') ?>"
                               required
                               autocomplete="email"
                               placeholder="Enter your email address"
                               class="form-input pl-10 pr-4">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your password"
                               class="form-input pl-10 pr-10">
                        <button type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="passwordToggle" class="fas fa-eye text-gray-400 hover:text-fuchsia-600 transition-colors"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox"
                           id="remember"
                           name="remember"
                           value="1"
                           class="h-4 w-4 text-fuchsia-600 focus:ring-fuchsia-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me for 30 days
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        id="submitBtn"
                        class="w-full btn-primary py-3 px-4 text-base font-medium">
                    <span id="submitText">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </span>
                    <span id="loadingText" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Signing In...
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-8 mb-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Or continue with</span>
                    </div>
                </div>
            </div>

            <!-- Google Sign-in Button -->
            <div class="mb-8">
                <a href="<?= base_url('auth/google') ?>" class="btn btn-outline w-full py-3 text-base">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Sign in with Google
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-500">
                    © <?= date('Y') ?> <?= $config->companyName ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');

            // Show loading state
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');

            // Re-enable after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            }, 5000);
        });

        // Auto-focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>