<?php
// Database connection (mysqli)

// Detect environment: local (XAMPP) or live (InfinityFree hosting)
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    // Local settings (XAMPP)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "student_consultation";
} else {
    // Live settings (InfinityFree hosting)
    $host = "sql307.infinityfree.com";
    $user = "if0_42974973";
    $pass = "raziq0397";
    $dbname = "if0_42974973_student_consultation";
}

// Connect to database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
