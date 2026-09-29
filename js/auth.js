// Authentication JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Login Form
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const role = document.getElementById('role').value;
            
            // Basic validation
            if (!username || !password || !role) {
                showMessage('error', 'Please fill in all fields', 'loginMessage');
                return;
            }
            
            // Simulate API call (in real app, this would be a fetch request)
            const loginData = {
                username: username,
                password: password,
                role: role
            };
            
            // Store in localStorage for demo (in real app, use proper session management)
            localStorage.setItem('currentUser', JSON.stringify({
                username: username,
                role: role,
                timestamp: new Date().getTime()
            }));
            
            // Redirect based on role
            setTimeout(() => {
                switch(role) {
                    case 'system_admin':
                        window.location.href = 'admin/index.php';
                        break;
                    case 'lab_assistant':
                        window.location.href = 'lab-assistant/index.php';
                        break;
                    case 'department_head':
                        window.location.href = 'department-head/index.php';
                        break;
                    case 'user':
                        window.location.href = 'user/index.php';
                        break;
                    case 'store_manager':
                        window.location.href = 'store-manager/index.php';
                        break;
                    default:
                        window.location.href = 'dashboard.php';
                }
            }, 1000);
            
            showMessage('success', 'Login successful! Redirecting...', 'loginMessage');
        });
    }
    
    // Registration Form
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const formData = {
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                username: document.getElementById('username').value,
                phone: document.getElementById('phone').value,
                password: document.getElementById('password').value,
                confirmPassword: document.getElementById('confirmPassword').value,
                department: document.getElementById('department').value,
                role: document.getElementById('role').value
            };
            
            // Validation
            if (formData.password !== formData.confirmPassword) {
                showMessage('error', 'Passwords do not match!', 'registerMessage');
                return;
            }
            
            if (formData.password.length < 6) {
                showMessage('error', 'Password must be at least 6 characters long', 'registerMessage');
                return;
            }
            
            // Check if terms are agreed
            const terms = document.querySelector('input[name="terms"]');
            if (!terms.checked) {
                showMessage('error', 'You must agree to the terms and conditions', 'registerMessage');
                return;
            }
            
            // Simulate registration (in real app, this would be a fetch request)
            const users = JSON.parse(localStorage.getItem('users') || '[]');
            
            // Check if username exists
            const usernameExists = users.some(user => user.username === formData.username);
            if (usernameExists) {
                showMessage('error', 'Username already exists!', 'registerMessage');
                return;
            }
            
            // Add new user
            users.push({
                id: users.length + 1,
                ...formData,
                created_at: new Date().toISOString(),
                is_active: true
            });
            
            localStorage.setItem('users', JSON.stringify(users));
            
            showMessage('success', 'Registration successful! Redirecting to login...', 'registerMessage');
            
            // Redirect to login after 2 seconds
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 2000);
        });
    }
    
    // Forgot Password Form
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const role = document.getElementById('role').value;
            
            if (!email || !role) {
                showMessage('error', 'Please fill in all fields', 'forgotPasswordMessage');
                return;
            }
            
            // Simulate password reset request
            showMessage('success', 'Password reset link sent to your email!', 'forgotPasswordMessage');
            
            // Reset form
            forgotPasswordForm.reset();
            
            // Redirect to login after 3 seconds
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 3000);
        });
    }
});

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}

// Show password strength indicator
function updatePasswordStrength(password) {
    const strength = checkPasswordStrength(password);
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');
    
    if (strengthBar && strengthText) {
        const width = (strength / 5) * 100;
        strengthBar.style.width = width + '%';
        
        if (strength <= 2) {
            strengthBar.style.backgroundColor = '#e74c3c';
            strengthText.textContent = 'Weak';
        } else if (strength <= 3) {
            strengthBar.style.backgroundColor = '#f39c12';
            strengthText.textContent = 'Medium';
        } else {
            strengthBar.style.backgroundColor = '#27ae60';
            strengthText.textContent = 'Strong';
        }
    }
}

// Initialize password strength checker if on registration page
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            updatePasswordStrength(this.value);
        });
    }
});