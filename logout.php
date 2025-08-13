<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .logout-section {
            padding: 60px 0;
        }
        .logout-card {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">My Blog</a>
        <div>
            <a href="index.php" class="btn btn-outline-light btn-sm me-2">Home</a>
            <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="logout-section">
    <div class="container">
        <div class="logout-card">
            <h1 class="mb-3">You have been logged out</h1>
            <p class="lead">Thank you for visiting. You can log in again to continue.</p>
            <a href="login.php" class="btn btn-primary">Login Again</a>
            <a href="index.php" class="btn btn-outline-secondary">Go to Home</a>
        </div>
    </div>
</div>

</body>
</html>