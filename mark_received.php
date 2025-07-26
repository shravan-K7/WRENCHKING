<?php
ob_start();
session_start();
require_once 'config.php'; // Your config file where $admin is set

if (isset($_GET['or_id'])) {
    $or_id = $_GET['or_id'];

    // Create Admin object
    $admin = new Admin();

    // Update the order to mark it as received
    $admin->cud("UPDATE `order` SET `or_received` = 1 WHERE `or_id` = '$or_id'", "update");

    // Redirect back to order_history.php with success message
    header("Location: order_history.php?success=received");
    exit();
} else {
    echo "Invalid order ID.";
}
?>