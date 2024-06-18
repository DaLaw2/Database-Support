<?php
include 'connection.php';

$conn = getDatabaseConnection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";