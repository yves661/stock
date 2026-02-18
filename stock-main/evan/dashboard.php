<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mini Shop Manager</title>
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
                <a href="index.html" class="brand-logo">
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
                    <li class="nav-item active">
                        <a href="dashboard.html" class="nav-link">
                            <i class="bi bi-house-door"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
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
                            <i class="bi bi-graph-up"></i>
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
        <main class="dashboard-content">
            <!-- Welcome Section -->
            <section class="welcome-section">
                <h1 class="welcome-title">WELCOME BACK, <span id="adminNameTitle">ADMIN</span>!</h1>
            </section>

            <!-- Stats Cards -->
            <section class="stats-section">
                <div class="row g-4">
                    <!-- Total Sales Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-header">
                                <h6>TOTAL SALES:</h6>
                                <i class="bi bi-cart2"></i>
                            </div>
                            <div class="stat-value">
                                <h2>150,000 <span>Rwf</span></h2>
                            </div>
                            <div class="stat-footer">
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> 12% from last month
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Total Profit Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-header">
                                <h6>TOTAL PROFIT:</h6>
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="stat-value">
                                <h2>45,000 <span>Rwf</span></h2>
                            </div>
                            <div class="stat-footer">
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> 8% from last month
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Alerts Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card alert-card">
                            <div class="stat-header">
                                <h6>LOW STOCK ALERTS</h6>
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="stat-value">
                                <h2>3 <span>ITEMS</span></h2>
                            </div>
                            <div class="stat-footer">
                                <a href="#inventory" class="view-link">View Items →</a>
                            </div>
                        </div>
                    </div>

                    <!-- New Orders Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-header">
                                <h6>NEW ORDERS:</h6>
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div class="stat-value">
                                <h2>12 <span>Orders</span></h2>
                            </div>
                            <div class="stat-footer">
                                <small class="text-info">
                                    <i class="bi bi-info-circle"></i> Today
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Quick Sell Section -->
            <section class="quick-sell-section">
                <h3 class="section-title">QUICK SELL (Gura yuba)</h3>
                
                <div class="quick-sell-form">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="searchProduct" 
                                    placeholder="Search Product..."
                                    aria-label="Search Product"
                                >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input 
                                type="number" 
                                class="form-control" 
                                id="quantityInput" 
                                placeholder="[Qty]"
                                min="1"
                                value="1"
                            >
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success w-100" id="addToCartBtn">
                                <i class="bi bi-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Best Selling Products Table -->
            <section class="products-section">
                <h3 class="section-title">BEST SELLING PRODUCTS</h3>
                
                <div class="table-responsive">
                    <table class="table table-hover products-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Sales Count</th>
                                <th>Total Revenue</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="product-name">
                                    <i class="bi bi-box"></i> Panadol
                                </td>
                                <td class="sales-count">50</td>
                                <td class="revenue">30,000 Rwf</td>
                                <td class="rating">
                                    <span class="badge bg-primary">6</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-name">
                                    <i class="bi bi-box"></i> Panadol
                                </td>
                                <td class="sales-count">50</td>
                                <td class="revenue">30,000 Rwf</td>
                                <td class="rating">
                                    <span class="badge bg-primary">2</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-name">
                                    <i class="bi bi-box"></i> Inyange Water
                                </td>
                                <td class="sales-count">45</td>
                                <td class="revenue">15,000 Rwf</td>
                                <td class="rating">
                                    <span class="badge bg-primary">3</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-name">
                                    <i class="bi bi-box"></i> Panadol
                                </td>
                                <td class="sales-count">45</td>
                                <td class="revenue">20,000 Rwf</td>
                                <td class="rating">
                                    <span class="badge bg-primary">4</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="product-name">
                                    <i class="bi bi-box"></i> Panadol
                                </td>
                                <td class="sales-count">45</td>
                                <td class="revenue">22,000 Rwf</td>
                                <td class="rating">
                                    <span class="badge bg-primary">5</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>
