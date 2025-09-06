<?php
include '../includes/db.php'; // Adjust path
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']); // Admin or Staff

    $sql = "SELECT id, role, password_hash FROM users WHERE email = '$email' AND role = '$role'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        if (hash('sha256', $password) === $row['password_hash']) { // SHA-256 check
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header('Location: dashboard.php');
            exit;
        }
    }
    $error = 'Invalid credentials';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin/Staff Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/fonts.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom, #010922, #88046B);;
        }
        .login-card-container {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1),
                        0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .toggle-btn {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        .toggle-btn.active {
            background-color: #88046B;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
             
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
            color: white;
            font-weight: 500;
            font-size: 22px;
        }
    </style>
</head>
<body class="bg-gray flex items-center justify-center min-h-screen">

    <div class="login-card-container flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-3xl overflow-hidden m-4">

        <!-- Left banner -->
        <div class="relative flex-1 bg-[#88046B] text-white p-8 md:p-12 flex flex-col justify-center items-center text-center">
            <div class="logo">
        <img src="../assest/Bus-logo-temokate-on-transparent-background-PNG-removebg-preview.png" alt="Bus Logo">
        <div class="logo-text">SLTB-Transit<span>Ease</span></div>
    </div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-md">
                Welcome to SLTB TransitEase Admin Portal!
            </h1>
            <p class="text-lg md:text-xl max-w-xs mb-8 drop-shadow-md">Only for Admin and SLTB Staff</p>
            <div>
                <a href="../public/index.php" class="bg-white text-[#88046B] py-2 px-4 rounded-lg">Home</a>
            </div>
        </div>

        <!-- Right side - Login form -->
        <div class="flex-1 p-8 md:p-12 flex flex-col justify-center">
            
            <!-- Error -->
            <?php if (isset($error)): ?>
                <p class="text-red-500 mb-4"><?php echo $error; ?></p>
            <?php endif; ?>

            <!-- Toggle buttons -->
            <div class="flex rounded-lg overflow-hidden mb-6">
                <button id="admin-btn" class="flex-1 py-3 px-4 text-center font-medium rounded-l-lg toggle-btn active" onclick="showForm('admin')">Admin</button>
                <button id="staff-btn" class="flex-1 py-3 px-4 text-center font-medium rounded-r-lg toggle-btn" onclick="showForm('staff')">Staff</button>
            </div>

            <!-- Admin Form -->
            <form id="admin-form" method="POST" class="space-y-6">
                <input type="hidden" name="role" value="Admin">
                <div>
                    <input type="email" name="email" class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#88046B]" placeholder="Admin Email" required>
                </div>
                <div>
                    <input type="password" name="password" class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#88046B]" placeholder="Admin Password" required>
                </div>
                <div>
                    <button type="submit" class="w-full py-3 px-4 rounded-lg shadow-sm text-lg font-medium text-white bg-[#88046B] hover:bg-[#6a0353] transform transition duration-200 hover:scale-105">Login</button>
                </div>
            </form>

            <!-- Staff Form -->
            <form id="staff-form" method="POST" class="space-y-6 hidden">
                <input type="hidden" name="role" value="Staff">
                <div>
                    <input type="email" name="email" class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#88046B]" placeholder="Staff Email" required>
                </div>
                <div>
                    <input type="password" name="password" class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#88046B]" placeholder="Staff Password" required>
                </div>
                <div>
                    <button type="submit" class="w-full py-3 px-4 rounded-lg shadow-sm text-lg font-medium text-white bg-[#88046B] hover:bg-[#6a0353] transform transition duration-200 hover:scale-105">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showForm(form) {
            const adminForm = document.getElementById('admin-form');
            const staffForm = document.getElementById('staff-form');
            const adminBtn = document.getElementById('admin-btn');
            const staffBtn = document.getElementById('staff-btn');

            if (form === 'admin') {
                adminForm.classList.remove('hidden');
                staffForm.classList.add('hidden');
                adminBtn.classList.add('active');
                staffBtn.classList.remove('active');
            } else {
                adminForm.classList.add('hidden');
                staffForm.classList.remove('hidden');
                adminBtn.classList.remove('active');
                staffBtn.classList.add('active');
            }
        }
    </script>
</body>
</html>
