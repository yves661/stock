<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$sku = trim($_POST['sku'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$cost = floatval($_POST['cost'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 0);

if (!$name || $price <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO products (sku, name, description, price, cost, quantity, active, created_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())');
$stmt->bind_param('sssddi', $sku, $name, $description, $price, $cost, $quantity);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product added']);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}
?>
