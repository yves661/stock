<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mini Shop Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/translator.js"></script>
</head>
<body class="login-page">
    <!-- Header/Navigation -->
    <header class="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-lg">
                <a class="navbar-brand d-flex align-items-center" href="index.html">
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
                            <a class="nav-link dropdown-toggle" href="#" id="featuresDropdown" role="button" data-bs-toggle="dropdown">
                                Features
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="featuresDropdown">
                                <li><a class="dropdown-item" href="features.html">All Features</a></li>
                                <li><a class="dropdown-item" href="features.html#streamlined">Streamlined Inventory</a></li>
                                <li><a class="dropdown-item" href="features.html#tracking">Effortless Tracking</a></li>
                                <li><a class="dropdown-item" href="features.html#reporting">Smart Reporting</a></li>
                            </ul>
                        </li>

                        <!-- Pricing Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="pricingDropdown" role="button" data-bs-toggle="dropdown">
                                Pricing
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="pricingDropdown">
                                <li><a class="dropdown-item" href="pricing.html#plans">All Plans</a></li>
                                <li><a class="dropdown-item" href="pricing.html#basic">Basic Plan</a></li>
                                <li><a class="dropdown-item" href="pricing.html#pro">Pro Plan</a></li>
                                <li><a class="dropdown-item" href="pricing.html#enterprise">Enterprise Plan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="pricing.html#faq">FAQ</a></li>
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
                            <a class="btn btn-primary text-white" href="login.html">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Login Container -->
    <main class="login-container">
        <div class="login-background"></div>
        
        <div class="login-form-wrapper">
            <div class="login-card">
                <!-- Login Card Header -->
                <div class="login-card-header">
                    <div class="login-icon">
                        <i class="bi bi-shop-window"></i>
                    </div>
                    <h3 class="login-card-title">Mini Shop Manager</h3>
                </div>

                <!-- Login Form -->
                <div class="login-card-body">
                    <h2 class="login-title">Admin Login</h2>
                    
                    <form id="loginForm" class="login-form">
                        <!-- Username Field -->
                        <div class="form-group mb-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="username" 
                                    placeholder="Enter your username"
                                    required
                                    aria-label="Username"
                                >
                            </div>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-login w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Go to Dashboard
                        </button>
                    </form>

                    <!-- Additional Links -->
                    <div class="login-footer">
                        <a href="#" class="forgot-password">Forgot Password?</a>
                        <span class="divider">•</span>
                        <a href="signup.html" class="back-home">Create Account</a>
                    </div>
                </div>

                <!-- Error/Success Messages -->
                <div id="loginMessage" class="login-message"></div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer py-4 mt-5">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="social-links">
                        <a href="#" class="social-link" title="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="#" class="footer-link">About Us</a>
                        <a href="#" class="footer-link">Contact</a>
                        <a href="#" class="footer-link">Support</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/login.js"></script>
</body>
</html>
