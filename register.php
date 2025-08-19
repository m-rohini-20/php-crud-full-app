<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Simple server-side validation
    if (empty($username) || empty($password)) {
    $error = "All fields are required.";
} 
elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters long.";
} 
elseif (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
    $error = "Password must contain at least one letter and one number.";
} 
else {
    // Check if username already exists
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username already taken!";
        } else {
            // Hash password before saving
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user with default role
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'editor')");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now log in.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Already have an account? <a href="login.php">Login</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>