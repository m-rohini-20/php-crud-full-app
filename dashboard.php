<?php
session_start();
include 'config.php';

// ✅ Protect page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ✅ Pagination settings
$posts_per_page = 5; // how many posts per page

// Get current page from URL, default = 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// ✅ Search
$search = "";
$where = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
}

// ✅ Count total posts (for pagination)
$count_query = "SELECT COUNT(*) AS total FROM posts $where";
$count_result = mysqli_query($conn, $count_query);
$total_posts = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// ✅ Fetch posts for current page
$query = "SELECT * FROM posts $where ORDER BY created_at DESC LIMIT $offset, $posts_per_page";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        padding-top: 60px;
        background-color: #f8f9fa;
    }
    .container {
        max-width: 900px;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }
    .btn {
        margin-right: 5px;
    }
    table tbody tr:hover {
        background-color: #f1f1f1;
    }
    .pagination {
        justify-content: center;
    }
</style>
</head>
<body class="bg-light">

<!-- Header -->
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <span class="navbar-brand">My Blog Dashboard</span>
        <div class="text-white">
            Welcome, <?php echo $_SESSION['username']; ?> | 
            <a href="logout.php" class="text-white text-decoration-none">Logout</a>
        </div>
    </div>
</nav>

<div class="container bg-white p-4 rounded shadow-sm">
    <div class="d-flex justify-content-between mb-3">
        <a href="create.php" class="btn btn-success">+ Create New Post</a>
        <form class="d-flex" method="GET" action="dashboard.php">
            <input class="form-control me-2" type="text" name="search" placeholder="Search posts..."
                   value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>

    <!-- Posts Table -->
    <table class="table table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars(substr($row['content'], 0, 50)) . '...'; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Are you sure?')" 
                       class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- ✅ Pagination Links -->
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>