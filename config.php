<?php
// Database connection (mysqli)

// Database settings
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student_consultation";

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
