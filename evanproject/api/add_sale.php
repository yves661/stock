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
$invoice_no = trim(isset($_POST['invoice_no']) ? $_POST['invoice_no'] : '');
$total_amount = floatval(isset($_POST['total_amount']) ? $_POST['total_amount'] : 0);
$tax_amount = floatval(isset($_POST['tax_amount']) ? $_POST['tax_amount'] : 0);
$discount_amount = floatval(isset($_POST['discount_amount']) ? $_POST['discount_amount'] : 0);
$payment_method = trim(isset($_POST['payment_method']) ? $_POST['payment_method'] : 'cash');
$status = trim(isset($_POST['status']) ? $_POST['status'] : 'completed');

if (!$invoice_no || $total_amount <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing or invalid fields']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO sales (user_id, invoice_no, total_amount, tax_amount, discount_amount, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
$stmt->bind_param('isdddss', $user_id, $invoice_no, $total_amount, $tax_amount, $discount_amount, $payment_method, $status);
if ($stmt->execute()) {
    $sale_id = $stmt->insert_id;
    
    // Handle sale items if provided
    if (isset($_POST['product_id']) && is_array($_POST['product_id'])) {
        $product_ids = $_POST['product_id'];
        $quantities = $_POST['quantity'] ?? [];
        $prices = $_POST['price'] ?? [];
        
        for ($i = 0; $i < count($product_ids); $i++) {
            if (!empty($product_ids[$i]) && !empty($quantities[$i])) {
                $stmt_item = $conn->prepare('INSERT INTO sale_items (user_id, sale_id, product_id, quantity, price) VALUES (?, ?, ?, ?, ?)');
                $stmt_item->bind_param('iiiid', $user_id, $sale_id, $product_ids[$i], $quantities[$i], $prices[$i]);
                $stmt_item->execute();
                $stmt_item->close();
                
                // Update product quantity
                $stmt_update = $conn->prepare('UPDATE products SET quantity = quantity - ? WHERE id = ? AND user_id = ?');
                $stmt_update->bind_param('iii', $quantities[$i], $product_ids[$i], $user_id);
                $stmt_update->execute();
                $stmt_update->close();
            }
        }
    }
    
    echo json_encode(['success' => true, 'message' => 'Sale created successfully', 'sale_id' => $sale_id]);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    exit;
}
?>
