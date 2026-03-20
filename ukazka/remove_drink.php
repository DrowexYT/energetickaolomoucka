<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

if (!isset($_GET['id'])) {
    die("No drink selected.");
}

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM inventory WHERE id = $id");
if ($result->num_rows == 0) {
    die("Drink not found.");
}

$drink = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Removal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        .confirm-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            margin: 10px;
        }
        .confirm-btn {
            background-color: #dc3545;
            color: white;
        }
        .cancel-btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="confirm-box">
        <h2>Are you sure?</h2>
        <p>Do you really want to remove <strong><?php echo htmlspecialchars($drink['drink_name']); ?></strong>?</p>
        
        <form method="POST" action="delete_drink.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="confirm-btn">Yes, Remove</button>
        </form>
        <a href="admin_dashboard.php"><button class="cancel-btn">Cancel</button></a>
    </div>

</body>
</html>
