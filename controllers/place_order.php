<?php
include '../config.php';
$admin = new Admin();
// session_start();

if (isset($_POST["order"])) {
    $cid = $_SESSION['c_id'];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $alt_phone = $_POST["alt_phone"];
    $address = $_POST["address"];
    $pincode = $_POST["pincode"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $landmark = $_POST["landmark"];
    $tid = $_POST["tid"];
    $paymentId = $_POST["paymentId"] ?? '';

    // Determine payment method
    $transactionId = empty($paymentId) ? $tid : $paymentId;
    $method = empty($paymentId) ? 'UPI' : 'RazorPay';

    $order = $admin->Rcud("INSERT INTO `order`(`c_id`, `or_name`, `or_email`, `or_phone`, `or_city`, `or_pin`, `or_address`, `or_alternative_phone`, `or_state`, `or_landmark`, `or_status`, `or_payment_status`,`or_payment_method`, `or_transaction_id`) 
    VALUES ('$cid','$name','$email','$phone','$city','$pincode','$address','$alt_phone','$state','$landmark','Placed','Pending','$method','$transactionId')");

    $getCartProducts = $admin->ret("SELECT * FROM `cart` INNER JOIN `product` ON product.p_id=cart.p_id WHERE `c_id`='$cid'");

    while ($product = $getCartProducts->fetch(PDO::FETCH_ASSOC)) {
        $pid = $product['p_id'];
        $price = $product['p_price'];
        $qty = $product['ct_qty'];
        $stock = $product['p_stock'];
        $updatedStock = $stock - $qty;
        $amount = $price * $qty + 10;

        $admin->cud("INSERT INTO `ordered_products`(`or_id`, `p_id`, `op_quantity`, `op_amount`) 
        VALUES ('$order','$pid','$qty','$amount')", "inserted");

        $admin->cud("UPDATE `product` SET `p_stock`='$updatedStock' WHERE `p_id`='$pid'", "updated");
    }

    $admin->cud("DELETE FROM `cart` WHERE `c_id`='$cid'", "clear cart");

    echo json_encode(["status" => "success", "message" => "Order placed successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>