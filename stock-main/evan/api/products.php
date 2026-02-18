<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$sql = 'SELECT id, sku, name, description, price, cost, quantity, active, created_at, updated_at FROM products';
$res = $conn->query($sql);
$products = [];
while ($row = $res->fetch_assoc()) {
    $products[] = $row;
}
echo json_encode(['success' => true, 'products' => $products]);
exit;
?>
