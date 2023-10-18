<?php
session_start();
include 'config.php';
$loggedIn = false;
$username = "Unknown";

if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $randomFileName = generateRandomString() . '.' . $imageFileType;
    $target_file = $upload_folder . $randomFileName;

// Check file size
    if ($_FILES["fileToUpload"]["size"] > $max_file_size) {
        echo "Sorry, your file is too large.";
        exit;
    }

// Authorise certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG and GIF files are allowed.";
        exit;
    }

// Move the downloaded file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
// Insert information from the file into the database
        $sql = "INSERT INTO uploaded_files (username, filename, upload_date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $randomFileName);
        if ($stmt->execute()) {
// Redirect to the uploaded image page
            header("Location: view_image.php?filename=" . $randomFileName);
            exit;
        } else {
            echo "Sorry, there was an error uploading your file to the database.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Upload Image</title>
    <link rel="stylesheet" type="text/css" href="upload.css">
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <?php if ($loggedIn) : ?>
        <a href="logout.php">Logout</a>
    <?php else : ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>

<div class="container">
    <h1>Upload Image</h1>
    <p><?php echo "Connecté en tant que: " . $username; ?></p>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileToUpload">Choose an image to download</label>
            <input type="file" name="fileToUpload" id="fileToUpload" required>
        </div>
        <input type="submit" value="Télécharger">
    </form>
</div>
</body>
</html>
