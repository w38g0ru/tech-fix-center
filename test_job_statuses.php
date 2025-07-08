<?php
/**
 * Test Job Statuses - Check if the production database supports new job statuses
 * Upload this to your production server and run it
 * Access via: https://tfc.gaighat.com/test_job_statuses.php?test=jobstatus2025
 */

// Security check
if (!isset($_GET['test']) || $_GET['test'] !== 'jobstatus2025') {
    http_response_code(404);
    exit('Not found');
}

echo "<h1>🔍 TFC Job Status Test</h1>";
echo "<style>body{font-family:monospace;} .error{color:red;background:#ffe6e6;padding:5px;} .success{color:green;background:#e6ffe6;padding:5px;} .warning{color:orange;background:#fff3e6;padding:5px;}</style>";

// Get database config from .env
if (!file_exists('.env')) {
    echo "<div class='error'>❌ .env file not found</div>";
    exit;
}

$envContent = file_get_contents('.env');

// Extract database config
preg_match('/database\.default\.hostname\s*=\s*(.+)/', $envContent, $hostMatch);
preg_match('/database\.default\.database\s*=\s*(.+)/', $envContent, $dbMatch);
preg_match('/database\.default\.username\s*=\s*(.+)/', $envContent, $userMatch);
preg_match('/database\.default\.password\s*=\s*(.+)/', $envContent, $passMatch);

$host = isset($hostMatch[1]) ? trim($hostMatch[1]) : 'localhost';
$database = isset($dbMatch[1]) ? trim($dbMatch[1]) : '';
$username = isset($userMatch[1]) ? trim($userMatch[1]) : '';
$password = isset($passMatch[1]) ? trim($passMatch[1]) : '';

echo "<h2>📋 Database Connection Test</h2>";
echo "<div class='info'><strong>Host:</strong> $host<br><strong>Database:</strong> $database<br><strong>User:</strong> $username</div>";

try {
    $mysqli = new mysqli($host, $username, $password, $database);
    
    if ($mysqli->connect_error) {
        echo "<div class='error'>❌ Database connection failed: " . $mysqli->connect_error . "</div>";
        exit;
    }
    
    echo "<div class='success'>✅ Database connection successful</div>";
    
    // Check if jobs table exists
    $result = $mysqli->query("SHOW TABLES LIKE 'jobs'");
    if (!$result || $result->num_rows === 0) {
        echo "<div class='error'>❌ Jobs table does not exist</div>";
        exit;
    }
    
    echo "<div class='success'>✅ Jobs table exists</div>";
    
    // Check jobs table structure
    echo "<h2>📊 Jobs Table Structure</h2>";
    $result = $mysqli->query("DESCRIBE jobs");
    if ($result) {
        echo "<table border='1' style='border-collapse:collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Check if new columns exist
    echo "<h2>🔍 New Columns Check</h2>";
    $newColumns = [
        'dispatch_type' => 'Dispatch Type',
        'service_center_id' => 'Service Center ID',
        'dispatch_date' => 'Dispatch Date',
        'expected_return_date' => 'Expected Return Date',
        'actual_return_date' => 'Actual Return Date',
        'nepali_date' => 'Nepali Date',
        'walk_in_customer_name' => 'Walk-in Customer Name'
    ];
    
    foreach ($newColumns as $column => $description) {
        $result = $mysqli->query("SHOW COLUMNS FROM jobs LIKE '$column'");
        if ($result && $result->num_rows > 0) {
            echo "<div class='success'>✅ $description ($column) exists</div>";
        } else {
            echo "<div class='error'>❌ $description ($column) missing</div>";
        }
    }
    
    // Check status column type
    echo "<h2>📝 Status Column Analysis</h2>";
    $result = $mysqli->query("SHOW COLUMNS FROM jobs WHERE Field = 'status'");
    if ($result && $row = $result->fetch_assoc()) {
        echo "<div class='info'><strong>Status Column Type:</strong> " . $row['Type'] . "</div>";
        
        // Check if new statuses are supported
        $newStatuses = [
            'Parts Pending',
            'Referred to Service Center', 
            'Ready to Dispatch to Customer',
            'Returned'
        ];
        
        $statusType = $row['Type'];
        foreach ($newStatuses as $status) {
            if (strpos($statusType, $status) !== false) {
                echo "<div class='success'>✅ Status '$status' supported</div>";
            } else {
                echo "<div class='error'>❌ Status '$status' NOT supported</div>";
            }
        }
    }
    
    // Check service_centers table
    echo "<h2>🏢 Service Centers Table Check</h2>";
    $result = $mysqli->query("SHOW TABLES LIKE 'service_centers'");
    if ($result && $result->num_rows > 0) {
        echo "<div class='success'>✅ Service centers table exists</div>";
        
        // Count service centers
        $result = $mysqli->query("SELECT COUNT(*) as count FROM service_centers");
        if ($result && $row = $result->fetch_assoc()) {
            echo "<div class='info'><strong>Service centers count:</strong> " . $row['count'] . "</div>";
        }
    } else {
        echo "<div class='error'>❌ Service centers table missing</div>";
    }
    
    // Test a simple job query
    echo "<h2>🧪 Job Query Test</h2>";
    try {
        $result = $mysqli->query("SELECT COUNT(*) as count FROM jobs");
        if ($result && $row = $result->fetch_assoc()) {
            echo "<div class='success'>✅ Basic job query works - " . $row['count'] . " jobs found</div>";
        }
        
        // Test job stats query (this might be causing the error)
        $result = $mysqli->query("SELECT status, COUNT(*) as count FROM jobs GROUP BY status");
        if ($result) {
            echo "<div class='success'>✅ Job status grouping works</div>";
            echo "<table border='1' style='border-collapse:collapse;margin:10px 0;'>";
            echo "<tr><th>Status</th><th>Count</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['status'] . "</td><td>" . $row['count'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='error'>❌ Job status grouping failed: " . $mysqli->error . "</div>";
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Job query test failed: " . $e->getMessage() . "</div>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Database error: " . $e->getMessage() . "</div>";
}

echo "<h2>🎯 Recommendations</h2>";
echo "<ul>";
echo "<li>If status column doesn't support new statuses: Run fix_job_statuses.sql</li>";
echo "<li>If service_centers table missing: Import full database or run migration</li>";
echo "<li>If new columns missing: Update database structure</li>";
echo "<li>If job queries fail: Check for data integrity issues</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>⚠️ SECURITY:</strong> Delete this file after testing!</p>";
echo "<p>Generated: " . date('Y-m-d H:i:s') . "</p>";
?>
