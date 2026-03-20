<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
include 'log_history.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $notes = $conn->real_escape_string($_POST['notes']);

    $stmt = $conn->prepare("INSERT INTO customers (name, notes, total_paid) VALUES (?, ?, 0)");
    $stmt->bind_param("ss", $name, $notes);
    if ($stmt->execute()) {
        logHistory($conn, "add_customer", "Added customer $name with notes: $notes");
        $stmt->close();
        $conn->close();
        header("Location: admin_dashboard.php?view=customers");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
        input, textarea {
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
    <h2>Add Customer</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Notes:</label>
        <textarea name="notes" rows="4"></textarea>

        <button type="submit">Add Customer</button>
    </form>

    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>
<?php $conn->close(); ?>