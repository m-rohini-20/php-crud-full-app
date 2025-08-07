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

$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $content = $conn->real_escape_string($_POST["content"]);

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Post created successfully!</p>";
    } else {
        echo "Error: " . $conn->error;
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