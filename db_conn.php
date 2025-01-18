<?php
$host = 'localhost'; // Database host
$db = 'u373995092_shopsphere'; // Database name
$user = 'u373995092_shopsphere'; // Database username
$pass = 'Shopsphere@2024'; // Database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
