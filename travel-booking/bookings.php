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

<div style="padding: 20px;">
    <h2>My Bookings</h2>
    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10">
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
        <p>You have no bookings yet.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
