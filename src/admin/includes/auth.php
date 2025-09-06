<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function is_admin() {
    return is_logged_in() && $_SESSION['role'] === 'admin';
}

function redirect_to_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function restrict_to_admin() {
    if (!is_admin()) {
        header('Location: dashboard.php'); // Or show error
        exit;
    }
}
?>