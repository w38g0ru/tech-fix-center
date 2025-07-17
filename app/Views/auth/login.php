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

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        yellow: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '<?= $config->brandColors['accent'] ?>',
                            500: '#f59e0b',
                            600: '<?= $config->brandColors['primary'] ?>',
                            700: '<?= $config->brandColors['secondary'] ?>',
                            800: '#92400e',
                            900: '<?= $config->brandColors['dark'] ?>'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #92400e 0%, #451a03 100%);
        }
        .glass-effect {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.98);
            border: 2px solid rgba(217, 119, 6, 0.2);
            box-shadow: 0 20px 60px rgba(217, 119, 6, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            transition: all 0.3s ease;
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(217, 119, 6, 0.4);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-6xl">
        <!-- Horizontal Login Container -->
        <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">

                <!-- Left Side - Dark Yellow Minimal Branding -->
                <div class="bg-gradient-to-br from-yellow-800 to-yellow-900 p-16 flex flex-col justify-center items-center text-white relative overflow-hidden">
                    <!-- Minimal Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute top-16 left-16 w-40 h-40 border-2 border-yellow-400 rounded-3xl"></div>
                        <div class="absolute bottom-24 right-16 w-28 h-28 border-2 border-yellow-400 rounded-3xl"></div>
                        <div class="absolute top-1/2 left-1/4 w-20 h-20 border-2 border-yellow-400 rounded-3xl"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 text-center">
                        <div class="inline-flex items-center justify-center w-28 h-28 bg-yellow-600 rounded-3xl shadow-2xl mb-10">
                            <i class="fas fa-tools text-5xl text-white"></i>
                        </div>
                        <h1 class="text-5xl font-bold mb-6 tracking-tight"><?= $config->appName ?></h1>
                        <p class="text-2xl text-yellow-200 mb-12 leading-relaxed font-light"><?= $config->appDescription ?></p>

                        <!-- Minimal Feature Cards -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-center bg-yellow-800/30 backdrop-blur-sm rounded-2xl p-4 border border-yellow-600/20">
                                <i class="fas fa-shield-alt mr-4 text-yellow-400 text-xl"></i>
                                <span class="text-lg font-medium">Secure & Professional</span>
                            </div>
                            <div class="flex items-center justify-center bg-yellow-800/30 backdrop-blur-sm rounded-2xl p-4 border border-yellow-600/20">
                                <i class="fas fa-users mr-4 text-yellow-400 text-xl"></i>
                                <span class="text-lg font-medium">Trusted by Technicians</span>
                            </div>
                            <div class="flex items-center justify-center bg-yellow-800/30 backdrop-blur-sm rounded-2xl p-4 border border-yellow-600/20">
                                <i class="fas fa-clock mr-4 text-yellow-400 text-xl"></i>
                                <span class="text-lg font-medium">24/7 Access</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Dark Yellow Minimal Login Form -->
                <div class="p-16 flex flex-col justify-center bg-white">
                    <div class="mb-10">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4 tracking-tight">Welcome Back</h2>
                        <p class="text-gray-600 text-xl font-light">Please sign in to your account</p>
                    </div>

                    <!-- Alert Messages -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <p class="text-red-700 font-medium"><?= esc(session()->getFlashdata('error')) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <p class="text-green-700 font-medium"><?= esc(session()->getFlashdata('success')) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Validation Errors -->
                    <?php if (session('errors')): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                                <div>
                                    <p class="text-red-700 font-medium mb-2">Please fix the following errors:</p>
                                    <ul class="text-red-600 text-sm space-y-1">
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
                        <div class="space-y-4">
                            <label for="email" class="block text-lg font-semibold text-gray-700">
                                Email Address <span class="text-yellow-600">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-yellow-600 text-lg"></i>
                                </div>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="<?= old('email') ?>"
                                       required
                                       autocomplete="email"
                                       placeholder="Enter your email address"
                                       class="w-full pl-14 pr-5 py-5 border-2 border-yellow-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-yellow-600 transition-all duration-300 text-lg bg-yellow-50/50">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-4">
                            <label for="password" class="block text-lg font-semibold text-gray-700">
                                Password <span class="text-yellow-600">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-yellow-600 text-lg"></i>
                                </div>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password"
                                       class="w-full pl-14 pr-16 py-5 border-2 border-yellow-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-yellow-600 transition-all duration-300 text-lg bg-yellow-50/50">
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-5 flex items-center">
                                    <i id="passwordToggle" class="fas fa-eye text-yellow-600 hover:text-yellow-700 transition-colors text-lg"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox"
                                       id="remember"
                                       name="remember"
                                       value="1"
                                       class="h-5 w-5 text-accent-500 focus:ring-accent-500 border-primary-300 rounded transition-colors">
                                <label for="remember" class="ml-3 block text-sm text-primary-700 cursor-pointer font-medium">
                                    Remember me for 30 days
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                id="submitBtn"
                                class="w-full btn-primary py-4 px-6 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submitText">
                                <i class="fas fa-sign-in-alt mr-3"></i>
                                Sign In Securely
                            </span>
                            <span id="loadingText" class="hidden">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Signing In...
                            </span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="mt-8 mb-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-primary-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-primary-500 font-medium">Or continue with</span>
                            </div>
                        </div>
                    </div>

                    <!-- Google Login Button -->
                    <div class="mb-8">
                        <a href="<?= base_url('auth/google') ?>"
                           class="w-full flex justify-center items-center px-6 py-4 border border-primary-200 rounded-xl shadow-sm bg-white text-lg font-medium text-primary-700 hover:bg-primary-50 hover:border-accent-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-all duration-200">
                            <svg class="w-6 h-6 mr-3" viewBox="0 0 24 24">
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
                        <p class="text-sm text-primary-500">
                            © <?= date('Y') ?> Infotech Suppliers & Traders, Gaighat. All rights reserved.
                        </p>
                    </div>
                </div>
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