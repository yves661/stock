// Features Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeSearch();
    initializeButtons();
    initializeTabs();
});

// Search Functionality
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    const featureCards = document.querySelectorAll('.feature-card');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            
            featureCards.forEach(card => {
                const title = card.querySelector('.feature-title').textContent.toLowerCase();
                const items = Array.from(card.querySelectorAll('.feature-list li'))
                    .map(li => li.textContent.toLowerCase())
                    .join(' ');

                if (searchTerm === '' || title.includes(searchTerm) || items.includes(searchTerm)) {
                    card.style.opacity = '1';
                    card.style.display = 'block';
                } else {
                    card.style.opacity = '0.3';
                }
            });
        });
    }
}

// Button Functionality
function initializeButtons() {
    // Add to Cart Button
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const originalText = this.textContent;
            this.textContent = '✓ Added to Cart';
            this.disabled = true;
            
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
            }, 2000);
        });
    }

    // Cancel Transaction Button
    const cancelBtn = document.getElementById('cancelBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to cancel this transaction?');
            if (confirmed) {
                document.getElementById('totalAmount').textContent = '0';
                this.textContent = 'Transaction Cancelled';
                setTimeout(() => {
                    this.textContent = 'Cancel Transaction';
                    document.getElementById('totalAmount').textContent = '2,500';
                }, 2000);
            }
        });
    }

    // Started Now (Checkout) Button
    const startBtn = document.getElementById('startBtn');
    if (startBtn) {
        startBtn.addEventListener('click', function() {
            const amount = document.getElementById('totalAmount').textContent;
            alert(`Processing payment of ${amount} Rwf.\n\nThank you for using Mini Shop Manager!`);
        });
    }
}

// Tabs Functionality
function initializeTabs() {
    const tabElements = document.querySelectorAll('[data-bs-toggle="tab"]');
    
    tabElements.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function() {
            const tabTarget = this.getAttribute('href');
            const contents = document.querySelectorAll('.features-section, .pricing-section');
            
            contents.forEach(content => {
                content.classList.add('d-none');
            });
            
            const activeContent = document.querySelector(tabTarget);
            if (activeContent) {
                activeContent.classList.remove('d-none');
            }
        });
    });
}

// Expose function to update total (optional)
window.updateTotal = function(amount) {
    const totalElement = document.getElementById('totalAmount');
    if (totalElement) {
        totalElement.textContent = amount;
    }
};
