<?php
require 'config.php';

// If already logged in, go to correct dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'staff') {
        header("Location: staff_dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }
    exit;
}

$message = "";

// Handle register form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Server-side validation
    if ($name === "" || $email === "" || $password === "") {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        // Check if email already exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "Email is already registered.";
        } else {
            // Hash password and insert new student
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = "student";

            $insert = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert, "ssss", $name, $email, $hash, $role);

            if (mysqli_stmt_execute($insert)) {
                $message = "Registration successful. You can now login.";
            } else {
                $message = "Something went wrong. Please try again.";
            }
        }
    }
}

include 'header.php';
?>

<div class="auth-card">
    <h1 class="auth-title">Create account</h1>
    <p class="auth-sub">Register as a student to book consultations.</p>

    <?php if ($message !== ""): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php" onsubmit="return validateRegister(this);">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Your full name">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="you@example.com">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Create a password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <p class="auth-alt">Already have an account? <a href="index.php">Login</a></p>
</div>

<?php include 'footer.php'; ?>
