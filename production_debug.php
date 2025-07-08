<?php
/**
 * Production Debug Script for TFC
 * Upload this file to your production server to diagnose issues
 * Access via: https://tfc.gaighat.com/production_debug.php
 */

// Security check - remove this file after debugging
if (!isset($_GET['debug']) || $_GET['debug'] !== 'tfc2025') {
    http_response_code(404);
    exit('Not found');
}

echo "<h1>🔍 TFC Production Diagnostics</h1>";
echo "<style>body{font-family:monospace;} .error{color:red;} .success{color:green;} .warning{color:orange;}</style>";

echo "<h2>📋 System Information</h2>";
echo "<strong>PHP Version:</strong> " . PHP_VERSION . "<br>";
echo "<strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Current Directory:</strong> " . getcwd() . "<br>";
echo "<strong>Script Path:</strong> " . __FILE__ . "<br>";

echo "<h2>🔧 Environment Check</h2>";

// Check if .env file exists
if (file_exists('.env')) {
    echo "<span class='success'>✅ .env file exists</span><br>";
    
    // Read .env file (safely)
    $envContent = file_get_contents('.env');
    if (strpos($envContent, 'CI_ENVIRONMENT') !== false) {
        preg_match('/CI_ENVIRONMENT\s*=\s*(.+)/', $envContent, $matches);
        $environment = isset($matches[1]) ? trim($matches[1]) : 'unknown';
        echo "<strong>Environment:</strong> $environment<br>";
    }
    
    if (strpos($envContent, 'app.baseURL') !== false) {
        preg_match('/app\.baseURL\s*=\s*(.+)/', $envContent, $matches);
        $baseURL = isset($matches[1]) ? trim($matches[1], " '\"") : 'unknown';
        echo "<strong>Base URL:</strong> $baseURL<br>";
    }
    
    if (strpos($envContent, 'database.default.hostname') !== false) {
        preg_match('/database\.default\.hostname\s*=\s*(.+)/', $envContent, $matches);
        $dbHost = isset($matches[1]) ? trim($matches[1]) : 'unknown';
        echo "<strong>DB Host:</strong> $dbHost<br>";
    }
} else {
    echo "<span class='error'>❌ .env file missing</span><br>";
}

// Check if vendor directory exists
if (is_dir('vendor')) {
    echo "<span class='success'>✅ Vendor directory exists</span><br>";
} else {
    echo "<span class='error'>❌ Vendor directory missing - run composer install</span><br>";
}

// Check if app directory exists
if (is_dir('app')) {
    echo "<span class='success'>✅ App directory exists</span><br>";
} else {
    echo "<span class='error'>❌ App directory missing</span><br>";
}

// Check writable directory
if (is_dir('writable') && is_writable('writable')) {
    echo "<span class='success'>✅ Writable directory exists and is writable</span><br>";
} else {
    echo "<span class='error'>❌ Writable directory issue</span><br>";
}

echo "<h2>🗄️ Database Connection Test</h2>";

// Try to load CodeIgniter config
try {
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        
        // Try to get database config
        if (class_exists('Config\Database')) {
            $config = new \Config\Database();
            $dbConfig = $config->default;
            
            echo "<strong>DB Config Found:</strong><br>";
            echo "Host: " . $dbConfig['hostname'] . "<br>";
            echo "Database: " . $dbConfig['database'] . "<br>";
            echo "Username: " . $dbConfig['username'] . "<br>";
            echo "Driver: " . $dbConfig['DBDriver'] . "<br>";
            
            // Test connection
            try {
                $mysqli = new mysqli(
                    $dbConfig['hostname'],
                    $dbConfig['username'],
                    $dbConfig['password'],
                    $dbConfig['database']
                );
                
                if ($mysqli->connect_error) {
                    echo "<span class='error'>❌ Database connection failed: " . $mysqli->connect_error . "</span><br>";
                } else {
                    echo "<span class='success'>✅ Database connection successful</span><br>";
                    
                    // Check if tables exist
                    $tables = ['admin_users', 'jobs', 'inventory_items', 'parts_requests', 'service_centers'];
                    foreach ($tables as $table) {
                        $result = $mysqli->query("SHOW TABLES LIKE '$table'");
                        if ($result && $result->num_rows > 0) {
                            echo "<span class='success'>✅ Table '$table' exists</span><br>";
                        } else {
                            echo "<span class='error'>❌ Table '$table' missing</span><br>";
                        }
                    }
                    
                    // Check admin users
                    $result = $mysqli->query("SELECT COUNT(*) as count FROM admin_users");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        echo "<strong>Admin users count:</strong> " . $row['count'] . "<br>";
                    }
                }
            } catch (Exception $e) {
                echo "<span class='error'>❌ Database error: " . $e->getMessage() . "</span><br>";
            }
        } else {
            echo "<span class='error'>❌ Could not load database config</span><br>";
        }
    } else {
        echo "<span class='error'>❌ Autoloader not found</span><br>";
    }
} catch (Exception $e) {
    echo "<span class='error'>❌ Error loading framework: " . $e->getMessage() . "</span><br>";
}

echo "<h2>📁 File Permissions</h2>";

$checkPaths = [
    'writable' => 'writable/',
    'public' => 'public/',
    'app' => 'app/',
    '.env' => '.env'
];

foreach ($checkPaths as $name => $path) {
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $readable = is_readable($path) ? '✅' : '❌';
        $writable = is_writable($path) ? '✅' : '❌';
        echo "<strong>$name:</strong> $perms | Readable: $readable | Writable: $writable<br>";
    } else {
        echo "<strong>$name:</strong> <span class='error'>❌ Not found</span><br>";
    }
}

echo "<h2>🔍 Recent Error Logs</h2>";

// Try to read PHP error log
$errorLogPaths = [
    '/var/log/apache2/error.log',
    '/var/log/httpd/error_log',
    '/var/log/nginx/error.log',
    '/var/log/php_errors.log',
    'writable/logs/log-' . date('Y-m-d') . '.log'
];

foreach ($errorLogPaths as $logPath) {
    if (file_exists($logPath) && is_readable($logPath)) {
        echo "<h3>📄 $logPath (last 10 lines)</h3>";
        $lines = file($logPath);
        $lastLines = array_slice($lines, -10);
        echo "<pre style='background:#f5f5f5;padding:10px;'>";
        foreach ($lastLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
        break;
    }
}

echo "<h2>🧪 CodeIgniter Test</h2>";

// Test if we can load CodeIgniter
try {
    if (file_exists('public/index.php')) {
        echo "<span class='success'>✅ public/index.php exists</span><br>";
        
        // Try to capture any output from a simple request
        ob_start();
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['HTTP_HOST'] = 'tfc.gaighat.com';
        
        // This is a simplified test - in production you'd need proper setup
        echo "<span class='warning'>⚠️ CodeIgniter bootstrap test would require proper environment setup</span><br>";
        
        ob_end_clean();
    } else {
        echo "<span class='error'>❌ public/index.php missing</span><br>";
    }
} catch (Exception $e) {
    echo "<span class='error'>❌ CodeIgniter test error: " . $e->getMessage() . "</span><br>";
}

echo "<h2>🎯 Recommendations</h2>";
echo "<ul>";
echo "<li>Check database credentials in .env file</li>";
echo "<li>Ensure all database tables are imported</li>";
echo "<li>Verify file permissions (writable/ should be 755)</li>";
echo "<li>Check web server document root points to public/ folder</li>";
echo "<li>Review error logs for specific PHP/Apache errors</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>⚠️ SECURITY WARNING:</strong> Delete this file after debugging!</p>";
echo "<p>Generated at: " . date('Y-m-d H:i:s') . "</p>";
?>
