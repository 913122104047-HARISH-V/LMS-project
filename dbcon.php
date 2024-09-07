<?php
$conn = new mysqli("localhost", "root", "", "library_database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>