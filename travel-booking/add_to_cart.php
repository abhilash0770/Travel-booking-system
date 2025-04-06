<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Avoid duplicates
    if (!in_array($package_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $package_id;
    }

    // Redirect back to home or packages page
    header("Location: index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
