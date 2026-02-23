<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$sql = 'SELECT id, invoice_no, user_id, total_amount, tax_amount, discount_amount, payment_method, status, created_at FROM sales';
$res = $conn->query($sql);
$sales = [];
while ($row = $res->fetch_assoc()) {
    $sales[] = $row;
}
echo json_encode(['success' => true, 'sales' => $sales]);
exit;
?>
