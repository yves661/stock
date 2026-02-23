// Signup Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeSignupForm();
    initializePasswordStrength();
    initializeNameClear();
});

// Initialize Signup Form
function initializeSignupForm() {
    const signupForm = document.getElementById('signupForm');
    const messageDiv = document.getElementById('signupMessage');

    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleSignup();
        });
    }

    // Real-time email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            validateEmail(this.value);
        });
    }

    // Password match validation
    const confirmPassword = document.getElementById('confirmPassword');
    if (confirmPassword) {
        confirmPassword.addEventListener('change', function() {
            validatePasswordMatch();
        });
    }
}

// Handle Signup
function handleSignup() {
    const fullname = document.getElementById('fullname').value.trim();
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const termsAccepted = document.getElementById('terms').checked;
    const messageDiv = document.getElementById('signupMessage');

    // Reset message
    messageDiv.innerHTML = '';
    messageDiv.className = 'signup-message';

    // Validate all fields
    if (!fullname || !username || !password || !confirmPassword) {
        showSignupMessage('Please fill in all required fields', 'error');
        return;
    }

    if (fullname.length < 3) {
        showSignupMessage('Full name must be at least 3 characters', 'error');
        return;
    }

    if (username.length < 3) {
        showSignupMessage('Username must be at least 3 characters', 'error');
        return;
    }

    if (email && !isValidEmail(email)) {
        showSignupMessage('Please enter a valid email address', 'error');
        return;
    }

    if (password.length < 6) {
        showSignupMessage('Password must be at least 6 characters', 'error');
        return;
    }

    if (password !== confirmPassword) {
        showSignupMessage('Passwords do not match', 'error');
        return;
    }

    if (!termsAccepted) {
        showSignupMessage('You must agree to the Terms of Service', 'error');
        return;
    }

    // Call backend API to create account
    showSignupMessage('Creating your account...', 'info');

    const formData = new FormData();
    formData.append('fullname', fullname);
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);

    fetch('api/register.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
      .then(data => {
        if (data.success) {
            showSignupMessage('Account created successfully! Redirecting to dashboard...', 'success');
            // Store complete user session data
            sessionStorage.setItem('isLoggedIn', 'true');
            sessionStorage.setItem('username', data.user.username);
            sessionStorage.setItem('fullname', data.user.fullname);
            sessionStorage.setItem('userRole', data.user.role);
            setTimeout(() => window.location.href = 'client_dashboard.php', 1500);
        } else {
            showSignupMessage(data.message || 'Registration failed', 'error');
        }
      }).catch(err => {
        showSignupMessage('Server error. Try again later.', 'error');
      });
}

// Password Strength Indicator
function initializePasswordStrength() {
    const passwordInput = document.getElementById('password');
    const strengthProgress = document.getElementById('strengthProgress');
    const strengthText = document.getElementById('strengthText');
    const passwordStrength = document.getElementById('passwordStrength');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = calculatePasswordStrength(this.value);
            
            if (this.value.length > 0) {
                passwordStrength.classList.add('show');
            } else {
                passwordStrength.classList.remove('show');
            }
            
            strengthProgress.style.width = strength.percentage + '%';
            strengthProgress.className = 'strength-progress strength-' + strength.level;
            strengthText.textContent = 'Password strength: ' + strength.label;
            strengthText.className = 'strength-text strength-' + strength.level;
        });
    }
}

// Calculate Password Strength
function calculatePasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;
    if (/[a-z]/.test(password)) strength += 1;
    if (/[A-Z]/.test(password)) strength += 1;
    if (/[0-9]/.test(password)) strength += 1;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 1;

    const levels = [
        { level: 'weak', label: 'Weak', percentage: 25 },
        { level: 'weak', label: 'Weak', percentage: 25 },
        { level: 'fair', label: 'Fair', percentage: 50 },
        { level: 'good', label: 'Good', percentage: 75 },
        { level: 'good', label: 'Good', percentage: 75 },
        { level: 'strong', label: 'Strong', percentage: 100 }
    ];

    return levels[strength] || levels[0];
}

// Email Validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validateEmail(email) {
    const emailInput = document.getElementById('email');
    if (email && !isValidEmail(email)) {
        emailInput.classList.add('is-invalid');
        showSignupMessage('Please enter a valid email address', 'error');
    } else {
        emailInput.classList.remove('is-invalid');
    }
}

// Validate Password Match
function validatePasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (confirmPassword && password !== confirmPassword) {
        document.getElementById('confirmPassword').classList.add('is-invalid');
        return false;
    } else {
        document.getElementById('confirmPassword').classList.remove('is-invalid');
        return true;
    }
}

// Clear Name Field
document.addEventListener('click', function(e) {
    if (e.target.closest('#nameHelpBtn')) {
        e.preventDefault();
        document.getElementById('fullname').value = '';
        document.getElementById('fullname').focus();
    }
});

// Show Signup Message
function showSignupMessage(message, type) {
    const messageDiv = document.getElementById('signupMessage');
    messageDiv.innerHTML = message;
    messageDiv.className = 'signup-message alert alert-' + (type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info');
    messageDiv.style.display = 'block';
}

// Terms Link handling
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('terms-link')) {
        e.preventDefault();
        alert('Terms and Conditions would load here');
    }
});
