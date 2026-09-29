<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}

// Check if user has the correct role
if ($_SESSION['role'] !== 'store_manager') {
    header('Location: ../unauthorized.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Manager Dashboard</title>
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
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <div>
                        <h4><?php echo $_SESSION['full_name'] ?? 'Store Manager'; ?></h4>
                        <small class="user-role">Store Manager</small>
                    </div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="index.php" class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="equipment_requests.php" class="nav-item">
                    <i class="fas fa-envelope"></i>
                    <span>Equipment Requests</span>
                </a>
                <a href="add_equipment.php" class="nav-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Equipment</span>
                </a>
                <a href="accept_maintenance.php" class="nav-item">
                    <i class="fas fa-wrench"></i>
                    <span>Accept Maintenance</span>
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
                        <span class="notification-badge">4</span>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="welcome-section">
                    <h1>Welcome, <?php echo $_SESSION['full_name'] ?? 'Store Manager'; ?>!</h1>
                    <p>Store Manager Dashboard - Injibara University Software Lab</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/main.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>