<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

$sale_id = intval($_GET['id']);
$confirm = isset($_GET['confirm']) && $_GET['confirm'] === 'yes';

// Fetch sale details
$stmt = $conn->prepare("SELECT * FROM sales WHERE id = ?");
$stmt->bind_param("i", $sale_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Sale not found.");
}
$sale = $result->fetch_assoc();
$buyer_name = $sale['buyer_name'];

// Fetch sale items
$items = $conn->query("SELECT * FROM sale_items WHERE sale_id = $sale_id");

if ($confirm) {
    $conn->begin_transaction();
    try {
        // Restore inventory quantities
        while ($item = $items->fetch_assoc()) {
            $drink_id = $item['drink_id'];
            $quantity = $item['quantity'];

            // Fetch current inventory quantity
            $stmt = $conn->prepare("SELECT quantity FROM inventory WHERE id = ?");
            $stmt->bind_param("i", $drink_id);
            $stmt->execute();
            $inv_result = $stmt->get_result();
            if ($inv_result->num_rows == 0) {
                throw new Exception("Drink ID '$drink_id' not found in inventory.");
            }
            $inventory = $inv_result->fetch_assoc();
            $current_quantity = $inventory['quantity'];

            // Restore quantity
            $new_quantity = $current_quantity + $quantity;
            $stmt = $conn->prepare("UPDATE inventory SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_quantity, $drink_id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to update inventory: " . $stmt->error);
            }
        }

        // Delete sale items
        $stmt = $conn->prepare("DELETE FROM sale_items WHERE sale_id = ?");
        $stmt->bind_param("i", $sale_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete sale items: " . $stmt->error);
        }

        // Delete sale
        $stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
        $stmt->bind_param("i", $sale_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete sale: " . $stmt->error);
        }

        logHistory($conn, "delete_sale", "Deleted sale ID $sale_id: $buyer_name");

        $conn->commit();
        header("Location: admin_dashboard.php?view=sales");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete Sale</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding: 20px; }
        .confirm-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; text-align: left; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 5px; color: white; }
        .btn-confirm { background-color: #dc3545; }
        .btn-confirm:hover { background-color: #c82333; }
        .btn-cancel { background-color: #6c757d; }
        .btn-cancel:hover { background-color: #5a6268; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="confirm-box">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete sale: "<?php echo htmlspecialchars($buyer_name); ?>" bought <?php echo $items->num_rows; ?> item(s)?</p>
        <?php if (isset($error_message)): ?>
            <p class="error">Failed to delete sale: <?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <a href="confirm_delete_sale.php?id=<?php echo $sale_id; ?>&confirm=yes" class="btn btn-confirm">Yes, Delete</a>
        <a href="admin_dashboard.php?view=sales" class="btn btn-cancel">No, Cancel</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>