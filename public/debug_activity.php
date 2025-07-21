<?php
// Simple debug script for user activity logging
// Access this directly at: http://tfc.local/debug_activity.php

// Simple database connection without full CodeIgniter bootstrap
$dbConfig = [
    'hostname' => 'localhost',
    'username' => 'root',  // Change this to your DB username
    'password' => '',      // Change this to your DB password
    'database' => 'tech_fix_center', // Change this to your DB name
    'port'     => 3306,
];

// Try to get config from CodeIgniter if possible
if (file_exists('../app/Config/Database.php')) {
    require_once '../app/Config/Database.php';
    if (class_exists('Config\Database')) {
        $config = new \Config\Database();
        if (isset($config->default)) {
            $dbConfig = [
                'hostname' => $config->default['hostname'],
                'username' => $config->default['username'],
                'password' => $config->default['password'],
                'database' => $config->default['database'],
                'port'     => $config->default['port'] ?? 3306,
            ];
        }
    }
}

echo "<h1>User Activity Logging Debug</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.info { color: blue; }
.section { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
button { background: #007cba; color: white; padding: 10px 15px; border: none; border-radius: 3px; cursor: pointer; }
button:hover { background: #005a87; }
</style>";

try {
    // Test database connection using PDO
    $dsn = "mysql:host={$dbConfig['hostname']};port={$dbConfig['port']};dbname={$dbConfig['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    echo "<div class='section'>";
    echo "<h2>1. Database Connection</h2>";
    echo "<span class='success'>✓ Database connected successfully</span><br>";
    echo "<span class='info'>Database: {$dbConfig['database']} on {$dbConfig['hostname']}</span><br>";
    
    // Check if table exists
    echo "<h2>2. Table Check</h2>";

    $stmt = $pdo->prepare("SHOW TABLES LIKE 'user_activity_logs'");
    $stmt->execute();
    $tableExists = $stmt->rowCount() > 0;

    if ($tableExists) {
        echo "<span class='success'>✓ Table 'user_activity_logs' exists</span><br>";

        // Show table structure
        $stmt = $pdo->prepare("DESCRIBE user_activity_logs");
        $stmt->execute();
        $fields = $stmt->fetchAll();

        echo "<h3>Table Structure:</h3>";
        echo "<ul>";
        foreach ($fields as $field) {
            echo "<li>{$field['Field']} ({$field['Type']})</li>";
        }
        echo "</ul>";

        // Check for required fields
        $fieldNames = array_column($fields, 'Field');
        $requiredFields = ['id', 'user_id', 'activity_type', 'details', 'ip_address', 'user_agent', 'created_at'];
        $missingFields = array_diff($requiredFields, $fieldNames);

        if (empty($missingFields)) {
            echo "<span class='success'>✓ All required fields present</span><br>";
        } else {
            echo "<span class='error'>✗ Missing fields: " . implode(', ', $missingFields) . "</span><br>";
        }

    } else {
        echo "<span class='error'>✗ Table 'user_activity_logs' does not exist</span><br>";
    }
    echo "</div>";
    
    // Test direct insert
    echo "<div class='section'>";
    echo "<h2>3. Direct Database Insert Test</h2>";

    if ($tableExists) {
        try {
            $stmt = $pdo->prepare("INSERT INTO user_activity_logs (user_id, activity_type, details, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                1, // user_id
                'login', // activity_type
                'Direct PDO insert test',
                $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                $_SERVER['HTTP_USER_AGENT'] ?? 'Test Agent'
            ]);

            if ($result) {
                echo "<span class='success'>✓ Direct insert successful (ID: " . $pdo->lastInsertId() . ")</span><br>";
            } else {
                echo "<span class='error'>✗ Direct insert failed</span><br>";
            }
        } catch (Exception $e) {
            echo "<span class='error'>✗ Direct insert error: " . $e->getMessage() . "</span><br>";
        }
    } else {
        echo "<span class='info'>Skipping insert test - table doesn't exist</span><br>";
    }
    echo "</div>";
    
    // Show recent logs
    echo "<div class='section'>";
    echo "<h2>4. Recent Activity Logs</h2>";

    if ($tableExists) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM user_activity_logs ORDER BY created_at DESC LIMIT 5");
            $stmt->execute();
            $logs = $stmt->fetchAll();

            if (!empty($logs)) {
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr><th>ID</th><th>User ID</th><th>Type</th><th>Details</th><th>IP</th><th>Created</th></tr>";
                foreach ($logs as $log) {
                    echo "<tr>";
                    echo "<td>{$log['id']}</td>";
                    echo "<td>{$log['user_id']}</td>";
                    echo "<td>{$log['activity_type']}</td>";
                    echo "<td>" . substr($log['details'], 0, 50) . "...</td>";
                    echo "<td>{$log['ip_address']}</td>";
                    echo "<td>{$log['created_at']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<span class='info'>No activity logs found</span><br>";
            }
        } catch (Exception $e) {
            echo "<span class='error'>✗ Error reading logs: " . $e->getMessage() . "</span><br>";
        }
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='section'>";
    echo "<span class='error'>✗ Database connection failed: " . $e->getMessage() . "</span>";
    echo "</div>";
}

// Create table button
if (isset($_GET['create_table'])) {
    echo "<div class='section'>";
    echo "<h2>Creating Table...</h2>";

    try {
        // Drop existing table
        $pdo->exec('DROP TABLE IF EXISTS user_activity_logs');

        // Create new table
        $sql = "CREATE TABLE user_activity_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            activity_type ENUM('login','logout','post') NOT NULL,
            details TEXT,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_activity_type (activity_type),
            INDEX idx_created_at (created_at),
            INDEX idx_user_activity (user_id, activity_type)
        )";

        $pdo->exec($sql);
        echo "<span class='success'>✓ Table created successfully!</span><br>";
        echo "<a href='debug_activity.php'>Refresh page to test</a>";

    } catch (Exception $e) {
        echo "<span class='error'>✗ Failed to create table: " . $e->getMessage() . "</span><br>";
    }
    echo "</div>";
}

if (!$tableExists || !empty($missingFields)) {
    echo "<div class='section'>";
    echo "<h2>Quick Fix</h2>";
    echo "<p>Click the button below to create/recreate the table with the correct structure:</p>";
    echo "<a href='debug_activity.php?create_table=1'><button>Create/Recreate Table</button></a>";
    echo "</div>";
}

echo "<div class='section'>";
echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li>If the table was created/fixed, try logging in again at <a href='/auth/login'>Login Page</a></li>";
echo "<li>Check the activity logs in your admin panel</li>";
echo "<li>Test the activity logging by performing some actions</li>";
echo "</ol>";
echo "</div>";
?>
