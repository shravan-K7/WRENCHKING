<?php
require __DIR__ . '/vendor/autoload.php'; // Ensure this file exists

use Razorpay\Api\Api;

$keyId = "rzp_test_6oiNOELMljBTJY"; // Replace with your Razorpay Test Key
$keySecret = "1POa1CGzwRgelSDxLzbnbOL0"; // Replace with your Razorpay Test Secret

$api = new Api($keyId, $keySecret);

$paymentId = $_GET['payment_id'];
$orderId = $_GET['order_id'];
$signature = $_GET['signature'];

$params = $orderId . "|" . $paymentId;
$generated_signature = hash_hmac('sha256', $params, $keySecret);

if ($generated_signature === $signature) {
    echo "<h2>Payment Successful!</h2>";
    echo "<p>Payment ID: $paymentId</p>";
    echo "<p>Order ID: $orderId</p>";
} else {
    echo "<h2>Payment Failed!</h2>";
}
?>