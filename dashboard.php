<?php 
// Start session at the beginning
session_start();

include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get available courses
$courses = $pdo->query("SELECT * FROM courses")->fetchAll();

// Get enrolled courses
$enrolled_courses = $pdo->prepare("
    SELECT c.* FROM courses c
    JOIN enrollments e ON c.id = e.course_id
    WHERE e.student_id = ?
");
$enrolled_courses->execute([$_SESSION['user_id']]);
$enrolled_courses = $enrolled_courses->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TTU Course Registration</title>
    <style>
        :root {
            --ttu-blue: #003366;
            --ttu-gold: #FFCC00;
            --ttu-light: #F5F5F5;
            --ttu-dark: #1a1a1a;
            --ttu-success: #4CAF50;
            --ttu-danger: #f44336;
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
            justify-content: space-between;
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
        
        .user-welcome {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-welcome p {
            margin: 0;
            font-weight: 600;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-logout {
            background-color: var(--ttu-danger);
            color: white;
            border: none;
        }
        
        .btn-logout:hover {
            background-color: #d32f2f;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 3rem;
        }
        
        .section-title {
            color: var(--ttu-blue);
            border-bottom: 2px solid var(--ttu-gold);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 3rem;
        }
        
        .course-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
        }
        
        .course-card.enrolled {
            border-left: 4px solid var(--ttu-success);
        }
        
        .course-card h3 {
            margin-top: 0;
            color: var(--ttu-blue);
        }
        
        .course-actions {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
        }
        
        .btn-enroll {
            background-color: var(--ttu-blue);
            color: white;
            border: none;
        }
        
        .btn-unenroll {
            background-color: var(--ttu-danger);
            color: white;
            border: none;
        }
        
        .btn-enroll:hover, .btn-unenroll:hover {
            opacity: 0.9;
        }
        
        .enrolled-list {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .enrolled-list ul {
            list-style: none;
            padding: 0;
        }
        
        .enrolled-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .enrolled-list li:last-child {
            border-bottom: none;
        }
        
        .no-courses {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            color: #666;
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .user-welcome {
                flex-direction: column;
                gap: 10px;
            }
            
            .course-grid {
                grid-template-columns: 1fr;
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
            <div class="user-welcome">
                <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>
        </div>
    </header>
    
    <div class="dashboard-container">
        <h2 class="section-title">Available Courses</h2>
        <div class="course-grid">
            <?php foreach ($courses as $course): ?>
                <?php 
                $is_enrolled = in_array($course['id'], array_column($enrolled_courses, 'id'));
                ?>
                <div class="course-card <?= $is_enrolled ? 'enrolled' : '' ?>">
                    <h3><?= htmlspecialchars($course['course_name']) ?></h3>
                    <p><?= htmlspecialchars($course['description']) ?></p>
                    <div class="course-actions">
                        <?php if ($is_enrolled): ?>
                            <form action="unenroll.php" method="post">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-unenroll">Unenroll</button>
                            </form>
                        <?php else: ?>
                            <form action="enroll.php" method="post">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-enroll">Enroll</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <h2 class="section-title">Your Enrolled Courses</h2>
        <?php if (empty($enrolled_courses)): ?>
            <div class="no-courses">
                <p>You haven't enrolled in any courses yet.</p>
            </div>
        <?php else: ?>
            <div class="enrolled-list">
                <ul>
                    <?php foreach ($enrolled_courses as $course): ?>
                        <li><?= htmlspecialchars($course['course_name']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>