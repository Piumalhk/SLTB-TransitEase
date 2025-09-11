<?php
include '../includes/db.php';
include '../includes/header.php';

$schedule_id = $_GET['schedule_id'] ?? 0;

if ($schedule_id <= 0) {
    echo "<p class='text-white text-center'>Invalid schedule ID.</p>";
    include '../includes/footer.php';
    exit;
}

$schedule_id = $conn->real_escape_string($schedule_id);

// Fetch bus schedule details
$sql = "SELECT s.id AS schedule_id, b.bus_number, b.bus_type, r.source, r.destination, s.departure_time, s.arrival_time, s.fare, s.travel_date
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

// Fetch seat statuses (assuming bookings table exists with columns: schedule_id, seat_number, status)
$seat_status = [];
$sql_seats = "SELECT seat_number, status FROM bookings WHERE schedule_id = '$schedule_id'";
$result_seats = $conn->query($sql_seats);
if ($result_seats) {
    while ($row = $result_seats->fetch_assoc()) {
        $seat_num = str_pad($row['seat_number'], 2, '0', STR_PAD_LEFT);
        $seat_status[$seat_num] = $row['status']; // status: 'booked', 'counter', 'processing'
    }
}

$conn->close();

// Define seat numbers for each "row" in the layout
$left_window = range(1, 41, 4); // 01,05,...,41
$left_aisle = range(2, 42, 4); // 02,06,...,42
$right_aisle = range(3, 43, 4); // 03,07,...,43
$right_window = range(4, 44, 4); // 04,08,...,44

// Back seats 45-50
$back_seats = [50, 49, 48, 47, 46, 45]; // Ordered top to bottom, with gap before 46
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLTB-TransitEase - Select Seats</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #010922, #88046B);
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .bus-details {
            text-align: center;
            margin-bottom: 20px;
        }
        .seat-map {
            position: relative;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .main-seats {
            display: flex;
            flex-direction: column-reverse;
        }
        .seat-row {
            display: flex;
        }
        .back-seats {
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }
        .gap {
            height: 50px; /* Adjust based on seat height + margin */
        }
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid black;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }
        .seat.available {
            background-color: white;
            color: black;
        }
        .seat.processing {
            background-color: green;
            color: white;
        }
        .seat.counter {
            background-color: orange;
            color: black;
        }
        .seat.booked {
            background-color: red;
            color: white;
            cursor: not-allowed;
        }
        .legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .legend .seat {
            cursor: default;
            margin: 0;
        }
        .driver {
            position: absolute;
            top: 0;
            left: -50px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: black;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .proceed {
            background-color: orange;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .proceed:hover {
            background-color: #FFDB48;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bus-details">
            <h1>Select Seats for Bus <?php echo $bus['bus_number']; ?> (<?php echo $bus['bus_type']; ?>)</h1>
            <p>From: <?php echo $bus['source']; ?> To: <?php echo $bus['destination']; ?></p>
            <p>Date: <?php echo $bus['travel_date']; ?> | Departure: <?php echo $bus['departure_time']; ?> | Arrival: <?php echo $bus['arrival_time']; ?></p>
            <p>Fare per seat: Rs. <?php echo $bus['fare']; ?></p>
        </div>

        <div class="legend">
            <div class="legend-item"><div class="seat available"></div> Available Seats</div>
            <div class="legend-item"><div class="seat processing"></div> Processing Seats</div>
            <div class="legend-item"><div class="seat counter"></div> Counter Seats</div>
            <div class="legend-item"><div class="seat booked"></div> Booked Seats</div>
        </div>

        <div class="seat-map">
            <div class="driver">🚗</div> <!-- Steering wheel emoji as placeholder -->
            <div class="main-seats">
                <div class="seat-row"> <!-- Bottom row: Left window (A) -->
                    <?php foreach ($left_window as $s): $seat = str_pad($s, 2, '0', STR_PAD_LEFT); $status = $seat_status[$seat] ?? 'available'; ?>
                        <div class="seat <?php echo $status; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="seat-row"> <!-- Left aisle (B) -->
                    <?php foreach ($left_aisle as $s): $seat = str_pad($s, 2, '0', STR_PAD_LEFT); $status = $seat_status[$seat] ?? 'available'; ?>
                        <div class="seat <?php echo $status; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="seat-row"> <!-- Right aisle (C) -->
                    <?php foreach ($right_aisle as $s): $seat = str_pad($s, 2, '0', STR_PAD_LEFT); $status = $seat_status[$seat] ?? 'available'; ?>
                        <div class="seat <?php echo $status; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="seat-row"> <!-- Top row: Right window (D) -->
                    <?php foreach ($right_window as $s): $seat = str_pad($s, 2, '0', STR_PAD_LEFT); $status = $seat_status[$seat] ?? 'available'; ?>
                        <div class="seat <?php echo $status; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="back-seats">
                <?php foreach ([50,49,48,47] as $s): $seat = str_pad($s, 2, '0', STR_PAD_LEFT); $status = $seat_status[$seat] ?? 'available'; ?>
                    <div class="seat <?php echo $status; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                <?php endforeach; ?>
                <div class="gap"></div>
                <?php foreach ([46,45] as $s): $seat = str_pad($s, 2, '0', STR_PAD_LEFT); $status = $seat_status[$seat] ?? 'available'; ?>
                    <div class="seat <?php echo $status; ?>" data-seat="<?php echo $seat; ?>"><?php echo $seat; ?></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="text-center">
            <p>Selected Seats: <span id="selected-seats"></span></p>
            <p>Total Fare: Rs. <span id="total-fare">0</span></p>
            <button class="proceed" onclick="proceedToPayment()">Proceed</button>
        </div>
    </div>

    <?php include_once '../includes/footer.php'; ?>

    <script>
        let selectedSeats = [];
        const farePerSeat = <?php echo $bus['fare']; ?>;
        const seats = document.querySelectorAll('.seat.available, .seat.counter'); // Assuming counter can be selected, adjust if not

        seats.forEach(seat => {
            seat.addEventListener('click', () => {
                if (seat.classList.contains('booked')) return; // Can't select booked

                if (seat.classList.contains('processing')) {
                    seat.classList.remove('processing');
                    selectedSeats = selectedSeats.filter(s => s !== seat.dataset.seat);
                } else {
                    seat.classList.add('processing');
                    selectedSeats.push(seat.dataset.seat);
                }

                document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                document.getElementById('total-fare').textContent = selectedSeats.length * farePerSeat;
            });
        });

        function proceedToPayment() {
            if (selectedSeats.length === 0) {
                alert('Please select at least one seat.');
                return;
            }
            // Navigate to booking details page
            window.location.href = `booking_details.php?schedule_id=<?php echo $schedule_id; ?>&seats=${selectedSeats.join(',')}&total=${selectedSeats.length * farePerSeat}`;
        }
    </script>
</body>
</html>