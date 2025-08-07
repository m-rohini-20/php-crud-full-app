<?php
$conn = new mysqli("localhost", "root", "", "blog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect after success to avoid resubmission
        header("Location: register.php?success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Registration successful!</p>
<?php endif; ?>

<form method="post" action="">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="text" name="password" required><br><br>
    <input type="submit" value="Register">
</form>