<?php
include 'db_connect.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    // Case-insensitive search for drinks that match the query
    $stmt = $conn->prepare("SELECT drink_id, drink_name FROM inventory WHERE LOWER(drink_name) LIKE LOWER(?)");
    $search = "%" . $query . "%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div onclick="selectDrink(' . $row['drink_id'] . ', \'' . $row['drink_name'] . '\')">' . $row['drink_name'] . '</div>';
        }
    } else {
        echo "No results found.";
    }

    $stmt->close();
}

$conn->close();
?>
