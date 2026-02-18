<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$key = trim($_POST['key'] ?? '');
$value = trim($_POST['value'] ?? '');
if (!$key) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing key']);
    exit;
}

$stmt = $conn->prepare('REPLACE INTO settings (k, v) VALUES (?, ?)');
$stmt->bind_param('ss', $key, $value);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Setting updated']);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}
?>
