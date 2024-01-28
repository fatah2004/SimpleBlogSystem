<?php
$servername = "localhost";
$username = "root";  // your MySQL username
$password = "";      // your MySQL password, leave it empty if you don't have one
$dbname = "simple_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
