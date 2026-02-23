// Dashboard Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
    initializeAdminName();
    initializeQuickSell();
    initializeSidebarNavigation();
});

// Check if user is logged in
function checkLoginStatus() {
    const isLoggedIn = sessionStorage.getItem('isLoggedIn');
    const username = sessionStorage.getItem('username');
    
    if (!isLoggedIn) {
        // Redirect to login if not authenticated
        window.location.href = 'login.php';
    } else {
        console.log('User logged in:', username);
    }
}

// Initialize Admin Name Display
function initializeAdminName() {
    const fullname = sessionStorage.getItem('fullname') || sessionStorage.getItem('username');
    const adminName = document.getElementById('adminName');
    const adminNameTitle = document.getElementById('adminNameTitle');
    
    if (fullname) {
        const displayName = fullname.charAt(0).toUpperCase() + fullname.slice(1);
        adminName.textContent = displayName;
        adminNameTitle.textContent = displayName.toUpperCase();
    }
}

// Initialize Quick Sell Functionality
function initializeQuickSell() {
    const searchInput = document.getElementById('searchProduct');
    const quantityInput = document.getElementById('quantityInput');
    const addToCartBtn = document.getElementById('addToCartBtn');

    // Sample products for demo
    const products = [
        { name: 'Panadol', price: 600 },
        { name: 'Inyange Water', price: 333 },
        { name: 'Coca Cola', price: 1000 },
        { name: 'Sprite', price: 1000 },
        { name: 'Ibuprofen', price: 500 },
        { name: 'Aspirin', price: 400 }
    ];

    // Search Product
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = this.value.toLowerCase();
            const matches = products.filter(p => p.name.toLowerCase().includes(query));
            
            if (matches.length > 0) {
                console.log('Found products:', matches);
            }
        });
    }

    // Add to Cart
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const product = searchInput.value.trim();
            const quantity = quantityInput.value;

            if (!product) {
                alert('Please search for a product');
                return;
            }

            if (quantity < 1) {
                alert('Please enter a valid quantity');
                return;
            }

            // Show feedback
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-circle"></i> Added to Cart';
            this.disabled = true;

            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                searchInput.value = '';
                quantityInput.value = 1;
            }, 1500);
        });
    }
}

// Initialize Sidebar Navigation
function initializeSidebarNavigation() {
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
        });
    });
}

// Sidebar responsive toggle (for mobile)
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    
    // Close sidebar when clicking outside (mobile)
    if (window.innerWidth < 768) {
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && 
                !e.target.closest('.navbar-toggler')) {
                sidebar.classList.remove('active');
            }
        });
    }
});

// Log out function
window.logout = function() {
    sessionStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('username');
    window.location.href = 'login.php';
};

// Real-time stats update (optional)
window.updateStats = function(stats) {
    if (stats.totalSales) {
        document.querySelector('[data-stat="sales"]').textContent = stats.totalSales;
    }
    if (stats.totalProfit) {
        document.querySelector('[data-stat="profit"]').textContent = stats.totalProfit;
    }
};
