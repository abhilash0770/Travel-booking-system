<?php
include 'db.php';

$limit = 9; // Show 9 packages per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = "%$search%";

// Prepare statement
$stmt = $conn->prepare("SELECT * FROM packages WHERE title LIKE ? LIMIT ?, ?");
$stmt->bind_param("sii", $searchTerm, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Travel Packages</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            padding: 20px;
        }
        .package-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
        }
        .package-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 12px;
            background: #333;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .pagination a.active {
            background: #007bff;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<h2 style="text-align:center;">Available Travel Packages</h2>

<!-- Search -->
<form method="GET" action="packages.php" style="text-align:center; margin: 20px;">
    <input type="text" name="search" placeholder="Search packages..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<div class="packages-grid">
<?php while($row = $result->fetch_assoc()): ?>
    <div class="package-card">
        <img src="images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p><strong>$<?= number_format($row['price'], 2) ?></strong></p>
        <form method="post" action="add_to_cart.php">
            <input type="hidden" name="package_id" value="<?= $row['id'] ?>">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
<?php endwhile; ?>
</div>

<!-- Pagination -->
<div class="pagination">
<?php
// Total count
$totalQuery = $conn->prepare("SELECT COUNT(*) AS total FROM packages WHERE title LIKE ?");
$totalQuery->bind_param("s", $searchTerm);
$totalQuery->execute();
$totalData = $totalQuery->get_result()->fetch_assoc();
$totalPages = ceil($totalData['total'] / $limit);

for ($i = 1; $i <= $totalPages; $i++) {
    $active = $i == $page ? "active" : "";
    echo "<a class='$active' href='?search=" . urlencode($search) . "&page=$i'>$i</a>";
}
?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>