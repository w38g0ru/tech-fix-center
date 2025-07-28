<?php
$config = config('App');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= $config->appName ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-sm">TFC</span>
            </div>
            <h1 class="text-2xl font-semibold text-gray-900"><?= $config->appShortName ?></h1>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            
            <!-- Alerts -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                    <p class="text-sm text-red-700"><?= esc(session()->getFlashdata('error')) ?></p>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-50 border border-green-200 rounded-md p-3 mb-4">
                    <p class="text-sm text-green-700"><?= esc(session()->getFlashdata('success')) ?></p>
                </div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                    <ul class="text-sm text-red-700 space-y-1">
                        <?php foreach (session('errors') as $error): ?>
                            <li>• <?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="<?= base_url('auth/processLogin') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= old('email') ?>"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-fuchsia-500"
                           placeholder="Enter your email">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-fuchsia-500"
                           placeholder="Enter your password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" value="1" class="h-4 w-4 text-fuchsia-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-fuchsia-600 text-white py-2 px-4 rounded-md hover:bg-fuchsia-700 font-medium">
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 mb-4">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">or</span>
                    </div>
                </div>
            </div>

            <!-- Google Button -->
            <a href="<?= base_url('auth/google') ?>" 
               class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continue with Google
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-xs text-gray-500">© <?= date('Y') ?> <?= $config->companyName ?></p>
        </div>
    </div>

</body>
</html>
