<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$sql = 'SELECT k, v FROM settings';
$res = $conn->query($sql);
$settings = [];
while ($row = $res->fetch_assoc()) {
    $settings[$row['k']] = $row['v'];
}
echo json_encode(['success' => true, 'settings' => $settings]);
exit;
?>
