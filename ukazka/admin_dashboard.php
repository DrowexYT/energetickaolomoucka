<?php
session_start();
include 'db_connect.php';

// Set PHP time zone to Czech Republic (Europe/Prague)
date_default_timezone_set('Europe/Prague');

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

$view = isset($_GET['view']) ? $_GET['view'] : 'inventory';

// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sale_id']) && isset($_POST['is_paid'])) {
        $sale_id = intval($_POST['sale_id']);
        $is_paid = intval($_POST['is_paid']);
        $stmt = $conn->prepare("UPDATE sales SET is_paid = ? WHERE id = ?");
        $stmt->bind_param("ii", $is_paid, $sale_id);
        $stmt->execute();
        $stmt->close();
        echo "Success";
        exit;
    } elseif (isset($_POST['sale_id']) && isset($_POST['is_profit_split'])) {
        $sale_id = intval($_POST['sale_id']);
        $is_profit_split = intval($_POST['is_profit_split']);
        $stmt = $conn->prepare("UPDATE sales SET is_profit_split = ? WHERE id = ?");
        $stmt->bind_param("ii", $is_profit_split, $sale_id);
        $stmt->execute();
        $stmt->close();
        echo "Success";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f4f4f4;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background: #007bff;
            color: white;
        }

        td {
            text-align: center;
        }

        .btn {
            padding: 8px 16px;
            margin: 5px;
            text-decoration: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
            display: inline-block;
        }

        .btn:hover {
            background: #0056b3;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .logout-btn {
            background: #dc3545;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        .stats {
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <a href="?view=inventory" class="btn">View Inventory</a>
    <a href="?view=sales" class="btn">View Sales</a>
    <a href="?view=customers" class="btn">View Customers</a>
    <a href="?view=history" class="btn">View History</a>
    <a href="?view=admins" class="btn">View Admins</a>
    <a href="add_drink.php" class="btn">Add Drink</a>
    <a href="add_sale.php" class="btn">Add Sale</a>
    <a href="add_customer.php" class="btn">Add Customer</a>
    <a href="add_buy_update.php" class="btn">Add Buy Update</a>
    <a href="logout.php" class="btn logout-btn">Logout</a>

    <?php
    if ($view == 'inventory') {
        echo "<h3>Inventory</h3>";
        $result = $conn->query("SELECT * FROM inventory");

        if ($result && $result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Drink Name</th>
                        <th>Quantity</th>
                        <th>Buy Price</th>
                        <th>Sell Price</th>
                        <th>Owner</th>
                        <th>Actions</th>
                    </tr>";
            $total_buy_price = 0;
            $total_sell_price = 0;
            $total_possible_profit = 0;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . intval($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['drink_name']) . "</td>
                        <td>" . intval($row['quantity']) . "</td>
                        <td>" . $row['buy_price'] . " Kč</td>
                        <td>" . $row['sell_price'] . " Kč</td>
                        <td>" . htmlspecialchars($row['owner']) . "</td>
                        <td>
                            <a href='edit_drink.php?id=" . $row['id'] . "' class='btn'>Edit</a>
                            <a href='delete_sale.php?id=" . $row['id'] . "' class='btn delete-btn' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                        </td>
                    </tr>";
                $total_buy_price += $row['quantity'] * $row['buy_price'];
                $total_sell_price += $row['quantity'] * $row['sell_price'];
                $total_possible_profit += $row['quantity'] * ($row['sell_price'] - $row['buy_price']);
            }
            echo "</table>";
            echo "<div class='stats'>
                    Total Buy Price: " . $total_buy_price . " Kč | 
                    Total Sell Price: " . $total_sell_price . " Kč | 
                    Total Possible Profit: " . $total_possible_profit . " Kč
                  </div>";
        } else {
            echo "<p style='color: red;'>No drinks in inventory.</p>";
        }
    } elseif ($view == 'sales') {
        echo "<h3>Sales</h3>";
        $result = $conn->query("SELECT s.*, (SELECT COUNT(*) FROM sale_items si WHERE si.sale_id = s.id) as item_count FROM sales s ORDER BY s.id DESC");

        if ($result && $result->num_rows > 0) {
            $total_paid = 0;
            $total_unpaid = 0;
            $dd_to_be_paid = 0;
            $adam_to_be_paid = 0;

            while ($row = $result->fetch_assoc()) {
                $stmt = $conn->prepare("SELECT owner FROM sale_items si LEFT JOIN inventory i ON si.drink_id = i.id WHERE si.sale_id = ? LIMIT 1");
                $stmt->bind_param("i", $row['id']);
                $stmt->execute();
                $owner_result = $stmt->get_result();
                $owner = $owner_result->num_rows > 0 ? $owner_result->fetch_assoc()['owner'] : 'Unknown';

                if ($row['is_paid']) {
                    $total_paid += $row['amount_paid'];
                } else {
                    $total_unpaid += $row['amount_paid'];
                }

                file_put_contents('debug.log', "admin_dashboard.php - Sale ID {$row['id']}: deal_maker = {$row['deal_maker']}, is_profit_split = {$row['is_profit_split']}, deal_maker_amount = {$row['deal_maker_amount']}\n", FILE_APPEND);

                if (!$row['is_profit_split']) {
                    if ($owner == 'DD') {
                        $dd_to_be_paid += $row['owner_amount'];
                    } else if ($owner == 'Adam') {
                        $adam_to_be_paid += $row['owner_amount'];
                    }

                    $deal_maker = trim(strtoupper($row['deal_maker']));
                    if ($deal_maker == 'DD') {
                        $dd_to_be_paid += $row['deal_maker_amount'];
                    } else if ($deal_maker == 'ADAM') {
                        $adam_to_be_paid += $row['deal_maker_amount'];
                    } else {
                        file_put_contents('debug.log', "admin_dashboard.php - Invalid deal_maker for Sale ID {$row['id']}: $deal_maker\n", FILE_APPEND);
                    }
                }
            }

            echo "<div class='stats'>
                    Total Paid Amount: " . $total_paid . " Kč | 
                    Total Unpaid Amount: " . $total_unpaid . " Kč
                  </div>";
            if ($dd_to_be_paid > 0 || $adam_to_be_paid > 0) {
                echo "<div class='stats'>
                        To Be Paid - DD: " . $dd_to_be_paid . " Kč | 
                        To Be Paid - Adam: " . $adam_to_be_paid . " Kč
                      </div>";
            }

            echo "<table>
                    <tr>
                        <th>Sale ID</th>
                        <th>Buyer Name</th>
                        <th>Items</th>
                        <th>Amount Paid</th>
                        <th>Purchase Date</th>
                        <th>Paid?</th>
                        <th>Profit Split?</th>
                        <th>Owner Amount</th>
                        <th>Deal Maker Amount</th>
                        <th>Actions</th>
                    </tr>";

            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                // Convert purchase_date from UTC to Europe/Prague and add 7-hour offset
                $date = new DateTime($row['purchase_date'], new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('Europe/Prague'));
                $date->modify('+7 hours'); // Temporary offset to align with 10 AM–1 PM
                $formatted_date = $date->format('d.m.Y H:i');

                $checked_paid = $row['is_paid'] ? 'checked' : '';
                $checked_split = $row['is_profit_split'] ? 'checked' : '';
                $item_display = $row['item_count'] > 1 ? "Sale #{$row['id']} - {$row['item_count']} Items" : htmlspecialchars($row['item_count'] == 1 ? $conn->query("SELECT drink_name FROM sale_items WHERE sale_id = {$row['id']}")->fetch_assoc()['drink_name'] : '');
                echo "<tr>
                        <td>" . intval($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['buyer_name']) . "</td>
                        <td>" . $item_display . "</td>
                        <td>" . $row['amount_paid'] . " Kč</td>
                        <td>" . htmlspecialchars($formatted_date) . "</td>
                        <td>
                            <input type='checkbox' class='paid-checkbox' data-sale-id='" . $row['id'] . "' $checked_paid>
                        </td>
                        <td>
                            <input type='checkbox' class='split-checkbox' data-sale-id='" . $row['id'] . "' $checked_split>
                        </td>
                        <td>" . $row['owner_amount'] . " Kč</td>
                        <td>" . $row['deal_maker_amount'] . " Kč</td>
                        <td>
                            <a href='view_sale.php?id=" . $row['id'] . "' class='btn'>View</a>
                            <a href='confirm_delete_sale.php?id=" . $row['id'] . "' class='btn delete-btn'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>No sales recorded.</p>";
        }
    } elseif ($view == 'customers') {
        echo "<h3>Customers</h3>";
        $result = $conn->query("SELECT * FROM customers ORDER BY name ASC");

        if ($result && $result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Total Paid</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>";
            $total_paid_all = 0;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . intval($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . $row['total_paid'] . " Kč</td>
                        <td>" . htmlspecialchars($row['notes'] ?? 'N/A') . "</td>
                        <td>
                            <a href='edit_customer.php?id=" . $row['id'] . "' class='btn'>Edit</a>
                            <a href='confirm_delete_customer.php?id=" . $row['id'] . "' class='btn delete-btn'>Delete</a>
                        </td>
                    </tr>";
                $total_paid_all += $row['total_paid'];
            }
            echo "</table>";
            echo "<div class='stats'>
                    Total Paid by All Customers: " . $total_paid_all . " Kč
                  </div>";
        } else {
            echo "<p style='color: red;'>No customers recorded.</p>";
        }
    } elseif ($view == 'history') {
        echo "<h3>Change History</h3>";
        $result = $conn->query("SELECT * FROM history ORDER BY created_at DESC");

        if ($result && $result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Action Type</th>
                        <th>Description</th>
                        <th>Admin</th>
                        <th>Timestamp</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . intval($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['action_type']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>" . htmlspecialchars($row['admin_id'] ?? 'N/A') . "</td>
                        <td>" . $row['created_at'] . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>No history recorded.</p>";
        }
    } elseif ($view == 'admins') {
        echo "<h3>Admins</h3>";
        $result = $conn->query("SELECT username, created_at FROM users ORDER BY created_at ASC");

        if ($result && $result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Username</th>
                        <th>Created At</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>" . $row['created_at'] . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>No admins recorded.</p>";
        }
    }
    $conn->close();
    ?>

    <script>
        document.querySelectorAll('.paid-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const saleId = this.getAttribute('data-sale-id');
                const isPaid = this.checked ? 1 : 0;

                fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `sale_id=${saleId}&is_paid=${isPaid}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "Success") {
                        location.reload();
                    } else {
                        console.error("Update failed: " + data);
                        this.checked = !this.checked;
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    this.checked = !this.checked;
                });
            });
        });

        document.querySelectorAll('.split-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const saleId = this.getAttribute('data-sale-id');
                const isProfitSplit = this.checked ? 1 : 0;

                fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `sale_id=${saleId}&is_profit_split=${isProfitSplit}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "Success") {
                        location.reload();
                    } else {
                        console.error("Update failed: " + data);
                        this.checked = !this.checked;
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    this.checked = !this.checked;
                });
            });
        });
    </script>
</body>
</html>