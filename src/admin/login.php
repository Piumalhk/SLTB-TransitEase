<?php
include '../includes/db.php'; // Adjust path
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT id, role, password_hash FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        if (hash('sha256', $password) === $row['password_hash']) { // Assuming SHA-256 hashing
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../assets/css/main.css"> <!-- Adjust path -->
    <style>
        .login-container { max-width: 400px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #e7ba04; color: black; padding: 10px; width: 100%; border: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin/Staff Login</h2>
        <?php if (isset($error)): ?><p style="color: red;"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>