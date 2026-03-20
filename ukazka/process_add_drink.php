<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drink_name = $_POST['drink_name'];
    $quantity = intval($_POST['quantity']);
    $buy_price = floatval($_POST['buy_price']);
    $sell_price = floatval($_POST['sell_price']);
    $owner = $_POST['owner'];

    // Ensure the owner is either "DD" or "Adam"
    if ($owner !== "DD" && $owner !== "Adam") {
        die("Invalid owner selected.");
    }

    // Insert into inventory
    $stmt = $conn->prepare("INSERT INTO inventory (drink_name, quantity, buy_price, sell_price, owner) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sddds", $drink_name, $quantity, $buy_price, $sell_price, $owner);

    if ($stmt->execute()) {
        header("Location: dashboard_admin.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
