<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$product_id = intval($_POST['product_id'] ?? 0);
$user_id = intval($_POST['user_id'] ?? 0);
$change_qty = intval($_POST['change_qty'] ?? 0);
$type = trim($_POST['type'] ?? '');
$note = trim($_POST['note'] ?? '');

if ($product_id <= 0 || !$type || $change_qty == 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO inventory_transactions (product_id, user_id, change_qty, type, note, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
$stmt->bind_param('iiiss', $product_id, $user_id, $change_qty, $type, $note);
if ($stmt->execute()) {
    // Update product quantity
    $conn->query('UPDATE products SET quantity = quantity + ' . intval($change_qty) . ' WHERE id = ' . intval($product_id));
    echo json_encode(['success' => true, 'message' => 'Inventory updated']);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}
?>
