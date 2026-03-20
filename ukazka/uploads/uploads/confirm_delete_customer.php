<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT name FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Customer not found.");
}
$customer = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        logHistory($conn, "delete_customer", "Deleted customer '{$customer['name']}' (ID $id)");
        $stmt->close();
        $conn->close();
        header("Location: admin_dashboard.php?view=customers");
        exit();
    } else {
        $error = "Failed to delete customer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        .confirm-container {
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
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .cancel-btn {
            background-color: #6c757d;
            color: white;
        }
        .cancel-btn:hover {
            background-color: #5a6268;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete customer "<?= htmlspecialchars($customer['name']) ?>"?</p>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <button type="submit" class="delete-btn">Yes, Delete</button>
            <a href="admin_dashboard.php?view=customers"><button type="button" class="cancel-btn">No, Cancel</button></a>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>