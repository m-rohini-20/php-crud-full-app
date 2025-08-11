<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check user in database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["username"] = $username;
        header("Location: dashboard.php"); // we'll create this later
        exit();
    } else {
        echo "<p style='color:red;'>Invalid login details.</p>";
    }
}
?>

<h2>Login</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="text" name="password" required><br><br>
    <input type="submit" value="Login">
</form>