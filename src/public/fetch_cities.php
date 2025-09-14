<?php
include '../includes/db.php'; // Adjust path based on your structure

// Get the search term from the AJAX request
$searchTerm = isset($_GET['term']) ? $conn->real_escape_string($_GET['term']) : '';

if (!empty($searchTerm)) {
    // Query to get cities matching the search term
    $sql = "SELECT city_name FROM cities WHERE city_name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row['city_name'];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($cities);
}

$conn->close();
?>