<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email    = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      header("Location: packages.php");
    } else {
      echo "<script>alert('Incorrect password'); window.history.back();</script>";
    }
  } else {
    echo "<script>alert('No user found with that email'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
?>