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

// Base URL: root folder of the project (works on both localhost/XAMPP and live hosting)
// config.php always lives in the project root, so its own web path IS the base path.
// Example on XAMPP: /MiniProject2_Group/   |   Example on live hosting: /
$base_url = str_replace('config.php', '', $_SERVER['SCRIPT_NAME']);
if (strpos($_SERVER['SCRIPT_NAME'], 'config.php') === false) {
    // config.php was required from a page in a sub-folder (student/, staff/, includes/, ajax/)
    // so we work it out from the current script's folder depth instead.
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $base_url = preg_replace('#/(student|staff|includes|ajax)$#', '', $scriptDir);
}
$base_url = rtrim($base_url, '/') . '/';
