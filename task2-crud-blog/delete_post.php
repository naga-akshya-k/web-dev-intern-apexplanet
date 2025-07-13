<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<p style='color:red; text-align:center;'>❌ No post ID provided.</p>";
    exit();
}

$post_id = $_GET['id'];

// Delete the post
$query = "DELETE FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<p style='color:black;text-align:center;'>✅ Post deleted successfully.</p>";
    header("Refresh:1; url=index.php");
} else {
    echo "<p style='color:red; text-align:center;'>❌ Post not found or already deleted.</p>";
}
?>