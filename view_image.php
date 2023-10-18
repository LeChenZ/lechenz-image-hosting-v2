<?php
session_start();
include 'config.php';

if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];

    $sql = "SELECT username FROM uploaded_files WHERE filename = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filename);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        $username = "Unknown";
    }
} else {
    $filename = "";
    $username = "Unknown";
}

$imageLink = $upload_folder . $filename;
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>View Image</title>
    <link rel="stylesheet" type="text/css" href="upload.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <style>
        .copy-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .center {
            display: block;
            margin: 0 auto;
            text-align: center;
        }

        .copy-button:hover {
            background-color: #45a049;
        }

        #imageLink {
            display: none;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <?php if (isset($_SESSION['username'])) : ?>
        <a href="logout.php">Logout</a>
    <?php else : ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>
<div class="container">
    <h1>Uploaded Image</h1>
    <?php
    if (!empty($filename)) {
        $imageLink = "https://" . $_SERVER['HTTP_HOST'] . "/" . $upload_folder . $filename;
        echo "<img src='" . $upload_folder . $filename . "' alt='Uploaded Image' style='max-width: 100%;'>";
        echo "<p>Uploaded by: " . $username . "</p>";
        echo "<input type='text' value='$imageLink' id='imageLink' readonly>";
        echo "<button class='copy-button center' id='copyButton'>Copy Image Link</button>";
    } else {
        echo "Image not found.";
    }
    ?>
</div>

<script>
    var copyButton = document.getElementById('copyButton');
    var imageUrl = "<?php echo $imageLink; ?>"; 

    var clipboard = new ClipboardJS(copyButton, {
        text: function() {
            return imageUrl;
        }
    });

    clipboard.on('success', function(e) {
        alert('Image link copied to clipboard: ' + e.text);
    });

    clipboard.on('error', function(e) {
        alert('Failed to copy image link.');
    });
</script>
</body>
</html>
