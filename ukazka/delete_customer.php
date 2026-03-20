<?php
session_start();
include 'db_connect.php';
include 'log_history.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Unauthorized access.");
}

$id = intval($_POST['id']);

// Fetch customer name for logging
$stmt = $conn->prepare("SELECT name FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$name = $customer['name'] ?? 'Unknown';
$stmt->close();

// Delete customer
$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    logHistory($conn, "delete_customer", "Deleted customer ID $id: $name");
    $stmt->close();
    $conn->close();
    header("Location: admin_dashboard.php?view=customers");
    exit();
} else {
    $stmt->close();
    $conn->close();
    die("Failed to delete customer. It may not exist.");
}
?>