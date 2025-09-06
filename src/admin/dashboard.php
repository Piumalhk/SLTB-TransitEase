<?php
include 'includes/auth.php';
include '../includes/db.php'; // Adjust path
redirect_to_login();

// Fetch stats
$sql_bookings = "SELECT COUNT(*) AS total FROM main_bookings";
$total_bookings = $conn->query($sql_bookings)->fetch_assoc()['total'];

$sql_users = "SELECT COUNT(*) AS total FROM users WHERE role = 'staff'";
$total_staff = $conn->query($sql_users)->fetch_assoc()['total'];

$sql_buses = "SELECT COUNT(*) AS total FROM buses";
$total_buses = $conn->query($sql_buses)->fetch_assoc()['total'];


$sql_booking_cancellation = "SELECT COUNT(*) AS total FROM booking_cancellations";
$total_booking_cancellations = $conn->query($sql_booking_cancellation)->fetch_assoc()['total'];




$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SLTB Transit Ease Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-purple': '#88046B',
                        'stat-dark-purple': '#4B043A',
                        'stat-light-purple': '#C25BB4',
                        'stat-teal': '#008080',
                        'stat-gold': '#FFD700',
                        'stat-red': '#FF0000',
                        'stat-orange': '#FFA500',
                        'stat-blue': '#008000',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            background-color: #4B043A;
            color: white;
        }
        .stat-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-icon {
            font-size: 2.5rem;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .logo img {
            height: 60px;
            margin-right: 10px;
        }

        .logo-text {
            font-family: 'Righteous', sans-serif;
            color: #ffffff;
            font-weight: 500;
            font-size: 22px;
        }
    </style>
</head>
<body class="bg-gray-100 flex h-auto">

    <!-- Sidebar -->
    <aside class="sidebar w-64 p-6 hidden md:block">
        <div class="text-xl font-bold mb-8 flex items-center gap-2">
            <svg class="w-8 h-8 text-primary-purple" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm0 14a6 6 0 110-12 6 6 0 010 12z"></path>
            </svg>
            <div class="logo">
        <img src="../assest/Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
        <div class="logo-text">SLTB-Transit<span>Ease</span></div>
    </div>
        </div>
        <nav>
            <ul>
                <li class="mb-4"><a href="dashboard.php" class="flex items-center gap-2 text-white p-2 rounded-lg bg-primary-purple">📊 Dashboard</a></li>
                <li class="mb-4"><a href="view_bookings.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">🎫 Bookings</a></li>
                <li class="mb-4"><a href="manage_buses.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">🚌 Buses</a></li>
                <li class="mb-4"><a href="manage_routes.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">🛣️ Routes</a></li>
                <li class="mb-4"><a href="manage_schedules.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">🗓️ Schedules</a></li>
                <?php if (is_admin()): ?>
                <li class="mb-4"><a href="manage_staff.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">👥 Staff</a></li>
                <li class="mb-4"><a href="publish_news.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">📰 News</a></li>
                <li class="mb-4"><a href="view_feedbacks.php" class="flex items-center gap-2 text-gray-300 hover:text-white p-2 rounded-lg hover:bg-stat-light-purple">💬 Feedbacks</a></li>
                <?php endif; ?>
                 <li class="mt-8"><a href="../public/index.php" class="flex items-center gap-2 text-blue-400 hover:text-white p-2 rounded-lg hover:bg-blue-600">🗓️ Home</a></li>
                <li class="mt-6"><a href="logout.php" class="flex items-center gap-2 text-red-400 hover:text-white p-2 rounded-lg hover:bg-red-600">🚪 Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Welcome <span class="text-primary-purple"><?php echo ucfirst($_SESSION['role']); ?></span></h1>
            <div class="flex items-center gap-2">
                <span class="text-gray-500"><?php echo date("D/M/d/Y"); ?></span>
                <img src="https://placehold.co/40x40/cccccc/ffffff?text=U" alt="User Profile" class="w-10 h-10 rounded-full">
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="stat-card bg-stat-light-purple p-6 rounded-lg text-white text-center">
                <span class="stat-icon">🚌</span>
                <p class="text-4xl font-bold mt-2"><?php echo $total_bookings; ?></p>
                <h3 class="text-lg font-semibold mt-1">Total Bookings</h3>
            </div>
            <div class="stat-card bg-stat-gold p-6 rounded-lg text-white text-center">
                <span class="stat-icon">👥</span>
                <p class="text-4xl font-bold mt-2"><?php echo $total_staff; ?></p>
                <h3 class="text-lg font-semibold mt-1">Total Staff</h3>
            </div>
            <div class="stat-card bg-stat-teal p-6 rounded-lg text-white text-center">
                <span class="stat-icon">🚌</span>
                <p class="text-4xl font-bold mt-2"><?php echo $total_buses; ?></p>
                <h3 class="text-lg font-semibold mt-1">Total Buses</h3>
            </div>
             <div class="stat-card bg-stat-red p-6 rounded-lg text-white text-center">
                <span class="stat-icon">🚌</span>
                <p class="text-4xl font-bold mt-2"><?php echo $total_booking_cancellations; ?></p>
                <h3 class="text-lg font-semibold mt-1">Total Booking Cancellations</h3>
            </div>
             <div class="stat-card bg-stat-blue p-6 rounded-lg text-white text-center">
                <span class="stat-icon">🚌</span>
                <p class="text-4xl font-bold mt-2"><?php echo $total_buses; ?></p>
                <h3 class="text-lg font-semibold mt-1">Total Buses</h3>
            </div>
            <div class="stat-card bg-stat-orange p-6 rounded-lg text-white text-center">
                <span class="stat-icon">🚌</span>
                <p class="text-4xl font-bold mt-2"><?php echo $total_buses; ?></p>
                <h3 class="text-lg font-semibold mt-1">Total Buses</h3>
            </div>
        </div>

        <!-- Placeholder Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">📅 Bookings Due Today</h2>
            <p class="text-gray-600">This section will display a list of today's bookings.</p>
        </div>
    </main>

</body>
</html>
