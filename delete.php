<?php
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"] ?? null;

if ($id) {
    $sql = "DELETE FROM posts WHERE id=$id";
    $conn->query($sql);
}

header("Location: posts.php");
exit();