<?php
require_once '../includes/session.php';
require_once '../includes/functions.php';
requireRole('lab_assistant');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Assistant Dashboard - Lab Equipment System</title>
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
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h4><?php echo $_SESSION['full_name'] ?? 'Lab Assistant'; ?></h4>
                        <small class="user-role">Lab Assistant</small>
                    </div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="index.php" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="inventory.php" class="nav-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Inventory Tracking</span>
                </a>
                <a href="checkin_checkout.php" class="nav-item">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Check In/Out</span>
                </a>
                <a href="maintenance_reports.php" class="nav-item">
                    <i class="fas fa-wrench"></i>
                    <span>Maintenance Reports</span>
                </a>
                <a href="usage_monitoring.php" class="nav-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Usage Monitoring</span>
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
                    <input type="text" placeholder="Search equipment, bookings...">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="user-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="welcome-section">
                    <h1>Lab Assistant Dashboard</h1>
                    <p>Track inventory, manage equipment check-in/out, and handle maintenance reports</p>
                </div>
                
                <!-- Equipment Status Overview -->
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-tools"></i> Equipment Status</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="equipmentStatusChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="checkin_checkout.php" class="btn btn-primary">
                                    <i class="fas fa-qrcode"></i> Scan Check-in/out
                                </a>
                                <a href="inventory.php" class="btn btn-secondary">
                                    <i class="fas fa-clipboard-check"></i> Take Inventory
                                </a>
                                <a href="maintenance_reports.php" class="btn btn-warning">
                                    <i class="fas fa-plus-circle"></i> New Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Equipment Requiring Attention -->
                <div class="table-container">
                    <div class="table-header">
                        <h3><i class="fas fa-exclamation-triangle"></i> Equipment Requiring Attention</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Equipment ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Issue</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>EQ-0012</td>
                                <td>Oscilloscope Tektronix</td>
                                <td>Lab 102</td>
                                <td>Calibration due</td>
                                <td><span class="status-badge status-pending">High</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-action="schedule" data-id="12">
                                        <i class="fas fa-calendar"></i> Schedule
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>EQ-0025</td>
                                <td>3D Printer Creality</td>
                                <td>Lab 101</td>
                                <td>Nozzle clogged</td>
                                <td><span class="status-badge status-pending">Medium</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-action="repair" data-id="25">
                                        <i class="fas fa-wrench"></i> Repair
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>