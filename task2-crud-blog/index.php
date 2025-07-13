<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch posts
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tech Blog - Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            margin: 0;
            padding: 0;
        }
        header {
            background: #1e90ff;
            padding: 20px;
            text-align: center;
            font-size: 28px;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .container {
            width: 80%;
            margin: 40px auto;
        }
        .top-links {
            text-align: center;
            margin-bottom: 20px;
        }
        .top-links a {
            background: #28a745;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 10px;
        }
        .top-links a.logout {
            background: #dc3545;
        }
        .post {
            background: #ffffff11;
            margin: 20px 0;
            padding: 20px;
            border-left: 5px solid #00bcd4;
            border-radius: 8px;
        }
        .post h2 {
            color: #00ffe0;
        }
        .post p {
            color: #f1f1f1;
        }
        .actions {
            margin-top: 10px;
        }
        .actions a {
            color: #ffffff;
            background: #17a2b8;
            padding: 5px 10px;
            margin-right: 8px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .actions a.delete {
            background: #e63946;
        }
    </style>
</head>
<body>

<header>
    WELCOME TO MY BLOG !!
</header>
<div class="container">
    <div class="top-links">
        <a href="add_post.php">➕ Add New Post</a>
        <a href="logout.php" class="logout"> Logout</a>
    </div>

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
</div>

</body>
</html>