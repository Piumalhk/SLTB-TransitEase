<?php
include '../includes/db.php';
include '../includes/header.php';

// Get search parameters from GET
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$date = $_GET['date'] ?? '';

$buses = [];

if ($from && $to && $date) {
    $from = $conn->real_escape_string($from);
    $to = $conn->real_escape_string($to);
    $date = $conn->real_escape_string($date);

    $sql = "SELECT s.id AS schedule_id, b.bus_number, b.bus_type, r.source, r.destination, s.departure_time, s.arrival_time, s.fare
            FROM schedules s
            JOIN buses b ON s.bus_id = b.id
            JOIN routes r ON s.route_id = r.id
            WHERE r.source='$from' AND r.destination='$to' AND s.travel_date='$date'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $buses[] = $row;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Search Results</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #010922, #88046B);
        }
        .bus-card {
            transition: transform 0.2s ease-in-out;
        }
        .bus-card:hover {
            transform: translateY(-5px);
        }
        .book-button {
            background-color: #e7ba04;
            color: black;
            border: 2px solid black;
            transition: background-color 0.3s ease;
        }
        .book-button:hover {
            background-color: #FFDB48;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Main Container -->
    <div class="container flex-1 w-full max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-white text-3xl md:text-4xl font-bold text-center mb-6">
            <?php echo $from && $to && $date ? "Buses from $from to $to on $date" : "Bus Search Results"; ?>
        </h1>
        
        <div id="resultsContainer" class="flex flex-col items-center space-y-6">
            <?php if (!empty($buses)): ?>
                <?php foreach($buses as $bus): ?>
                    <div class="bus-card bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                        <div class="flex-1">
                            <h2 class="text-xl md:text-2xl font-bold text-[#002597]"><?php echo $bus['bus_number']; ?></h2>
                            <p class="text-gray-600"><?php echo $bus['bus_type']; ?></p>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm"><span class="font-semibold">Departure:</span> <?php echo $bus['departure_time']; ?></p>
                                <p class="text-sm"><span class="font-semibold">Arrival:</span> <?php echo $bus['arrival_time']; ?></p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-center md:text-right space-y-2 md:space-y-0">
                            <img src="../assest/sltbbus.png" alt="Bus Image" class="w-28 h-20 object-cover mx-auto">
                            <p class="text-2xl font-bold text-[#e7ba04]">Rs. <?php echo $bus['fare']; ?></p>
                            <button onclick="window.location.href='busbooking.php?schedule_id=<?php echo $bus['schedule_id']; ?>'" class="book-button px-6 py-2 rounded-full font-semibold">Select Seats</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-white text-lg text-center my-8">
                    No buses found for this route. Please try a different search.
                </div>
            <?php endif; ?>
        </div>
    </div>
    
<?php include_once '../includes/footer.php'; ?>
</body>
</html>

