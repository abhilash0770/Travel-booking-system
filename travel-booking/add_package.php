<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  $stmt = $conn->prepare("INSERT INTO packages (title, description, price) VALUES (?, ?, ?)");
  $stmt->bind_param("ssd", $title, $description, $price);

  if ($stmt->execute()) {
    echo "<script>alert('Package added successfully'); window.location.href='admin.html';</script>";
  } else {
    echo "<script>alert('Failed to add package'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
?>