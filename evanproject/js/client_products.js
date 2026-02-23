// Client Products JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeProductForm();
    initializeProductActions();
});

// Initialize Product Form
function initializeProductForm() {
    const addProductForm = document.getElementById('addProductForm');
    if (addProductForm) {
        addProductForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleAddProduct();
        });
    }
}

// Handle Add Product
function handleAddProduct() {
    const formData = new FormData(document.getElementById('addProductForm'));
    
    // Show loading state
    const submitBtn = document.querySelector('#addProductForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Adding...';
    submitBtn.disabled = true;

    fetch('api/add_product.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            modal.hide();
            
            // Reset form
            document.getElementById('addProductForm').reset();
            
            // Show success message
            showAlert('Product added successfully!', 'success');
            
            // Reload page to show new product
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showAlert(data.message || 'Failed to add product', 'error');
        }
    })
    .catch(err => {
        showAlert('Server error. Please try again.', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Initialize Product Actions
function initializeProductActions() {
    // Add event listeners for delete confirmations
    document.addEventListener('click', function(e) {
        if (e.target.closest('[onclick*="deleteProduct"]')) {
            e.preventDefault();
            const productId = e.target.closest('[onclick*="deleteProduct"]').getAttribute('onclick').match(/\d+/)[0];
            confirmDeleteProduct(productId);
        }
    });
}

// Edit Product
function editProduct(productId) {
    // For now, show alert - can be expanded to open edit modal
    showAlert('Edit functionality coming soon!', 'info');
}

// Delete Product
function deleteProduct(productId) {
    if (!confirm('Are you sure you want to delete this product?')) {
        return;
    }

    const formData = new FormData();
    formData.append('product_id', productId);

    fetch('api/delete_product.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Remove product row from table
            const productRow = document.querySelector(`tr[data-product-id="${productId}"]`);
            if (productRow) {
                productRow.remove();
            }
            
            // Update stats
            updateProductStats();
            
            showAlert('Product deleted successfully!', 'success');
        } else {
            showAlert(data.message || 'Failed to delete product', 'error');
        }
    })
    .catch(err => {
        showAlert('Server error. Please try again.', 'error');
    });
}

// Confirm Delete Product
function confirmDeleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        deleteProduct(productId);
    }
}

// Update Product Statistics
function updateProductStats() {
    const totalProducts = document.querySelectorAll('#productsTable tbody tr:not(:first-child)').length;
    const activeProducts = document.querySelectorAll('#productsTable tbody .badge.bg-success').length;
    const lowStock = document.querySelectorAll('#productsTable tbody .badge.bg-warning').length;
    
    // Update stat cards
    const totalProductsEl = document.getElementById('totalProducts');
    const activeProductsEl = document.getElementById('activeProducts');
    const lowStockEl = document.getElementById('lowStock');
    
    if (totalProductsEl) totalProductsEl.textContent = totalProducts;
    if (activeProductsEl) activeProductsEl.textContent = activeProducts;
    if (lowStockEl) lowStockEl.textContent = lowStock;
}

// Show Alert Message
function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 3000);
}
