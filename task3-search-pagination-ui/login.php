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
            $error = "❌ Invalid password";
        }
    } else {
        $error = "❌ User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tech Blog - Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
           background: #d3eef2;
background: linear-gradient(145deg, rgba(211, 238, 242, 1) 7%, rgba(211, 238, 242, 1) 42%, rgba(250, 240, 240, 1) 81%);
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 400px;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(15px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #120e0eff;
        }

        .login-card input[type="text"],
        .login-card input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            outline: none;
            background: #ffffff10;
            color: black;
            border: 1px solid black;
        }

        .login-card input::placeholder {
            color: black;
        }

        .login-card button {
            width: 45%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            margin-left: 27%;
            border-radius: 8px;
            background-color: #1e90ff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .login-card button:hover {
            background-color: #0078d4;
        }

        .error {
            color: #ff6b6b;
            text-align: center;
        }

        .create {
            text-align: center;
            margin-top: 10px;
        }

        .create a {
            color: #ccc;
            text-decoration: none;
        }

        .create a:hover {
            color: black;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>SIGN IN</h2>
    
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required >
        <button type="submit">LOGIN NOW</button>
    </form>
    <div class="create">
        <p><a href="register.php">Create new account</a></p>
    </div>
</div>

</body>
</html>