<?php
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ✅ Allow only admin to delete posts
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied! Only admin can delete posts.'); 
          window.location='dashboard.php';</script>";
    exit();
}

// ✅ Database connection
$conn = new mysqli("localhost", "root", "", "blog");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Delete post using prepared statement
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>