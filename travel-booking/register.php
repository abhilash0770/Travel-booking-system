<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
  $stmt->bind_param("sss", $name, $email, $password);

  if ($stmt->execute()) {
    echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
  } else {
    echo "<script>alert('Error: Email may already exist.'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
?>