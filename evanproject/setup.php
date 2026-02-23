<?php
require_once __DIR__ . '/includes/init.php';

// Create default admin user if not exists
$admin_username = 'admin';
$admin_password = 'password123'; // Change this in production!
$admin_fullname = 'Administrator';
$admin_role = 'admin';

// Check if admin user already exists
$stmt = $conn->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $admin_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Create admin user
    $password_hash = password_hash($admin_password, PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare('INSERT INTO users (fullname, username, password_hash, role, status, created_at) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $admin_fullname, $admin_username, $password_hash, $admin_role, $status, $created_at);
    
    $status = 'active';
    $stmt->execute();
    
    echo "Admin user created successfully!<br>";
    echo "Username: " . $admin_username . "<br>";
    echo "Password: " . $admin_password . "<br>";
    echo "<br><strong>Important:</strong> Change this password in production!<br>";
    echo "<a href='index.php'>Go to homepage</a> | <a href='login.php'>Go to login</a>";
} else {
    echo "Admin user already exists.<br>";
    echo "<a href='index.php'>Go to homepage</a> | <a href='login.php'>Go to login</a>";
}
?>
