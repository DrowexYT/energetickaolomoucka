<?php
include 'db_connect.php';

$buyer_name = "Filip Jeřábek";
$stmt = $conn->prepare("SELECT * FROM sales WHERE buyer_name = ?");
$stmt->bind_param("s", $buyer_name);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "Sale ID: " . $row['id'] . ", Buyer: " . $row['buyer_name'] . "\n";
}

$stmt->close();
$conn->close();
?>