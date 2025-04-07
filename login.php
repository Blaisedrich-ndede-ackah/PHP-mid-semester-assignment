<?php
// Start session at the absolute beginning
session_start();

// Include configuration file
require 'config.php';

// Initialize variables
$errors = [];

// Process login if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // Only proceed if no validation errors
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid email or password";
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $errors[] = "A system error occurred. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TTU Course Registration</title>
    <style>
        :root {
            --ttu-blue: #003366;
            --ttu-gold: #FFCC00;
            --ttu-light: #F5F5F5;
            --ttu-dark: #1a1a1a;
            --ttu-error: #e74c3c;
            --ttu-success: #2ecc71;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--ttu-light);
            color: var(--ttu-dark);
            line-height: 1.6;
        }
        
        header {
            background-color: var(--ttu-blue);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            margin-bottom: 2rem;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 50px;
            margin-right: 15px;
        }
        
        .logo-text h1 {
            margin: 0;
            font-size: 1.3rem;
        }
        
        .logo-text p {
            margin: 0;
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .login-container {
            max-width: 500px;
            width: 90%;
            margin: 0 auto 3rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: var(--ttu-blue);
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #666;
            margin-top: 0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--ttu-blue);
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--ttu-gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.2);
        }
        
        .btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--ttu-blue);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .btn:hover {
            background-color: #002244;
            transform: translateY(-2px);
        }
        
        .error-container {
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: #fde8e8;
            border-left: 4px solid var(--ttu-error);
            border-radius: 4px;
        }
        
        .error {
            color: var(--ttu-error);
            margin: 0;
            font-size: 0.9rem;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        
        .form-footer a {
            color: var(--ttu-blue);
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
            color: #002244;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: -1rem;
            margin-bottom: 1.5rem;
        }
        
        .forgot-password a {
            color: #666;
            font-size: 0.85rem;
            text-decoration: none;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
            color: var(--ttu-blue);
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }
            
            .logo {
                margin-bottom: 15px;
                justify-content: center;
            }
            
            .login-container {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 1.25rem;
                width: 95%;
            }
            
            input[type="email"],
            input[type="password"],
            .btn {
                padding: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="ttulogo.png" alt="TTU Logo">
                <div class="logo-text">
                    <h1>Takoradi Technical University</h1>
                </div>
            </div>
        </div>
    </header>
    
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Login to access your dashboard</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <?php foreach ($errors as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" novalidate>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <div class="forgot-password">
                    <a href="forgot-password.php">Forgot password?</a>
                </div>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div class="form-footer">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>