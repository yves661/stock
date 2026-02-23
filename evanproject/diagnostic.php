<?php
// Server Error Diagnostic Script
echo "<h2>Mini Shop Manager - Server Diagnostic</h2>";

// Check 1: PHP Version
echo "<h3>✅ PHP Version: " . PHP_VERSION . "</h3>";

// Check 2: Required Extensions
$required_extensions = ['mysqli', 'session', 'json'];
echo "<h3>🔍 PHP Extensions Check:</h3>";
foreach ($required_extensions as $ext) {
    $status = extension_loaded($ext) ? "✅" : "❌";
    echo "$status $ext<br>";
}

// Check 3: Database Connection
echo "<h3>🔍 Database Connection:</h3>";
try {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'mini_shop');
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        echo "❌ Database connection failed: " . $conn->connect_error . "<br>";
        echo "<strong>Solution:</strong> Check MySQL/XAMPP is running and database 'mini_shop' exists<br>";
    } else {
        echo "✅ Database connection successful<br>";
        
        // Check if tables exist
        $result = $conn->query("SHOW TABLES");
        if ($result->num_rows > 0) {
            echo "✅ Database tables found: ";
            while($row = $result->fetch_array()) {
                echo $row[0] . " ";
            }
            echo "<br>";
        } else {
            echo "❌ No tables found. Run setup.php to create tables<br>";
        }
        $conn->close();
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Check 4: File Permissions
echo "<h3>🔍 File Permissions:</h3>";
$files_to_check = [
    'includes/db.php',
    'includes/init.php',
    'api/login.php',
    'api/register.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        if (is_readable($file)) {
            echo "✅ $file - readable<br>";
        } else {
            echo "❌ $file - not readable<br>";
        }
    } else {
        echo "❌ $file - missing<br>";
    }
}

// Check 5: Session Support
echo "<h3>🔍 Session Support:</h3>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "✅ Session is active<br>";
} else {
    if (session_start()) {
        echo "✅ Session started successfully<br>";
    } else {
        echo "❌ Session failed to start<br>";
    }
}

// Check 6: Error Reporting
echo "<h3>🔍 Error Reporting:</h3>";
echo "Current error reporting: " . error_reporting() . "<br>";
echo "Display errors: " . (ini_get('display_errors') ? 'On' : 'Off') . "<br>";

echo "<h3>💡 Common Solutions:</h3>";
echo "1. <strong>Database Issue:</strong> Start XAMPP/MySQL and create 'mini_shop' database<br>";
echo "2. <strong>Run Setup:</strong> Visit <a href='setup.php'>setup.php</a> to create admin user<br>";
echo "3. <strong>Check Logs:</strong> Look at XAMPP error logs for detailed errors<br>";
echo "4. <strong>Permissions:</strong> Ensure XAMPP has write access to project folder<br>";

?>
