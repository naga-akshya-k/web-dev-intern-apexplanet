<?php
include 'db.php';
include 'session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {
        $query = "INSERT INTO posts (title, content, created_at) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $title, $content);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<p style='color:black; text-align:center;'>✅ Post added successfully!</p>";
            header("Refresh:1; url=index.php");
        } else {
            echo "<p style='color:red; text-align:center;'>❌ Failed to add post.</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Title and Content cannot be empty.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<style>
     *{
        font-family: 'Courier New', Courier, monospace;
    }
    body{
        width: 100%;
        height: 85vmin;
        background: url("intern.jpg");
 }
 div{
    background-color: rgba(red, green, blue, alpha);
    backdrop-filter: blur(9px);
    width:900px;
    height: 500px;
    margin-left: 20%;
    margin-top: 5%;
    border-radius: 20px;
    
    
 }
 div h2{
    color:blue;
    font-size: 30px;
    padding-top: 40px;
 }
 label{
    color: blue;
    font-size:30px;
    font-weight: 600;
 }
 input{
    width: 67%;
    height: 40px;
    border-radius: 10px;
 }
 input[type="text"]{
    font-size: 20px;
 }
textarea{
    width: 52%;
    font-size: 20px;
    border-radius: 10px;
}
textarea:focus{
    outline: none;
}
button{
    background-color: green;
    color:aliceblue;
    font-style:normal;
    padding: 15px 25px;
    border-radius: 15px;
    border: 1px solid black;
    font-size: 20px;
    cursor: pointer;
}
input:focus{
    outline: none;
}
</style>
<body>
    <div>
    <h2 style="text-align:center;">Add New Post</h2>
    <form method="POST" action="" style="text-align:center;">
        <label for="">Title:</label><input type="text" name="title" placeholder="Title" required><br><br>
        <label for="">Content:</label>
        <br>
        <textarea name="content" placeholder="Content" rows="5" cols="40" required></textarea><br><br>
        <button type="submit">Submit</button>
    </form>
    </div>
</body>
</html>