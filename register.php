<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    $sql = "INSERT INTO users (username, email, password, user_ip) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $user_ip);
    
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="login.php">Login</a>
</div>
<div class="container">
    <h1>Register</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <input type="submit" value="Register">
    </form>
</div>
</body>
</html>
