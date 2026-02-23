<?php
require_once __DIR__ . '/../includes/init.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}


$fullname = trim(isset($_POST['fullname']) ? $_POST['fullname'] : '');
$username = trim(isset($_POST['username']) ? $_POST['username'] : '');
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (!$fullname || !$username || !$password) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Password too short']);
    exit;
}

// Check if user exists
$stmt = $conn->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'Username already registered']);
    exit;
}
$stmt->close();

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare('INSERT INTO users (fullname, username, password_hash, role, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
$role = 'admin';
$status = 'active';
$stmt->bind_param('sssss', $fullname, $username, $password_hash, $role, $status);
if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    echo json_encode([
        'success' => true, 
        'message' => 'Account created successfully',
        'user' => [
            'id' => $user_id,
            'fullname' => $fullname,
            'username' => $username,
            'role' => 'admin'
        ]
    ]);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    exit;
}
?>
