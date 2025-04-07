<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TTU Course Registration</title>
    <style>
        :root {
            --ttu-blue: #003366;
            --ttu-gold: #FFCC00;
            --ttu-light: #F5F5F5;
            --ttu-dark: #1a1a1a;
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
        
        .registration-container {
            max-width: 500px;
            width: 90%;
            margin: 0 auto 3rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .registration-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .registration-header h2 {
            color: var(--ttu-blue);
            margin-bottom: 0.5rem;
        }
        
        .registration-header p {
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
        
        input[type="text"],
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
        
        input[type="text"]:focus,
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
        
        .error {
            display: block;
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            padding: 0.75rem;
            background-color: #fde8e8;
            border-radius: 4px;
            margin-bottom: 1rem;
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
        
        .password-hint {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.25rem;
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
            
            .registration-container {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .registration-container {
                padding: 1.25rem;
                width: 95%;
            }
            
            input[type="text"],
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
                <!-- TTU Logo - replace with actual logo if available -->
                <img src="ttulogo.png" alt="TTU Logo">
                <div class="logo-text">
                    <h1>Takoradi Technical University</h1>
                </div>
            </div>
        </div>
    </header>
    
    <div class="registration-container">
        <div class="registration-header">
            <h2>Create Your Account</h2>
            <p>Register to access the course registration system</p>
        </div>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            $errors = [];
            
            if (empty($name)) $errors[] = "Name is required";
            if (empty($email)) $errors[] = "Email is required";
            if (empty($password)) $errors[] = "Password is required";
            if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
            
            if (empty($errors)) {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                
                if ($stmt->rowCount() > 0) {
                    $errors[] = "Email already exists";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                    $stmt->execute([$name, $email, $hashed_password]);
                    
                    $_SESSION['user_id'] = $pdo->lastInsertId();
                    $_SESSION['user_name'] = $name;
                    header("Location: dashboard.php");
                    exit();
                }
            }
        }
        ?>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <p class="password-hint">Must be at least 6 characters</p>
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
        
        <div class="form-footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>