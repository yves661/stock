<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$name = trim(isset($_POST['name']) ? $_POST['name'] : '');
$sku = trim(isset($_POST['sku']) ? $_POST['sku'] : '');
$description = trim(isset($_POST['description']) ? $_POST['description'] : '');
$price = floatval(isset($_POST['price']) ? $_POST['price'] : 0);
$cost = floatval(isset($_POST['cost']) ? $_POST['cost'] : 0);
$quantity = intval(isset($_POST['quantity']) ? $_POST['quantity'] : 0);
$active = isset($_POST['active']) ? intval($_POST['active']) : 1;

if (!$name || $price <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO products (user_id, sku, name, description, price, cost, quantity, active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
$stmt->bind_param('isssddii', $user_id, $sku, $name, $description, $price, $cost, $quantity, $active);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully']);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    exit;
}
?>
