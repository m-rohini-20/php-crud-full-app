<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Blog - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .welcome-section {
            padding: 60px 0;
        }
        .welcome-card {
            max-width: 600px;
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
            <?php if (!empty($_SESSION['username'])) { ?>
                <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-outline-light btn-sm me-2">Login</a>
                <a href="register.php" class="btn btn-outline-light btn-sm">Register</a>
            <?php } ?>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="welcome-section">
    <div class="container">
        <div class="welcome-card">
            <h1 class="mb-3">Welcome to My Blog</h1>
            <p class="lead">This is a simple blog application built using PHP & MySQL with CRUD functionality, search, and pagination.</p>
            <?php if (!empty($_SESSION['username'])) { ?>
                <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-success">Login</a>
                <a href="register.php" class="btn btn-outline-primary">Register</a>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>