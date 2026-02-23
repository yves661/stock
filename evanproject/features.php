<?php
require_once __DIR__ . '/includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - Mini Shop Manager</title>
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
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <i class="bi bi-shop-window me-2 fs-5"></i>
                    <strong>Mini Shop Manager</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto gap-2">
                        <!-- Features Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="featuresDropdown" role="button" data-bs-toggle="dropdown">
                                Features
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="featuresDropdown">
                                <li><a class="dropdown-item" href="features.php">All Features</a></li>
                                <li><a class="dropdown-item" href="features.php#streamlined">Streamlined Inventory</a></li>
                                <li><a class="dropdown-item" href="features.php#tracking">Effortless Tracking</a></li>
                                <li><a class="dropdown-item" href="features.php#reporting">Smart Reporting</a></li>
                            </ul>
                        </li>

                        <!-- Pricing Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pricingDropdown" role="button" data-bs-toggle="dropdown">
                                Pricing
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="pricingDropdown">
                                <li><a class="dropdown-item" href="pricing.php#plans">All Plans</a></li>
                                <li><a class="dropdown-item" href="pricing.php#basic">Basic Plan</a></li>
                                <li><a class="dropdown-item" href="pricing.php#pro">Pro Plan</a></li>
                                <li><a class="dropdown-item" href="pricing.php#enterprise">Enterprise Plan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="pricing.php#faq">FAQ</a></li>
                            </ul>
                        </li>

                        <!-- Language Selector -->
                        <li class="nav-item">
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
                        </li>

                        <!-- Login Button -->
                        <li class="nav-item">
                            <a class="btn btn-primary text-white" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-area">
        <!-- Tabs Section -->
        <div class="container-lg">
            <div class="tabs-section py-3">
                <ul class="nav nav-underline" id="featureTabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#features-tab" data-bs-toggle="tab">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing-tab" data-bs-toggle="tab">Pricing</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Features Section -->
        <section class="features-section py-5" id="features-tab">
            <div class="container-lg">
                <!-- Section Title -->
                <h1 class="display-6 fw-bold text-dark mb-4">Powerful Features to Grow Your Shop Business</h1>

                <!-- Search Bar and Add to Cart -->
                <div class="search-section mb-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    class="form-control search-input" 
                                    id="searchInput" 
                                    placeholder="Search"
                                    aria-label="Search features"
                                >
                                <button class="btn btn-dark add-to-cart-btn" id="addToCartBtn" type="button">
                                    + Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Cards Grid -->
                <div class="row g-4 mb-5" id="featuresContainer">
                    <!-- Card 1: Streamlined Inventory -->
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <h5 class="feature-title">Streamlined Inventory</h5>
                            <ul class="feature-list">
                                <li>Easy Product Add/Edit</li>
                                <li>Real-time Stock Tracking</li>
                                <li>Low Stock Alerts (Ref. invisible image)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Card 2: Effortless Tracking -->
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-cart-check"></i>
                            </div>
                            <h5 class="feature-title">Effortless Tracking</h5>
                            <ul class="feature-list">
                                <li>Quick Sell Interface</li>
                                <li>Automatic Total Calculation</li>
                                <li>Sales History</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Card 3: Smart Reporting -->
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <h5 class="feature-title">Smart Reporting</h5>
                            <ul class="feature-list">
                                <li>Daily & Period Sales</li>
                                <li>Profitability Insights</li>
                                <li>Export to PDF/Excel</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="row justify-content-end">
                    <div class="col-lg-5 col-md-7">
                        <div class="pricing-card">
                            <div class="pricing-header">
                                <h4 class="text-white mb-0">
                                    Total: <span id="totalAmount">2,500</span> Rwf
                                </h4>
                            </div>
                            <div class="pricing-actions">
                                <button class="btn btn-light w-100 mb-3" id="cancelBtn">
                                    Cancel Transaction
                                </button>
                                <button class="btn btn-success w-100" id="startBtn">
                                    Started Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Tab Content (hidden by default) -->
        <section class="pricing-section py-5 d-none" id="pricing-tab">
            <div class="container-lg">
                <h2 class="display-6 fw-bold text-dark mb-5">Pricing Plans</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="pricing-plan">
                            <h5>Starter</h5>
                            <p class="price">2,500 <span>Rwf/month</span></p>
                            <ul class="plan-features">
                                <li>Up to 100 products</li>
                                <li>Basic reports</li>
                                <li>Email support</li>
                            </ul>
                            <button class="btn btn-outline-dark w-100">Choose Plan</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pricing-plan featured">
                            <h5>Professional</h5>
                            <p class="price">5,000 <span>Rwf/month</span></p>
                            <ul class="plan-features">
                                <li>Unlimited products</li>
                                <li>Advanced reports</li>
                                <li>Priority support</li>
                            </ul>
                            <button class="btn btn-dark w-100">Choose Plan</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pricing-plan">
                            <h5>Enterprise</h5>
                            <p class="price">10,000 <span>Rwf/month</span></p>
                            <ul class="plan-features">
                                <li>Unlimited everything</li>
                                <li>Custom reports</li>
                                <li>24/7 support</li>
                            </ul>
                            <button class="btn btn-outline-dark w-100">Choose Plan</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer py-4">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="social-links">
                        <a href="#" class="social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link" title="Twitter"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="#" class="footer-link">About Us</a>
                        <a href="#" class="footer-link">Mini Rai Shop</a>
                        <a href="#" class="footer-link">Contact</a>
                        <a href="#" class="footer-link">Disrector</a>
                        <a href="#" class="footer-link">Mireracon</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/features.js"></script>
</body>
</html>
