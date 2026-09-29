<?php
session_start();

// Simple authentication without database
$users = [
    'admin' => [
        'password' => 'admin123',
        'role' => 'system_admin',
        'full_name' => 'System Administrator'
    ],
    'labassist1' => [
        'password' => 'lab123',
        'role' => 'lab_assistant',
        'full_name' => 'Lab Assistant'
    ],
    'student1' => [
        'password' => 'student123',
        'role' => 'user',
        'full_name' => 'Test Student'
    ],
    'depthead' => [
        'password' => 'dept123',
        'role' => 'department_head',
        'full_name' => 'Department Head'
    ],
    'storemanager' => [
        'password' => 'store123',
        'role' => 'store_manager',
        'full_name' => 'Store Manager'
    ]
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $selectedRole = trim($_POST['role']);
    
    if (empty($username) || empty($password) || empty($selectedRole)) {
        $error = 'Please fill in all fields';
    } elseif (isset($users[$username])) {
        $user = $users[$username];
        
        if ($user['password'] === $password && $user['role'] === $selectedRole) {
            $_SESSION['user_id'] = $username;
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            // Redirect based on role
            switch($user['role']) {
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
                    header('Location: index.html');
            }
            exit();
        } else {
            $error = 'Invalid username, password, or role selection';
        }
    } else {
        $error = 'Invalid username, password, or role selection';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lab Equipment System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <img src="https://via.placeholder.com/60x60/2c3e50/ffffff?text=IU" alt="University Logo">
                <h2>Login to Lab Equipment System</h2>
                <p>Enter your credentials to access your dashboard</p>
            </div>

            <?php if ($error): ?>
                <div class="message error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="auth-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                           placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter your password">
                    <div class="password-toggle">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role"><i class="fas fa-user-tag"></i> Login As</label>
                    <select id="role" name="role" required>
                        <option value="">Select your role</option>
                        <option value="system_admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'system_admin') ? 'selected' : ''; ?>>System Administrator</option>
                        <option value="lab_assistant" <?php echo (isset($_POST['role']) && $_POST['role'] == 'lab_assistant') ? 'selected' : ''; ?>>Lab Assistant</option>
                        <option value="department_head" <?php echo (isset($_POST['role']) && $_POST['role'] == 'department_head') ? 'selected' : ''; ?>>Department Head</option>
                        <option value="user" <?php echo (isset($_POST['role']) && $_POST['role'] == 'user') ? 'selected' : ''; ?>>Student/Researcher/Faculty</option>
                        <option value="store_manager" <?php echo (isset($_POST['role']) && $_POST['role'] == 'store_manager') ? 'selected' : ''; ?>>Store Manager</option>
                    </select>
                </div>

                <div class="form-options">
                    <label class="checkbox">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="forgot-password.html" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="register.html">Register here</a></p>
                    <p><a href="index.html"><i class="fas fa-home"></i> Back to Home</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const passwordInput = document.querySelector('#password');
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>