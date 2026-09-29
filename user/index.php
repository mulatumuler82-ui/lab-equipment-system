<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

// Check if user has the correct role
if ($_SESSION['role'] !== 'user') {
    header('Location: ../unauthorized.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h4><?php echo $_SESSION['full_name'] ?? 'User'; ?></h4>
                        <small class="user-role">Student/Researcher/Faculty</small>
                    </div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="index.php" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="search_equipment.php" class="nav-item">
                    <i class="fas fa-search"></i>
                    <span>Resource Search</span>
                </a>
                <a href="booking.php" class="nav-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Equipment Booking</span>
                </a>
                <a href="profile.php" class="nav-item">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile Management</span>
                </a>
                <a href="report_issue.php" class="nav-item">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Report Issues</span>
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
                    <input type="text" placeholder="Search equipment...">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="user-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">2</span>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="welcome-section">
                    <h1>Welcome, <?php echo $_SESSION['full_name'] ?? 'User'; ?>!</h1>
                    <p>User Dashboard - Injibara University Software Lab</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>My Bookings</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="stat-info">
                            <h3>45</h3>
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
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/main.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>