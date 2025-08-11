<?php
session_start();
include 'config.php';

// Number of posts per page
$limit = 5; 

// Current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Search term
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Calculate offset
$start = ($page - 1) * $limit;

// Count total posts
$sqlCount = "SELECT COUNT(*) as total FROM posts WHERE title LIKE ? OR content LIKE ?";
$stmtCount = $conn->prepare($sqlCount);
$searchTerm = "%$search%";
$stmtCount->bind_param("ss", $searchTerm, $searchTerm);
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$totalRecords = $resultCount->fetch_assoc()['total'];
$stmtCount->close();

// Fetch posts for current page
$sql = "SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $start);
$stmt->execute();
$result = $stmt->get_result();

// Total pages
$totalPages = ceil($totalRecords / $limit);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<body>
<div class="container">
    <h2 class="mb-4">All Blog Posts</h2>

    <!-- Search Form -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <a href="create.php" class="btn btn-success mb-3">+ Create New Post</a>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <!-- Posts Table -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['content'], 0, 50)) . '...'; ?></td>
                    <td><?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No posts found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</body>
</html>