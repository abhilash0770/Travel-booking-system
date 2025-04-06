<?php
session_start();

if (isset($_GET['package_id']) && in_array($_GET['package_id'], $_SESSION['cart'])) {
    $_SESSION['cart'] = array_diff($_SESSION['cart'], [$_GET['package_id']]);
}

header("Location: cart.php");
exit();
