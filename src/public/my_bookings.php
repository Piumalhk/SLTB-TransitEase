<?php
include '../includes/db.php';
include '../includes/header.php';

$phone = $_POST['phone'] ?? '';
$bookings = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $phone) {
    $phone = $conn->real_escape_string($phone);
    $sql = "SELECT mb.*, s.travel_date, s.departure_time, r.source, r.destination, b.bus_number
            FROM main_bookings mb
            JOIN schedules s ON mb.schedule_id = s.id
            JOIN routes r ON s.route_id = r.id
            JOIN buses b ON s.bus_id = b.id
            WHERE mb.passenger_phone = '$phone'";

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
}

// Fetch seats for each booking (keep connection open until here)
foreach ($bookings as &$booking) {
    $seats_sql = "SELECT seat_number FROM bookings WHERE main_booking_id = '{$booking['id']}'";
    $seats_result = $conn->query($seats_sql); // This line was causing the error
    $seats = [];
    while ($row = $seats_result->fetch_assoc()) {
        $seats[] = $row['seat_number'];
    }
    $booking['seats'] = $seats; // Add seats to the booking array
}

$conn->close(); // Close connection after all operations
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - My Bookings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: linear-gradient(to bottom, #010922, #88046B); color: white; }
        .container { max-width: 900px; margin: 0 auto; padding: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; }
        .submit-btn { background-color: #e7ba04; color: black; padding: 12px; border: none; border-radius: 50px; cursor: pointer; width: 100%; font-weight: bold; }
        .submit-btn:hover { background-color: #FFDB48; }
        .booking-card { background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .booking-card h2 { color: #e7ba04; }
        .actions { display: flex; gap: 10px; margin-top: 10px; }
        .btn { padding: 10px 20px; border-radius: 30px; font-weight: bold; cursor: pointer; }
        .download-btn { background-color: #e7ba04; color: black; }
        .cancel-btn { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-3xl font-bold text-center mb-8">View My Bookings</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="phone">Enter Your Phone Number *</label>
                <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}">
            </div>
            <button type="submit" class="submit-btn">Search Bookings</button>
        </form>

        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <h2>Booking #<?php echo $booking['id']; ?> (Status: <?php echo ucfirst($booking['status']); ?>)</h2>
                    <p>Bus: <?php echo $booking['bus_number']; ?> | From: <?php echo $booking['source']; ?> to <?php echo $booking['destination']; ?></p>
                    <p>Date: <?php echo $booking['travel_date']; ?> | Departure: <?php echo $booking['departure_time']; ?></p>
                    <p>Seats: <?php echo implode(', ', $booking['seats']); ?> | Total: Rs. <?php echo $booking['total_amount']; ?></p>
                    <div class="actions">
                        <?php if ($booking['status'] === 'confirmed'): ?>
                            <a href="generate_bill.php?main_booking_id=<?php echo $booking['id']; ?>" class="btn download-btn" target="_blank">Download E-Bill</a>
                        <?php endif; ?>
                        <?php if ($booking['status'] !== 'cancelled'): ?>
                            <button onclick="if(confirm('Cancel this booking?')) window.location.href='cancel_booking.php?main_booking_id=<?php echo $booking['id']; ?>'" class="btn cancel-btn">Booking Cancel</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="text-center text-red-500">No bookings found for this phone number.</p>
        <?php endif; ?>
    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>
</html>