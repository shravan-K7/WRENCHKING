<?php
// Fetch the order from create-order.php
$orderData = file_get_contents("http://127.0.0.1/wrenchking/create-order.php");
$order = json_decode($orderData, true);

// Razorpay Test Key
$keyId = "rzp_test_6oiNOELMljBTJY"; // Replace with your Razorpay Test Key
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>

    <h2>Pay ₹500.00 for WrenchKing Services</h2>
    <button id="payButton">Pay Now</button>

    <script>
        var options = {
            "key": "<?= $keyId ?>", // Razorpay Test Key
            "amount": "<?= $order['amount'] ?>",
            "currency": "<?= $order['currency'] ?>",
            "name": "WrenchKing Garage Services",
            "description": "Service Payment",
            "order_id": "<?= $order['order_id'] ?>",
            "handler": function (response) {
                alert("Payment Successful!\nPayment ID: " + response.razorpay_payment_id);
                window.location.href = "verify-payment.php?payment_id=" + response.razorpay_payment_id +
                    "&order_id=" + response.razorpay_order_id + "&signature=" + response.razorpay_signature;
            },
            "prefill": {
                "name": "John Doe",
                "email": "johndoe@example.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#F37254"
            }
        };

        var rzp1 = new Razorpay(options);
        document.getElementById('payButton').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>

</body>

</html>