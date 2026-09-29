// Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard based on user role
    const currentUser = JSON.parse(localStorage.getItem('currentUser') || sessionStorage.getItem('currentUser') || '{}');
    
    if (currentUser && currentUser.role) {
        updateUserInfo(currentUser);
        loadDashboardData(currentUser.role);
        setupDashboardEvents(currentUser.role);
    }
    
    // Logout functionality
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear user data
            localStorage.removeItem('currentUser');
            sessionStorage.removeItem('currentUser');
            
            // Redirect to login
            window.location.href = '../login.html';
        });
    }
    
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterTable(searchTerm);
        });
    }
    
    // Date pickers
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        input.min = today;
        
        // For return dates, set default to 7 days from now
        if (input.id === 'returnDate') {
            const nextWeek = new Date();
            nextWeek.setDate(nextWeek.getDate() + 7);
            input.value = nextWeek.toISOString().split('T')[0];
        }
    });
    
    // Initialize charts if Chart.js is available
    if (typeof Chart !== 'undefined') {
        initializeCharts();
    }
});

function updateUserInfo(user) {
    // Update user display name
    const userDisplay = document.querySelector('.user-info span');
    if (userDisplay) {
        userDisplay.textContent = user.username || 'User';
    }
    
    // Update role display
    const roleDisplay = document.querySelector('.user-role');
    if (roleDisplay) {
        const roleNames = {
            'system_admin': 'System Administrator',
            'lab_assistant': 'Lab Assistant',
            'department_head': 'Department Head',
            'user': 'Student/Researcher/Faculty',
            'store_manager': 'Store Manager'
        };
        roleDisplay.textContent = roleNames[user.role] || user.role;
    }
}

function loadDashboardData(role) {
    // Load data based on user role
    switch(role) {
        case 'system_admin':
            loadAdminData();
            break;
        case 'lab_assistant':
            loadLabAssistantData();
            break;
        case 'department_head':
            loadDepartmentHeadData();
            break;
        case 'user':
            loadUserData();
            break;
        case 'store_manager':
            loadStoreManagerData();
            break;
    }
}

function setupDashboardEvents(role) {
    // Setup event listeners based on role
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const itemId = this.dataset.id;
            
            handleAction(action, itemId, role);
        });
    });
}

function filterTable(searchTerm) {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

function handleAction(action, itemId, role) {
    console.log(`Action: ${action}, Item ID: ${itemId}, Role: ${role}`);
    
    switch(action) {
        case 'approve':
            approveRequest(itemId);
            break;
        case 'reject':
            rejectRequest(itemId);
            break;
        case 'checkout':
            checkoutEquipment(itemId);
            break;
        case 'checkin':
            checkinEquipment(itemId);
            break;
        case 'report':
            reportMaintenance(itemId);
            break;
        case 'edit':
            editItem(itemId);
            break;
        case 'delete':
            deleteItem(itemId);
            break;
    }
}

// Role-specific data loading functions
function loadAdminData() {
    // Load system statistics
    updateStats({
        totalUsers: 45,
        activeSessions: 12,
        pendingAudits: 3,
        systemHealth: 'Good'
    });
}

function loadLabAssistantData() {
    updateStats({
        totalEquipment: 120,
        checkedOut: 15,
        maintenance: 8,
        available: 97
    });
}

function loadDepartmentHeadData() {
    updateStats({
        pendingRequests: 12,
        approvedToday: 5,
        totalLabs: 8,
        occupancyRate: '75%'
    });
}

function loadUserData() {
    updateStats({
        myBookings: 3,
        activeBookings: 1,
        reportedIssues: 2,
        availableEquipments: 45
    });
}

function loadStoreManagerData() {
    updateStats({
        totalInventory: 150,
        pendingRequests: 8,
        maintenancePending: 5,
        lowStock: 3
    });
}

function updateStats(stats) {
    // Update statistics cards
    Object.keys(stats).forEach((stat, index) => {
        const statElement = document.querySelector(`.stat-card:nth-child(${index + 1}) h3`);
        if (statElement) {
            statElement.textContent = stats[stat];
        }
    });
}

// Chart initialization
function initializeCharts() {
    // Equipment Status Chart
    const equipmentCtx = document.getElementById('equipmentStatusChart');
    if (equipmentCtx) {
        new Chart(equipmentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Checked Out', 'Maintenance', 'Reserved'],
                datasets: [{
                    data: [85, 12, 8, 5],
                    backgroundColor: [
                        '#27ae60',
                        '#3498db',
                        '#f39c12',
                        '#9b59b6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // Usage Trends Chart
    const usageCtx = document.getElementById('usageTrendsChart');
    if (usageCtx) {
        new Chart(usageCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Equipment Usage',
                    data: [65, 78, 90, 85, 92, 88],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

// API simulation functions
function approveRequest(requestId) {
    showMessage('success', `Request #${requestId} approved successfully`);
    // In real app, make API call here
}

function rejectRequest(requestId) {
    if (confirm('Are you sure you want to reject this request?')) {
        showMessage('info', `Request #${requestId} rejected`);
        // In real app, make API call here
    }
}

function checkoutEquipment(equipmentId) {
    showMessage('success', `Equipment #${equipmentId} checked out`);
    // In real app, make API call here
}

function checkinEquipment(equipmentId) {
    showMessage('success', `Equipment #${equipmentId} checked in`);
    // In real app, make API call here
}

// Export functionality
function exportToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    const csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cols = row.querySelectorAll('td, th');
        
        cols.forEach(col => {
            rowData.push(col.textContent.trim());
        });
        
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    a.download = `${filename}_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showMessage('success', 'Data exported successfully');
}