<?php
include 'includes/auth.php';
include '../includes/db.php'; 
redirect_to_login();
restrict_to_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add staff logic
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password_hash = hash('sha256', $_POST['password']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $sql = "INSERT INTO users (name, email, password_hash, phone, role) 
            VALUES ('$name', '$email', '$password_hash', '$phone', 'staff')";
    $conn->query($sql);
}

// Fetch staff
$sql = "SELECT id, name, email, phone FROM users WHERE role = 'staff'";
$result = $conn->query($sql);
$staff = [];
while ($row = $result->fetch_assoc()) {
    $staff[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-purple': '#88046B',
                        'stat-light-purple': '#C25BB4',
                        'stat-teal': '#008080',
                        'stat-gold': '#FFD700',
                        'stat-dark-purple': '#4B043A',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-6xl mx-auto py-10 px-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">👥 Manage Staff</h2>
            <a href="dashboard.php" class="bg-primary-purple text-white px-4 py-2 rounded-lg shadow hover:bg-stat-light-purple transition">
                ⬅ Back to Dashboard
            </a>
        </div>

        <!-- Staff Form -->
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">➕ Add New Staff</h3>
            <form method="POST" class="space-y-4">
                <input type="text" name="name" placeholder="Name" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-purple focus:outline-none">
                <input type="email" name="email" placeholder="Email" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-purple focus:outline-none">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-purple focus:outline-none">
                <input type="text" name="phone" placeholder="Phone" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-purple focus:outline-none">
                <button type="submit" class="bg-stat-gold text-black px-6 py-2 rounded-lg shadow hover:bg-yellow-400 transition">
                    Add Staff
                </button>
            </form>
        </div>

        <!-- Staff Table -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">📋 Staff List</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-primary-purple text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">Phone</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($staff as $s): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4"><?php echo $s['id']; ?></td>
                                <td class="py-3 px-4"><?php echo $s['name']; ?></td>
                                <td class="py-3 px-4"><?php echo $s['email']; ?></td>
                                <td class="py-3 px-4"><?php echo $s['phone']; ?></td>
                                <td class="py-3 px-4 text-center">
                                    <a href="?edit=<?php echo $s['id']; ?>" 
                                       class="text-blue-600 hover:underline">✏️ Edit</a> 
                                    | 
                                    <a href="?delete=<?php echo $s['id']; ?>" 
                                       class="text-red-600 hover:underline">🗑️ Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($staff)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No staff members found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
