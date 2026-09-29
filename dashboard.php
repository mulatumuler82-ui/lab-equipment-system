<?php
require_once 'includes/session.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.html');
    exit();
}

$userRole = getUserRole();
$userId = $_SESSION['user_id'];

// Get dashboard statistics
$stats = getDashboardStats($userId, $userRole);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lab Equipment System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content-dashboard">
            <!-- Top Bar -->
            <div class="top-bar">
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="search-box">
                    <input type="text" placeholder="Search equipment, bookings, reports...">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="user-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <a href="logout.php" class="btn btn-secondary" id="logoutBtn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h1>Welcome, <?php echo $_SESSION['full_name'] ?? 'User'; ?>!</h1>
                    <p><?php 
                        $roleNames = [
                            'system_admin' => 'System Administrator',
                            'lab_assistant' => 'Lab Assistant',
                            'department_head' => 'Department Head',
                            'user' => 'Student/Researcher/Faculty',
                            'store_manager' => 'Store Manager'
                        ];
                        echo $roleNames[$userRole] ?? $userRole;
                    ?> Dashboard - Injibara University Software Lab</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <?php if ($userRole === 'system_admin'): ?>
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['total_users'] ?? 0; ?></h3>
                                <p>Total Users</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['total_equipment'] ?? 0; ?></h3>
                                <p>Total Equipment</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['pending_bookings'] ?? 0; ?></h3>
                                <p>Pending Approvals</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon secondary">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-info">
                                <h3>98%</h3>
                                <p>System Health</p>
                            </div>
                        </div>
                        
                    <?php elseif ($userRole === 'lab_assistant'): ?>
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['total_equipment'] ?? 0; ?></h3>
                                <p>Total Equipment</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['checked_out'] ?? 0; ?></h3>
                                <p>Checked Out</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['maintenance'] ?? 0; ?></h3>
                                <p>Under Maintenance</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon secondary">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3>85%</h3>
                                <p>Availability Rate</p>
                            </div>
                        </div>
                        
                    <?php elseif ($userRole === 'user'): ?>
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['my_bookings'] ?? 0; ?></h3>
                                <p>My Bookings</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo $stats['available_equipment'] ?? 0; ?></h3>
                                <p>Available Equipment</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-info">
                                <h3>2</h3>
                                <p>Reported Issues</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon secondary">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="stat-info">
                                <h3>15</h3>
                                <p>Total Usage</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Actions -->
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <?php if ($userRole === 'user'): ?>
                                    <a href="user/search_equipment.php" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Search Equipment
                                    </a>
                                    <a href="user/booking.php" class="btn btn-secondary">
                                        <i class="fas fa-calendar-plus"></i> New Booking
                                    </a>
                                    <a href="user/report_issue.php" class="btn btn-warning">
                                        <i class="fas fa-exclamation-circle"></i> Report Issue
                                    </a>
                                <?php elseif ($userRole === 'lab_assistant'): ?>
                                    <a href="lab-assistant/inventory.php" class="btn btn-primary">
                                        <i class="fas fa-clipboard-list"></i> View Inventory
                                    </a>
                                    <a href="lab-assistant/checkin_checkout.php" class="btn btn-secondary">
                                        <i class="fas fa-exchange-alt"></i> Check In/Out
                                    </a>
                                    <a href="lab-assistant/maintenance_reports.php" class="btn btn-warning">
                                        <i class="fas fa-wrench"></i> Maintenance
                                    </a>
                                <?php elseif ($userRole === 'system_admin'): ?>
                                    <a href="admin/manage_users.php" class="btn btn-primary">
                                        <i class="fas fa-users-cog"></i> Manage Users
                                    </a>
                                    <a href="admin/audit_trail.php" class="btn btn-secondary">
                                        <i class="fas fa-history"></i> Audit Trail
                                    </a>
                                    <a href="admin/security_backup.php" class="btn btn-warning">
                                        <i class="fas fa-shield-alt"></i> Security
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-history"></i> Recent Activity</h3>
                        </div>
                        <div class="card-body">
                            <div class="activity-list">
                                <div class="activity-item">
                                    <i class="fas fa-check-circle success"></i>
                                    <div>
                                        <p>Login successful</p>
                                        <small>Just now</small>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <i class="fas fa-tools warning"></i>
                                    <div>
                                        <p>Equipment maintenance scheduled</p>
                                        <small>2 hours ago</small>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <i class="fas fa-calendar-check primary"></i>
                                    <div>
                                        <p>New booking request submitted</p>
                                        <small>Yesterday</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Bookings/Requests Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3>Recent <?php echo $userRole === 'user' ? 'My Bookings' : 'Requests'; ?></h3>
                        <button class="btn btn-secondary" onclick="exportToCSV('recentTable', 'recent_data')">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                    <table id="recentTable">
                        <thead>
                            <tr>
                                <?php if ($userRole === 'system_admin' || $userRole === 'department_head'): ?>
                                    <th>Request ID</th>
                                    <th>User</th>
                                    <th>Equipment</th>
                                    <th>Booking Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                <?php else: ?>
                                    <th>Request ID</th>
                                    <th>Equipment</th>
                                    <th>Booking Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via JavaScript -->
                            <tr>
                                <td colspan="6" style="text-align: center;">Loading data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/main.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>