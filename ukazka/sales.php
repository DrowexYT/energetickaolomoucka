<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

// Fetch drinks and customers for the dropdowns
$drinks_result = $conn->query("SELECT drink_id, drink_name FROM inventory");
$customers_result = $conn->query("SELECT customer_id, customer_name FROM customers");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $drink_id = $_POST['drink_id'];
    $quantity = $_POST['quantity'];
    $amount_paid = $_POST['amount_paid'];
    $payment_status = $_POST['payment_status'];

    // Insert into the sales table
    $stmt = $conn->prepare("INSERT INTO sales (customer_id, drink_id, quantity, amount_paid, payment_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiids", $customer_id, $drink_id, $quantity, $amount_paid, $payment_status);
    $stmt->execute();
    $stmt->close();  // Close the statement

    // Update inventory after the sale
    $stmt2 = $conn->prepare("SELECT quantity FROM inventory WHERE drink_id = ?");
    $stmt2->bind_param("i", $drink_id);
    $stmt2->execute();
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {
        $stmt2->bind_result($existing_quantity);
        $stmt2->fetch();
        $new_quantity = $existing_quantity - $quantity;

        // Update the inventory with the new quantity
        $update_stmt = $conn->prepare("UPDATE inventory SET quantity = ? WHERE drink_id = ?");
        $update_stmt->bind_param("ii", $new_quantity, $drink_id);
        $update_stmt->execute();
        $update_stmt->close();  // Close the update statement
    }

    $stmt2->close();  // Close the select statement
    echo "Sale recorded successfully!";
}

$conn->close();
?>

<h2>Record a New Sale</h2>
<form method="post">
    <label>Customer:
        <select name="customer_id" required>
            <option value="">Select Customer</option>
            <?php while($customer = $customers_result->fetch_assoc()): ?>
                <option value="<?= $customer['customer_id'] ?>"><?= $customer['customer_name'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Drink:
        <select name="drink_id" required>
            <option value="">Select Drink</option>
            <?php while($drink = $drinks_result->fetch_assoc()): ?>
                <option value="<?= $drink['drink_id'] ?>"><?= $drink['drink_name'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Quantity: <input type="number" name="quantity" required></label><br>
    <label>Amount Paid: <input type="number" step="0.01" name="amount_paid" required></label><br>
    <label>Payment Status:
        <select name="payment_status">
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
        </select>
    </label><br>
    <button type="submit">Record Sale</button>
</form>

<!-- Button to go back to the dashboard -->
<a href="admin_dashboard.php">
    <button>Back to Dashboard</button>
</a>
