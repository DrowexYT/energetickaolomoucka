<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $drink_name = trim($_POST['drink_name']);
    $quantity = intval($_POST['quantity']);
    $buy_price = intval($_POST['buy_price']);
    $sell_price = intval($_POST['sell_price']);
    $owner = $_POST['owner'];
    $image = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $error = "Error uploading image.";
        }
    }

    if (empty($drink_name)) {
        $error = "Drink name is required.";
    } elseif ($quantity < 0 || $buy_price < 0 || $sell_price < 0) {
        $error = "Quantity, buy price, and sell price must be non-negative.";
    } elseif (!in_array($owner, ['DD', 'Adam'])) {
        $error = "Invalid owner selected.";
    } elseif (!isset($error)) {
        $stmt = $conn->prepare("INSERT INTO inventory (drink_name, quantity, buy_price, sell_price, owner, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiss", $drink_name, $quantity, $buy_price, $sell_price, $owner, $image);
        if ($stmt->execute()) {
            logHistory($conn, "add_drink", "Added $quantity $drink_name at buy price $buy_price Kč, sell price $sell_price Kč, owner $owner" . ($image ? ", image: $image" : ""));
            $stmt->close();
            $conn->close();
            header("Location: admin_dashboard.php?view=inventory");
            exit();
        } else {
            $error = "Failed to add drink.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Drink</title>
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
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h2>Add Drink</h2>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Drink Name:</label>
        <input type="text" name="drink_name" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="0" required>

        <label>Buy Price (Kč):</label>
        <input type="number" name="buy_price" min="0" required>

        <label>Sell Price (Kč):</label>
        <input type="number" name="sell_price" min="0" required>

        <label>Owner:</label>
        <select name="owner" required>
            <option value="DD">DD</option>
            <option value="Adam">Adam</option>
        </select>

        <label>Image (optional):</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Add Drink</button>
    </form>
    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>
<?php $conn->close(); ?>