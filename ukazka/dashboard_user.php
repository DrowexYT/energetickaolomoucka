<?php
session_start();
include 'db_connect.php';

// Fetch available items, grouping by drink_name
$items = $conn->query("
    SELECT drink_name, MAX(sell_price) as sell_price, SUM(quantity) as quantity, GROUP_CONCAT(id) as ids
    FROM inventory 
    WHERE quantity > 0 
    GROUP BY drink_name
");

// Extract unique brands from items
$brands = [];
$items_array = [];
while ($item = $items->fetch_assoc()) {
    $drink_name = $item['drink_name'];
    // Define multi-word brands
    $multi_word_brands = ['Crazy Wolf', 'Big Shock'];
    $brand = $drink_name;
    foreach ($multi_word_brands as $mw_brand) {
        if (stripos($drink_name, $mw_brand) === 0) {
            $brand = $mw_brand;
            break;
        }
    }
    // For single-word brands, take the first word
    if (!in_array($brand, $multi_word_brands)) {
        $brand = explode(' ', $drink_name)[0];
    }
    if (!in_array($brand, $brands)) {
        $brands[] = $brand;
    }
    $items_array[] = $item; // Store items for rendering
}
$items->data_seek(0); // Reset cursor for rendering
sort($brands); // Sort brands alphabetically

// Default username for unauthenticated users
$display_username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Host";

// Check if the user is an admin
$is_admin = false;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_query = $conn->query("SELECT role FROM users WHERE username = '$username'");
    if ($user_query->num_rows > 0) {
        $user = $user_query->fetch_assoc();
        $is_admin = $user['role'] === 'admin';
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energetická Olomoucká</title>
    <link rel="apple-touch-icon" sizes="180x180" href="Uploads/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Uploads/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Uploads/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #263238 100%);
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            animation: fadeIn 1s ease-in-out;
            color: #f5f5f5;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .container {
            max-width: 60%;
            margin: 0 auto;
            background: #2c3e50;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        @media (max-width: 768px) {
            .container {
                max-width: 100%;
                padding: 15px;
            }
            body {
                padding: 10px;
            }
        }

        h2, h3 {
            text-align: center;
            color: #f5f5f5;
            margin: 15px 0;
            font-weight: 600;
        }

        h2 {
            font-size: 1.8em;
        }

        h3 {
            font-size: 1.4em;
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-btn {
            background-color: #34495e;
            color: #f5f5f5;
            padding: 10px 15px;
            border: 1px solid #4a6076;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.2s, transform 0.1s;
        }

        .filter-btn:hover {
            background-color: #3e5a74;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
            transform: scale(1.02);
        }

        .filter-btn.active {
            background-color: #1abc9c;
            border-color: #16a085;
        }

        .filter-btn.active:hover {
            background-color: #16a085;
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.5);
        }

        .item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #4a6076;
            border-radius: 10px;
            background-color: #34495e;
            font-size: 15px;
            transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;
        }

        .item:hover {
            transform: scale(1.02);
            background-color: #3e5a74;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        }

        .item span {
            flex: 1;
            margin-right: 10px;
            color: #f5f5f5;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls button {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 17px;
            transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
        }

        .quantity-controls button:hover {
            background-color: #16a085;
            transform: scale(1.05);
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.5);
        }

        .quantity-controls button:disabled {
            background-color: #7f8c8d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .quantity-controls .quantity {
            width: 30px;
            text-align: center;
            font-size: 17px;
            color: #f5f5f5;
        }

        #order-message {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #4a6076;
            border-radius: 10px;
            background-color: #34495e;
            white-space: pre-wrap;
            font-size: 15px;
            color: #f5f5f5;
            user-select: text;
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
        }

        .copy-container {
            margin-top: 15px;
        }

        .copy-message {
            background-color: #27ae60;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 17px;
            transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
        }

        .copy-message:hover {
            background-color: #219653;
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(39, 174, 96, 0.5);
        }

        .copy-message i {
            margin-right: 8px;
        }

        .record-sale-link {
            margin-top: 15px;
            text-align: center;
        }

        .record-sale-link a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #e67e22;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 17px;
            transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
        }

        .record-sale-link a:hover {
            background-color: #d35400;
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(230, 126, 34, 0.5);
        }

        .instagram-links {
            margin-top: 20px;
            text-align: center;
        }

        .instagram-links p {
            color: #f5f5f5;
            margin-bottom: 10px;
        }

        .instagram-links a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #C13584;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 17px;
            transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
        }

        .instagram-links a:hover {
            background-color: #9b2c6b;
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(193, 53, 132, 0.5);
        }

        .instagram-links a i {
            margin-right: 8px;
        }

        .auth-btn {
            background-color: #1abc9c;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 15px;
            font-size: 17px;
            transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
        }

        .auth-btn:hover {
            background-color: #16a085;
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.5);
        }

        .logout-btn {
            background-color: #c0392b;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 15px;
            font-size: 17px;
            transition: transform 0.1s, background-color 0.2s, box-shadow 0.2s;
        }

        .logout-btn:hover {
            background-color: #992d22;
            transform: scale(1.02);
            box-shadow: 0 0 8px rgba(192, 57, 43, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Energetická Olomoucká</h2>
        <h3>Vyber, zkopíruj a pošli na IG</h3>
        <div class="filter-container">
            <button class="filter-btn active" data-brand="all">Vše</button>
            <?php foreach ($brands as $brand): ?>
                <button class="filter-btn" data-brand="<?php echo htmlspecialchars($brand); ?>"><?php echo htmlspecialchars($brand); ?></button>
            <?php endforeach; ?>
        </div>
        <div id="items">
            <?php while ($item = $items->fetch_assoc()): ?>
                <div class="item" data-ids="<?php echo htmlspecialchars($item['ids']); ?>" data-name="<?php echo htmlspecialchars($item['drink_name']); ?>" data-price="<?php echo $item['sell_price']; ?>" data-stock="<?php echo $item['quantity']; ?>">
                    <span><?php echo htmlspecialchars($item['drink_name']); ?> - <?php echo $item['sell_price']; ?> Kč (<?php echo $item['quantity']; ?> k dispozici)</span>
                    <div class="quantity-controls">
                        <button class="minus">-</button>
                        <span class="quantity">0</span>
                        <button class="plus">+</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <h3>Tvoje objednávka</h3>
        <div id="order-message">Žádné položky nevybrány.</div>
        <div class="copy-container">
            <button id="copy-message" class="copy-message"><i class="fas fa-copy"></i> Kopírovat objednávku</button>
        </div>
        <?php if ($is_admin): ?>
            <div class="record-sale-link" id="record-sale-link" style="display: none;">
                <a href="#" id="record-sale-anchor">Zaznamenat prodej</a>
            </div>
        <?php endif; ?>

        <div class="instagram-links">
            <p>Objednávku zašlete na Instagram:</p>
            <a href="https://www.instagram.com/energeticka_olomoucka/" target="_blank"><i class="fab fa-instagram"></i> Náš Instagram</a>
        </div>

        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php" class="logout-btn">Odhlásit se</a>
        <?php else: ?>
            <a href="login.php" class="auth-btn">Přihlásit se (Admin)</a>
        <?php endif; ?>
    </div>

    <script>
        // Track quantities for each item (using drink_name as key)
        const quantities = {};

        // Initialize quantities to 0 for each item
        document.querySelectorAll('.item').forEach(item => {
            const drinkName = item.getAttribute('data-name');
            quantities[drinkName] = 0;
        });

        // Store original items
        const originalItems = Array.from(document.querySelectorAll('.item')).map(item => item.cloneNode(true));

        // Function to update item event listeners
        function updateItemListeners(item) {
            const drinkName = item.getAttribute('data-name');
            const plusButton = item.querySelector('.plus');
            const minusButton = item.querySelector('.minus');
            const quantitySpan = item.querySelector('.quantity');
            quantitySpan.textContent = quantities[drinkName] || 0;

            // Remove existing listeners to prevent duplicates
            const newPlus = plusButton.cloneNode(true);
            const newMinus = minusButton.cloneNode(true);
            plusButton.parentNode.replaceChild(newPlus, plusButton);
            minusButton.parentNode.replaceChild(newMinus, minusButton);

            newPlus.addEventListener('click', () => {
                const stock = parseInt(item.getAttribute('data-stock'));
                if (quantities[drinkName] < stock) {
                    quantities[drinkName]++;
                    quantitySpan.textContent = quantities[drinkName];
                    updateOrderMessage();
                    updateButtonStates();
                } else {
                    alert(`Omlouváme se, pouze ${stock} ${drinkName} skladem!`);
                }
            });

            newMinus.addEventListener('click', () => {
                if (quantities[drinkName] > 0) {
                    quantities[drinkName]--;
                    quantitySpan.textContent = quantities[drinkName];
                    updateOrderMessage();
                    updateButtonStates();
                }
            });
        }

        // Function to filter items by brand
        function filterItems(brand) {
            const itemsContainer = document.getElementById('items');
            itemsContainer.innerHTML = '';

            // Filter items
            let filteredItems = brand === 'all' 
                ? originalItems 
                : originalItems.filter(item => {
                    const name = item.getAttribute('data-name').toLowerCase();
                    return name.startsWith(brand.toLowerCase());
                });

            // Append filtered items
            filteredItems.forEach(item => {
                const newItem = item.cloneNode(true);
                itemsContainer.appendChild(newItem);
                updateItemListeners(newItem);
            });

            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-brand') === brand) {
                    btn.classList.add('active');
                }
            });

            updateButtonStates();
        }

        // Attach filter event listeners
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                const brand = button.getAttribute('data-brand');
                filterItems(brand);
            });
        });

        // Update order message with total amount included
        function updateOrderMessage() {
            const messageDiv = document.getElementById('order-message');
            const recordSaleLink = document.getElementById('record-sale-link');
            const recordSaleAnchor = document.getElementById('record-sale-anchor');
            let message = "Chtěl bych objednat:\n";
            let total = 0;
            let hasItems = false;
            let orderItems = [];

            for (const [drinkName, quantity] of Object.entries(quantities)) {
                if (quantity > 0) {
                    // Try to find the item in the current DOM, else fall back to originalItems
                    let itemDiv = document.querySelector(`.item[data-name="${drinkName.replace(/"/g, '\\"')}"]`);
                    if (!itemDiv) {
                        itemDiv = originalItems.find(item => item.getAttribute('data-name') === drinkName);
                    }
                    if (itemDiv) {
                        const itemPrice = parseFloat(itemDiv.getAttribute('data-price'));
                        const itemIds = itemDiv.getAttribute('data-ids').split(',');
                        const itemId = itemIds[0]; // Use the first ID
                        message += `${quantity} ${drinkName}\n`;
                        total += quantity * itemPrice;
                        hasItems = true;
                        orderItems.push({ id: itemId, name: drinkName, quantity: quantity, price: itemPrice });
                    }
                }
            }

            if (!hasItems) {
                message = "Žádné položky nevybrány.";
                if (recordSaleLink) recordSaleLink.style.display = 'none';
            } else {
                message += `\nCelková částka: ${total.toFixed(2)} Kč`;
                if (recordSaleLink) {
                    recordSaleLink.style.display = 'block';
                    const orderData = {
                        items: orderItems,
                        total: total.toFixed(2)
                    };
                    const orderDataStr = encodeURIComponent(JSON.stringify(orderData));
                    recordSaleAnchor.href = `add_sale.php?order=${orderDataStr}`;
                }
            }

            messageDiv.textContent = message;
            return message;
        }

        // Update button states based on quantities
        function updateButtonStates() {
            document.querySelectorAll('.item').forEach(item => {
                const drinkName = item.getAttribute('data-name');
                const stock = parseInt(item.getAttribute('data-stock'));
                const quantity = quantities[drinkName] || 0;
                const plusButton = item.querySelector('.plus');
                const minusButton = item.querySelector('.minus');

                plusButton.disabled = quantity >= stock;
                minusButton.disabled = quantity <= 0;
            });
        }

        // Initial button state update
        updateButtonStates();

        // Copy message to clipboard
        document.getElementById('copy-message').addEventListener('click', () => {
            const message = updateOrderMessage();
            const copyButton = document.getElementById('copy-message');

            if (message === "Žádné položky nevybrány.") {
                alert('Žádné položky k zkopírování. Vyberte nějaké nápoje.');
                return;
            }

            const showCopyStatus = () => {
                const originalContent = '<i class="fas fa-copy"></i> Kopírovat objednávku';
                copyButton.innerHTML = '<i class="fas fa-copy"></i> Zkopírováno';
                setTimeout(() => {
                    copyButton.innerHTML = originalContent;
                }, 2000);
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(message).then(() => {
                    showCopyStatus();
                }).catch(err => {
                    console.error('Clipboard API failed: ', err);
                    try {
                        const textarea = document.createElement('textarea');
                        textarea.value = message;
                        document.body.appendChild(textarea);
                        textarea.select();
                        const success = document.execCommand('copy');
                        document.body.removeChild(textarea);
                        if (success) {
                            showCopyStatus();
                        } else {
                            alert('Nepodařilo se zkopírovat zprávu automaticky. Zkopíruj text výše ručně (vyber text a stiskni Ctrl+C nebo Cmd+C).');
                        }
                    } catch (execErr) {
                        console.error('execCommand failed: ', execErr);
                        alert('Nepodařilo se zkopírovat zprávu automaticky. Zkopíruj text výše ručně (vyber text a stiskni Ctrl+C nebo Cmd+C).');
                    }
                });
            } else {
                try {
                    const textarea = document.createElement('textarea');
                    textarea.value = message;
                    document.body.appendChild(textarea);
                    textarea.select();
                    const success = document.execCommand('copy');
                    document.body.removeChild(textarea);
                    if (success) {
                        showCopyStatus();
                    } else {
                        alert('Nepodařilo se zkopírovat zprávu automaticky. Zkopíruj text výše ručně (vyber text a stiskni Ctrl+C nebo Cmd+C).');
                    }
                } catch (err) {
                    console.error('Copy failed: ', err);
                    alert('Nepodařilo se zkopírovat zprávu automaticky. Zkopíruj text výše ručně (vyber text a stiskni Ctrl+C nebo Cmd+C).');
                }
            }
        });

        // Initialize item listeners for initial items
        document.querySelectorAll('.item').forEach(item => {
            updateItemListeners(item);
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>