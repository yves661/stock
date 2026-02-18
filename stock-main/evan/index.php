<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Shop Manager - Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/translator.js"></script>
  </head>
  <body>
    <header class="site-header">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand d-flex align-items-center" href="index.html">
            <i class="bi bi-shop-window me-2 fs-4"></i>
            Mini Shop Manager
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

    <main class="main-area">
      <section class="hero py-5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h1 class="display-5 fw-bold">Manage Your Mini Shop with Ease</h1>
              <p class="lead text-muted mb-4">Simplify Stock, Boost Profits, and Track sales Effortsells. Designed for Rwanda</p>
              <div>
                <a href="features.html" class="btn btn-success btn-lg me-2">Get Started Now</a>
                <small class="text-muted">No credit card required</small>
              </div>
            </div>
            <div class="col-lg-6 text-center mt-4 mt-lg-0">
              <div class="laptop-mock mx-auto shadow-sm">
                <svg width="420" height="260" viewBox="0 0 420 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect x="12" y="18" width="396" height="240" rx="12" fill="#f7f9fb" stroke="#e6edf3"/>
                  <rect x="36" y="42" width="332" height="168" rx="6" fill="#0b2746" />
                  <rect x="56" y="66" width="292" height="28" rx="6" fill="#ffffff" />
                  <rect x="56" y="102" width="200" height="20" rx="4" fill="#ffffff" />
                  <rect x="56" y="132" width="160" height="16" rx="4" fill="#ffffff" />
                  <circle cx="210" cy="220" r="6" fill="#ced7e0" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="features py-5 bg-light">
        <div class="container">
          <h6 class="text-uppercase text-muted mb-3">Best Selling Products</h6>
          <div class="row g-3">
            <div class="col-sm-6 col-md-3">
              <div class="card feature-card h-100 text-center p-3">
                <div class="icon mb-3"><i class="bi bi-grid-3x3-gap fs-2"></i></div>
                <h6 class="mb-0">Stock Management</h6>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card feature-card h-100 text-center p-3">
                <div class="icon mb-3"><i class="bi bi-cart-check fs-2"></i></div>
                <h6 class="mb-0">Sales Tracking</h6>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card feature-card h-100 text-center p-3">
                <div class="icon mb-3"><i class="bi bi-file-earmark-text fs-2"></i></div>
                <h6 class="mb-0">Financial Reports</h6>
              </div>
            </div>
            <div class="col-sm-6 col-md-3">
              <div class="card feature-card h-100 text-center p-3">
                <div class="icon mb-3"><i class="bi bi-people fs-2"></i></div>
                <h6 class="mb-0">User-Friendly</h6>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <footer class="py-4 text-center text-muted small">
      <div class="container">About Us Mini Rai Shop · Contact · Terms</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
