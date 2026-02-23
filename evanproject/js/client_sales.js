// Client Sales JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeSaleForm();
    initializeSaleActions();
});

// Initialize Sale Form
function initializeSaleForm() {
    const newSaleForm = document.getElementById('newSaleForm');
    if (newSaleForm) {
        newSaleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleNewSale();
        });
    }

    // Product select change handlers
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const select = e.target;
            const priceInput = select.closest('.sale-item').querySelector('.price-input');
            const quantityInput = select.closest('.sale-item').querySelector('.quantity-input');
            
            if (select.value) {
                const price = select.options[select.selectedIndex].dataset.price;
                const maxQuantity = parseInt(select.options[select.selectedIndex].dataset.quantity);
                
                priceInput.value = price;
                quantityInput.max = maxQuantity;
                
                // Update total
                updateSaleTotal();
            }
        }
    });

    // Quantity change handlers
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            updateSaleTotal();
        }
    });
}

// Handle New Sale
function handleNewSale() {
    const formData = new FormData(document.getElementById('newSaleForm'));
    
    // Show loading state
    const submitBtn = document.querySelector('#newSaleForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Creating...';
    submitBtn.disabled = true;

    fetch('api/add_sale.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('newSaleModal'));
            modal.hide();
            
            // Reset form
            document.getElementById('newSaleForm').reset();
            
            // Show success message
            showAlert('Sale created successfully!', 'success');
            
            // Reload page to show new sale
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showAlert(data.message || 'Failed to create sale', 'error');
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

// Add Sale Item
function addSaleItem() {
    const saleItems = document.getElementById('saleItems');
    const newItem = document.createElement('div');
    newItem.className = 'row mb-2 sale-item';
    newItem.innerHTML = `
        <div class="col-md-5">
            <select class="form-select product-select" name="product_id[]" required>
                <option value="">Select Product</option>
                ${document.querySelector('.product-select').innerHTML}
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control quantity-input" name="quantity[]" placeholder="Qty" min="1" required>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control price-input" name="price[]" placeholder="Price" readonly>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSaleItem(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    saleItems.appendChild(newItem);
}

// Remove Sale Item
function removeSaleItem(button) {
    const saleItems = document.getElementById('saleItems');
    if (saleItems.children.length > 1) {
        button.closest('.sale-item').remove();
        updateSaleTotal();
    }
}

// Update Sale Total
function updateSaleTotal() {
    const saleItems = document.querySelectorAll('.sale-item');
    let total = 0;
    
    saleItems.forEach(item => {
        const price = parseFloat(item.querySelector('.price-input').value) || 0;
        const quantity = parseInt(item.querySelector('.quantity-input').value) || 0;
        total += price * quantity;
    });
    
    const totalInput = document.getElementById('totalAmount');
    if (totalInput) {
        totalInput.value = total;
    }
}

// Initialize Sale Actions
function initializeSaleActions() {
    // Add event listeners for delete confirmations
    document.addEventListener('click', function(e) {
        if (e.target.closest('[onclick*="deleteSale"]')) {
            e.preventDefault();
            const saleId = e.target.closest('[onclick*="deleteSale"]').getAttribute('onclick').match(/\d+/)[0];
            confirmDeleteSale(saleId);
        }
    });
}

// View Sale Details
function viewSaleDetails(saleId) {
    // For now, show alert - can be expanded to show modal with details
    showAlert('Sale details functionality coming soon!', 'info');
}

// Delete Sale
function deleteSale(saleId) {
    if (!confirm('Are you sure you want to delete this sale?')) {
        return;
    }

    const formData = new FormData();
    formData.append('sale_id', saleId);

    fetch('api/delete_sale.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Remove sale row from table
            const saleRow = document.querySelector(`tr[data-sale-id="${saleId}"]`);
            if (saleRow) {
                saleRow.remove();
            }
            
            // Update stats
            updateSaleStats();
            
            showAlert('Sale deleted successfully!', 'success');
        } else {
            showAlert(data.message || 'Failed to delete sale', 'error');
        }
    })
    .catch(err => {
        showAlert('Server error. Please try again.', 'error');
    });
}

// Confirm Delete Sale
function confirmDeleteSale(saleId) {
    if (confirm('Are you sure you want to delete this sale? This action cannot be undone.')) {
        deleteSale(saleId);
    }
}

// Update Sale Statistics
function updateSaleStats() {
    const totalSales = document.querySelectorAll('#salesTable tbody tr:not(:first-child)').length;
    
    // Update stat cards (simplified - in real app would recalculate from remaining data)
    const totalSalesEl = document.querySelector('.stat-card h4');
    if (totalSalesEl) {
        totalSalesEl.textContent = totalSales;
    }
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
