<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">T</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900"><?= $title ?></h1>
                        <p class="text-sm text-gray-600">Database Connection Test</p>
                    </div>
                </div>
                <a href="<?= base_url('test') ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Test
                </a>
            </div>
        </div>

        <!-- Status Message -->
        <?php if ($status === 'success'): ?>
        <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Database Connection Successful!</h3>
                    <p class="text-sm text-green-700 mt-1"><?= $message ?></p>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Database Connection Failed!</h3>
                    <p class="text-sm text-red-700 mt-1"><?= $message ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Database Configuration -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Database Configuration</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Database Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono"><?= $database_name ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Hostname</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono"><?= $hostname ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Username</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono"><?= $username ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Driver</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= $driver ?></dd>
                </div>
            </div>
        </div>

        <?php if ($status === 'error'): ?>
        <!-- Troubleshooting Tips -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mt-6">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Troubleshooting Tips</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Make sure MySQL/MariaDB is running on your system</li>
                            <li>Verify the database name "<?= $database_name ?>" exists</li>
                            <li>Check if the username "<?= $username ?>" has proper permissions</li>
                            <li>Ensure the password is correct (currently empty)</li>
                            <li>Verify MySQL is running on port 3306</li>
                            <li>Check your .env file configuration</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
