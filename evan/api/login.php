<?php
require_once __DIR__ . '/../includes/init.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$stmt = $conn->prepare('SELECT id, fullname, password_hash, role, status FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    exit;
}

if (!password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    exit;
}

// Successful login
$_SESSION['user_id'] = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['role'] = $user['role'];

// update last login
$stmt = $conn->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
$stmt->bind_param('i', $user['id']);
$stmt->execute();

echo json_encode(['success' => true, 'message' => 'Logged in', 'user' => ['id' => $user['id'], 'fullname' => $user['fullname'], 'role' => $user['role']]]);
exit;

?>
