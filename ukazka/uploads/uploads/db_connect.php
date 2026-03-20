<?php
$servername = "sql207.ezyro.com"; // Replace with your actual MySQL hostname

$username = "ezyro_38606904"; // Replace with your ProFreeHost database username

$password = "dbea30fba76c1"; // Replace with your actual password

$dbname = "ezyro_38606904_energeticka"; // Replace with your actual database name



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>