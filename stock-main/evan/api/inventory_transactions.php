<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$sql = 'SELECT t.id, t.product_id, t.user_id, t.change_qty, t.type, t.note, t.created_at, p.name as product_name, u.fullname as user_name FROM inventory_transactions t LEFT JOIN products p ON t.product_id = p.id LEFT JOIN users u ON t.user_id = u.id';
$res = $conn->query($sql);
$transactions = [];
while ($row = $res->fetch_assoc()) {
    $transactions[] = $row;
}
echo json_encode(['success' => true, 'transactions' => $transactions]);
exit;
?>
