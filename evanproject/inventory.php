<?php
require_once __DIR__ . '/includes/init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - Mini Shop Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/translator.js"></script>
</head>
<body class="dashboard-page">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-left">
                <a href="dashboard.php" class="brand-logo">
                    <i class="bi bi-shop-window"></i>
                    <span>Mini Shop Manager</span>
                </a>
            </div>
            <div class="header-right">
                <div class="language-selector" id="languageSelector">
                    <button id="languageBtn" onclick="toggleLanguageDropdown(); return false;">
                        <i class="bi bi-globe"></i>
                        <span>English</span>
                    </button>
                    <div id="languageDropdown">
                        <button onclick="setLanguage('en'); return false;" data-lang="en" class="active">English</button>
                        <button onclick="setLanguage('fr'); return false;" data-lang="fr">Français</button>
                        <button onclick="setLanguage('rw'); return false;" data-lang="rw">Kinyarwanda</button>
                    </div>
                </div>
                <div class="user-menu">
                    <i class="bi bi-person-circle"></i>
                    <span id="adminName">Admin</span>
                    <a href="#" onclick="logout(); return false;" class="logout-link" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="bi bi-house-door"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="sales.php" class="nav-link">
                            <i class="bi bi-cart-check"></i>
                            <span>Sales</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="inventory.php" class="nav-link">
                            <i class="bi bi-box"></i>
                            <span>Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="bi bi-bar-chart"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <!-- Page Title -->
            <div class="page-header mb-4">
                <h1 class="page-title">Inventory Management</h1>
            </div>

            <!-- Add New Product Section -->
            <section class="add-product-section">
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <i class="bi bi-plus-circle"></i>
                            Add New Product
                        </h3>
                    </div>
                    <div class="section-body">
                        <form id="addProductForm" class="add-product-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="productName" 
                                        placeholder="Product Name"
                                        required
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="category" 
                                        placeholder="Category"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="buyingPrice" 
                                        placeholder="Buying Price (Rwf)"
                                        required
                                        min="0"
                                        step="0.01"
                                    >
                                </div>
                                <div class="form-group">
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="sellingPrice" 
                                        placeholder="Selling Price (Rwf)"
                                        required
                                        min="0"
                                        step="0.01"
                                    >
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="currentStock" 
                                        placeholder="Current Stock"
                                        required
                                        min="0"
                                    >
                                </div>
                                <button type="submit" class="btn btn-add-stock">
                                    <i class="bi bi-plus-lg"></i> Add to Stock
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Products Table Section -->
            <section class="products-table-section">
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <i class="bi bi-table"></i>
                            Product Inventory
                        </h3>
                        <div class="header-stats">
                            <span class="stat-item">Total Products: <strong id="totalProducts">0</strong></span>
                            <span class="stat-item">Total Value: <strong id="totalValue">0 Rwf</strong></span>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="table-responsive">
                            <table class="table inventory-table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Buying Price (Rwf)</th>
                                        <th>Selling Price (Rwf)</th>
                                        <th>Current Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="inventoryTableBody">
                                    <tr class="empty-inventory">
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-inbox"></i>
                                            <p>No products in inventory. Add a product to get started.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Low Stock Alert Section -->
            <section class="low-stock-section">
                <div class="section-card warning-card">
                    <div class="section-header warning-header">
                        <h3>
                            <i class="bi bi-exclamation-triangle"></i>
                            Low Stock Alert
                        </h3>
                    </div>
                    <div class="section-body">
                        <div id="lowStockList">
                            <p class="text-center text-muted py-3">No low stock items</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName">
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="editCategory">
                        </div>
                        <div class="mb-3">
                            <label for="editBuyingPrice" class="form-label">Buying Price (Rwf)</label>
                            <input type="number" class="form-control" id="editBuyingPrice" min="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="editSellingPrice" class="form-label">Selling Price (Rwf)</label>
                            <input type="number" class="form-control" id="editSellingPrice" min="0" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="editCurrentStock" class="form-label">Current Stock</label>
                            <input type="number" class="form-control" id="editCurrentStock" min="0">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/inventory.js"></script>
</body>
</html>
