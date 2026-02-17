<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Transaction - Mini Shop Manager</title>
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
                <a href="dashboard.html" class="brand-logo">
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
                        <a href="dashboard.html" class="nav-link">
                            <i class="bi bi-house-door"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="sales.html" class="nav-link">
                            <i class="bi bi-cart-check"></i>
                            <span>Sales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory.html" class="nav-link">
                            <i class="bi bi-box"></i>
                            <span>Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.html" class="nav-link">
                            <i class="bi bi-bar-chart"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="settings.html" class="nav-link">
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
                <h1 class="page-title">Sales Transaction</h1>
            </div>

            <!-- New Sale Section -->
            <section class="sales-section">
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <i class="bi bi-plus-circle"></i>
                            New Sale
                        </h3>
                    </div>
                    <div class="section-body">
                        <div class="search-input-group">
                            <div class="input-group">
                                <span class="input-group-text search-icon">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="searchProductSales" 
                                    placeholder="Search Product..."
                                    aria-label="Search products"
                                >
                            </div>
                            <button type="button" class="btn btn-add-to-cart-sales" id="addToCartBtnSales">
                                <i class="bi bi-plus-lg"></i> Add to Cart
                            </button>
                        </div>

                        <!-- Products Grid -->
                        <div class="products-grid mt-4">
                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Rice (1kg)</h5>
                                    <p class="product-price">5,500 Rwf</p>
                                    <p class="product-stock">Stock: <span>45</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Rice (1kg)', 5500, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Beans (1kg)</h5>
                                    <p class="product-price">7,200 Rwf</p>
                                    <p class="product-stock">Stock: <span>32</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Beans (1kg)', 7200, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Sugar (kg)</h5>
                                    <p class="product-price">4,500 Rwf</p>
                                    <p class="product-stock">Stock: <span>58</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Sugar (kg)', 4500, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Oil (1L)</h5>
                                    <p class="product-price">9,800 Rwf</p>
                                    <p class="product-stock">Stock: <span>24</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Oil (1L)', 9800, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Salt (500g)</h5>
                                    <p class="product-price">1,200 Rwf</p>
                                    <p class="product-stock">Stock: <span>120</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Salt (500g)', 1200, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Flour (2kg)</h5>
                                    <p class="product-price">6,500 Rwf</p>
                                    <p class="product-stock">Stock: <span>40</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Flour (2kg)', 6500, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Milk (1L)</h5>
                                    <p class="product-price">3,200 Rwf</p>
                                    <p class="product-stock">Stock: <span>60</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Milk (1L)', 3200, 1)">Add</button>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">Eggs (dozen)</h5>
                                    <p class="product-price">5,000 Rwf</p>
                                    <p class="product-stock">Stock: <span>35</span></p>
                                    <button class="btn btn-sm btn-success" onclick="addProductToCart('Eggs (dozen)', 5000, 1)">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cart Sale Section -->
            <section class="cart-section">
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <i class="bi bi-cart-fill"></i>
                            Cart Sale
                        </h3>
                    </div>
                    <div class="section-body">
                        <div class="table-responsive">
                            <table class="table sales-table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Unit Price (Rwf)</th>
                                        <th>Quantity</th>
                                        <th>Subtotal (Rwf)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody">
                                    <!-- Cart items will be populated here -->
                                    <tr class="empty-cart-message">
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-inbox"></i>
                                            <p>No items in cart. Add a product to get started.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Cart Summary -->
                        <div class="cart-summary">
                            <div class="summary-row">
                                <span class="summary-label">Subtotal:</span>
                                <span class="summary-value" id="subtotal">0 Rwf</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Tax (5%):</span>
                                <span class="summary-value" id="tax">0 Rwf</span>
                            </div>
                            <div class="summary-row total-row">
                                <span class="summary-label">Total:</span>
                                <span class="summary-value" id="total">0 Rwf</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="cart-actions">
                            <button type="button" class="btn btn-cancel" id="cancelBtn">
                                <i class="bi bi-x-circle"></i> Cancel Transaction
                            </button>
                            <button type="button" class="btn btn-confirm" id="confirmBtn">
                                <i class="bi bi-check-circle"></i> Confirm Sale
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/sales.js"></script>
</body>
</html>
