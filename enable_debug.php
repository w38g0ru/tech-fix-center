<?php
/**
 * Quick Debug Enabler for TFC Production
 * This will temporarily enable detailed error reporting
 * Upload to server and run once, then delete
 */

// Security check
if (!isset($_GET['enable']) || $_GET['enable'] !== 'debug2025') {
    http_response_code(404);
    exit('Not found');
}

echo "<h1>🔧 TFC Debug Mode Enabler</h1>";
echo "<style>body{font-family:monospace;} .success{color:green;} .error{color:red;}</style>";

// Check if .env exists
if (!file_exists('.env')) {
    echo "<div class='error'>❌ .env file not found</div>";
    exit;
}

// Read current .env
$envContent = file_get_contents('.env');

// Backup original .env
if (!file_exists('.env.backup')) {
    file_put_contents('.env.backup', $envContent);
    echo "<div class='success'>✅ Created .env.backup</div>";
}

// Enable development mode for detailed errors
if (strpos($envContent, 'CI_ENVIRONMENT') !== false) {
    $envContent = preg_replace('/CI_ENVIRONMENT\s*=\s*.+/', 'CI_ENVIRONMENT = development', $envContent);
    echo "<div class='success'>✅ Set environment to development</div>";
} else {
    $envContent = "CI_ENVIRONMENT = development\n" . $envContent;
    echo "<div class='success'>✅ Added development environment setting</div>";
}

// Add debug settings
$debugSettings = "\n# Temporary debug settings\napp.forceGlobalSecureRequests = false\nlogger.threshold = 9\n";

if (strpos($envContent, '# Temporary debug settings') === false) {
    $envContent .= $debugSettings;
    echo "<div class='success'>✅ Added debug settings</div>";
}

// Write updated .env
if (file_put_contents('.env', $envContent)) {
    echo "<div class='success'>✅ Updated .env file</div>";
} else {
    echo "<div class='error'>❌ Failed to update .env file</div>";
}

echo "<h2>📋 Next Steps:</h2>";
echo "<ol>";
echo "<li>Now try accessing: <a href='https://tfc.gaighat.com/dashboard/jobs'>https://tfc.gaighat.com/dashboard/jobs</a></li>";
echo "<li>You should see detailed error messages instead of 'Whoops!'</li>";
echo "<li>Note the specific error and fix it</li>";
echo "<li>Run restore_production.php to restore production settings</li>";
echo "<li>Delete this file and debug files</li>";
echo "</ol>";

echo "<h2>🔄 To Restore Production Mode:</h2>";
echo "<p>Create and run restore_production.php:</p>";
echo "<pre style='background:#f5f5f5;padding:10px;'>";
echo htmlspecialchars('<?php
if (file_exists(".env.backup")) {
    copy(".env.backup", ".env");
    unlink(".env.backup");
    echo "Production mode restored";
} else {
    echo "No backup found";
}
?>');
echo "</pre>";

echo "<hr>";
echo "<p><strong>⚠️ IMPORTANT:</strong> This enables development mode which shows detailed errors. Restore production mode after debugging!</p>";
?>
