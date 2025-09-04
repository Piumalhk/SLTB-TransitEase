<?php
include '../includes/db.php'; // Adjust path


$sql_bookings = "SELECT COUNT(*) AS total FROM main_bookings";
$total_bookings = $conn->query($sql_bookings)->fetch_assoc()['total'];

$sql_users = "SELECT COUNT(*) AS total FROM users WHERE role = 'staff'";
$total_staff = $conn->query($sql_users)->fetch_assoc()['total'];

$sql_buses = "SELECT COUNT(*) AS total FROM buses";
$total_buses = $conn->query($sql_buses)->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/main.css"> <!-- Adjust path -->
    <style>
        .dashboard { max-width: 800px; margin: 20px auto; }
        .stats { display: flex; gap: 20px; }
        .stat { background: #e7ba04; padding: 20px; border-radius: 10px; text-align: center; flex: 1; color: black; }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo $_SESSION['role']; ?></h2>
        <div class="stats">
            <div class="stat"><h3>Total Bookings</h3><p><?php echo $total_bookings; ?></p></div>
            <div class="stat"><h3>Total Staff</h3><p><?php echo $total_staff; ?></p></div>
            <div class="stat"><h3>Total Buses</h3><p><?php echo $total_buses; ?></p></div>
        </div>
        <a href="logout.php">Logout</a>
        
            <a href="manage_staff.php">Manage Staff</a> | <a href="manage_buses.php">Manage Buses</a> | <a href="manage_routes.php">Manage Routes</a> | <a href="manage_schedules.php">Manage Schedules</a> | <a href="publish_news.php">Publish News</a> | <a href="view_feedbacks.php">View Feedbacks</a>
        
        <a href="view_bookings.php">View Bookings</a>
    </div>
</body>
</html>