// Inventory Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
    initializeAdminName();
    initializeInventoryPage();
    loadInventoryData();
});

// Sample initial inventory data
const sampleProducts = [
    { id: 1, name: 'Panadol', category: 'Medicine', buyingPrice: 150, sellingPrice: 200, stock: 100 },
    { id: 2, name: 'Inyange Milk', category: 'Dairy', buyingPrice: 400, sellingPrice: 500, stock: 50 },
    { id: 3, name: 'AZAM Biscuit', category: 'Snack', buyingPrice: 80, sellingPrice: 100, stock: 200 }
];

let inventoryData = [];
let editingProductId = null;

// Check if user is logged in
function checkLoginStatus() {
    const isLoggedIn = sessionStorage.getItem('isLoggedIn');
    if (!isLoggedIn) {
        window.location.href = 'login.html';
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

// Initialize Inventory Page
function initializeInventoryPage() {
    const addProductForm = document.getElementById('addProductForm');
    const saveEditBtn = document.getElementById('saveEditBtn');

    // Add Product Form Submit
    if (addProductForm) {
        addProductForm.addEventListener('submit', handleAddProduct);
    }

    // Save Edit Button
    if (saveEditBtn) {
        saveEditBtn.addEventListener('click', handleSaveEdit);
    }
}

// Load Inventory Data from Storage
function loadInventoryData() {
    const stored = sessionStorage.getItem('inventoryData');
    
    if (stored) {
        inventoryData = JSON.parse(stored);
    } else {
        inventoryData = JSON.parse(JSON.stringify(sampleProducts));
        sessionStorage.setItem('inventoryData', JSON.stringify(inventoryData));
    }

    updateInventoryDisplay();
}

// Handle Add Product
function handleAddProduct(e) {
    e.preventDefault();

    const productName = document.getElementById('productName').value.trim();
    const category = document.getElementById('category').value.trim();
    const buyingPrice = parseFloat(document.getElementById('buyingPrice').value);
    const sellingPrice = parseFloat(document.getElementById('sellingPrice').value);
    const currentStock = parseInt(document.getElementById('currentStock').value);

    // Validation
    if (!productName || !category) {
        alert('Please fill in all required fields');
        return;
    }

    if (buyingPrice < 0 || sellingPrice < 0 || currentStock < 0) {
        alert('Prices and stock cannot be negative');
        return;
    }

    if (sellingPrice <= buyingPrice) {
        alert('Selling price must be greater than buying price');
        return;
    }

    // Create new product
    const newProduct = {
        id: Date.now(),
        name: productName,
        category: category,
        buyingPrice: buyingPrice,
        sellingPrice: sellingPrice,
        stock: currentStock
    };

    inventoryData.push(newProduct);
    sessionStorage.setItem('inventoryData', JSON.stringify(inventoryData));

    // Reset form
    document.getElementById('addProductForm').reset();
    
    // Update display
    updateInventoryDisplay();
    
    // Show success message
    alert(`Product "${productName}" added successfully!`);
}

// Update Inventory Display
function updateInventoryDisplay() {
    updateInventoryTable();
    updateStats();
    updateLowStockAlert();
}

// Update Inventory Table
function updateInventoryTable() {
    const tableBody = document.getElementById('inventoryTableBody');
    
    if (inventoryData.length === 0) {
        tableBody.innerHTML = `
            <tr class="empty-inventory">
                <td colspan="6" class="text-center py-4">
                    <i class="bi bi-inbox"></i>
                    <p>No products in inventory. Add a product to get started.</p>
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = inventoryData.map(product => `
        <tr>
            <td>
                <strong>${product.name}</strong>
            </td>
            <td>${product.category}</td>
            <td>${product.buyingPrice} Rwf</td>
            <td>${product.sellingPrice} Rwf</td>
            <td>
                <span class="stock-badge ${product.stock < 50 ? 'low-stock' : ''}">${product.stock}</span>
            </td>
            <td>
                <div class="action-buttons">
                    <button type="button" class="btn-action edit" onclick="editProduct(${product.id})" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button type="button" class="btn-action delete" onclick="deleteProduct(${product.id})" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Update Statistics
function updateStats() {
    const totalProducts = inventoryData.length;
    const totalValue = inventoryData.reduce((sum, p) => sum + (p.buyingPrice * p.stock), 0);

    document.getElementById('totalProducts').textContent = totalProducts;
    document.getElementById('totalValue').textContent = totalValue.toLocaleString() + ' Rwf';
}

// Update Low Stock Alert
function updateLowStockAlert() {
    const lowStockItems = inventoryData.filter(p => p.stock < 50);
    const lowStockList = document.getElementById('lowStockList');

    if (lowStockItems.length === 0) {
        lowStockList.innerHTML = '<p class="text-center text-muted py-3">No low stock items</p>';
        return;
    }

    lowStockList.innerHTML = `
        <div class="low-stock-items">
            ${lowStockItems.map(item => `
                <div class="low-stock-item">
                    <div class="item-info">
                        <strong>${item.name}</strong>
                        <span class="category-badge">${item.category}</span>
                    </div>
                    <div class="item-stock">
                        <span class="stock-count">${item.stock} units remaining</span>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

// Edit Product
window.editProduct = function(productId) {
    const product = inventoryData.find(p => p.id === productId);
    
    if (!product) return;

    editingProductId = productId;

    // Populate modal
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editCategory').value = product.category;
    document.getElementById('editBuyingPrice').value = product.buyingPrice;
    document.getElementById('editSellingPrice').value = product.sellingPrice;
    document.getElementById('editCurrentStock').value = product.stock;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
    modal.show();
};

// Handle Save Edit
function handleSaveEdit() {
    if (!editingProductId) return;

    const productName = document.getElementById('editProductName').value.trim();
    const category = document.getElementById('editCategory').value.trim();
    const buyingPrice = parseFloat(document.getElementById('editBuyingPrice').value);
    const sellingPrice = parseFloat(document.getElementById('editSellingPrice').value);
    const currentStock = parseInt(document.getElementById('editCurrentStock').value);

    // Validation
    if (!productName || !category) {
        alert('Please fill in all required fields');
        return;
    }

    if (buyingPrice < 0 || sellingPrice < 0 || currentStock < 0) {
        alert('Prices and stock cannot be negative');
        return;
    }

    if (sellingPrice <= buyingPrice) {
        alert('Selling price must be greater than buying price');
        return;
    }

    // Update product
    const product = inventoryData.find(p => p.id === editingProductId);
    if (product) {
        product.name = productName;
        product.category = category;
        product.buyingPrice = buyingPrice;
        product.sellingPrice = sellingPrice;
        product.stock = currentStock;

        sessionStorage.setItem('inventoryData', JSON.stringify(inventoryData));
        updateInventoryDisplay();

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
        modal.hide();

        alert('Product updated successfully!');
    }
}

// Delete Product
window.deleteProduct = function(productId) {
    const product = inventoryData.find(p => p.id === productId);
    
    if (!product) return;

    if (confirm(`Are you sure you want to delete "${product.name}"?`)) {
        inventoryData = inventoryData.filter(p => p.id !== productId);
        sessionStorage.setItem('inventoryData', JSON.stringify(inventoryData));
        updateInventoryDisplay();
        alert('Product deleted successfully!');
    }
};

// Logout function
window.logout = function() {
    sessionStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('username');
    window.location.href = 'login.html';
};
