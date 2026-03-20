<?php
function logHistory($conn, $action_type, $description) {
    $admin_username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : null;
    $stmt = $conn->prepare("INSERT INTO history (action_type, description, admin_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $action_type, $description, $admin_username);
    $stmt->execute();
    $stmt->close();
}
?>