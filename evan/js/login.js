// Login Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeLoginForm();
    initializePasswordToggle();
});

// Initialize Login Form
function initializeLoginForm() {
    const loginForm = document.getElementById('loginForm');
    const messageDiv = document.getElementById('loginMessage');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });
    }
}

// Handle Login
function handleLogin() {
    const username = document.getElementById('username').value.trim();
    const messageDiv = document.getElementById('loginMessage');

    // Validate input
    if (!username) {
        showMessage('Please enter your username', 'error');
        return;
    }

    if (username.length < 2) {
        showMessage('Username must be at least 2 characters', 'error');
        return;
    }

    // Store session and redirect immediately
    sessionStorage.setItem('isLoggedIn', 'true');
    sessionStorage.setItem('username', username);
    
    // Redirect instantly to dashboard
    window.location.href = 'dashboard.html';
}

// Show Message
function showMessage(message, type) {
    const messageDiv = document.getElementById('loginMessage');
    messageDiv.innerHTML = message;
    messageDiv.className = 'login-message alert alert-' + (type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info');
    messageDiv.style.display = 'block';
}

// Initialize Password Toggle (optional future feature)
function initializePasswordToggle() {
    // Future: Add show/hide password functionality
}

// Handle Forgot Password
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('forgot-password')) {
        e.preventDefault();
        alert('Password reset link would be sent to your email.\n\nFor demo: use admin / password123');
    }
});
