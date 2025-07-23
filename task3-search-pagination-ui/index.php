<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM posts WHERE (title LIKE '%$search%' OR content LIKE '%$search%') ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$count_query = "SELECT COUNT(*) AS total FROM posts WHERE (title LIKE '%$search%' OR content LIKE '%$search%')";
$count_result = mysqli_query($conn, $count_query);
$total = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total / $limit);
?><!DOCTYPE html><html>
<head>
    <title>Tech Blog - Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7fa;
        color: #333;
        margin: 0;
        padding: 0;
    }
    header {
        background: #343a40;
        padding: 20px;
        text-align: center;
        font-size: 28px;
        color: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .container {
        width: 90%;
        max-width: 900px;
        margin: 40px auto;
    }
    .top-links {
        text-align: center;
        margin-bottom: 30px;
    }
    .top-links a {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 30px;
        margin: 0 10px;
        transition: background 0.3s;
    }
    .top-links a:hover {
        background: #0056b3;
    }
    .top-links a.logout {
        background: #dc3545;
    }
    form {
        text-align: center;
        margin-bottom: 30px;
    }
    input[type="text"] {
        padding: 10px;
        width: 60%;
        border-radius: 30px;
        border: 1px solid #ccc;
        font-size: 16px;
    }
    button {
        padding: 10px 20px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 30px;
        font-size: 16px;
        cursor: pointer;
        margin-left: 10px;
    }
    button:hover {
        background: #218838;
    }
    .post {
        background: white;
        margin: 20px 0;
        padding: 25px;
        border-left: 6px solid #007bff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .post h2 {
        color: #007bff;
        margin: 0 0 10px;
    }
    .post p {
        line-height: 1.6;
        color: #555;
    }
    .post small {
        color: #777;
    }
    .actions {
        margin-top: 15px;
    }
    .actions a {
        display: inline-block;
        color: white;
        background: #17a2b8;
        padding: 6px 14px;
        margin-right: 10px;
        text-decoration: none;
        border-radius: 20px;
        font-size: 14px;
    }
    .actions a.delete {
        background: #e63946;
    }
    .pagination {
        text-align: center;
        margin-top: 40px;
    }
    .pagination a {
        margin: 0 5px;
        padding: 8px 14px;
        background: #e9ecef;
        border-radius: 20px;
        text-decoration: none;
        color: #333;
        transition: 0.3s;
    }
    .pagination a:hover {
        background: #007bff;
        color: white;
    }
</style>

</head>
<body><header>
    WELCOME TO MY BLOG !!
</header>
<div class="container">
    <div class="top-links">
        <a href="add_post.php">➕ Add New Post</a>
        <a href="logout.php" class="logout">Logout</a>
    </div><form method="GET" action="">
    <input type="text" name="search" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='post'>";
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>🕒 Posted on: " . $row['created_at'] . "</small>";
        echo "<div class='actions'>
                <a href='edit_post.php?id={$row['id']}'>✏ Edit</a>
                <a href='delete_post.php?id={$row['id']}' class='delete' onclick=\"return confirm('Are you sure?')\">🗑 Delete</a>
              </div>";
        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;'>No posts available. Add your first post! 🚀</p>";
}
?>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

</div></body>
</html>