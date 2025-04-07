<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTU Course Registration System</title>
    <style>
        :root {
            --ttu-blue:rgb(0, 51, 102);
            --ttu-gold: #FFCC00;
            --ttu-light: #F5F5F5;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--ttu-light);
            color: #333;
        }
        
        header {
            background-color: var(--ttu-blue);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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
            height: 60px;
            margin-right: 15px;
        }
        
        .logo-text h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .logo-text p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .hero {
            background: linear-gradient(rgba(0, 51, 102, 0.79), rgba(33, 98, 163, 0.9)), 
                        url('ttulogo.png');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 20px;
            text-align: center;
        }
        
        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--ttu-gold);
            color: var(--ttu-blue);
        }
        
        .btn-primary:hover {
            background-color: #e6b800;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        .features {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 20px;
        }
        
        .features h3 {
            text-align: center;
            color: var(--ttu-blue);
            font-size: 2rem;
            margin-bottom: 2rem;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-card h4 {
            color: var(--ttu-blue);
            margin-top: 0;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--ttu-gold);
            margin-bottom: 15px;
        }
        
        footer {
            background-color: var(--ttu-blue);
            color: white;
            text-align: center;
            padding: 2rem 20px;
            margin-top: 3rem;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 1rem;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
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
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <!-- Placeholder for TTU logo - replace with actual logo if available -->
                <img src="ttulogo.png" alt="TTU Logo">
                <div class="logo-text">
                    <h1>Takoradi Technical University</h1>
                </div>
            </div>
        </div>
    </header>
    
    <section class="hero">
  
        <h2>Welcome to TTU Course Registration</h2>
        <p>DEPARTMENT OF COMPUTER SCIENCE <br>
MIDSEM ASSIGNMENT 
ADVANCED WEB TECH – BTECH REGULAR <br> 
FIRST SEMESTER 2024/2025 <br><strong>BlaisedRich Ndede Ackah (BC/ITS/23/014)</strong> <br>Register for your courses online with our easy-to-use platform. Manage your academic journey with just a few clicks.</p>
        
        <div class="cta-buttons">
            <a href="register.php" class="btn btn-primary">Create Account</a>
            <a href="login.php" class="btn btn-secondary">Student Login</a>
        </div>
    </section>
    
    <section class="features">
        <h3>Why Use Our System?</h3>
        
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h4>Easy Course Selection</h4>
                <p>Browse and select from all available courses offered by Takoradi Technical University with detailed descriptions.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h4>Real-time Updates</h4>
                <p>See your enrolled courses immediately and make changes to your schedule as needed.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h4>Secure Access</h4>
                <p>Your personal and academic information is protected with our secure login system.</p>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-links">
            <a href="https://ttu.edu.gh">TTU Website</a>
            <a href="#">Help Center</a>
            <a href="#">Contact Support</a>
        </div>
        <p>&copy; <?php echo date('Y'); ?> Takoradi Technical University. All rights reserved.</p>
    </footer>
</body>
</html>