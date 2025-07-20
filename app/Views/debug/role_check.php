<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .debug-section h3 { margin-top: 0; color: #333; }
        .status-true { color: green; font-weight: bold; }
        .status-false { color: red; font-weight: bold; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1><?= $title ?></h1>
    
    <div class="debug-section">
        <h3>Login Status</h3>
        <p>Is Logged In: <span class="status-<?= $isLoggedIn ? 'true' : 'false' ?>"><?= $isLoggedIn ? 'YES' : 'NO' ?></span></p>
    </div>
    
    <div class="debug-section">
        <h3>Current User Information</h3>
        <pre><?= print_r($currentUser, true) ?></pre>
    </div>
    
    <div class="debug-section">
        <h3>User Role</h3>
        <p>Current Role: <strong><?= $userRole ?></strong></p>
    </div>
    
    <div class="debug-section">
        <h3>Role Checks</h3>
        <p>Has Admin Role: <span class="status-<?= $hasAdminRole ? 'true' : 'false' ?>"><?= $hasAdminRole ? 'YES' : 'NO' ?></span></p>
        <p>Has SuperAdmin Role: <span class="status-<?= $hasSuperAdminRole ? 'true' : 'false' ?>"><?= $hasSuperAdminRole ? 'YES' : 'NO' ?></span></p>
        <p>Has Any Admin Role: <span class="status-<?= $hasAnyAdminRole ? 'true' : 'false' ?>"><?= $hasAnyAdminRole ? 'YES' : 'NO' ?></span></p>
        <p>Can Create Technician: <span class="status-<?= $canCreateTechnician ? 'true' : 'false' ?>"><?= $canCreateTechnician ? 'YES' : 'NO' ?></span></p>
    </div>
    
    <div class="debug-section">
        <h3>Full Session Data</h3>
        <pre><?= print_r($sessionData, true) ?></pre>
    </div>
    
    <div class="debug-section">
        <h3>Actions</h3>
        <p><a href="<?= base_url('debug/service-center') ?>">Test Service Center Access</a></p>
        <p><a href="<?= base_url('dashboard/service-centers') ?>">Go to Service Centers</a></p>
        <p><a href="<?= base_url('dashboard') ?>">Go to Dashboard</a></p>
    </div>
</body>
</html>
