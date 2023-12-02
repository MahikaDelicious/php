<?php
$servername = "localhost";

$dbname = "crud";

// Create connection
$conn = new mysqli($servername, $crud);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>