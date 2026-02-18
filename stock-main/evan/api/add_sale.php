<?php
require_once __DIR__ . '/../includes/init.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$invoice_no = trim($_POST['invoice_no'] ?? '');
$user_id = intval($_POST['user_id'] ?? 0);
$total_amount = floatval($_POST['total_amount'] ?? 0);
$tax_amount = floatval($_POST['tax_amount'] ?? 0);
$discount_amount = floatval($_POST['discount_amount'] ?? 0);
$payment_method = trim($_POST['payment_method'] ?? '');
$status = trim($_POST['status'] ?? 'completed');

if (!$invoice_no || $total_amount <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO sales (invoice_no, user_id, total_amount, tax_amount, discount_amount, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
$stmt->bind_param('sidddss', $invoice_no, $user_id, $total_amount, $tax_amount, $discount_amount, $payment_method, $status);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Sale recorded', 'sale_id' => $conn->insert_id]);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}
?>
