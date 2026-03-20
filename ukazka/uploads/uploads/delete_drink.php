<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';
include 'log_history.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Unauthorized access.");
}

if (!isset($_POST['id'])) {
    die("Invalid request.");
}

$id = intval($_POST['id']);

// Fetch drink name for logging
$stmt = $conn->prepare("SELECT drink_name FROM inventory WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$drink = $result->fetch_assoc();
$drink_name = $drink['drink_name'] ?? 'Unknown';
$stmt->close();

// Use prepared statement to safely delete
$stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    logHistory($conn, "delete_drink", "Deleted drink ID $id: $drink_name");
    $stmt->close();
    $conn->close();
    header("Location: admin_dashboard.php?view=inventory");
    exit();
} else {
    $stmt->close();
    $conn->close();
    die("Failed to delete drink. It may not exist.");
}
?>