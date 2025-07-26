<?php
include './config.php';
$admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["or_id"])) {
    $orderId = $_POST["or_id"];

    // Check current status
    $check = $admin->ret("SELECT or_status FROM `order` WHERE or_id = '$orderId'");
    if ($check->rowCount() > 0) {
        $row = $check->fetch(PDO::FETCH_ASSOC);
        $status = $row['or_status'];

        if ($status == 'Placed' || $status == 'Accepted') {
            // Update order status to Cancelled
            $admin->cud("UPDATE `order` SET or_status = 'Cancelled' WHERE or_id = '$orderId'", "upd");
            echo "<script>alert('Order cancelled successfully!'); window.location.href='order_history.php';</script>";
        } else {
            echo "<script>alert('Order cannot be cancelled at this stage.'); window.location.href='order_history.php';</script>";
        }
    } else {
        echo "<script>alert('Order not found.'); window.location.href='order_history.php';</script>";
    }
} else {
    header("Location: order_history.php");
    exit;
}
?>