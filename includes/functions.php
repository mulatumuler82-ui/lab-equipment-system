<?php
// Get the base directory
define('BASE_DIR', dirname(__DIR__));

// Include database connection using absolute path
require_once BASE_DIR . '/database/database_connection.php';

// User functions
function registerUser($userData) {
    $conn = getConnection();
    
    // Hash password
    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, full_name, department, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", 
        $userData['username'],
        $userData['email'],
        $hashedPassword,
        $userData['role'],
        $userData['full_name'],
        $userData['department'],
        $userData['phone']
    );
    
    return $stmt->execute();
}

function authenticateUser($username, $password) {
    $conn = getConnection();
    
    $stmt = $conn->prepare("SELECT id, username, password, role, full_name FROM users WHERE username = ? AND is_active = 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    
    return false;
}

// Equipment functions
function getEquipment($filters = []) {
    $conn = getConnection();
    
    $sql = "SELECT e.*, l.lab_name FROM equipment e LEFT JOIN laboratories l ON e.lab_id = l.id WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($filters['status'])) {
        $sql .= " AND e.status = ?";
        $params[] = $filters['status'];
        $types .= "s";
    }
    
    if (!empty($filters['category'])) {
        $sql .= " AND e.category = ?";
        $params[] = $filters['category'];
        $types .= "s";
    }
    
    if (!empty($filters['lab_id'])) {
        $sql .= " AND e.lab_id = ?";
        $params[] = $filters['lab_id'];
        $types .= "i";
    }
    
    $sql .= " ORDER BY e.equipment_name";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result();
}

function addEquipment($equipmentData) {
    $conn = getConnection();
    
    $stmt = $conn->prepare("INSERT INTO equipment (equipment_name, description, category, serial_number, lab_id, status, purchase_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", 
        $equipmentData['equipment_name'],
        $equipmentData['description'],
        $equipmentData['category'],
        $equipmentData['serial_number'],
        $equipmentData['lab_id'],
        $equipmentData['status'],
        $equipmentData['purchase_date']
    );
    
    return $stmt->execute();
}

// Booking functions
function createBooking($bookingData) {
    $conn = getConnection();
    
    $stmt = $conn->prepare("INSERT INTO booking_requests (user_id, equipment_id, booking_date, return_date, purpose) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss",
        $bookingData['user_id'],
        $bookingData['equipment_id'],
        $bookingData['booking_date'],
        $bookingData['return_date'],
        $bookingData['purpose']
    );
    
    if ($stmt->execute()) {
        // Update equipment status
        $updateStmt = $conn->prepare("UPDATE equipment SET status = 'reserved' WHERE id = ?");
        $updateStmt->bind_param("i", $bookingData['equipment_id']);
        $updateStmt->execute();
        
        return true;
    }
    
    return false;
}

function approveBooking($bookingId, $approvedBy) {
    $conn = getConnection();
    
    $stmt = $conn->prepare("UPDATE booking_requests SET status = 'approved', approved_by = ?, approved_date = NOW() WHERE id = ?");
    $stmt->bind_param("ii", $approvedBy, $bookingId);
    
    return $stmt->execute();
}

// Maintenance functions
function reportMaintenance($reportData) {
    $conn = getConnection();
    
    $stmt = $conn->prepare("INSERT INTO maintenance_reports (equipment_id, reported_by, issue_description, priority) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss",
        $reportData['equipment_id'],
        $reportData['reported_by'],
        $reportData['issue_description'],
        $reportData['priority']
    );
    
    if ($stmt->execute()) {
        // Update equipment status
        $updateStmt = $conn->prepare("UPDATE equipment SET status = 'maintenance' WHERE id = ?");
        $updateStmt->bind_param("i", $reportData['equipment_id']);
        $updateStmt->execute();
        
        return true;
    }
    
    return false;
}

// Dashboard statistics
function getDashboardStats($userId, $role) {
    $conn = getConnection();
    $stats = [];
    
    switch ($role) {
        case 'system_admin':
            $result = $conn->query("SELECT COUNT(*) as total_users FROM users");
            $stats['total_users'] = $result->fetch_assoc()['total_users'];
            
            $result = $conn->query("SELECT COUNT(*) as total_equipment FROM equipment");
            $stats['total_equipment'] = $result->fetch_assoc()['total_equipment'];
            
            $result = $conn->query("SELECT COUNT(*) as pending_bookings FROM booking_requests WHERE status = 'pending'");
            $stats['pending_bookings'] = $result->fetch_assoc()['pending_bookings'];
            break;
            
        case 'lab_assistant':
            $result = $conn->query("SELECT COUNT(*) as total_equipment FROM equipment");
            $stats['total_equipment'] = $result->fetch_assoc()['total_equipment'];
            
            $result = $conn->query("SELECT COUNT(*) as checked_out FROM equipment WHERE status = 'checked_out'");
            $stats['checked_out'] = $result->fetch_assoc()['checked_out'];
            
            $result = $conn->query("SELECT COUNT(*) as maintenance FROM equipment WHERE status = 'maintenance'");
            $stats['maintenance'] = $result->fetch_assoc()['maintenance'];
            break;
            
        case 'user':
            $stmt = $conn->prepare("SELECT COUNT(*) as my_bookings FROM booking_requests WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stats['my_bookings'] = $stmt->get_result()->fetch_assoc()['my_bookings'];
            
            $result = $conn->query("SELECT COUNT(*) as available_equipment FROM equipment WHERE status = 'available'");
            $stats['available_equipment'] = $result->fetch_assoc()['available_equipment'];
            break;
    }
    
    return $stats;
}

// Audit trail
function logAudit($userId, $action, $tableName = null, $recordId = null, $oldValues = null, $newValues = null) {
    $conn = getConnection();
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $stmt = $conn->prepare("INSERT INTO audit_trail (user_id, action, table_name, record_id, old_values, new_values, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiiss", $userId, $action, $tableName, $recordId, $oldValues, $newValues, $ip);
    
    return $stmt->execute();
}
?>