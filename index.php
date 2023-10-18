<?php
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Image Upload Service</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <?php if (!isset($_SESSION['username'])) { ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php } else { ?>
        <a href="logout.php">Log Out</a>
    <?php } ?>
</div>
<div class="container">
    <div id="header">
        <h1>Image Upload Service</h1>
    </div>
    <div id="main-content">
        <?php
        if (isset($_SESSION['username'])) {
            echo "Connected as " . $_SESSION['username'];
        } else if ($authentication_required) {
            header("Location: login.php");
            exit;
        }
        ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
</div>
</body>
</html>
