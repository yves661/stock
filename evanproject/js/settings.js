// Settings Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
    initializeAdminName();
    initializeSettingsPage();
    loadUserProfile();
});

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

// Initialize Settings Page
function initializeSettingsPage() {
    const settingsForm = document.getElementById('settingsForm');
    const resetBtn = document.getElementById('resetBtn');
    const clearCacheBtn = document.getElementById('clearCacheBtn');
    const deleteAccountBtn = document.getElementById('deleteAccountBtn');

    // Form Submit
    if (settingsForm) {
        settingsForm.addEventListener('submit', handleSettingsSave);
    }

    // Reset Button
    if (resetBtn) {
        resetBtn.addEventListener('click', resetForm);
    }

    // Clear Cache
    if (clearCacheBtn) {
        clearCacheBtn.addEventListener('click', clearCache);
    }

    // Delete Account
    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', deleteAccount);
    }

    // Load saved settings
    loadSettings();
}

// Load Settings from Storage
function loadSettings() {
    const settings = JSON.parse(sessionStorage.getItem('shopSettings')) || {
        shopName: 'Mini Shop Manager',
        currency: 'Rwf',
        address: 'Kinywhwasanda',
        language: 'English',
        phone: '',
        tax: 5
    };

    document.getElementById('shopName').value = settings.shopName;
    document.getElementById('currency').value = settings.currency.toLowerCase() === 'rwf' ? 'rwf' : settings.currency.toLowerCase();
    document.getElementById('address').value = settings.address;
    document.getElementById('language').value = settings.language.toLowerCase();
    document.getElementById('phone').value = settings.phone;
    document.getElementById('tax').value = settings.tax;
}

// Handle Settings Save
function handleSettingsSave(e) {
    e.preventDefault();

    const shopName = document.getElementById('shopName').value.trim();
    const currency = document.getElementById('currency').value;
    const address = document.getElementById('address').value.trim();
    const language = document.getElementById('language').value;
    const phone = document.getElementById('phone').value.trim();
    const tax = document.getElementById('tax').value;
    const password = document.getElementById('password').value;

    // Validation
    if (!shopName) {
        alert('Shop name is required');
        return;
    }

    if (phone && !/^\d{10,}$/.test(phone.replace(/\D/g, ''))) {
        alert('Please enter a valid phone number');
        return;
    }

    if (tax < 0 || tax > 100) {
        alert('Tax rate must be between 0 and 100');
        return;
    }

    // Save settings
    const settings = {
        shopName: shopName,
        currency: currency === 'rwf' ? 'Rwf' : currency.toUpperCase(),
        address: address,
        language: language.charAt(0).toUpperCase() + language.slice(1),
        phone: phone,
        tax: parseFloat(tax)
    };

    sessionStorage.setItem('shopSettings', JSON.stringify(settings));

    // If password is provided, update it silently (demo only)
    if (password) {
        sessionStorage.setItem('adminPassword', password);
    }

    // Show success message
    const btn = document.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-circle"></i> Changes Saved!';
    btn.style.backgroundColor = '#28a745';

    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.backgroundColor = '';
    }, 2000);

    alert('Settings saved successfully!');
}

// Reset Form
function resetForm() {
    if (confirm('Are you sure you want to reset all settings to saved values?')) {
        loadSettings();
        alert('Settings reset to last saved values');
    }
}

// Load User Profile
function loadUserProfile() {
    const username = sessionStorage.getItem('username') || 'Admin';
    
    document.getElementById('profileUsername').textContent = username;
    
    // Get last login time (demo)
    const lastLogin = new Date().toLocaleString();
    document.getElementById('profileLastLogin').textContent = lastLogin;

    // Load profile table data (from session storage if available)
    const profileData = JSON.parse(sessionStorage.getItem('profileData')) || [
        { product: 'Panadol', sales: 50, revenue: 30000, rating: 6 },
        { product: 'Panadol', sales: 50, revenue: 30000, rating: 3 },
        { product: 'Inyange Water', sales: 45, revenue: 15000, rating: 3 },
        { product: 'Coca Cola', sales: 40, revenue: 40000, rating: 4 },
        { product: 'Sprite', sales: 35, revenue: 35000, rating: 5 }
    ];

    sessionStorage.setItem('profileData', JSON.stringify(profileData));
}

// Clear Cache
function clearCache() {
    if (confirm('Are you sure you want to clear all cached data? This will remove cart, sales history, and temporary data.')) {
        sessionStorage.removeItem('salesCart');
        sessionStorage.removeItem('salesHistory');
        sessionStorage.removeItem('profileData');
        alert('Cache cleared successfully!');
    }
}

// Delete Account
function deleteAccount() {
    const confirmText = prompt('Type "DELETE ACCOUNT" to confirm account deletion:');
    
    if (confirmText === 'DELETE ACCOUNT') {
        const secondConfirm = confirm('Are you absolutely sure? This action cannot be undone!');
        
        if (secondConfirm) {
            sessionStorage.clear();
            alert('Account deleted. Redirecting to login...');
            window.location.href = 'login.php';
        }
    } else if (confirmText !== null) {
        alert('Confirmation text does not match. Account deletion cancelled.');
    }
}

// Logout function
window.logout = function() {
    sessionStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('username');
    window.location.href = 'login.php';
};

// Save settings periodically (auto-save)
window.addEventListener('beforeunload', function() {
    const shopName = document.getElementById('shopName')?.value;
    if (shopName) {
        const currentSettings = JSON.parse(sessionStorage.getItem('shopSettings')) || {};
        currentSettings.lastModified = new Date().toISOString();
        sessionStorage.setItem('shopSettings', JSON.stringify(currentSettings));
    }
});
