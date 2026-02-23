// Client Reports JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeReportActions();
});

// Initialize Report Actions
function initializeReportActions() {
    // Add any interactive features for reports
    console.log('Client reports initialized');
}

// Export Report
function exportReport() {
    // Create CSV data for export
    let csvContent = "Date,Sales Count,Revenue\n";
    
    // Get data from the table
    const rows = document.querySelectorAll('#salesTable tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 3) {
            const date = cells[0].textContent.trim();
            const sales = cells[1].textContent.trim();
            const revenue = cells[2].textContent.trim();
            csvContent += `"${date}","${sales}","${revenue}"\n`;
        }
    });
    
    // Create download link
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', `sales_report_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    
    // Show success message
    showAlert('Report exported successfully!', 'success');
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
