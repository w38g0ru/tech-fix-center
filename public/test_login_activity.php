<?php
// Test login activity logging
// Access this at: http://tfc.local/test_login_activity.php

require_once '../vendor/autoload.php';

$pathsConfig = require_once '../app/Config/Paths.php';
$paths = new \Config\Paths();

$app = new \CodeIgniter\CodeIgniter($paths);
$app->initialize();

echo "<h1>Test Login Activity Logging</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.info { color: blue; }
.section { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
</style>";

try {
    // Load helper
    helper('activity');
    
    echo "<div class='section'>";
    echo "<h2>Testing Activity Helper Functions</h2>";
    
    // Test user ID (you can change this to match your admin user ID)
    $testUserId = 1; // Change this to your actual admin user ID
    
    // Test login activity
    echo "<h3>1. Testing Login Activity</h3>";
    $loginResult = log_login_activity($testUserId, 'Test login from debug script');
    if ($loginResult) {
        echo "<span class='success'>✓ Login activity logged successfully</span><br>";
    } else {
        echo "<span class='error'>✗ Failed to log login activity</span><br>";
    }
    
    // Test logout activity
    echo "<h3>2. Testing Logout Activity</h3>";
    $logoutResult = log_logout_activity($testUserId, 'Test logout from debug script');
    if ($logoutResult) {
        echo "<span class='success'>✓ Logout activity logged successfully</span><br>";
    } else {
        echo "<span class='error'>✗ Failed to log logout activity</span><br>";
    }
    
    // Test post activity
    echo "<h3>3. Testing Post Activity</h3>";
    $postResult = log_post_activity($testUserId, 'Test post activity from debug script');
    if ($postResult) {
        echo "<span class='success'>✓ Post activity logged successfully</span><br>";
    } else {
        echo "<span class='error'>✗ Failed to log post activity</span><br>";
    }
    
    echo "</div>";
    
    // Show recent activities
    echo "<div class='section'>";
    echo "<h2>Recent Activities for User ID: $testUserId</h2>";
    
    try {
        $activities = get_user_recent_activities($testUserId, 10);
        
        if (!empty($activities)) {
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<tr><th>ID</th><th>Type</th><th>Details</th><th>IP</th><th>Created</th></tr>";
            foreach ($activities as $activity) {
                echo "<tr>";
                echo "<td>{$activity['id']}</td>";
                echo "<td>{$activity['activity_type']}</td>";
                echo "<td>" . substr($activity['details'], 0, 50) . "...</td>";
                echo "<td>{$activity['ip_address']}</td>";
                echo "<td>{$activity['created_at']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<span class='info'>No activities found for this user</span><br>";
        }
    } catch (Exception $e) {
        echo "<span class='error'>✗ Error getting activities: " . $e->getMessage() . "</span><br>";
    }
    
    echo "</div>";
    
    // Show activity stats
    echo "<div class='section'>";
    echo "<h2>Activity Statistics (Last 7 Days)</h2>";
    
    try {
        $stats = get_activity_stats(7);
        echo "<ul>";
        echo "<li>Total Activities: {$stats['total_activities']}</li>";
        echo "<li>Login Count: {$stats['login_count']}</li>";
        echo "<li>Logout Count: {$stats['logout_count']}</li>";
        echo "<li>Post Count: {$stats['post_count']}</li>";
        echo "</ul>";
    } catch (Exception $e) {
        echo "<span class='error'>✗ Error getting stats: " . $e->getMessage() . "</span><br>";
    }
    
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='section'>";
    echo "<span class='error'>✗ Error: " . $e->getMessage() . "</span>";
    echo "</div>";
}

echo "<div class='section'>";
echo "<h2>Next Steps</h2>";
echo "<p>If the tests above are successful, the activity logging system is working!</p>";
echo "<p>Now try:</p>";
echo "<ol>";
echo "<li><a href='/auth/login'>Login to your application</a> with admin2@techfixcenter.com</li>";
echo "<li>Perform some actions (create jobs, add inventory, etc.)</li>";
echo "<li>Check this page again to see if new activities are logged</li>";
echo "</ol>";
echo "</div>";
?>
