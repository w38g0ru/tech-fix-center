<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tech Fix Center</title>
    <meta name="description" content="Secure login to Tech Fix Center - Professional device repair management system">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    
    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        },
                        success: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            600: '#16a34a'
                        },
                        danger: {
                            50: '#fef2f2',
                            500: '#ef4444',
                            600: '#dc2626'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'shake': 'shake 0.5s ease-in-out',
                        'pulse-slow': 'pulse 3s infinite'
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
        }
        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 animate-fade-in">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></g></svg>');"></div>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-md relative z-10">
        <!-- Logo and Header -->
        <div class="text-center mb-8 animate-slide-up">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                <i class="fas fa-tools text-3xl text-primary-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Tech Fix Center</h1>
            <p class="text-white/80 text-sm">Professional Device Repair Management</p>
        </div>

        <!-- Login Form -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-slide-up">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                <p class="text-gray-600 text-sm">Please sign in to your account</p>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 p-4 bg-danger-50 border border-danger-200 rounded-lg animate-shake">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-danger-500 mr-3"></i>
                        <p class="text-danger-700 text-sm font-medium"><?= esc(session()->getFlashdata('error')) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 p-4 bg-success-50 border border-success-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-success-500 mr-3"></i>
                        <p class="text-success-700 text-sm font-medium"><?= esc(session()->getFlashdata('success')) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('auth/processLogin') ?>" method="POST" id="loginForm" class="space-y-6">
                <?= csrf_field() ?>
                
                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700">
                        Email Address <span class="text-danger-500">*</span>
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
                               class="input-focus w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?= session('errors.email') ? 'border-danger-500 bg-danger-50' : '' ?>">
                    </div>
                    <?php if (session('errors.email')): ?>
                        <p class="text-danger-600 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <?= esc(session('errors.email')) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        Password <span class="text-danger-500">*</span>
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
                               class="input-focus w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 <?= session('errors.password') ? 'border-danger-500 bg-danger-50' : '' ?>">
                        <button type="button" 
                                onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="passwordToggle" class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                        </button>
                    </div>
                    <?php if (session('errors.password')): ?>
                        <p class="text-danger-600 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <?= esc(session('errors.password')) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               value="1"
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition-colors">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                            Remember me for 30 days
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        id="submitBtn"
                        class="btn-hover w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-semibold shadow-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="submitText">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In Securely
                    </span>
                    <span id="loadingText" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Signing In...
                    </span>
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Demo Credentials:</h4>
                <div class="space-y-1 text-xs text-gray-600">
                    <p><strong>Super Admin:</strong> admin@techfixcenter.com / password</p>
                    <p><strong>Admin:</strong> admin2@techfixcenter.com / password</p>
                    <p><strong>Manager:</strong> manager@techfixcenter.com / password</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    © <?= date('Y') ?> Tech Fix Center. All rights reserved.
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

        // Demo credential quick fill
        function fillDemo(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        // Add click handlers for demo credentials
        document.addEventListener('DOMContentLoaded', function() {
            const demoCredentials = document.querySelectorAll('.demo-credential');
            demoCredentials.forEach(function(element) {
                element.addEventListener('click', function() {
                    const email = this.dataset.email;
                    const password = this.dataset.password;
                    fillDemo(email, password);
                });
            });
        });
    </script>
</body>
</html>
