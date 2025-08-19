<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ✅ Allow only admin to edit posts
if ($_SESSION['role'] != 'admin') {
    echo "<script>alert('Access denied! Only admin can edit posts.'); 
    window.location='dashboard.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<?php
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"] ?? null;

if ($id) {
    // Handle update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $conn->real_escape_string($_POST["title"]);
        $content = $conn->real_escape_string($_POST["content"]);

        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);

        if ($stmt->execute()) {
         echo "<p style='color:green;'>Post updated successfully!</p>";
        }
         else {
             echo "Error: " . $stmt->error;
        }

$stmt->close();

        header("Location: posts.php");
        exit();
    }

    // Show current post data
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows === 0) {
        echo "Post not found.";
        exit();
    }

    $row = $result->fetch_assoc();
} else {
    echo "Invalid post ID.";
    exit();
}
?>

<h2 class="mb-4">📝 Edit Blog Post</h2>

<form method="post" action="">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" rows="5" class="form-control" required><?= htmlspecialchars($row['content']) ?></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<p class="mt-3">
    <a href="posts.php" class="btn btn-secondary">← Back to Posts</a>
</p>

<p><a href='posts.php'>← Back to Posts</a></p>
</body>
</html>