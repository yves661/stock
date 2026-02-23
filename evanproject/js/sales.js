// Sales Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
    initializeAdminName();
    initializeSalesPage();
});

// Sample products database
const productsList = [
    { id: 1, name: 'Panadol', price: 500 },
    { id: 2, name: 'Inyange Water', price: 333 },
    { id: 3, name: 'Coca Cola', price: 1000 },
    { id: 4, name: 'Sprite', price: 1000 },
    { id: 5, name: 'Ibuprofen', price: 500 },
    { id: 6, name: 'Aspirin', price: 400 },
    { id: 7, name: 'Sugar (1kg)', price: 600 },
    { id: 8, name: 'Rice (2kg)', price: 2000 },
    { id: 9, name: 'Bread', price: 1500 },
    { id: 10, name: 'Milk (1L)', price: 800 }
];

// Cart storage
let salesCart = JSON.parse(sessionStorage.getItem('salesCart')) || [];

// Check if user is logged in
function checkLoginStatus() {
    const isLoggedIn = sessionStorage.getItem('isLoggedIn');
    if (!isLoggedIn) {
        window.location.href = 'login.php';
    }
}

// Initialize Admin Name Display
function initializeAdminName() {
    const username = sessionStorage.getItem('username');
    const adminName = document.getElementById('adminName');
    
    if (username) {
        const displayName = username.charAt(0).toUpperCase() + username.slice(1);
        adminName.textContent = displayName;
    }
}

// Initialize Sales Page
function initializeSalesPage() {
    const searchInput = document.getElementById('searchProductSales');
    const addToCartBtn = document.getElementById('addToCartBtnSales');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');

    // Search Product
    if (searchInput) {
        searchInput.addEventListener('input', handleProductSearch);
    }

    // Add to Cart
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            addProductToCart();
        });
    }

    // Cancel Transaction
    if (cancelBtn) {
        cancelBtn.addEventListener('click', cancelTransaction);
    }

    // Confirm Sale
    if (confirmBtn) {
        confirmBtn.addEventListener('click', confirmSale);
    }

    // Initialize cart display
    updateCartDisplay();
}

// Handle Product Search
function handleProductSearch(e) {
    const query = e.target.value.toLowerCase().trim();
    const matchedProducts = productsList.filter(p => p.name.toLowerCase().includes(query));
    
    if (query && matchedProducts.length > 0) {
        console.log('Matched products:', matchedProducts);
    }
}

// Add Product to Cart
function addProductToCart(productName, productPrice, quantity) {
    // If called with parameters (from product cards)
    if (productName && productPrice) {
        // Check if product already in cart
        const existingItem = salesCart.find(item => item.name === productName);
        
        if (existingItem) {
            existingItem.quantity += (quantity || 1);
        } else {
            // Generate a simple ID based on product name
            const productId = salesCart.length + Math.random();
            salesCart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: (quantity || 1)
            });
        }

        // Save to session
        sessionStorage.setItem('salesCart', JSON.stringify(salesCart));
        
        // Update display
        updateCartDisplay();
        
        // Show success message on button
        try {
            const btn = event.currentTarget || event.target;
            if (btn) {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Added!';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 1000);
            }
        } catch (e) {
            // Button feedback not critical
            console.log('Product added to cart');
        }
        return;
    }

    // Original search-based method
    const searchInput = document.getElementById('searchProductSales');
    const searchProductName = searchInput.value.trim();

    if (!searchProductName) {
        alert('Please enter a product name');
        return;
    }

    // Find product
    const product = productsList.find(p => p.name.toLowerCase() === searchProductName.toLowerCase());
    
    if (!product) {
        alert(`Product "${searchProductName}" not found. Available products: ${productsList.map(p => p.name).join(', ')}`);
        searchInput.value = '';
        return;
    }

    // Check if product already in cart
    const existingItem = salesCart.find(item => item.id === product.id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        salesCart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: 1
        });
    }

    // Save to session
    sessionStorage.setItem('salesCart', JSON.stringify(salesCart));
    
    // Update display
    updateCartDisplay();
    searchInput.value = '';
}

// Update Cart Display
function updateCartDisplay() {
    const cartTableBody = document.getElementById('cartTableBody');
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total');

    if (salesCart.length === 0) {
        cartTableBody.innerHTML = `
            <tr class="empty-cart-message">
                <td colspan="5" class="text-center py-4">
                    <i class="bi bi-inbox"></i>
                    <p>No items in cart. Add a product to get started.</p>
                </td>
            </tr>
        `;
        subtotalEl.textContent = '0 Rwf';
        taxEl.textContent = '0 Rwf';
        totalEl.textContent = '0 Rwf';
        return;
    }

    // Build cart rows
    let subtotal = 0;
    cartTableBody.innerHTML = salesCart.map(item => {
        const itemSubtotal = item.price * item.quantity;
        subtotal += itemSubtotal;

        return `
            <tr>
                <td>
                    <i class="bi bi-box me-2"></i>
                    ${item.name}
                </td>
                <td>${item.price} Rwf</td>
                <td>
                    <div class="quantity-control">
                        <button type="button" class="btn-qty" onclick="updateQuantity(${item.id}, -1)" title="Decrease">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="qty-display">${item.quantity}</span>
                        <button type="button" class="btn-qty" onclick="updateQuantity(${item.id}, 1)" title="Increase">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </td>
                <td>${itemSubtotal.toLocaleString()} Rwf</td>
                <td>
                    <button type="button" class="btn-remove" onclick="removeFromCart(${item.id})" title="Remove">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    // Calculate tax and total
    const tax = subtotal * 0.05;
    const total = subtotal + tax;

    subtotalEl.textContent = subtotal.toLocaleString() + ' Rwf';
    taxEl.textContent = Math.round(tax).toLocaleString() + ' Rwf';
    totalEl.textContent = Math.round(total).toLocaleString() + ' Rwf';
}

// Update Quantity
window.updateQuantity = function(productId, change) {
    const item = salesCart.find(i => i.id === productId);
    
    if (item) {
        item.quantity += change;
        
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            sessionStorage.setItem('salesCart', JSON.stringify(salesCart));
            updateCartDisplay();
        }
    }
};

// Remove from Cart
window.removeFromCart = function(productId) {
    salesCart = salesCart.filter(item => item.id !== productId);
    sessionStorage.setItem('salesCart', JSON.stringify(salesCart));
    updateCartDisplay();
};

// Cancel Transaction
function cancelTransaction() {
    if (salesCart.length === 0) {
        alert('Cart is already empty');
        return;
    }

    const confirm = window.confirm('Are you sure you want to cancel this transaction? All items will be removed from the cart.');
    
    if (confirm) {
        salesCart = [];
        sessionStorage.setItem('salesCart', JSON.stringify(salesCart));
        updateCartDisplay();
        document.getElementById('searchProductSales').value = '';
    }
}

// Confirm Sale
function confirmSale() {
    if (salesCart.length === 0) {
        alert('Please add items to cart before confirming sale');
        return;
    }

    // Calculate totals
    const subtotal = salesCart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.05;
    const total = subtotal + tax;

    // Create sale record
    const saleRecord = {
        id: Date.now(),
        date: new Date().toLocaleString(),
        items: [...salesCart],
        subtotal: subtotal,
        tax: Math.round(tax),
        total: Math.round(total)
    };

    // Store sale record
    let salesHistory = JSON.parse(sessionStorage.getItem('salesHistory')) || [];
    salesHistory.push(saleRecord);
    sessionStorage.setItem('salesHistory', JSON.stringify(salesHistory));

    // Show confirmation
    alert(`Sale confirmed!\n\nItems: ${salesCart.length}\nTotal: ${Math.round(total).toLocaleString()} Rwf`);

    // Clear cart
    salesCart = [];
    sessionStorage.setItem('salesCart', JSON.stringify(salesCart));
    updateCartDisplay();
    document.getElementById('searchProductSales').value = '';
}

// Logout function (from dashboard.js)
window.logout = function() {
    sessionStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('username');
    window.location.href = 'login.php';
};
