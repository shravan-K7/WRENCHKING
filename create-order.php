<?php
require __DIR__ . '/vendor/autoload.php';
use Razorpay\Api\Api;
include './config.php';

$admin = new Admin();

if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];

    // Step 1: Calculate the total dynamically
    $getCartProducts = $admin->ret("SELECT * FROM `cart` 
    INNER JOIN `product` ON product.p_id=cart.p_id 
    WHERE `c_id`='$cId'");

    $subTotal = 0;
    $parcelfee = 10;

    while ($product = $getCartProducts->fetch(PDO::FETCH_ASSOC)) {
        $price = $product['p_price'];
        $quantity = $product['ct_qty'];
        $total = $price * $quantity;
        $subTotal += $total;
    }

    $grandTotal = $parcelfee + $subTotal;
    $amountInPaise = $grandTotal * 100;

    // Step 2: Razorpay credentials
    $keyId = "rzp_test_6oiNOELMljBTJY";      // ✅ Replace with your real key for production
    $keySecret = "1POa1CGzwRgelSDxLzbnbOL0"; // ✅ Replace with your real secret

    $api = new Api($keyId, $keySecret);

    // Step 3: Create Razorpay order
    $orderData = [
        'receipt' => 'rcptid_' . rand(1000, 9999),
        'amount' => $amountInPaise,
        'currency' => 'INR',
        'payment_capture' => 1
    ];

    $order = $api->order->create($orderData);

    // ✅ Step 4: Return order data including Razorpay public key
    echo json_encode([
        'order_id' => $order['id'],
        'amount' => $order['amount'],
        'currency' => $order['currency'],
        'grand_total' => $grandTotal,
        'key' => $keyId  // ✅ Include the public key here
    ]);
} else {
    echo json_encode(['error' => 'Session not set']);
}