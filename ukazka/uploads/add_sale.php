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

echo "<!-- Debug: add_sale.php updated April 15, 2025 -->";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buyer_name = $conn->real_escape_string($_POST['buyer_name']);
    $deal_maker = $conn->real_escape_string($_POST['deal_maker']);
    $amount_paid = intval($_POST['amount_paid']);
    $is_paid = isset($_POST['is_paid']) ? 1 : 0;
    $drink_ids = $_POST['drink_id'];
    $quantities = $_POST['quantity'];

    file_put_contents('debug.log', "add_sale.php - Deal Maker: $deal_maker\n", FILE_APPEND);

    $conn->begin_transaction();

    try {
        // Insert main sale
        $stmt = $conn->prepare("INSERT INTO sales (buyer_name, amount_paid, purchase_date, is_paid, deal_maker, profit, owner_amount, deal_maker_amount) VALUES (?, ?, NOW(), ?, ?, 0, 0, 0)");
        $stmt->bind_param("sisi", $buyer_name, $amount_paid, $is_paid, $deal_maker);
        $stmt->execute();
        $sale_id = $stmt->insert_id;

        $total_profit = 0;
        $total_owner_amount = 0;
        $total_deal_maker_amount = 0;

        // Calculate total expected sale price
        $total_expected_sale_price = 0;
        $items = [];
        foreach ($drink_ids as $index => $drink_id) {
            $drink_id = intval($drink_id);
            $quantity = intval($quantities[$index]);

            file_put_contents('debug.log', "add_sale.php - Drink ID: $drink_id, Quantity: $quantity\n", FILE_APPEND);

            if ($quantity <= 0) {
                throw new Exception("Invalid quantity for Drink ID $drink_id: $quantity");
            }

            // Fetch drink details
            $stmt = $conn->prepare("SELECT drink_name, quantity as stock_quantity, sell_price, buy_price, owner FROM inventory WHERE id = ?");
            $stmt->bind_param("i", $drink_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                throw new Exception("Drink not found for ID: $drink_id");
            }
            $drink = $result->fetch_assoc();

            if ($drink['stock_quantity'] < $quantity) {
                throw new Exception("Insufficient stock for {$drink['drink_name']}: {$drink['stock_quantity']} available, $quantity requested");
            }

            $total_expected_sale_price += $drink['sell_price'] * $quantity;
            $items[] = [
                'drink_id' => $drink_id,
                'drink_name' => $drink['drink_name'],
                'quantity' => $quantity,
                'sell_price' => $drink['sell_price'],
                'buy_price' => $drink['buy_price'],
                'owner' => $drink['owner']
            ];
        }

        // Process each drink
        foreach ($items as $item) {
            $drink_id = $item['drink_id'];
            $drink_name = $item['drink_name'];
            $quantity = $item['quantity'];
            $sell_price = $item['sell_price'];
            $buy_price = $item['buy_price'];
            $owner = $item['owner'];

            // Calculate per-item sale price (proportional to sell_price)
            $item_sale_price = ($sell_price * $quantity) * ($amount_paid / $total_expected_sale_price);

            // Calculate profit and split
            $item_cost = $buy_price * $quantity;
            $item_profit = $item_sale_price - $item_cost;
            $profit_per_can = $item_profit / $quantity;
            $half_profit_per_can = $profit_per_can / 2;
            $deal_maker_profit_per_can = ceil($half_profit_per_can);
            $owner_profit_per_can = floor($half_profit_per_can);

            // Ensure profits are non-negative
            if ($deal_maker_profit_per_can < 0 || $owner_profit_per_can < 0) {
                throw new Exception("Negative profit calculated for Drink ID $drink_id: Deal Maker: $deal_maker_profit_per_can, Owner: $owner_profit_per_can");
            }

            $item_owner_amount = ($buy_price + $owner_profit_per_can) * $quantity;
            $item_deal_maker_amount = $deal_maker_profit_per_can * $quantity;

            $total_profit += $item_profit;
            $total_owner_amount += $item_owner_amount;
            $total_deal_maker_amount += $item_deal_maker_amount;

            // Insert into sale_items
            $stmt = $conn->prepare("INSERT INTO sale_items (sale_id, drink_id, drink_name, quantity, buy_price, sale_price, owner_amount, deal_maker_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisiiiii", $sale_id, $drink_id, $drink_name, $quantity, $buy_price, $item_sale_price, $item_owner_amount, $item_deal_maker_amount);
            $stmt->execute();

            // Update inventory
            $stmt = $conn->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $drink_id);
            $stmt->execute();
        }

        // Update the main sale with totals
        $stmt = $conn->prepare("UPDATE sales SET profit = ?, owner_amount = ?, deal_maker_amount = ? WHERE id = ?");
        $stmt->bind_param("iiii", $total_profit, $total_owner_amount, $total_deal_maker_amount, $sale_id);
        $stmt->execute();

        logHistory($conn, "add_sale", "Added sale ID $sale_id: $buyer_name bought multiple items for $amount_paid Kč, deal maker: $deal_maker, total owner amount: $total_owner_amount Kč, total deal maker amount: $total_deal_maker_amount Kč, paid: " . ($is_paid ? "Yes" : "No"));

        $conn->commit();
        header("Location: admin_dashboard.php?view=sales");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        file_put_contents('debug.log', "add_sale.php - Error: " . $e->getMessage() . "\n", FILE_APPEND);
        die("Error: " . $e->getMessage());
    }
}

// Fetch dropdown data
$drinks = $conn->query("SELECT id, drink_name, quantity, owner, buy_price FROM inventory WHERE quantity > 0");
$customers = $conn->query("SELECT name FROM customers ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sale</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; text-align: left; }
        input, select { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        label { display: block; margin: 10px 0 5px; }
        button { background-color: #dc3545; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; width: 100%; margin-top: 10px; }
        button:hover { background-color: #c82333; }
        .drink-item { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        #add-drink { background-color: #007bff; width: auto; margin: 10px 0; }
        #add-drink:hover { background-color: #0056b3; }
    </style>
    <script>
        function addDrinkItem() {
            const container = document.getElementById('drink-items');
            const item = document.createElement('div');
            item.className = 'drink-item';
            item.innerHTML = `
                <label>Drink:</label>
                <select name="drink_id[]" required>
                    <option value="">Select a drink</option>
                    <?php 
                    $drinks->data_seek(0);
                    while ($row = $drinks->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['drink_name']) . " (Stock: " . $row['quantity'] . ", Owner: " . $row['owner'] . ", Buy: " . $row['buy_price'] . " Kč)" ?></option>
                    <?php endwhile; ?>
                </select>
                <label>Quantity:</label>
                <input type="number" name="quantity[]" min="1" required>
            `;
            container.appendChild(item);
        }
    </script>
</head>
<body>
    <h2>Add Sale</h2>
    <form method="POST">
        <label>Buyer Name:</label>
        <select name="buyer_name" required>
            <option value="">Select a customer</option>
            <?php while ($row = $customers->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['name']) ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select>

        <div id="drink-items">
            <div class="drink-item">
                <label>Drink:</label>
                <select name="drink_id[]" required>
                    <option value="">Select a drink</option>
                    <?php 
                    $drinks->data_seek(0);
                    while ($row = $drinks->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['drink_name']) . " (Stock: " . $row['quantity'] . ", Owner: " . $row['owner'] . ", Buy: " . $row['buy_price'] . " Kč)" ?></option>
                    <?php endwhile; ?>
                </select>
                <label>Quantity:</label>
                <input type="number" name="quantity[]" min="1" required>
            </div>
        </div>
        <button type="button" id="add-drink" onclick="addDrinkItem()">Add Another Drink</button>

        <label>Total Amount Paid (Kč):</label>
        <input type="number" name="amount_paid" min="0" required>

        <label>Deal Maker:</label>
        <select name="deal_maker" required>
            <option value="DD">DD</option>
            <option value="Adam">Adam</option>
        </select>

        <label>Paid:</label>
        <input type="checkbox" name="is_paid" value="1"> Yes

        <button type="submit">Record Sale</button>
    </form>
    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>
<?php $conn->close(); ?>