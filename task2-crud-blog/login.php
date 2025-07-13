<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>❌ Invalid password</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>❌ User not found</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial;
            background: #9b999aff;
        }
        .form-container {
            margin: 100px auto;
            width: 350px;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px gray;
            text-align: center;
            position: absolute;
            top: 12%;
            left: 35%;
        }
        .form-container{
            background:transparent;
            backdrop-filter: blur(8px);
        }
        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 20px;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid gray;
            height: 20px;
        }
        button {
            margin-top: 10px;
            padding: 15px 20px;
            background-color: #28a745; /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
            color:yellow; /* Darker green */
        }
        input::placeholder{
            color: blue;
        }
        input:focus{
            outline: none;
            border:2px solid #c42268ff;
        }
        h2{
            color:whitesmoke;
            font-size: 30px;
        }
        img{
            width: 100%;
            height: 100vh;
            background-position: bottom;
            background-size: cover;
        }
    </style>
</head>
<body>
<div>
    <img src="crud.jpg">
</div>
<div class="form-container">
    <h2>Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Enter Username" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>