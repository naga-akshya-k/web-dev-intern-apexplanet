<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "<p style='color:red; text-align:center;'>❌ No post ID provided.</p>";
    exit();
}

$post_id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) == 1) {
    $post = mysqli_fetch_assoc($result);
} else {
    echo "<p style='color:red; text-align:center;'>❌ Post not found.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = trim($_POST['title']);
    $new_content = trim($_POST['content']);

    if (!empty($new_title) && !empty($new_content)) {
        $update = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, "ssi", $new_title, $new_content, $post_id);
        mysqli_stmt_execute($stmt);

        echo "<p style='color:white; text-align:center;'>✅ Post updated!</p>";
        header("Refresh:1; url=index.php");
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Title and content cannot be empty.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<style>
    *{
        font-family: 'Courier New', Courier, monospace;
    }
    body{
        width: 100%;
        height: 85vmin;
        background: #090979;
background: linear-gradient(145deg, rgba(9, 9, 121, 1) 42%, rgba(34, 116, 230, 1) 81%);
 }
 div{
    background: #2f2fd3ff;
    backdrop-filter: blur(4px);
    width:900px;
    height: 500px;
    margin-left: 20%;
    margin-top: 5%;
    border-radius: 20px;
 }
 div h2{
    color:white;
    font-size: 30px;
    padding-top: 40px;
 }
 label{
    color: goldenrod;
    font-size:30px;
    font-weight: 600;
 }
 input{
    width: 70%;
    height: 40px;
    border-radius: 10px;
 }
 input[type="text"]{
    font-size: 20px;
 }
textarea{
    width: 50%;
    font-size: 20px;
    border-radius: 10px;
}
textarea:focus{
    outline: none;
}
button{
    background-color: yellowgreen;
    color:white;
    padding: 15px 25px;
    border-radius: 10px;
    border: 1px solid black;
    font-size: 20px;
}
input:focus{
    outline: none;
}
</style>
<body>
    <div>
    <h2 style="text-align:center;">Edit Post</h2>
    <form method="POST" style="text-align:center;">
        <label for="">Title:</label><input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>
        <label for="">Content:</label>
        <br>
        <textarea name="content" rows="5" cols="40" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
        <button type="submit">Update</button>
    </form>
    </div>
</body>
</html>