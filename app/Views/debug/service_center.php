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
        .access-granted { background-color: #d4edda; border-color: #c3e6cb; color: #155724; }
        .access-denied { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1><?= $title ?></h1>
    
    <div class="debug-section <?= $shouldHaveAccess ? 'access-granted' : 'access-denied' ?>">
        <h3>Access Status</h3>
        <p><strong><?= $shouldHaveAccess ? 'ACCESS GRANTED' : 'ACCESS DENIED' ?></strong></p>
        <p>Reason: <?= $redirectReason ?></p>
    </div>
    
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
        <h3>Role Checks for Service Center Access</h3>
        <p>Has Admin Role: <span class="status-<?= $hasAdminRole ? 'true' : 'false' ?>"><?= $hasAdminRole ? 'YES' : 'NO' ?></span></p>
        <p>Has SuperAdmin Role: <span class="status-<?= $hasSuperAdminRole ? 'true' : 'false' ?>"><?= $hasSuperAdminRole ? 'YES' : 'NO' ?></span></p>
        <p>Has Any Admin Role (Required): <span class="status-<?= $hasAnyAdminRole ? 'true' : 'false' ?>"><?= $hasAnyAdminRole ? 'YES' : 'NO' ?></span></p>
    </div>
    
    <div class="debug-section">
        <h3>Service Center Controller Logic</h3>
        <p>The ServiceCenters controller checks:</p>
        <code>if (!hasAnyRole(['superadmin', 'admin']))</code>
        <p>Result: <?= $hasAnyAdminRole ? 'User passes the check' : 'User fails the check and gets redirected' ?></p>
    </div>
    
    <div class="debug-section">
        <h3>Actions</h3>
        <p><a href="<?= base_url('debug/role-check') ?>">Full Role Debug</a></p>
        <p><a href="<?= base_url('dashboard/service-centers') ?>">Try Service Centers (will redirect if no access)</a></p>
        <p><a href="<?= base_url('dashboard') ?>">Go to Dashboard</a></p>
    </div>
</body>
</html>
