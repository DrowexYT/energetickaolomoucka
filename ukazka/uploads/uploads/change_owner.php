<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $owner = $_POST['owner'] === "DD" ? "DD" : "Adam"; // Only allow valid values

    $conn->query("UPDATE inventory SET owner='$owner' WHERE id=$id");
}

header("Location: admin_dashboard.php");
exit;
?>
