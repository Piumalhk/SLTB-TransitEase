<?php
include 'includes/auth.php';
include '../includes/db.php'; // Adjust path based on structure
redirect_to_login();
restrict_to_admin();

$search_bus = '';
$search_source = '';
$search_destination = '';
$search_date = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_bus = $conn->real_escape_string($_GET['bus'] ?? '');
    $search_source = $conn->real_escape_string($_GET['source'] ?? '');
    $search_destination = $conn->real_escape_string($_GET['destination'] ?? '');
    $search_date = $conn->real_escape_string($_GET['date'] ?? '');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $bus_id = (int)$_POST['bus_id'];
        $route_id = (int)$_POST['route_id'];
        $departure_time = $conn->real_escape_string($_POST['departure_time']);
        $arrival_time = $conn->real_escape_string($_POST['arrival_time']);
        $travel_date = $conn->real_escape_string($_POST['travel_date']);
        $fare = (float)$_POST['fare'];
        $sql = "INSERT INTO schedules (bus_id, route_id, departure_time, arrival_time, travel_date, fare) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $bus_id, $route_id, $departure_time, $arrival_time, $travel_date, $fare);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $bus_id = (int)$_POST['bus_id'];
        $route_id = (int)$_POST['route_id'];
        $departure_time = $conn->real_escape_string($_POST['departure_time']);
        $arrival_time = $conn->real_escape_string($_POST['arrival_time']);
        $travel_date = $conn->real_escape_string($_POST['travel_date']);
        $fare = (float)$_POST['fare'];
        $sql = "UPDATE schedules SET bus_id = ?, route_id = ?, departure_time = ?, arrival_time = ?, travel_date = ?, fare = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssd", $bus_id, $route_id, $departure_time, $arrival_time, $travel_date, $fare, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $sql = "DELETE FROM schedules WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch buses and routes for dropdowns
$buses_sql = "SELECT id, bus_number FROM buses";
$buses_result = $conn->query($buses_sql);
$buses = [];
while ($row = $buses_result->fetch_assoc()) {
    $buses[$row['id']] = $row['bus_number'];
}

$routes_sql = "SELECT id, source, destination FROM routes";
$routes_result = $conn->query($routes_sql);
$routes = [];
while ($row = $routes_result->fetch_assoc()) {
    $routes[$row['id']] = $row['source'] . ' to ' . $row['destination'];
}

// Fetch schedules with search filter
$sql = "SELECT s.id, s.bus_id, s.route_id, s.departure_time, s.arrival_time, s.travel_date, s.fare, b.bus_number, r.source, r.destination 
        FROM schedules s 
        JOIN buses b ON s.bus_id = b.id 
        JOIN routes r ON s.route_id = r.id";
if ($search_bus || $search_source || $search_destination || $search_date) {
    $sql .= " WHERE 1=1";
    if ($search_bus) $sql .= " AND b.bus_number LIKE ?";
    if ($search_source) $sql .= " AND r.source LIKE ?";
    if ($search_destination) $sql .= " AND r.destination LIKE ?";
    if ($search_date) $sql .= " AND s.travel_date LIKE ?";
}
$stmt = $conn->prepare($sql);
if ($search_bus || $search_source || $search_destination || $search_date) {
    $params = [];
    $types = '';
    if ($search_bus) {
        $params[] = "%$search_bus%";
        $types .= 's';
    }
    if ($search_source) {
        $params[] = "%$search_source%";
        $types .= 's';
    }
    if ($search_destination) {
        $params[] = "%$search_destination%";
        $types .= 's';
    }
    if ($search_date) {
        $params[] = "%$search_date%";
        $types .= 's';
    }
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$schedules = [];
while ($row = $result->fetch_assoc()) {
    $schedules[] = $row;
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Manage Schedules</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="manage.css">
</head>
<body>
    <div class="manage-container">
        <h2>Manage Schedules</h2>

        <!-- Search Form -->
        <form method="GET" class="search-form">
            <input type="text" name="bus" placeholder="Search by Bus Number" value="<?php echo htmlspecialchars($search_bus); ?>">
            <input type="text" name="source" placeholder="Search by Source" value="<?php echo htmlspecialchars($search_source); ?>">
            <input type="text" name="destination" placeholder="Search by Destination" value="<?php echo htmlspecialchars($search_destination); ?>">
            <input type="date" name="date" placeholder="Search by Date" value="<?php echo htmlspecialchars($search_date); ?>">
            <button type="submit" name="search">Search</button>
        </form>

        <form method="POST">
            <select name="bus_id" required>
                <option value="">Select Bus</option>
                <?php foreach ($buses as $id => $bus_number): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($bus_number); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="route_id" required>
                <option value="">Select Route</option>
                <?php foreach ($routes as $id => $route): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($route); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="time" name="departure_time" placeholder="Departure Time" required>
            <input type="time" name="arrival_time" placeholder="Arrival Time" required>
            <input type="date" name="travel_date" value="<?php echo date('Y-m-d'); ?>" required>
            <input type="number" name="fare" step="0.01" placeholder="Fare (LKR)" required>
            <button type="submit" name="add">Add Schedule</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Bus</th>
                <th>Route</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Date</th>
                <th>Fare</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($schedules as $schedule): ?>
                <tr>
                    <td><?php echo $schedule['id']; ?></td>
                    <td><?php echo htmlspecialchars($schedule['bus_number']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['source'] . ' to ' . $schedule['destination']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['departure_time']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['arrival_time']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['travel_date']); ?></td>
                    <td><?php echo htmlspecialchars($schedule['fare']); ?></td>
                    <td>
                        <a href="?delete=<?php echo $schedule['id']; ?>&bus=<?php echo urlencode($search_bus); ?>&source=<?php echo urlencode($search_source); ?>&destination=<?php echo urlencode($search_destination); ?>&date=<?php echo urlencode($search_date); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">
                            <select name="bus_id" required>
                                <?php foreach ($buses as $id => $bus_number): ?>
                                    <option value="<?php echo $id; ?>" <?php echo $id == $schedule['bus_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($bus_number); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select name="route_id" required>
                                <?php foreach ($routes as $id => $route): ?>
                                    <option value="<?php echo $id; ?>" <?php echo $id == $schedule['route_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($route); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="time" name="departure_time" value="<?php echo htmlspecialchars($schedule['departure_time']); ?>" required>
                            <input type="time" name="arrival_time" value="<?php echo htmlspecialchars($schedule['arrival_time']); ?>" required>
                            <input type="date" name="travel_date" value="<?php echo htmlspecialchars($schedule['travel_date']); ?>" required>
                            <input type="number" name="fare" step="0.01" value="<?php echo htmlspecialchars($schedule['fare']); ?>" required>
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