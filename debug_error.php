<?php
/**
 * Emergency Debug Script for TFC Production Error
 * Upload this to your production server root directory
 * Access via: https://tfc.gaighat.com/debug_error.php?key=debug2025
 */

// Security check
if (!isset($_GET['key']) || $_GET['key'] !== 'debug2025') {
    http_response_code(404);
    exit('Not found');
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>🚨 TFC Emergency Debug</h1>";
echo "<style>body{font-family:monospace;background:#f5f5f5;} .error{color:red;background:#ffe6e6;padding:10px;} .success{color:green;background:#e6ffe6;padding:10px;} .warning{color:orange;background:#fff3e6;padding:10px;}</style>";

echo "<h2>🔍 Basic Environment Check</h2>";

// Check PHP version
echo "<div class='info'>";
echo "<strong>PHP Version:</strong> " . PHP_VERSION . "<br>";
echo "<strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Current Directory:</strong> " . getcwd() . "<br>";
echo "</div>";

// Check critical files
echo "<h2>📁 Critical Files Check</h2>";
$criticalFiles = [
    '.env' => '.env',
    'vendor/autoload.php' => 'Composer Autoloader',
    'app/Config/App.php' => 'App Config',
    'app/Config/Database.php' => 'Database Config',
    'public/index.php' => 'Main Entry Point',
    'writable' => 'Writable Directory'
];

foreach ($criticalFiles as $file => $description) {
    if (file_exists($file)) {
        echo "<div class='success'>✅ $description ($file) - EXISTS</div>";
        if ($file === 'writable' && !is_writable($file)) {
            echo "<div class='error'>❌ Writable directory is not writable!</div>";
        }
    } else {
        echo "<div class='error'>❌ $description ($file) - MISSING</div>";
    }
}

// Check .env configuration
echo "<h2>⚙️ Environment Configuration</h2>";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    // Check environment setting
    if (preg_match('/CI_ENVIRONMENT\s*=\s*(.+)/', $envContent, $matches)) {
        $env = trim($matches[1]);
        echo "<div class='info'><strong>Environment:</strong> $env</div>";
        
        if ($env === 'development') {
            echo "<div class='warning'>⚠️ Environment is set to 'development' - this will show detailed errors</div>";
        }
    }
    
    // Check base URL
    if (preg_match('/app\.baseURL\s*=\s*(.+)/', $envContent, $matches)) {
        $baseURL = trim($matches[1], " '\"");
        echo "<div class='info'><strong>Base URL:</strong> $baseURL</div>";
    }
} else {
    echo "<div class='error'>❌ .env file not found</div>";
}

// Test database connection
echo "<h2>🗄️ Database Connection Test</h2>";
try {
    if (file_exists('.env')) {
        $envContent = file_get_contents('.env');
        
        // Extract database config from .env
        preg_match('/database\.default\.hostname\s*=\s*(.+)/', $envContent, $hostMatch);
        preg_match('/database\.default\.database\s*=\s*(.+)/', $envContent, $dbMatch);
        preg_match('/database\.default\.username\s*=\s*(.+)/', $envContent, $userMatch);
        preg_match('/database\.default\.password\s*=\s*(.+)/', $envContent, $passMatch);
        
        $host = isset($hostMatch[1]) ? trim($hostMatch[1]) : 'localhost';
        $database = isset($dbMatch[1]) ? trim($dbMatch[1]) : '';
        $username = isset($userMatch[1]) ? trim($userMatch[1]) : '';
        $password = isset($passMatch[1]) ? trim($passMatch[1]) : '';
        
        echo "<div class='info'>";
        echo "<strong>DB Host:</strong> $host<br>";
        echo "<strong>DB Name:</strong> $database<br>";
        echo "<strong>DB User:</strong> $username<br>";
        echo "</div>";
        
        if ($database && $username) {
            $mysqli = new mysqli($host, $username, $password, $database);
            
            if ($mysqli->connect_error) {
                echo "<div class='error'>❌ Database connection failed: " . $mysqli->connect_error . "</div>";
            } else {
                echo "<div class='success'>✅ Database connection successful</div>";
                
                // Check critical tables
                $tables = ['admin_users', 'jobs', 'inventory_items'];
                foreach ($tables as $table) {
                    $result = $mysqli->query("SHOW TABLES LIKE '$table'");
                    if ($result && $result->num_rows > 0) {
                        echo "<div class='success'>✅ Table '$table' exists</div>";
                    } else {
                        echo "<div class='error'>❌ Table '$table' missing</div>";
                    }
                }
                
                $mysqli->close();
            }
        } else {
            echo "<div class='error'>❌ Database configuration incomplete</div>";
        }
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Database test error: " . $e->getMessage() . "</div>";
}

// Test CodeIgniter bootstrap
echo "<h2>🚀 CodeIgniter Bootstrap Test</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<div class='success'>✅ Autoloader loaded</div>";
        
        // Try to load basic CodeIgniter classes
        if (class_exists('CodeIgniter\CodeIgniter')) {
            echo "<div class='success'>✅ CodeIgniter core class available</div>";
        } else {
            echo "<div class='error'>❌ CodeIgniter core class not found</div>";
        }
        
        // Check if we can access config
        if (class_exists('Config\App')) {
            echo "<div class='success'>✅ App config class available</div>";
        } else {
            echo "<div class='error'>❌ App config class not found</div>";
        }
        
    } else {
        echo "<div class='error'>❌ Composer autoloader not found</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Bootstrap error: " . $e->getMessage() . "</div>";
}

// Check recent error logs
echo "<h2>📋 Recent Error Logs</h2>";
$logPaths = [
    'writable/logs',
    '/var/log/apache2/error.log',
    '/var/log/nginx/error.log',
    '/var/log/php_errors.log'
];

foreach ($logPaths as $logPath) {
    if (is_dir($logPath)) {
        echo "<h3>📁 $logPath</h3>";
        $files = glob($logPath . '/*.log');
        foreach (array_slice($files, -3) as $file) {
            echo "<h4>📄 " . basename($file) . "</h4>";
            $lines = file($file);
            $recentLines = array_slice($lines, -10);
            echo "<pre style='background:#f0f0f0;padding:10px;max-height:200px;overflow:auto;'>";
            foreach ($recentLines as $line) {
                echo htmlspecialchars($line);
            }
            echo "</pre>";
        }
    } elseif (file_exists($logPath) && is_readable($logPath)) {
        echo "<h3>📄 $logPath (last 15 lines)</h3>";
        $lines = file($logPath);
        $recentLines = array_slice($lines, -15);
        echo "<pre style='background:#f0f0f0;padding:10px;max-height:300px;overflow:auto;'>";
        foreach ($recentLines as $line) {
            if (strpos($line, 'error') !== false || strpos($line, 'Error') !== false || 
                strpos($line, 'fatal') !== false || strpos($line, 'Fatal') !== false) {
                echo "<span style='color:red;font-weight:bold;'>" . htmlspecialchars($line) . "</span>";
            } else {
                echo htmlspecialchars($line);
            }
        }
        echo "</pre>";
    }
}

// Test a simple route
echo "<h2>🧪 Simple Route Test</h2>";
try {
    // Test if we can make a simple internal request
    $testUrl = 'https://tfc.gaighat.com/auth/login';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "<div class='info'><strong>Login page test:</strong> HTTP $httpCode</div>";
    
    if ($httpCode === 200) {
        echo "<div class='success'>✅ Login page accessible</div>";
    } else {
        echo "<div class='error'>❌ Login page issue (HTTP $httpCode)</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Route test error: " . $e->getMessage() . "</div>";
}

echo "<h2>🎯 Recommendations</h2>";
echo "<ul>";
echo "<li>If database connection failed: Update .env with correct credentials</li>";
echo "<li>If tables are missing: Import database from app/Models/tfc_database_dump.sql</li>";
echo "<li>If autoloader missing: Run 'composer install' on server</li>";
echo "<li>If writable directory issues: Set proper permissions (755)</li>";
echo "<li>Check error logs above for specific PHP errors</li>";
echo "<li>If environment is 'development': Change to 'production' in .env</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>⚠️ SECURITY:</strong> Delete this file after debugging!</p>";
echo "<p>Generated: " . date('Y-m-d H:i:s') . "</p>";
?>
