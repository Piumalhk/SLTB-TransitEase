<?php
include '../includes/db.php';
include '../includes/header.php';

$main_booking_id = $_GET['main_booking_id'] ?? 0;

if ($main_booking_id <= 0) {
    echo "<p class='text-white text-center'>Invalid booking ID.</p>";
    include '../includes/footer.php';
    exit;
}

$main_booking_id = $conn->real_escape_string($main_booking_id);

// Fetch details
$sql = "SELECT mb.*, s.travel_date, s.departure_time, s.arrival_time, r.source, r.destination, b.bus_number
        FROM main_bookings mb
        JOIN schedules s ON mb.schedule_id = s.id
        JOIN routes r ON s.route_id = r.id
        JOIN buses b ON s.bus_id = b.id
        WHERE mb.id = '$main_booking_id' AND mb.status = 'confirmed'";

$result = $conn->query($sql);
$booking = $result ? $result->fetch_assoc() : null;

if (!$booking) {
    echo "<p class='text-white text-center'>Booking not confirmed or not found.</p>";
    include '../includes/footer.php';
    exit;
}

// Fetch seats
$seats_sql = "SELECT seat_number FROM bookings WHERE main_booking_id = '$main_booking_id'";
$seats_result = $conn->query($seats_sql);
$seats = [];
while ($row = $seats_result->fetch_assoc()) {
    $seats[] = $row['seat_number'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Booking Confirmation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: linear-gradient(to bottom, #010922, #88046B); color: white; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px; background: rgba(17, 39, 107, 0.8); border-radius: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.4); text-align: center; }
        .success-msg { font-size: 2.5rem; font-weight: bold; color: #e7ba04; margin-bottom: 20px; animation: fadeIn 1s ease-in; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .details { margin-bottom: 30px; font-size: 1.2rem; }
        .action-buttons { display: flex; justify-content: center; gap: 20px; }
        .btn { padding: 15px 30px; border-radius: 50px; font-weight: bold; font-size: 1.1rem; transition: transform 0.2s, background-color 0.3s; cursor: pointer; }
        .download-btn { background-color: #e7ba04; color: black; border: none; }
        .download-btn:hover { background-color: #FFDB48; transform: scale(1.05); }
        .cancel-btn { background-color: #dc3545; color: white; border: none; }
        .cancel-btn:hover { background-color: #c82333; transform: scale(1.05); }
        .view-btn { background-color: #11276B; color: white; border: none; }
        .view-btn:hover { background-color: #0d1f57; transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="success-msg">Congratulations! Your Booking is Successful.</h1>
        <p class="details">Booking ID: #<?php echo $main_booking_id; ?></p>
        <p class="details">Bus: <?php echo $booking['bus_number']; ?> | From: <?php echo $booking['source']; ?> to <?php echo $booking['destination']; ?></p>
        <p class="details">Date: <?php echo $booking['travel_date']; ?> | Departure: <?php echo $booking['departure_time']; ?></p>
        <p class="details">Seats: <?php echo implode(', ', $seats); ?> | Total Paid: Rs. <?php echo $booking['total_amount']; ?></p>

        <div class="action-buttons">
            <a href="generate_bill.php?main_booking_id=<?php echo $main_booking_id; ?>" class="btn download-btn" target="_blank">Download E-Bill</a>
            <button onclick="if(confirm('Are you sure you want to cancel this booking?')) window.location.href='cancel_booking.php?main_booking_id=<?php echo $main_booking_id; ?>'" class="btn cancel-btn">Cancel Booking</button>
            <a href="my_bookings.php" class="btn view-btn">View My Bookings</a>
        </div>
    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>
</html>