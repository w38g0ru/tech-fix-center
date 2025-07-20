<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8"><?= $title ?></h1>

            <!-- Debug Information -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">🔍 Debug Information</h2>
                <div class="space-y-3">
                    <div><strong>User ID:</strong> <?= $user_id ?? 'Not set' ?></div>

                    <?php if (isset($debug['table_exists'])): ?>
                        <div><strong>Table Exists:</strong>
                            <span class="<?= $debug['table_exists'] ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $debug['table_exists'] ? 'Yes' : 'No' ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($debug['table_fields'])): ?>
                        <div><strong>Table Fields:</strong>
                            <ul class="list-disc list-inside ml-4">
                                <?php foreach ($debug['table_fields'] as $field): ?>
                                    <li class="text-sm"><?= esc($field) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($debug['direct_insert'])): ?>
                        <div><strong>Direct DB Insert:</strong>
                            <span class="<?= $debug['direct_insert'] === 'Success' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= esc($debug['direct_insert']) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($debug['db_error'])): ?>
                        <div class="text-red-600"><strong>DB Error:</strong> <?= esc(json_encode($debug['db_error'])) ?></div>
                    <?php endif; ?>

                    <?php if (isset($debug['db_connection'])): ?>
                        <div class="text-red-600"><strong>DB Connection:</strong> <?= esc($debug['db_connection']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Errors -->
            <?php if (!empty($errors)): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold text-red-800 mb-4">❌ Errors</h2>
                    <?php foreach ($errors as $type => $error): ?>
                        <div class="mb-2">
                            <strong><?= ucfirst($type) ?>:</strong>
                            <span class="text-red-600"><?= esc($error) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Test Results -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Activity Logging Test Results</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 border rounded-lg">
                        <h3 class="font-medium text-gray-700">Login Activity</h3>
                        <p class="text-sm <?= $results['login'] ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $results['login'] ? 'Success' : 'Failed' ?>
                        </p>
                    </div>
                    <div class="p-4 border rounded-lg">
                        <h3 class="font-medium text-gray-700">Logout Activity</h3>
                        <p class="text-sm <?= $results['logout'] ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $results['logout'] ? 'Success' : 'Failed' ?>
                        </p>
                    </div>
                    <div class="p-4 border rounded-lg">
                        <h3 class="font-medium text-gray-700">Post Activity</h3>
                        <p class="text-sm <?= $results['post'] ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $results['post'] ? 'Success' : 'Failed' ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Activity Stats -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Activity Statistics (Last 7 Days)</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600"><?= $stats['total_activities'] ?></div>
                        <div class="text-sm text-gray-600">Total Activities</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600"><?= $stats['login_count'] ?></div>
                        <div class="text-sm text-gray-600">Logins</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600"><?= $stats['logout_count'] ?></div>
                        <div class="text-sm text-gray-600">Logouts</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600"><?= $stats['post_count'] ?></div>
                        <div class="text-sm text-gray-600">Posts</div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activities</h2>
                <?php if (!empty($recent_activities)): ?>
                    <div class="space-y-3">
                        <?php foreach ($recent_activities as $activity): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full <?= $activity['activity_type'] === 'login' ? 'bg-green-500' : ($activity['activity_type'] === 'logout' ? 'bg-red-500' : 'bg-blue-500') ?>"></div>
                                    <div>
                                        <div class="font-medium text-gray-800 capitalize"><?= esc($activity['activity_type']) ?></div>
                                        <div class="text-sm text-gray-600"><?= esc($activity['details']) ?></div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= date('M j, Y H:i', strtotime($activity['created_at'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No recent activities found.</p>
                <?php endif; ?>
            </div>
            
            <!-- Test POST Activity -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Test POST Activity Logging</h2>
                <p class="text-gray-600 mb-4">Click the button below to test automatic POST activity logging via the ActivityLogFilter.</p>
                <form method="POST" action="<?= base_url('test-activity/post') ?>">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                        Test POST Request
                    </button>
                </form>
            </div>
            
            <!-- Navigation -->
            <div class="mt-8 text-center">
                <a href="<?= base_url('dashboard') ?>" class="text-blue-600 hover:text-blue-800">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>
