// Reports Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    checkLoginStatus();
    initializeAdminName();
    initializeReportsPage();
    loadSampleReportData();
});

// Sample report data
const reportData = [
    { date: '2026-02-16', product: 'Panadol', price: 500, quantity: 80, revenue: 40000, profit: 12000 },
    { date: '2026-02-15', product: 'Sprite', price: 1000, quantity: 60, revenue: 60000, profit: 15000 },
    { date: '2026-02-14', product: 'Inyange Water', price: 333, quantity: 120, revenue: 39960, profit: 10000 },
    { date: '2026-02-13', product: 'Coca Cola', price: 1000, quantity: 50, revenue: 50000, profit: 12000 },
    { date: '2026-02-12', product: 'Ibuprofen', price: 500, quantity: 100, revenue: 50000, profit: 15000 },
    { date: '2026-02-11', product: 'Aspirin', price: 400, quantity: 90, revenue: 36000, profit: 8000 },
    { date: '2026-02-10', product: 'Sugar (1kg)', price: 600, quantity: 150, revenue: 90000, profit: 25000 },
];

let currentReportData = [...reportData];
let totalRevenue = 225960;

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

// Initialize Reports Page
function initializeReportsPage() {
    const generateReportBtn = document.getElementById('generateReportBtn');
    const downloadPdfBtn = document.getElementById('downloadPdfBtn');
    const downloadExcelBtn = document.getElementById('downloadExcelBtn');
    const productSearch = document.getElementById('productSearch');
    const dateRangeDropdown = document.getElementById('dateRangeDropdown');
    const profitFilter = document.getElementById('profitFilter');
    const stockFilter = document.getElementById('stockFilter');

    // Generate Report
    if (generateReportBtn) {
        generateReportBtn.addEventListener('click', generateReport);
    }

    // Download PDF
    if (downloadPdfBtn) {
        downloadPdfBtn.addEventListener('click', downloadPDF);
    }

    // Download Excel
    if (downloadExcelBtn) {
        downloadExcelBtn.addEventListener('click', downloadExcel);
    }

    // Search product
    if (productSearch) {
        productSearch.addEventListener('input', filterReports);
    }

    // Date range filter
    if (dateRangeDropdown) {
        dateRangeDropdown.addEventListener('change', applyDateRangeFilter);
    }

    // Profit filter
    if (profitFilter) {
        profitFilter.addEventListener('change', filterReports);
    }

    // Stock filter
    if (stockFilter) {
        stockFilter.addEventListener('change', filterReports);
    }
}

// Load Sample Report Data
function loadSampleReportData() {
    updateReportTable(currentReportData);
}

// Update Report Table
function updateReportTable(data) {
    const tableBody = document.getElementById('reportsTableBody');
    
    if (data.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-4">
                    <i class="bi bi-inbox"></i>
                    <p>No reports found matching your filters.</p>
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = data.map(item => `
        <tr>
            <td>
                <strong>${item.product}</strong><br>
                <small>${item.date}</small>
            </td>
            <td>
                <strong>${item.price} Rwf</strong>
            </td>
            <td>
                <strong>${item.quantity}</strong>
            </td>
            <td>
                <strong>${item.revenue.toLocaleString()} Rwf</strong>
            </td>
        </tr>
    `).join('');

    // Update total revenue
    const grandTotal = data.reduce((sum, item) => sum + item.revenue, 0);
    document.getElementById('grandTotalRevenue').textContent = grandTotal.toLocaleString() + ' Rwf';
    totalRevenue = grandTotal;
}

// Filter Reports
function filterReports() {
    const productSearch = document.getElementById('productSearch').value.toLowerCase();
    const profitFilter = document.getElementById('profitFilter').value;

    let filtered = reportData.filter(item => {
        // Product name filter
        if (productSearch && !item.product.toLowerCase().includes(productSearch)) {
            return false;
        }

        // Profit filter
        if (profitFilter === 'high' && item.profit <= 10000) {
            return false;
        }
        if (profitFilter === 'medium' && (item.profit > 10000 || item.profit < 5000)) {
            return false;
        }
        if (profitFilter === 'low' && item.profit >= 5000) {
            return false;
        }

        return true;
    });

    currentReportData = filtered;
    updateReportTable(filtered);
}

// Apply Date Range Filter
function applyDateRangeFilter() {
    const dateRangeValue = document.getElementById('dateRangeDropdown').value;
    const today = new Date();
    let startDate, endDate;

    switch (dateRangeValue) {
        case 'today':
            startDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + 1);
            break;
        case 'week':
            startDate = new Date(today);
            startDate.setDate(today.getDate() - today.getDay());
            endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + 7);
            break;
        case 'month':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 1);
            break;
        case 'year':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date(today.getFullYear() + 1, 0, 1);
            break;
        default:
            return;
    }

    const filtered = reportData.filter(item => {
        const itemDate = new Date(item.date);
        return itemDate >= startDate && itemDate < endDate;
    });

    currentReportData = filtered;
    updateReportTable(filtered);
}

// Generate Report
function generateReport() {
    filterReports();
    alert(`Report generated!\n\nTotal Items: ${currentReportData.length}\nTotal Revenue: ${totalRevenue.toLocaleString()} Rwf`);
}

// Download PDF Function
function downloadPDF() {
    if (currentReportData.length === 0) {
        alert('No data to download');
        return;
    }

    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Sales Report - Mini Shop Manager\n";
    csvContent += "Generated: " + new Date().toLocaleString() + "\n\n";
    csvContent += "Date,Product,Price,Quantity,Revenue\n";

    currentReportData.forEach(item => {
        csvContent += `"${item.date}","${item.product}",${item.price},${item.quantity},${item.revenue}\n`;
    });

    csvContent += "\n";
    csvContent += `Grand Total Revenue,,,," ${totalRevenue.toLocaleString()} Rwf"\n`;

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `sales-report-${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);

    link.click();
    document.body.removeChild(link);

    alert('Report downloaded as CSV (PDF export requires additional libraries)');
}

// Download Excel Function
function downloadExcel() {
    if (currentReportData.length === 0) {
        alert('No data to download');
        return;
    }

    let csvContent = "Date,Product,Price,Quantity,Revenue\n";

    currentReportData.forEach(item => {
        csvContent += `${item.date},"${item.product}",${item.price},${item.quantity},${item.revenue}\n`;
    });

    csvContent += `\nGrand Total Revenue,,,${totalRevenue}\n`;

    const encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `sales-report-${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);

    link.click();
    document.body.removeChild(link);

    alert('Report exported as Excel CSV file');
}

// Logout function
window.logout = function() {
    sessionStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('username');
    window.location.href = 'login.html';
};
