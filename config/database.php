<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP/WAMP
$dbname = "hospital_billing";

// Create a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$base_url = '/CBS/'; // Adjust based on your folder structure


?>
