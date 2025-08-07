<?php
session_start();

// Only show this page if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
<p>You are now logged in.</p>
<a href="logout.php">Logout</a>