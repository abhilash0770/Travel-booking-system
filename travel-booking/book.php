<?php
session_start();

// Dummy user ID for now (replace with actual session user ID if you have login system)
$user_id = $_SESSION['user_id'] ?? 1;

// Connect to database
$conn = new mysqli("localhost", "root", "", "travel_booking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check cart
if (empty($_SESSION['cart'])) {
    echo "Cart is empty. <a href='cart.php'>Go back</a>";
    exit();
}

// Insert each item into bookings
foreach ($_SESSION['cart'] as $package_id) {
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, package_id, booking_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $package_id);
    $stmt->execute();
    $stmt->close();
}

// Clear the cart
$_SESSION['cart'] = [];

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed</title>
</head>
<body>
    <h2 align="center">Booking Successful!</h2>
    <p align="center"><a href="bookings.php">View My Bookings</a></p>
</body>
</html>
