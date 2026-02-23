<?php
require_once __DIR__ . '/includes/init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current user's sales
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT s.*, COUNT(si.id) as item_count FROM sales s LEFT JOIN sale_items si ON s.id = si.sale_id WHERE s.user_id = ? GROUP BY s.id ORDER BY s.created_at DESC');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$sales = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get user's products for sale form
$stmt = $conn->prepare('SELECT id, name, price, quantity FROM products WHERE user_id = ? AND active = 1 AND quantity > 0 ORDER BY name');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sales - Mini Shop Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/translator.js"></script>
</head>
<body>
    <!-- Header/Navigation -->
    <header class="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-lg">
                <a class="navbar-brand d-flex align-items-center" href="client_dashboard.php">
                    <i class="bi bi-shop-window me-2 fs-5"></i>
                    <strong>Mini Shop Manager</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="client_dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="client_products.php">
                                <i class="bi bi-box"></i> My Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="client_sales.php">
                                <i class="bi bi-cart-check"></i> My Sales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="client_reports.php">
                                <i class="bi bi-graph-up"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)" onclick="logout()">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-lg py-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">My Sales</h1>
                    <p class="text-muted mb-0">Manage your sales transactions</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSaleModal">
                    <i class="bi bi-plus-circle"></i> New Sale
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="bi bi-cart-check fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Total Sales</h6>
                                    <h4 class="mb-0"><?php echo count($sales); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                                    <i class="bi bi-currency-dollar fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Total Revenue</h6>
                                    <h4 class="mb-0"><?php echo number_format(array_sum(array_column($sales, 'total_amount')) ?: 0, 0); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle p-3 me-3">
                                    <i class="bi bi-receipt fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Today's Sales</h6>
                                    <h4 class="mb-0"><?php 
                                        $today = date('Y-m-d');
                                        $today_sales = array_filter($sales, fn($s) => date('Y-m-d', strtotime($s['created_at'])) == $today);
                                        echo count($today_sales); 
                                    ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3">
                                    <i class="bi bi-graph-up fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Avg Sale</h6>
                                    <h4 class="mb-0"><?php 
                                        $avg = count($sales) > 0 ? array_sum(array_column($sales, 'total_amount')) / count($sales) : 0;
                                        echo number_format($avg, 0); 
                                    ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sales History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="salesTable">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($sales)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-cart-check fs-1 d-block mb-3"></i>
                                                <h5>No sales found</h5>
                                                <p>Create your first sale to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($sales as $sale): ?>
                                        <tr data-sale-id="<?php echo $sale['id']; ?>">
                                            <td>
                                                <strong><?php echo htmlspecialchars($sale['invoice_no']); ?></strong>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($sale['created_at'])); ?></td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $sale['item_count']; ?> items</span>
                                            </td>
                                            <td>
                                                <strong><?php echo number_format($sale['total_amount'], 0); ?></strong>
                                            </td>
                                            <td><?php echo htmlspecialchars($sale['payment_method'] ?: 'N/A'); ?></td>
                                            <td>
                                                <span class="badge <?php echo $sale['status'] == 'completed' ? 'bg-success' : 'bg-warning'; ?>">
                                                    <?php echo ucfirst($sale['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary btn-sm" onclick="viewSaleDetails(<?php echo $sale['id']; ?>)">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteSale(<?php echo $sale['id']; ?>)">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- New Sale Modal -->
    <div class="modal fade" id="newSaleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="newSaleForm">
                    <div class="modal-body">
                        <!-- Sale Items -->
                        <div class="mb-4">
                            <h6 class="mb-3">Sale Items</h6>
                            <div id="saleItems">
                                <div class="row mb-2 sale-item">
                                    <div class="col-md-5">
                                        <select class="form-select product-select" name="product_id[]" required>
                                            <option value="">Select Product</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>" data-quantity="<?php echo $product['quantity']; ?>">
                                                    <?php echo htmlspecialchars($product['name']); ?> (<?php echo $product['quantity']; ?> available)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control quantity-input" name="quantity[]" placeholder="Qty" min="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control price-input" name="price[]" placeholder="Price" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSaleItem(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addSaleItem()">
                                <i class="bi bi-plus"></i> Add Item
                            </button>
                        </div>

                        <!-- Sale Details -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Invoice #</label>
                                <input type="text" class="form-control" id="invoiceNo" name="invoice_no" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-control" name="payment_method">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="mobile">Mobile Money</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total Amount</label>
                                <input type="number" class="form-control" id="totalAmount" name="total_amount" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Sale</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/client_sales.js"></script>
</body>
</html>
