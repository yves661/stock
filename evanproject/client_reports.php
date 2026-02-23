<?php
require_once __DIR__ . '/includes/init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current user's statistics for reports
$user_id = $_SESSION['user_id'];

// Get sales data for reports
$stmt = $conn->prepare('SELECT DATE(created_at) as sale_date, COUNT(*) as sales_count, SUM(total_amount) as revenue FROM sales WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE(created_at) ORDER BY sale_date DESC');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$daily_sales = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get top selling products
$stmt = $conn->prepare('SELECT p.name, SUM(si.quantity) as total_sold, SUM(si.quantity * si.price) as revenue FROM sale_items si JOIN sales s ON si.sale_id = s.id JOIN products p ON si.product_id = p.id WHERE s.user_id = ? GROUP BY p.id, p.name ORDER BY total_sold DESC LIMIT 10');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$top_products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get monthly summary
$stmt = $conn->prepare('SELECT DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as sales_count, SUM(total_amount) as revenue FROM sales WHERE user_id = ? GROUP BY DATE_FORMAT(created_at, "%Y-%m") ORDER BY month DESC LIMIT 12');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$monthly_summary = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Mini Shop Manager</title>
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
                            <a class="nav-link" href="client_sales.php">
                                <i class="bi bi-cart-check"></i> My Sales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="client_reports.php">
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
                    <h1 class="h3 mb-1">Reports</h1>
                    <p class="text-muted mb-0">View your business analytics and insights</p>
                </div>
                <div>
                    <button class="btn btn-outline-primary" onclick="exportReport()">
                        <i class="bi bi-download"></i> Export Report
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                    <i class="bi bi-calendar-check fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">This Month</h6>
                                    <h4 class="mb-0"><?php 
                                        $current_month = date('Y-m');
                                        $month_data = array_filter($monthly_summary, fn($m) => $m['month'] == $current_month);
                                        $month_revenue = !empty($month_data) ? array_values($month_data)[0]['revenue'] : 0;
                                        echo number_format($month_revenue, 0);
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
                                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                                    <i class="bi bi-graph-up-arrow fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Total Revenue</h6>
                                    <h4 class="mb-0"><?php echo number_format(array_sum(array_column($monthly_summary, 'revenue')) ?: 0, 0); ?></h4>
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
                                    <h6 class="mb-1">Total Sales</h6>
                                    <h4 class="mb-0"><?php echo number_format(array_sum(array_column($monthly_summary, 'sales_count'))); ?></h4>
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
                                    <i class="bi bi-trophy fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Avg Sale</h6>
                                    <h4 class="mb-0"><?php 
                                        $total_sales = array_sum(array_column($monthly_summary, 'sales_count'));
                                        $total_revenue = array_sum(array_column($monthly_summary, 'revenue'));
                                        $avg_sale = $total_sales > 0 ? $total_revenue / $total_sales : 0;
                                        echo number_format($avg_sale, 0);
                                    ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Sales Trend (Last 30 Days)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Sales</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($daily_sales)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="bi bi-graph-down fs-1 d-block mb-3"></i>
                                                        <h6>No sales data available</h6>
                                                        <p>Start making sales to see reports</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach (array_slice($daily_sales, 0, 10) as $sale): ?>
                                                <tr>
                                                    <td><?php echo date('M d, Y', strtotime($sale['sale_date'])); ?></td>
                                                    <td>
                                                        <span class="badge bg-info"><?php echo $sale['sales_count']; ?></span>
                                                    </td>
                                                    <td>
                                                        <strong><?php echo number_format($sale['revenue'], 0); ?></strong>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Top Products</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($top_products)): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-box fs-1 text-muted d-block mb-3"></i>
                                    <h6 class="text-muted">No product sales yet</h6>
                                </div>
                            <?php else: ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach (array_slice($top_products, 0, 5) as $product): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($product['name']); ?></h6>
                                                <small class="text-muted"><?php echo $product['total_sold']; ?> sold</small>
                                            </div>
                                            <strong><?php echo number_format($product['revenue'], 0); ?></strong>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/client_reports.js"></script>
</body>
</html>
