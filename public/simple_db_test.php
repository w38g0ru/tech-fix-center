<?php
// SUPER SIMPLE DATABASE TEST
// Just update the database details below and run this script

// ===== UPDATE THESE VALUES FOR YOUR DATABASE =====
$host = 'localhost';
$username = 'root';        // Your MySQL username
$password = '';            // Your MySQL password (often empty for local)
$database = 'tfc';         // Your database name

echo "<h1>Simple Database Test</h1>";
echo "<style>body{font-family:Arial;margin:20px;} .ok{color:green;} .error{color:red;} .info{color:blue;}</style>";

echo "<h2>1. Testing Database Connection</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span class='ok'>✓ Connected to database '$database' successfully!</span><br>";
    
    echo "<h2>2. Checking if user_activity_logs table exists</h2>";
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'user_activity_logs'");
    if ($stmt->rowCount() > 0) {
        echo "<span class='ok'>✓ Table exists!</span><br>";
        
        echo "<h2>3. Testing Insert</h2>";
        $sql = "INSERT INTO user_activity_logs (user_id, activity_type, details, ip_address, user_agent) VALUES (1, 'login', 'Test from simple script', '127.0.0.1', 'Test Browser')";
        $pdo->exec($sql);
        echo "<span class='ok'>✓ Insert successful!</span><br>";
        
        echo "<h2>4. Recent Records</h2>";
        $stmt = $pdo->query("SELECT * FROM user_activity_logs ORDER BY created_at DESC LIMIT 5");
        $records = $stmt->fetchAll();
        
        if ($records) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>User</th><th>Type</th><th>Details</th><th>Created</th></tr>";
            foreach ($records as $row) {
                echo "<tr><td>{$row['id']}</td><td>{$row['user_id']}</td><td>{$row['activity_type']}</td><td>{$row['details']}</td><td>{$row['created_at']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<span class='info'>No records found</span>";
        }
        
    } else {
        echo "<span class='error'>✗ Table doesn't exist!</span><br>";
        
        if (isset($_GET['create'])) {
            echo "<h2>Creating Table...</h2>";
            $sql = "CREATE TABLE user_activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                activity_type ENUM('login','logout','post') NOT NULL,
                details TEXT,
                ip_address VARCHAR(45),
                user_agent TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sql);
            echo "<span class='ok'>✓ Table created! <a href='simple_db_test.php'>Refresh</a></span>";
        } else {
            echo "<a href='simple_db_test.php?create=1' style='background:blue;color:white;padding:10px;text-decoration:none;'>Create Table</a>";
        }
    }
    
} catch (PDOException $e) {
    echo "<span class='error'>✗ Database Error: " . $e->getMessage() . "</span><br>";
    echo "<span class='info'>Check your database details at the top of this script!</span><br>";
    echo "<span class='info'>Common issues:</span><ul>";
    echo "<li>Wrong database name (try 'tfc', 'tech_fix_center', or check phpMyAdmin)</li>";
    echo "<li>Wrong username/password</li>";
    echo "<li>MySQL not running</li>";
    echo "</ul>";
}

echo "<hr><h2>Instructions:</h2>";
echo "<ol>";
echo "<li>If you see connection errors, edit the database details at the top of this script</li>";
echo "<li>If the table doesn't exist, click 'Create Table'</li>";
echo "<li>If everything works, try logging into your app and check for new records</li>";
echo "</ol>";
?>
