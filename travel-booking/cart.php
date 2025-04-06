<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "travel_booking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - Travel Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            margin-top: 20px;
        }
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, td, th {
            border: 1px solid #333;
            padding: 10px;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .form-center {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<h2 align="center">Your Cart</h2>

<?php
if (empty($_SESSION['cart'])) {
    echo "<p align='center'>Your cart is empty.</p>";
} else {
    echo "<table>";
    echo "<tr><th>Package Name</th><th>Location</th><th>Price</th><th>Action</th></tr>";

    foreach ($_SESSION['cart'] as $package_id) {
        $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['location']) . "</td>";
            echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
            echo "<td><a href='remove_from_cart.php?package_id=" . $package_id . "' class='btn'>Remove</a></td>";
            echo "</tr>";
        }

        $stmt->close();
    }

    echo "</table>";

    // Book Now Button
    echo '<div class="form-center">';
    echo '<form method="post" action="book.php">';
    echo '<button type="submit" class="btn">Book Now</button>';
    echo '</form>';
    echo '</div>';
}

$conn->close();
?>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php'; ?>

</body>
</html>
