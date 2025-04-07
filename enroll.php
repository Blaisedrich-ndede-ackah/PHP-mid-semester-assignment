<?php
session_start();

include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];
    $student_id = $_SESSION['user_id'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
        $stmt->execute([$student_id, $course_id]);
    } catch (PDOException $e) {
        // This will catch duplicate enrollment attempts
    }
}

header("Location: dashboard.php");
exit();
?>