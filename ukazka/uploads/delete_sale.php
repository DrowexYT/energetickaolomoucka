<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

file_put_contents('debug.log', "delete_sale.php - Script reached at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// Handle both GET (direct link) and POST (from confirmation)
$sale_id = isset($_POST['id']) ? intval($_POST['id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
if ($sale_id <= 0) {
    file_put_contents('debug.log', "delete_sale.php - Invalid or missing sale ID: " . (isset($_POST['id']) ? $_POST['id'] : $_GET['id']) . "\n", FILE_APPEND);
    die("Invalid sale ID");
}

file_put_contents('debug.log', "delete_sale.php - Starting deletion for sale ID: $sale_id\n", FILE_APPEND);

$conn->begin_transaction();

try {
    // Fetch sale details
    $stmt = $conn->prepare("SELECT drink_name, quantity, amount_paid, purchase_date, buyer_name, deal_maker, is_paid FROM sales WHERE id = ?");
    $stmt->bind_param("i", $sale_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        throw new Exception("Sale not found for ID: $sale_id");
    }
    $sale = $result->fetch_assoc();
    $drink_name = $sale['drink_name'];
    $quantity = $sale['quantity'];
    $amount_paid = $sale['amount_paid'];
    $purchase_date = $sale['purchase_date'];
    $buyer_name = $sale['buyer_name'];
    $deal_maker = $sale['deal_maker'];
    $is_paid = $sale['is_paid'];

    file_put_contents('debug.log', "delete_sale.php - Sale found: $buyer_name bought $quantity $drink_name (ID: $sale_id)\n", FILE_APPEND);

    // Fetch inventory item
    $stmt = $conn->prepare("SELECT id, quantity FROM inventory WHERE drink_name = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $drink_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        throw new Exception("Drink '$drink_name' not found in inventory.");
    }
    $inventory = $result->fetch_assoc();
    $inventory_id = $inventory['id'];
    $current_quantity = $inventory['quantity'];
    $new_quantity = $current_quantity + $quantity;

    file_put_contents('debug.log', "delete_sale.php - Inventory found: ID $inventory_id, Drink: $drink_name, Current Quantity: $current_quantity, Adding: $quantity, New Quantity: $new_quantity\n", FILE_APPEND);

    // Update inventory
    $stmt = $conn->prepare("UPDATE inventory SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_quantity, $inventory_id);
    if (!$stmt->execute()) {
        throw new Exception("Inventory update failed: " . $stmt->error);
    }

    file_put_contents('debug.log', "delete_sale.php - Inventory updated successfully: $drink_name now at $new_quantity\n", FILE_APPEND);

    // Delete sale
    $stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt->bind_param("i", $sale_id);
    if (!$stmt->execute()) {
        throw new Exception("Sale deletion failed: " . $stmt->error);
    }

    file_put_contents('debug.log', "delete_sale.php - Sale ID $sale_id deleted successfully\n", FILE_APPEND);

    // Log the deletion
    logHistory($conn, "delete_sale", "Deleted sale ID $sale_id: $buyer_name bought $quantity of $drink_name for $amount_paid Kč on $purchase_date, deal maker: $deal_maker, paid: " . ($is_paid ? "Yes" : "No") . ", returned $quantity to inventory (ID $inventory_id, new qty: $new_quantity)");

    $conn->commit();
    file_put_contents('debug.log', "delete_sale.php - Transaction committed for sale ID: $sale_id\n", FILE_APPEND);
    header("Location: admin_dashboard.php?view=sales");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    file_put_contents('debug.log', "delete_sale.php - Error: " . $e->getMessage() . "\n", FILE_APPEND);
    die("Transaction failed: " . $e->getMessage());
}

$conn->close();
?>