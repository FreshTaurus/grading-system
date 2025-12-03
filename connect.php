<?php
// MySQLi Procedural Version 'connect.php'

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "judge_grading_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";
?>

