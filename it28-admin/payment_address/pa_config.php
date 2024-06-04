<?php
// Database configuration
$servername = "localhost";
$username = "u593341949_dev_cagabcabon";
$password = "20221651Cagabcabon";
$database = "u593341949_db_cagabcabon";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
