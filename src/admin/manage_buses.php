<?php
include 'includes/auth.php';
include '../includes/db.php'; 

redirect_to_login();
restrict_to_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bus_number = $conn->real_escape_string($_POST['bus_number']);
    $bus_type = $conn->real_escape_string($_POST['bus_type']);
    $total_seats = (int)$_POST['total_seats'];
    $status = $conn->real_escape_string($_POST['status']);
    $sql = "INSERT INTO buses (bus_number, bus_type, total_seats, status) VALUES ('$bus_number', '$bus_type', $total_seats, '$status')";
    $conn->query($sql);
}

// Fetch buses
$sql = "SELECT * FROM buses";
$result = $conn->query($sql);
$buses = [];
while ($row = $result->fetch_assoc()) {
    $buses[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Buses</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f8f9fa;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #88046B; /* Primary color */
        }
        form {
            max-width: 450px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #88046B; /* Primary */
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #6c024f; /* Darker shade for hover */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px auto;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th {
            background: #e7ba04; /* Secondary accent */
            color: black;
            text-align: left;
            padding: 12px;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        a {
            color: #88046B; /* Primary links */
            text-decoration: none;
            margin: 0 5px;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-link {
            display: block;
            text-align: center;
            margin: 20px auto;
            color: #88046B;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Manage Buses</h2>
    <form method="POST">
        <input type="text" name="bus_number" placeholder="Bus Number" required>
        <select name="bus_type" required>
            <option value="Normal">Normal</option>
            <option value="Semi-Luxury">Semi-Luxury</option>
            <option value="Luxury">Luxury</option>
            <option value="AC">AC</option>
        </select>
        <input type="number" name="total_seats" placeholder="Total Seats" required>
        <select name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button type="submit">Add Bus</button>
    </form>
    <table>
        <tr><th>ID</th><th>Bus Number</th><th>Type</th><th>Seats</th><th>Status</th><th>Actions</th></tr>
        <?php foreach ($buses as $b): ?>
            <tr>
                <td><?php echo $b['id']; ?></td>
                <td><?php echo $b['bus_number']; ?></td>
                <td><?php echo $b['bus_type']; ?></td>
                <td><?php echo $b['total_seats']; ?></td>
                <td><?php echo $b['status']; ?></td>
                <td><a href="?delete=<?php echo $b['id']; ?>">Delete</a> | <a href="?edit=<?php echo $b['id']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php" class="back-link">⬅ Back to Dashboard</a>
</body>
</html>

