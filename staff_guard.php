<?php
// Allow only logged-in Staff
// Require config.php (starts session) before this file

// Not logged in -> go to login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Logged in but not staff -> send to student dashboard
if ($_SESSION['role'] !== 'staff') {
    header("Location: student_dashboard.php");
    exit;
}
