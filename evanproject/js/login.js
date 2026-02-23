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
    const password = document.getElementById('password').value;
    const messageDiv = document.getElementById('loginMessage');

    // Validate input
    if (!username || !password) {
        showMessage('Please enter your username and password', 'error');
        return;
    }

    // Send login request to backend
    fetch('api/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('isLoggedIn', 'true');
            sessionStorage.setItem('username', username);
            window.location.href = 'dashboard.php';
        } else {
            showMessage(data.message || 'Login failed', 'error');
        }
    })
    .catch(() => {
        showMessage('Network error. Please try again.', 'error');
    });
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
