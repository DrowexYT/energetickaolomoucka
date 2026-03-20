<?php
include 'db_connect.php';

$conn->query("UPDATE profits SET total_profit = 0, clean_profit = 0");

$result = $conn->query("SELECT s.owner_amount, s.deal_maker_amount, s.deal_maker, i.owner 
                        FROM sales s 
                        LEFT JOIN inventory i ON s.drink_name = i.drink_name 
                        WHERE s.is_profit_split = 1");

while ($row = $result->fetch_assoc()) {
    if ($row['owner']) {
        $stmt = $conn->prepare("UPDATE profits SET total_profit = total_profit + ? WHERE person = ?");
        $stmt->bind_param("ds", $row['owner_amount'], $row['owner']);
        $stmt->execute();
    }
    if ($row['deal_maker']) {
        $stmt = $conn->prepare("UPDATE profits SET total_profit = total_profit + ?, clean_profit = clean_profit + ? WHERE person = ?");
        $stmt->bind_param("dds", $row['deal_maker_amount'], $row['deal_maker_amount'], $row['deal_maker']);
        $stmt->execute();
    }
}

$stmt->close();
$conn->close();
echo "Profits synced!";
?>