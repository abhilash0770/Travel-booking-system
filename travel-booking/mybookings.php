<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "travel_booking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT b.booking_date, p.title, p.price FROM bookings b 
        JOIN packages p ON b.package_id = p.id 
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings - Travel Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRr9j1pE2vKDAlifOiK1Aas_BgWZjCWgSw5RQ&s') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background: rgba(200, 230, 243, 0.9);
            padding: 20px 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 12px;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .no-bookings {
            text-align: center;
            font-size: 18px;
            color: #888;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Bookings</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Package</th>
                    <th>Price</th>
                    <th>Booking Date</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td>$<?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <div class="no-bookings">You have no bookings yet.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
