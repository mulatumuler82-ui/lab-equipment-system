<?php
require_once '../includes/session.php';
require_once '../includes/functions.php';
requireRole('system_admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin Dashboard - Lab Equipment System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <h4><?php echo $_SESSION['full_name'] ?? 'Admin'; ?></h4>
                        <small class="user-role">System Administrator</small>
                    </div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="index.php" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="manage_users.php" class="nav-item">
                    <i class="fas fa-users-cog"></i>
                    <span>Manage Users</span>
                </a>
                <a href="audit_trail.php" class="nav-item">
                    <i class="fas fa-history"></i>
                    <span>Audit Trail</span>
                </a>
                <a href="security_backup.php" class="nav-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Security & Backup</span>
                </a>
                <a href="../logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content-dashboard">
            <!-- Top Bar -->
            <div class="top-bar">
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="search-box">
                    <input type="text" placeholder="Search users, logs, equipment...">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="user-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="welcome-section">
                    <h1>System Administrator Dashboard</h1>
                    <p>Manage users, security, backups, and audit trails for the laboratory equipment system</p>
                </div>
                
                <!-- System Overview -->
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-cogs"></i> System Overview</h3>
                        </div>
                        <div class="card-body">
                            <div class="system-metrics">
                                <div class="metric">
                                    <span class="metric-label">Total Users</span>
                                    <span class="metric-value">45</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">Active Sessions</span>
                                    <span class="metric-value">12</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">Storage Used</span>
                                    <span class="metric-value">2.4 GB / 10 GB</span>
                                </div>
                                <div class="metric">
                                    <span class="metric-label">System Uptime</span>
                                    <span class="metric-value">99.8%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions-grid">
                                <a href="manage_users.php" class="quick-action">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add User</span>
                                </a>
                                <a href="audit_trail.php" class="quick-action">
                                    <i class="fas fa-file-export"></i>
                                    <span>Export Logs</span>
                                </a>
                                <a href="security_backup.php" class="quick-action">
                                    <i class="fas fa-database"></i>
                                    <span>Backup Now</span>
                                </a>
                                <a href="#" class="quick-action">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Reports</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent User Activity -->
                <div class="table-container">
                    <div class="table-header">
                        <h3><i class="fas fa-history"></i> Recent User Activity</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>john_doe</td>
                                <td><span class="status-badge status-approved">User</span></td>
                                <td>Logged in</td>
                                <td>2024-01-15 10:30:25</td>
                                <td>192.168.1.100</td>
                            </tr>
                            <tr>
                                <td>lab_assist1</td>
                                <td><span class="status-badge status-pending">Lab Assistant</span></td>
                                <td>Checked out equipment</td>
                                <td>2024-01-15 09:15:42</td>
                                <td>192.168.1.101</td>
                            </tr>
                            <tr>
                                <td>dept_head</td>
                                <td><span class="status-badge status-approved">Dept Head</span></td>
                                <td>Approved booking request</td>
                                <td>2024-01-14 16:20:15</td>
                                <td>192.168.1.102</td>
                            </tr>
                            <tr>
                                <td>store_manager</td>
                                <td><span class="status-badge status-approved">Store Manager</span></td>
                                <td>Added new equipment</td>
                                <td>2024-01-14 14:45:30</td>
                                <td>192.168.1.103</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/main.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>