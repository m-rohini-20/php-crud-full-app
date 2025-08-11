<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<?php
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<h2 class="mb-4">📝 All Blog Posts</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo "<h4 class='card-title'>" . htmlspecialchars($row['title']) . "</h4>";
        echo "<p class='card-text'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small class='text-muted'>Posted on: " . $row['created_at'] . "</small><br><br>";
        echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>📝 Edit</a> ";
        echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure?');\">🗑️ Delete</a>";
        echo '</div></div>';
    }
} else {
    echo "<p>No posts found.</p>";
}
?>
<a href='create.php' class="btn btn-success">➕ Create New Post</a>
</body>
</html>
