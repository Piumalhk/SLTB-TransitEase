<?php
include '../includes/db.php';
include '../includes/header.php';

$schedule_id = $_GET['schedule_id'] ?? 0;
$seats = explode(',', $_GET['seats'] ?? '');
$total = $_GET['total'] ?? 0;

if ($schedule_id <= 0 || empty($seats) || $total <= 0) {
    echo "<p class='text-white text-center'>Invalid booking details.</p>";
    include '../includes/footer.php';
    exit;
}

$schedule_id = $conn->real_escape_string($schedule_id);

// Fetch bus schedule details
$sql = "SELECT s.id AS schedule_id, b.bus_number, b.bus_type, r.source, r.destination, s.departure_time, s.arrival_time, s.travel_date, s.fare
        FROM schedules s
        JOIN buses b ON s.bus_id = b.id
        JOIN routes r ON s.route_id = r.id
        WHERE s.id = '$schedule_id'";

$result = $conn->query($sql);
$bus = $result ? $result->fetch_assoc() : null;

if (!$bus) {
    echo "<p class='text-white text-center'>No bus found for this schedule.</p>";
    include '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passenger_name = $conn->real_escape_string($_POST['passenger_name']);
    $passenger_phone = $conn->real_escape_string($_POST['passenger_phone']);
    $passenger_email = $conn->real_escape_string($_POST['passenger_email'] ?? '');

    // Insert main booking
    $sql_main = "INSERT INTO main_bookings (schedule_id, passenger_name, passenger_phone, passenger_email, total_amount) 
                 VALUES ('$schedule_id', '$passenger_name', '$passenger_phone', '$passenger_email', '$total')";
    $conn->query($sql_main);
    $main_booking_id = $conn->insert_id;

    // Insert per-seat bookings
    foreach ($seats as $seat) {
        $seat = $conn->real_escape_string($seat);
        $sql_seat = "INSERT INTO bookings (schedule_id, passenger_name, passenger_phone, passenger_email, seat_number, status, main_booking_id) 
                     VALUES ('$schedule_id', '$passenger_name', '$passenger_phone', '$passenger_email', '$seat', 'booked', '$main_booking_id')";
        $conn->query($sql_seat);
    }

    $conn->close();

    // Redirect to payment page
    header("Location: payment.php?main_booking_id=$main_booking_id&total=$total");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Confirm Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: linear-gradient(to bottom, #010922, #88046B); color: white; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; background: rgba(255,255,255,0.1); border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
        .booking-details { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; box-sizing: border-box; font-size: 1rem; }
        .proceed { background-color: #e7ba04; color: black; padding: 12px 24px; border: none; border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 1.1rem; transition: background-color 0.3s; }
        .proceed:hover { background-color: #FFDB48; }
        .selected-seats { margin: 10px 0; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="booking-details">
            <h1 class="text-3xl font-bold mb-4">Confirm Booking for Bus <?php echo $bus['bus_number']; ?> (<?php echo $bus['bus_type']; ?>)</h1>
            <p class="text-lg">From: <?php echo $bus['source']; ?> To: <?php echo $bus['destination']; ?></p>
            <p class="text-lg">Date: <?php echo $bus['travel_date']; ?> | Departure: <?php echo $bus['departure_time']; ?> | Arrival: <?php echo $bus['arrival_time']; ?></p>
            <p class="selected-seats text-xl">Selected Seats: <?php echo implode(', ', $seats); ?></p>
            <p class="text-2xl font-bold text-[#e7ba04]">Total Fare: Rs. <?php echo $total; ?></p>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="passenger_name">Passenger Name *</label>
                <input type="text" id="passenger_name" name="passenger_name" required>
            </div>
            <div class="form-group">
                <label for="passenger_phone">Passenger Phone *</label>
                <input type="tel" id="passenger_phone" name="passenger_phone" required pattern="[0-9]{10}">
            </div>
            <div class="form-group">
                <label for="passenger_email">Passenger Email (Optional)</label>
                <input type="email" id="passenger_email" name="passenger_email">
            </div>
            <button type="submit" class="proceed w-full">Proceed to Payment</button>
        </form>
    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>
</html>