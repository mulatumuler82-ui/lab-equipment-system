<?php
session_start();

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check user role
function getUserRole() {
    return $_SESSION['user_role'] ?? null;
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../login.html');
        exit();
    }
}

// Redirect based on role
function redirectBasedOnRole() {
    if (isLoggedIn()) {
        $role = getUserRole();
        switch ($role) {
            case 'system_admin':
                header('Location: admin/index.php');
                break;
            case 'lab_assistant':
                header('Location: lab-assistant/index.php');
                break;
            case 'department_head':
                header('Location: department-head/index.php');
                break;
            case 'user':
                header('Location: user/index.php');
                break;
            case 'store_manager':
                header('Location: store-manager/index.php');
                break;
            default:
                header('Location: ../index.html');
        }
        exit();
    }
}

// Check specific role access
function requireRole($requiredRole) {
    requireLogin();
    if (getUserRole() !== $requiredRole) {
        header('Location: ../unauthorized.html');
        exit();
    }
}
?>