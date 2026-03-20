<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetická Olomoucká</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .drink-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
        }
        .drink-card {
            background: white;
            width: 200px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .drink-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .drink-card h3 {
            margin: 10px 0 5px;
            font-size: 18px;
            color: #333;
        }
        .drink-card p {
            margin: 5px 0;
            font-size: 16px;
            color: #007bff;
            font-weight: bold;
        }
        .btn {
            padding: 10px 20px;
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
        .no-drinks {
            color: red;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h2>Energetická Olomoucká Sklad</h2>

    <?php
    // Group by drink_name, sum quantity, and take the latest sell_price and image
    $result = $conn->query("
        SELECT drink_name, SUM(quantity) as total_quantity, sell_price, image
        FROM inventory
        WHERE quantity > 0
        GROUP BY drink_name
        HAVING total_quantity > 0
    ");

    if ($result && $result->num_rows > 0) {
        echo "<div class='drink-container'>";
        while ($row = $result->fetch_assoc()) {
            $image = $row['image'] ? "uploads/" . htmlspecialchars($row['image']) : "uploads/default_drink.jpg";
            echo "<div class='drink-card'>
                    <img src='$image' alt='" . htmlspecialchars($row['drink_name']) . "'>
                    <h3>" . htmlspecialchars($row['drink_name']) . " (" . $row['total_quantity'] . ")</h3>
                    <p>" . $row['sell_price'] . " Kč</p>
                  </div>";
        }
        echo "</div>";
    } else {
        echo "<p class='no-drinks'>No drinks available.</p>";
    }
    $conn->close();
    ?>

    <br>
    <a href="login.php" class="btn">Admin Login</a>
</body>
</html>