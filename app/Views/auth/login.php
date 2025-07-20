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
                        quasar: {
                            primary: '<?= $config->brandColors['primary'] ?>',    // #1976d2
                            secondary: '<?= $config->brandColors['secondary'] ?>', // #26a69a
                            accent: '<?= $config->brandColors['accent'] ?>',      // #9c27b0
                            warning: '<?= $config->brandColors['warning'] ?>',    // #ff9800
                            danger: '<?= $config->brandColors['danger'] ?>',      // #f44336
                            success: '<?= $config->brandColors['success'] ?>',    // #4caf50
                            info: '<?= $config->brandColors['info'] ?>',          // #2196f3
                            dark: '<?= $config->brandColors['dark'] ?>',          // #1d1d1d
                            light: '<?= $config->brandColors['light'] ?>',        // #fafafa
                        }
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
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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

    <div class="w-full max-w-4xl">
        <!-- Login Container -->
        <div class="card overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[500px]">

                <!-- Left Side - Branding -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-8 flex flex-col justify-center items-center text-white relative">
                    <!-- Subtle Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-8 left-8 w-24 h-24 border border-white/20 rounded-full"></div>
                        <div class="absolute bottom-16 right-8 w-16 h-16 border border-white/20 rounded-full"></div>
                        <div class="absolute top-1/2 left-1/4 w-12 h-12 border border-white/20 rounded-full"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-white/10 rounded-full backdrop-blur-sm">
                            <i class="fas fa-tools text-2xl text-white"></i>
                        </div>
                        <h1 class="text-2xl font-semibold mb-1"><?= $config->appShortName ?></h1>
                        <p class="text-blue-200 mb-4 text-xs font-medium">Tech Fix Center</p>
                        <p class="text-blue-100 mb-6 text-sm leading-relaxed"><?= $config->appDescription ?></p>

                        <!-- Feature List -->
                        <div class="space-y-2 text-blue-100 text-sm">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-shield-alt mr-2 text-white text-xs"></i>
                                <span>Secure & Professional</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fas fa-users mr-2 text-white text-xs"></i>
                                <span>Trusted by Technicians</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fas fa-clock mr-2 text-white text-xs"></i>
                                <span>24/7 Access</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="p-8 flex flex-col justify-center bg-white">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2 text-gray-900">Welcome Back</h2>
                        <p class="text-sm text-gray-600">Please sign in to your account</p>
                    </div>

                    <!-- Alert Messages -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-error">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2 text-sm"></i>
                                <span class="text-sm"><?= esc(session()->getFlashdata('error')) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-sm"></i>
                                <span class="text-sm"><?= esc(session()->getFlashdata('success')) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Validation Errors -->
                    <?php if (session('errors')): ?>
                        <div class="alert alert-error">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle mr-2 mt-0.5 text-sm"></i>
                                <div>
                                    <p class="text-sm font-medium mb-2">Please fix the following errors:</p>
                                    <ul class="text-sm space-y-1">
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

                        <!-- Google Clean Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium mb-2" style="color: #202124;">
                                Email Address <span style="color: #ea4335;">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope" style="color: #5f6368;"></i>
                                </div>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="<?= old('email') ?>"
                                       required
                                       autocomplete="email"
                                       placeholder="Enter your email address"
                                       class="form-control w-full pl-10 pr-3 py-3 text-base">
                            </div>
                        </div>

                        <!-- Google Clean Password Field -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium mb-2" style="color: #202124;">
                                Password <span style="color: #ea4335;">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock" style="color: #5f6368;"></i>
                                </div>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password"
                                       class="form-control w-full pl-10 pr-10 py-3 text-base">
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="passwordToggle" class="fas fa-eye hover:text-blue-600 transition-colors" style="color: #5f6368;"></i>
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