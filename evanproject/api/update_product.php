<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$sku = trim($_POST['sku'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$cost = floatval($_POST['cost'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 0);

if ($id <= 0 || !$name || $price <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare('UPDATE products SET sku=?, name=?, description=?, price=?, cost=?, quantity=? WHERE id=?');
$stmt->bind_param('sssddii', $sku, $name, $description, $price, $cost, $quantity, $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product updated']);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}
?>
