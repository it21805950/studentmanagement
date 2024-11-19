<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "computer_diploma_institute";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
