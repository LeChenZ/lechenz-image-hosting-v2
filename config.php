<?php
// Configuration settings for the image upload service
$max_file_size = 52428800;  // 50MB in bytes
$upload_folder = 'uploads/';

// Database configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "imageservice";

// Must be logged in to upload a file
$authentication_required = true;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
