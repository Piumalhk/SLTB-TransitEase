<?php
include 'includes/auth.php';
include '../includes/db.php'; // Adjust path based on structure
redirect_to_login();
restrict_to_admin();

$search_source = '';
$search_destination = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_source = $conn->real_escape_string($_GET['source'] ?? '');
    $search_destination = $conn->real_escape_string($_GET['destination'] ?? '');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $source = $conn->real_escape_string($_POST['source']);
        $destination = $conn->real_escape_string($_POST['destination']);
        $stops = $conn->real_escape_string($_POST['stops']);
        $sql = "INSERT INTO routes (source, destination, stops) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $source, $destination, $stops);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $source = $conn->real_escape_string($_POST['source']);
        $destination = $conn->real_escape_string($_POST['destination']);
        $stops = $conn->real_escape_string($_POST['stops']);
        $sql = "UPDATE routes SET source = ?, destination = ?, stops = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $source, $destination, $stops, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $sql = "DELETE FROM routes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch routes with search filter
$sql = "SELECT * FROM routes";
if ($search_source || $search_destination) {
    $sql .= " WHERE 1=1";
    if ($search_source) $sql .= " AND source LIKE ?";
    if ($search_destination) $sql .= " AND destination LIKE ?";
}
$stmt = $conn->prepare($sql);
if ($search_source || $search_destination) {
    $params = [];
    $types = '';
    if ($search_source) {
        $params[] = "%$search_source%";
        $types .= 's';
    }
    if ($search_destination) {
        $params[] = "%$search_destination%";
        $types .= 's';
    }
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$routes = [];
while ($row = $result->fetch_assoc()) {
    $routes[] = $row;
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Manage Routes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="manage.css">
</head>
<body>
    <div class="manage-container">
        <h2>Manage Routes</h2>

        <!-- Search Form -->
        <form method="GET" class="search-form">
            <input type="text" name="source" placeholder="Search by Source" value="<?php echo htmlspecialchars($search_source); ?>">
            <input type="text" name="destination" placeholder="Search by Destination" value="<?php echo htmlspecialchars($search_destination); ?>">
            <button type="submit" name="search">Search</button>
        </form>

        <form method="POST">
            <input type="text" name="source" placeholder="Source" required>
            <input type="text" name="destination" placeholder="Destination" required>
            <textarea name="stops" placeholder="Stops (comma-separated)" required></textarea>
            <button type="submit" name="add">Add Route</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Stops</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($routes as $route): ?>
                <tr>
                    <td><?php echo $route['id']; ?></td>
                    <td><?php echo htmlspecialchars($route['source']); ?></td>
                    <td><?php echo htmlspecialchars($route['destination']); ?></td>
                    <td><?php echo htmlspecialchars($route['stops']); ?></td>
                    <td>
                        <a href="?delete=<?php echo $route['id']; ?>&source=<?php echo urlencode($search_source); ?>&destination=<?php echo urlencode($search_destination); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $route['id']; ?>">
                            <input type="text" name="source" value="<?php echo htmlspecialchars($route['source']); ?>" required>
                            <input type="text" name="destination" value="<?php echo htmlspecialchars($route['destination']); ?>" required>
                            <textarea name="stops" required><?php echo htmlspecialchars($route['stops']); ?></textarea>
                            <button type="submit" name="update">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>