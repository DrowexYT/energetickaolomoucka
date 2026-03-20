<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sale_id = intval($_GET['id']);

// Fetch sale details
$sale_result = $conn->query("SELECT * FROM sales WHERE id = $sale_id");
if (!$sale_result || $sale_result->num_rows == 0) {
    die("Sale not found for ID: $sale_id");
}
$sale = $sale_result->fetch_assoc();

// Fetch sale items with owner from inventory
$items = $conn->query("
    SELECT si.*, i.owner 
    FROM sale_items si 
    LEFT JOIN inventory i ON si.drink_id = i.id 
    WHERE si.sale_id = $sale_id
");
if (!$items) {
    die("Error fetching items: " . $conn->error);
}

// Fallback for deal_maker
$deal_maker = $sale['deal_maker'];
if ($deal_maker === '0' || empty($deal_maker)) {
    $deal_maker = 'Unknown';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sale #<?php echo $sale_id; ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding: 20px; }
        .sale-details { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); display: inline-block; text-align: left; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="sale-details">
        <h2>Sale #<?php echo $sale_id; ?></h2>
        <p><strong>Total Amount Paid:</strong> <?php echo $sale['amount_paid']; ?> Kč</p>
        <p><strong>Total Owner Amount:</strong> <?php echo $sale['owner_amount']; ?> Kč</p>
        <p><strong>Total Deal Maker Amount:</strong> <?php echo $sale['deal_maker_amount']; ?> Kč</p>
        <p><strong>Purchase Date:</strong> <?php echo $sale['purchase_date']; ?></p>
        <p><strong>Paid:</strong> <?php echo $sale['is_paid'] ? 'Yes' : 'No'; ?></p>

        <h3>Items</h3>
        <?php if ($items->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Drink Name</th>
                    <th>Quantity</th>
                    <th>Owner of the Can</th>
                    <th>Deal Maker</th>
                    <th>Amount Paid</th>
                    <th>Owner Amount</th>
                    <th>Deal Maker Amount</th>
                </tr>
                <?php while ($item = $items->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['drink_name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo htmlspecialchars($item['owner'] ?? 'Unknown'); ?></td>
                        <td><?php echo htmlspecialchars($deal_maker); ?></td>
                        <td><?php echo $item['sale_price']; ?> Kč</td>
                        <td><?php echo $item['owner_amount']; ?> Kč</td>
                        <td><?php echo $item['deal_maker_amount']; ?> Kč</td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No items found for this sale.</p>
        <?php endif; ?>
        <br>
        <a href="admin_dashboard.php?view=sales" class="btn">Back to Sales</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>