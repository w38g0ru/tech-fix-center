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
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-fuchsia-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">T</span>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900"><?= $title ?></h1>
                    <p class="text-sm text-gray-600">CodeIgniter 4 Setup Verification</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Setup Successful!</h3>
                    <p class="text-sm text-green-700 mt-1"><?= $message ?></p>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">System Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Base URL</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono"><?= $base_url ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Environment</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $environment === 'development' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' ?>">
                            <?= ucfirst($environment) ?>
                        </span>
                    </dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">PHP Version</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= $php_version ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">CodeIgniter Version</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= $ci_version ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Server Software</dt>
                    <dd class="mt-1 text-sm text-gray-900"><?= $server_info ?></dd>
                </div>
                <div class="bg-gray-50 rounded-md p-4">
                    <dt class="text-sm font-medium text-gray-500">Document Root</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono break-all"><?= $document_root ?></dd>
                </div>
            </div>
        </div>

        <!-- Test Links -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Test Links</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="<?= base_url('test/database') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    Test Database
                </a>
                
                <a href="<?= base_url('test/routes') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Test Routes
                </a>
                
                <a href="<?= base_url('dashboard') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-fuchsia-600 hover:bg-fuchsia-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                    </svg>
                    Go to Dashboard
                </a>
            </div>
        </div>

        <!-- Current Request Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mt-6">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Current Request</h3>
                    <p class="text-sm text-blue-700 mt-1 font-mono"><?= $request_uri ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
