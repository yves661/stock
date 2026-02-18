<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$sql = 'SELECT id, name, price, features, created_at FROM pricing_plans';
$res = $conn->query($sql);
$plans = [];
while ($row = $res->fetch_assoc()) {
    $plans[] = $row;
}
echo json_encode(['success' => true, 'plans' => $plans]);
exit;
?>
