<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - TTU Course Registration</title>
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
        
        .password-container {
            max-width: 500px;
            width: 90%;
            margin: 0 auto 3rem;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .password-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .password-header h2 {
            color: var(--ttu-blue);
            margin-bottom: 0.5rem;
        }
        
        .password-header p {
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
        
        input[type="email"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        input[type="email"]:focus {
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
        
        .message-container {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            text-align: center;
        }
        
        .error {
            background-color: #fde8e8;
            border-left: 4px solid var(--ttu-error);
            color: var(--ttu-error);
        }
        
        .success {
            background-color: #e8f8f0;
            border-left: 4px solid var(--ttu-success);
            color: var(--ttu-success);
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
        
        /* Popup Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .modal-content h3 {
            color: var(--ttu-blue);
            margin-top: 0;
        }
        
        .modal-btn {
            padding: 0.75rem 1.5rem;
            background-color: var(--ttu-blue);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1rem;
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
            
            .password-container {
                padding: 1.5rem;
            }
            
            .modal-content {
                margin: 30% auto;
                width: 90%;
            }
        }
        
        @media (max-width: 480px) {
            .password-container {
                padding: 1.25rem;
                width: 95%;
            }
            
            input[type="email"],
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
    
    <div class="password-container">
        <div class="password-header">
            <h2>Reset Your Password</h2>
            <p>Enter your email address to request password reset</p>
        </div>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            
            // Validate email
            if (empty($email)) {
                $error = "Email address is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address";
            } else {
                // Show the popup modal
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("passwordModal").style.display = "block";
                    });
                </script>';
                
            }
        }
        ?>
        
        <?php if (isset($error)): ?>
            <div class="message-container error">
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>
        
        <form method="post" id="resetForm">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit" class="btn">Request Password Reset</button>
        </form>
        
        <div class="form-footer">
            Remember your password? <a href="login.php">Login here</a>
        </div>
    </div>
    
    <!-- Popup Modal -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
        <h3>Password Reset Request Submitted.</h3>
<p>Your request to reset your password has been received, though it's hard to believe you actually care enough to follow through.</p>
<p>If you're even remotely serious about this, go bother your Head of Department with your index number. They might help, but don’t expect them to drop everything for you.</p>
            <button class="modal-btn" onclick="redirectToIndex()">OK</button>
        </div>
    </div>
    
    <script>
        function redirectToIndex() {
            // Close the modal
            document.getElementById("passwordModal").style.display = "none";
            // Redirect to index.php
            window.location.href = "index.php";
        }
        
        // Close modal if clicked outside
        window.onclick = function(event) {
            const modal = document.getElementById("passwordModal");
            if (event.target == modal) {
                modal.style.display = "none";
                window.location.href = "index.php";
            }
        }
    </script>
</body>
</html>