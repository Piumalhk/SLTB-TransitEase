<?php
include 'db_connect.php'; // Ensure this file contains the correct database connection details

// Debugging: Check if GET parameters are received
if (isset($_GET['route_from']) && isset($_GET['route_to']) && isset($_GET['date'])) {
    $route_from = $_GET['route_from'];
    $route_to = $_GET['route_to'];
    $date = $_GET['date'];

    echo "Received: Route From - $route_from, Route To - $route_to, Date - $date<br>"; // Debugging output

    // Get the day of the week from the date
    $day_of_week = date('l', strtotime($date));

    // SQL query to fetch bus schedules
    $sql = "SELECT b.id, b.route_from, b.route_to, s.day_of_week, s.departure_time, s.arrival_time 
            FROM buses b
            JOIN weekly_schedules s ON b.id = s.bus_id
            WHERE b.route_from = ? AND b.route_to = ? AND s.day_of_week = ?";
    
    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sss", $route_from, $route_to, $day_of_week);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the results
    echo "<h2>Available Buses from $route_from to $route_to on $date ($day_of_week):</h2>";
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Route From</th>
                    <th>Route To</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Select</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['route_from']}</td>
                    <td>{$row['route_to']}</td>
                    <td>{$row['departure_time']}</td>
                    <td>{$row['arrival_time']}</td>
                    <td><button onclick=\"selectBus({$row['id']})\">Select</button></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "Sorry, no buses are available on this route for the selected date.";
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "Please provide route from, route to, and date parameters.";
}

$conn->close();
?>

<script>
function selectBus(busId) {
    // Implement the logic to select the bus and proceed to booking
    alert('Bus selected: ' + busId);
}
</script>
