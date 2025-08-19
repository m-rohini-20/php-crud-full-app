<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied! Only admin can create posts.'); window.location='dashboard.php';</script>";
    exit();
}

$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || empty($content)) {
        echo "<p style='color:red;'>Title and Content cannot be empty!</p>";
    } else {
    
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Post created successfully!</p>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<h2>Create New Post</h2>
<h2 class="mb-4">➕ Create New Blog Post</h2>

<form method="post" action="">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" rows="5" class="form-control" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Post</button>
</form>

<p class="mt-3">
    <a href="posts.php" class="btn btn-secondary">← Back to Posts</a>
</p>

<p><a href="dashboard.php">Back to Dashboard</a></p>
</<body>
</html>