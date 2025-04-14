<?php
session_start();
include('../server/connection.php'); // or your DB connection file

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?order_updated=Order deleted successfully.");
        exit();
    } else {
        header("Location: dashboard.php?order_failed=Failed to delete order.");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
