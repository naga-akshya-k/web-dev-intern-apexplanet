<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<p style='color:green; text-align:center;'>✅ Registered successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Registration failed: " . mysqli_error($conn) . "</p>";
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
background: #d3eef2;
background: linear-gradient(145deg, rgba(211, 238, 242, 1) 7%, rgba(211, 238, 242, 1) 42%, rgba(250, 240, 240, 1) 81%);
        }
        .form-container {
            margin: 100px auto;
            width: 350px;
            padding: 50px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px gray;
            text-align: center;
            background: #f9f9f9ff;
            position: absolute;
            top: 12%;
            left: 35%;
        }
        .form-container h2{
            color: black;
        }
        .form-container{
            background: transparent;
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
            font-size: 15px;
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
    </style>
</head>
<body>
<div class="form-container">
    <h2>Register</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Enter Username" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
