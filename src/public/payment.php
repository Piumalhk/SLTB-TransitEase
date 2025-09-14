<?php
include '../includes/db.php';
include '../includes/header.php';

$main_booking_id = $_GET['main_booking_id'] ?? 0;
$total = $_GET['total'] ?? 0;

if ($main_booking_id <= 0 || $total <= 0) {
    echo "<p class='text-white text-center'>Invalid payment details.</p>";
    include '../includes/footer.php';
    exit;
}

$main_booking_id = $conn->real_escape_string($main_booking_id);

// Fetch main booking details for display
$sql = "SELECT mb.*, s.travel_date, s.departure_time, s.arrival_time, r.source, r.destination, b.bus_number
        FROM main_bookings mb
        JOIN schedules s ON mb.schedule_id = s.id
        JOIN routes r ON s.route_id = r.id
        JOIN buses b ON s.bus_id = b.id
        WHERE mb.id = '$main_booking_id'";

$result = $conn->query($sql);
$booking = $result ? $result->fetch_assoc() : null;

if (!$booking) {
    echo "<p class='text-white text-center'>No booking found.</p>";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate payment success
    $method = 'Card'; // Mock
    $sql_payment = "INSERT INTO payments (main_booking_id, amount, method, status) 
                    VALUES ('$main_booking_id', '$total', '$method', 'paid')";
    $conn->query($sql_payment);

    // Update main booking status
    $conn->query("UPDATE main_bookings SET status = 'confirmed' WHERE id = '$main_booking_id'");

    $conn->close();

    // Redirect to confirmation
    header("Location: confirmation.php?main_booking_id=$main_booking_id");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Payment Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: linear-gradient(to bottom, #010922, #88046B); color: white; }
        .container { max-width: 600px; margin: 0 auto; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.3); }
        .payment-details { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; font-size: 1.1rem; }
        .form-group input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; box-sizing: border-box; font-size: 1rem; background: #fff; color: #000; }
        .pay-button { background-color: #e7ba04; color: black; padding: 15px; border: none; border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 1.2rem; transition: background-color 0.3s, transform 0.2s; width: 100%; }
        .pay-button:hover { background-color: #FFDB48; transform: scale(1.05); }
        .card-icons { display: flex; justify-content: center; gap: 20px; margin-bottom: 20px; }
        .card-icons img { width: 60px; opacity: 0.9; transition: opacity 0.3s; }
        .card-icons img:hover { opacity: 1; }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-details">
            <h1 class="text-3xl font-bold mb-4">Secure Payment for Booking #<?php echo $main_booking_id; ?></h1>
            <p class="text-lg">Bus: <?php echo $booking['bus_number']; ?> | From: <?php echo $booking['source']; ?> to <?php echo $booking['destination']; ?></p>
            <p class="text-lg">Date: <?php echo $booking['travel_date']; ?> | Seats: <?php echo implode(', ', $seats); ?></p>
            <p class="text-2xl font-bold text-[#e7ba04]">Total: Rs. <?php echo $total; ?></p>
        </div>

        <div class="card-icons">
            <img src="../assest/visa.png" alt="Visa">
            <img src="../assest/master.png" alt="Mastercard">
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="card_number">Card Number *</label>
                <input type="text" id="card_number" name="card_number" required placeholder="1234 5678 9012 3456" maxlength="19">
            </div>
            <div class="form-group flex space-x-4">
                <div class="w-1/2">
                    <label for="expiry">Expiry Date *</label>
                    <input type="text" id="expiry" name="expiry" required placeholder="MM/YY">
                </div>
                <div class="w-1/2">
                    <label for="cvv">CVV *</label>
                    <input type="text" id="cvv" name="cvv" required placeholder="123" maxlength="3">
                </div>
            </div>
            <button type="submit" class="pay-button">Pay Now</button>
        </form>
    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>
</html>