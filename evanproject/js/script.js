document.addEventListener('DOMContentLoaded', function(){
  // Initialize any global functionality
  // Features and Pricing navigation is handled through links
  
  // Example: Add analytics or global event handlers here
  console.log('Mini Shop Manager loaded successfully');
});

// Logout function
function logout() {
  fetch('api/logout.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      sessionStorage.clear();
      window.location.href = 'login.php';
    } else {
      alert('Logout failed. Please try again.');
    }
  })
  .catch(() => {
    alert('Network error during logout.');
  });
}
