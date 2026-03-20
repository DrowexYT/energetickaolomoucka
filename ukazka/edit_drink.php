<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM inventory WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Drink not found.");
}
$drink = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $drink_name = trim($_POST['drink_name']);
    $quantity = intval($_POST['quantity']);
    $buy_price = intval($_POST['buy_price']);
    $sell_price = intval($_POST['sell_price']);
    $owner = $_POST['owner'];
    $image = $drink['image']; // Default to existing image

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
        $stmt = $conn->prepare("UPDATE inventory SET drink_name = ?, quantity = ?, buy_price = ?, sell_price = ?, owner = ?, image = ? WHERE id = ?");
        $stmt->bind_param("siiissi", $drink_name, $quantity, $buy_price, $sell_price, $owner, $image, $id);
        if ($stmt->execute()) {
            logHistory($conn, "edit_drink", "Edited drink ID $id: $drink_name, quantity $quantity, buy price $buy_price Kč, sell price $sell_price Kč, owner $owner" . ($image ? ", image: $image" : ""));
            $stmt->close();
            $conn->close();
            header("Location: admin_dashboard.php?view=inventory");
            exit();
        } else {
            $error = "Failed to update drink.";
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
    <title>Edit Drink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            width: 400px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .cancel-btn {
            background-color: #6c757d;
        }
        .cancel-btn:hover {
            background-color: #5a6268;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .current-image {
            max-width: 100px;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Drink</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="drink_name">Drink Name:</label>
            <input type="text" name="drink_name" value="<?= htmlspecialchars($drink['drink_name']) ?>" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="<?= $drink['quantity'] ?>" min="0" required>

            <label for="buy_price">Buy Price (Kč):</label>
            <input type="number" name="buy_price" value="<?= $drink['buy_price'] ?>" min="0" required>

            <label for="sell_price">Sell Price (Kč):</label>
            <input type="number" name="sell_price" value="<?= $drink['sell_price'] ?>" min="0" required>

            <label for="owner">Owner:</label>
            <select name="owner" required>
                <option value="DD" <?= $drink['owner'] == 'DD' ? 'selected' : '' ?>>DD</option>
                <option value="Adam" <?= $drink['owner'] == 'Adam' ? 'selected' : '' ?>>Adam</option>
            </select>

            <label for="image">Image (optional):</label>
            <input type="file" name="image" accept="image/*">
            <?php if ($drink['image']): ?>
                <p>Current Image: <img src="uploads/<?= htmlspecialchars($drink['image']) ?>" alt="Current Image" class="current-image"></p>
            <?php endif; ?>

            <button type="submit">Save Changes</button>
        </form>
        <a href="admin_dashboard.php?view=inventory"><button type="button" class="cancel-btn">Cancel</button></a>
    </div>
</body>
</html>
<?php $conn->close(); ?>