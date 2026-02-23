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
    <title>Sales Reports - Mini Shop Manager</title>
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
                    <li class="nav-item">
                        <a href="inventory.php" class="nav-link">
                            <i class="bi bi-box"></i>
                            <span>Stock</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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
                <h1 class="page-title">Sales Reports</h1>
            </div>

            <!-- Reports Section -->
            <section class="reports-section">
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <i class="bi bi-graph-up"></i>
                            Sales Reports
                        </h3>
                    </div>
                    <div class="section-body">
                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="filter-group">
                                <div class="search-box">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="productSearch" 
                                        placeholder="Search Product..."
                                        aria-label="Search products"
                                    >
                                    <span class="search-qty">[Qty]</span>
                                </div>

                                <div class="filter-row">
                                    <div class="filter-item">
                                        <label for="fromDate">From:</label>
                                        <input type="date" class="form-control" id="fromDate">
                                    </div>
                                    <div class="filter-item">
                                        <label for="toDate">To:</label>
                                        <input type="date" class="form-control" id="toDate">
                                    </div>
                                    <div class="filter-item">
                                        <label for="profitFilter">Total Profit:</label>
                                        <select class="form-select" id="profitFilter">
                                            <option value="">All</option>
                                            <option value="high">High (>10,000 Rwf)</option>
                                            <option value="medium">Medium (5,000-10,000 Rwf)</option>
                                            <option value="low">Low (<5,000 Rwf)</option>
                                        </select>
                                    </div>
                                    <div class="filter-item">
                                        <label for="stockFilter">Low Stock Items:</label>
                                        <select class="form-select" id="stockFilter">
                                            <option value="">All Items</option>
                                            <option value="low">Low Stock</option>
                                            <option value="critical">Critical Stock</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-filter">
                                <select class="form-select" id="dateRangeDropdown">
                                    <option value="">Date Range</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>

                            <button type="button" class="btn btn-generate" id="generateReportBtn">
                                <i class="bi bi-arrow-repeat"></i> Generate Report
                            </button>
                        </div>

                        <!-- Reports Table -->
                        <div class="table-responsive">
                            <table class="table reports-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Price</th>
                                        <th>Total Items</th>
                                        <th>Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody id="reportsTableBody">
                                    <tr>
                                        <td>
                                            <strong>Panadol</strong><br>
                                            <small>Daily Sales</small>
                                        </td>
                                        <td>
                                            <strong>500</strong><br>
                                            <small>Price</small>
                                        </td>
                                        <td>
                                            <strong>80.00 Rwf</strong><br>
                                            <small>Total Items</small>
                                        </td>
                                        <td>
                                            <strong>Total Revenue</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>500</td>
                                        <td>60.00 Rwf</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>Transaction ID</td>
                                        <td>Total Profit</td>
                                        <td>60.00 Rwf</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Inyange Water</td>
                                        <td>600</td>
                                        <td>60.00 Rwf</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>3</td>
                                        <td>60.00 Rwf</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>Cost</td>
                                        <td>20.00 Rwf</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>Product Name</td>
                                        <td>Cost</td>
                                        <td>60.00 Rwf</td>
                                        <td>5</td>
                                    </tr>
                                    <tr class="highlight-row">
                                        <td>Product Name</td>
                                        <td>600 Rwf</td>
                                        <td>15.00 Rwf</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>Current Stock</td>
                                        <td>100 Rwf</td>
                                        <td>12.00 Rwf</td>
                                        <td>5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Section -->
                        <div class="report-summary">
                            <h4>Summary</h4>
                            <div class="summary-content">
                                <div class="summary-stat">
                                    <span class="summary-label">Grand Total Revenue:</span>
                                    <span class="summary-value" id="grandTotalRevenue">45,000 Rwf</span>
                                </div>
                                <div class="summary-actions">
                                    <button type="button" class="btn btn-pdf" id="downloadPdfBtn">
                                        <i class="bi bi-filetype-pdf"></i> Download as PDF
                                    </button>
                                    <button type="button" class="btn btn-excel" id="downloadExcelBtn">
                                        <i class="bi bi-file-earmark-spreadsheet"></i> Export to Excel
                                    </button>
                                </div>
                            </div>
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
    <script src="js/reports.js"></script>
</body>
</html>
