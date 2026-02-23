<?php
require_once __DIR__ . '/includes/init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current user's statistics
$user_id = $_SESSION['user_id'];

// Get product stats
$stmt = $conn->prepare('SELECT COUNT(*) as total, SUM(quantity) as total_quantity, SUM(price * quantity) as total_value FROM products WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$product_stats = $result->fetch_assoc();
$stmt->close();

// Get sales stats
$stmt = $conn->prepare('SELECT COUNT(*) as total_sales, SUM(total_amount) as total_revenue FROM sales WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$sales_stats = $result->fetch_assoc();
$stmt->close();

// Get recent products
$stmt = $conn->prepare('SELECT name, quantity, created_at FROM products WHERE user_id = ? ORDER BY created_at DESC LIMIT 5');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$recent_products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Mini Shop Manager</title>
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
                            <a class="nav-link active" href="client_dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="client_products.php">
                                <i class="bi bi-box"></i> My Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="client_sales.php">
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
            <!-- Welcome Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
                    <p class="text-muted mb-0">Manage your shop inventory and sales</p>
                </div>
                <div>
                    <a href="client_products.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="bi bi-box fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Total Products</h6>
                                    <h4 class="mb-0"><?php echo number_format($product_stats['total']); ?></h4>
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
                                    <h6 class="mb-1">Total Value</h6>
                                    <h4 class="mb-0"><?php echo number_format($product_stats['total_value'] ?: 0, 0); ?></h4>
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
                                    <i class="bi bi-cart-check fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Total Sales</h6>
                                    <h4 class="mb-0"><?php echo number_format($sales_stats['total_sales']); ?></h4>
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
                                    <h6 class="mb-1">Revenue</h6>
                                    <h4 class="mb-0"><?php echo number_format($sales_stats['total_revenue'] ?: 0, 0); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Products</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($recent_products)): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-box fs-1 text-muted d-block mb-3"></i>
                                    <h6 class="text-muted">No products yet</h6>
                                    <p class="text-muted">Add your first product to get started</p>
                                    <a href="client_products.php" class="btn btn-primary">Add Product</a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Added Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_products as $product): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                    <td>
                                                        <span class="badge bg-success"><?php echo $product['quantity']; ?></span>
                                                    </td>
                                                    <td><?php echo date('M d, Y', strtotime($product['created_at'])); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="client_products.php" class="btn btn-outline-primary">
                                    <i class="bi bi-plus-circle me-2"></i> Add New Product
                                </a>
                                <a href="client_sales.php" class="btn btn-outline-success">
                                    <i class="bi bi-cart-plus me-2"></i> Create Sale
                                </a>
                                <a href="client_reports.php" class="btn btn-outline-info">
                                    <i class="bi bi-file-earmark-text me-2"></i> View Reports
                                </a>
                                <a href="settings.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
