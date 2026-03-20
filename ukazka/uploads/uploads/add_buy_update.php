<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drink_id = intval($_POST['drink_id']); // Use drink_id instead of drink_name
    $quantity = intval($_POST['quantity']);
    $buy_price = intval($_POST['buy_price']);
    $sell_price = intval($_POST['sell_price']);
    $owner = $_SESSION['admin_username'];

    // Fetch drink_name for logging
    $stmt = $conn->prepare("SELECT drink_name FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $drink_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $drink_name = $result->num_rows > 0 ? $result->fetch_assoc()['drink_name'] : "Unknown";

    $stmt = $conn->prepare("SELECT id, quantity FROM inventory WHERE id = ? AND owner = ?");
    $stmt->bind_param("is", $drink_id, $owner);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $stmt = $conn->prepare("UPDATE inventory SET quantity = ?, buy_price = ?, sell_price = ? WHERE id = ?");
        $stmt->bind_param("iiii", $new_quantity, $buy_price, $sell_price, $row['id']);
        $action = "Updated";
    } else {
        $stmt = $conn->prepare("INSERT INTO inventory (drink_name, quantity, buy_price, sell_price, owner) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $drink_name, $quantity, $buy_price, $sell_price, $owner);
        $action = "Added";
    }

    if ($stmt->execute()) {
        logHistory($conn, "buy_update", "$action $quantity of $drink_name at buy price $buy_price Kč and sell price $sell_price Kč, owner: $owner");
        $stmt->close();
        $conn->close();
        header("Location: admin_dashboard.php?view=inventory");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Fetch drinks for dropdown
$drinks = $conn->query("SELECT id, drink_name, quantity FROM inventory");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Buy Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        button {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h2>Add Buy Update</h2>
    <form method="POST">
        <label>Drink:</label>
        <select name="drink_id" required>
            <option value="">Select a drink</option>
            <?php while ($row = $drinks->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['drink_name']) . " (Stock: " . $row['quantity'] . ")" ?></option>
            <?php endwhile; ?>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" required>

        <label>Buy Price (Kč):</label>
        <input type="number" name="buy_price" required>

        <label>Sell Price (Kč):</label>
        <input type="number" name="sell_price" required>

        <button type="submit">Add/Update Inventory</button>
    </form>

    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>
<?php $conn->close(); ?>