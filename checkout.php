<?php
require __DIR__ . '/vendor/autoload.php';
include './config.php';
// session_start();

$admin = new Admin();
$keyId = "rzp_test_6oiNOELMljBTJY"; // Razorpay test key
$keySecret = "1POa1CGzwRgelSDxLzbnbOL0"; // Razorpay test secret

// Check if customer is logged in
if (!isset($_SESSION['c_id'])) {
    echo "<script>
        alert('Please sign in to proceed to checkout.');
        window.location.href = 'signin.php';
    </script>";
    exit();
}

$c_id = $_SESSION['c_id'];

// Check if cart has items for this customer
$checkCart = $admin->ret("SELECT * FROM cart WHERE c_id = ?", [$c_id]);

if ($checkCart->rowCount() === 0) {
    echo "<script>
        alert('Your cart is empty. Please add products before proceeding to checkout.');
        window.location.href = 'cart.php';
    </script>";
    exit();
}

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);
if (isset($_GET['payment_id']) && isset($_GET['order_id'])) {

    $paymentId = $_GET['payment_id'];
    $orderId = $_GET['order_id'];
    $signature = $_GET['signature'];

    $params = $orderId . "|" . $paymentId;
    $generated_signature = hash_hmac('sha256', $params, $keySecret);
}
$order = null;
$grandTotal = 0;

if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];

    // Get customer profile
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");
    $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);

    // Get cart data
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

    // Create Razorpay order
    $api = new Api($keyId, $keySecret);
    $orderData = [
        'receipt' => 'rcptid_' . rand(1000, 9999),
        'amount' => $amountInPaise,
        'currency' => 'INR',
        'payment_capture' => 1
    ];
    $razorOrder = $api->order->create($orderData);

    $order = [
        'order_id' => $razorOrder['id'],
        'amount' => $razorOrder['amount'],
        'currency' => $razorOrder['currency'],
        'grand_total' => $grandTotal
    ];
} else {
    echo "<script>alert('Please log in first'); window.location='signin.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WrenchKing</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        th,
        td {
            text-align: center;
        }

        .checkout-container {
            display: flex;
            /* height: 100vh; */
        }

        .form-section {
            width: 75%;
            overflow-y: auto;
            padding: 20px;
        }

        .summary-section {
            width: 25%;
            background-color: #f8f9fa;
            padding: 20px;
            position: sticky;
            right: 0;
            top: 0;
            /* height: 100vh; */
        }

        .form-control {
            border: 1px solid grey !important;
            border-radius: 4px !important;
        }

        textarea {
            resize: none;
        }
    </style>

</head>

<body>

    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>
    <!-- Header end -->

    <!-- Checkout Form Start -->
    <div class="checkout-container">

        <div class="form-section">
            <div class="container">
                <h2 class="text-center bg-primary text-white rounded-3 p-3">Checkout Form</h2>
                <form id="checkout-form" action="./controllers/booking.php" method="POST"
                    onsubmit="return validateForm()">
                    <div class="row g-3 mt-3">

                        <!-- Name -->
                        <div class="col-12 col-sm-6">
                            <input type="text" name="name" class="form-control text-dark" placeholder="Full Name"
                                required style="height: 55px;" value="<?php echo $profile['c_name']; ?>">
                        </div>

                        <!-- Email -->
                        <div class="col-12 col-sm-6">
                            <input type="email" name="email" class="form-control text-dark" placeholder="Email Address"
                                required style="height: 55px;" value="<?php echo $profile['c_email']; ?>">
                        </div>

                        <!-- Phone -->
                        <div class="col-12 col-sm-6">
                            <input type="tel" name="phone" class="form-control text-dark" placeholder="Phone Number"
                                required pattern="[0-9]{10}" maxlength="10" style="height: 55px;"
                                value="<?php echo $profile['c_phone']; ?>">
                        </div>

                        <!-- Alternate Phone -->
                        <div class="col-12 col-sm-6">
                            <input type="tel" name="alt_phone" class="form-control text-dark"
                                placeholder="Alternate Phone Number" pattern="[0-9]{10}" maxlength="10"
                                style="height: 55px;">

                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <textarea name="address" id="address" class="form-control text-dark" placeholder="Address"
                                required style="height: 100px;"></textarea>
                        </div>


                        <!-- Pincode -->
                        <div class="col-12 col-sm-6">
                            <input type="text" name="pincode" class="form-control text-dark" placeholder="Pincode"
                                required pattern="[0-9]{6}" maxlength="6" style="height: 55px;">

                        </div>

                        <!-- State -->
                        <div class="col-12 col-sm-6">
                            <input type="text" name="state" class="form-control text-dark" placeholder="State" required
                                style="height: 55px;">
                        </div>

                        <!-- City/District/Town -->
                        <div class="col-12 col-sm-6">
                            <input type="text" name="city" class="form-control text-dark"
                                placeholder="City / District / Town" required style="height: 55px;">
                        </div>

                        <!-- Landmark (Optional) -->
                        <div class="col-12 col-sm-6">
                            <input type="text" name="landmark" class="form-control text-dark"
                                placeholder="Landmark (Optional)" style="height: 55px;">
                        </div>
                        <?php
                        if (isset($_GET['payment_id']) && isset($_GET['order_id'])) {
                            # code...
                            if ($generated_signature === $signature) {
                                echo "<h2>Payment Successful!</h2>";
                                echo "<div><label class='form-label'>Payment ID</label>: <input class='form-control text-dark' value='$paymentId' name='paymentId' readOnly/></div>";
                                // echo "<p>Order ID: $orderId</p>";
                            } else {
                                echo "<h2>Payment Failed!</h2>";
                            }
                        }
                        ?>
                        <input type="hidden" name="paymentId" id="payment_id" value="">
                        <input type="hidden" name="tid" value="<?php echo uniqid(); ?>">
                        <input type="hidden" name="order" value="1">

                        <div id="Payment">
                            <div class="row p-2">
                                <small style="font-weight: bold; color: #333;">Select Payment Method</small>

                                <div class="col-6 mt-3">
                                    <input onclick="Display('upi')" type="button" name="pay" value="UPI" id="upi"
                                        class="form-control btn btn-outline-primary" style="width: 96%;">
                                </div>

                                <div class="col-6 mt-3">
                                    <input onclick="Display('razorpay')" type="button" name="pay" value="Razorpay"
                                        id="razorpay" class="form-control btn btn-outline-success" style="width: 96%;">
                                </div>
                            </div>

                        </div>
                        <?php
                        // Get the first service provider from product table via cart
                        $getFirstSP = $admin->ret("SELECT product.sp_id FROM cart 
    INNER JOIN product ON product.p_id = cart.p_id 
    WHERE cart.c_id = '$cId' LIMIT 1");

                        if ($getFirstSP->rowCount() > 0) {
                            $firstSP = $getFirstSP->fetch(PDO::FETCH_ASSOC);
                            $serviceProvider = $firstSP['sp_id'];

                            // Fetch provider profile
                            $serviceProviderProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$serviceProvider'");

                            if ($serviceProviderProfile->rowCount() > 0) {
                                $profile = $serviceProviderProfile->fetch(PDO::FETCH_ASSOC);
                                ?>

                                <div id="qrCode" style="display: none;"
                                    class="row mt-4 col-12 grid-margin stretch-card justify-content-center align-items-center">
                                    <div class="col-md-4">
                                        <div class="card-body p-2 d-flex justify-content-center align-items-center flex-column">
                                            <h6 class="card-title text-center">QR Code of
                                                <?php echo $profile['sp_name']; ?>
                                            </h6>
                                            <?php if (!empty($profile['sp_qrcode']) && $profile['sp_qrcode'] != "uploads/") { ?>
                                                <img style="width: 250px; border-radius:4%;"
                                                    src="./admin/controllers/<?php echo $profile['sp_qrcode']; ?>" alt="QR Code">
                                            <?php } else { ?>
                                                <p class="text-muted">No QR code available.</p>
                                            <?php } ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <label for="tid" class="form-label">Transaction ID</label>
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="text" id="tid" name="tid" class="form-control w-100" maxlength="12"
                                                    placeholder="Enter UPI transaction ID here">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            } else {
                                echo '<div class="text-danger text-center">Service Provider details not found.</div>';
                            }
                        } else {
                            echo '<div class="text-danger text-center">No service provider found in your cart.</div>';
                        }
                        ?>


                        <!-- Submit Button -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <button class="btn btn-secondary w-100 py-3 rounded-3" name="book"
                                    onclick="location.href='cart.php'" type="button">Back to Cart</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" id="place-order-button"
                                    class="btn btn-primary w-100 py-3 rounded-3" disabled>
                                    Continue / Place Order
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- Right Panel: Fixed Summary Section -->
        <div class="summary-section">
            <h4 class="text-dark">PRICE DETAILS</h4>
            <hr>
            <?php
            $getCartProducts = $admin->ret("SELECT * FROM `cart` INNER JOIN `product` on product.p_id=cart.p_id WHERE `c_id`='$cId'");
            $subTotal = 0;
            while ($product = $getCartProducts->fetch(PDO::FETCH_ASSOC)) {
                $price = $product['p_price'];
                $serviceProvider = $product['sp_id'];
                $quantity = $product['ct_qty'];
                $total = $price * $quantity;
                $subTotal += $total;
                $parcelfee = 10;
                $grandTotal = $parcelfee + $subTotal;
                ?>
                <p>
                    <strong><?php echo $product['p_name']; ?> * <?php echo $product['ct_qty'] ?></strong>
                    <span class="float-end">₹<?php echo $total; ?></span>
                </p>
            <?php } ?>
            <hr>
            <p><strong>Sub Total</strong> <span class="float-end">₹<?php echo $subTotal ?></span></p>
            <hr>
            <p><strong>Delivery Charges</strong> <span class="float-end text-success">FREE</span></p>
            <p><strong>Parcel Fee</strong> <span class="float-end">₹<?php echo $parcelfee ?></span></p>
            <hr>
            <h5><strong>Grand Total</strong> <span class="float-end">₹<?php echo $grandTotal ?></span></h5>

            <!-- Add spacing and note -->
            <div class="mt-4 p-3 bg-warning-subtle border-start border-4 border-warning rounded">
                <p class="mb-0 text-dark"><strong>Note:</strong> Once the order is dispatched, it cannot be cancelled.
                    Please review your cart before proceeding.</p>
            </div>
        </div>

        <!-- Left Panel: Scrollable Form Section -->
    </div>
    <!-- Checkout Form End -->


    <!-- Footer Start -->
    <?php
    include './includes/footer.php';
    ?>
    <!-- Footer End -->

    <script src="js/sparpurchase.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.getElementById('upi').disabled = true;
        document.getElementById('razorpay').disabled = true;

        const form = document.getElementById('checkout-form');
        const requiredFields = form.querySelectorAll('input[required], textarea[required]');
        let selectedMethod = null;

        function validateAddress() {
            const address = document.getElementById('address').value.trim();

            if (address.length < 10) {
                alert("Please enter at least 10 characters for the address.");
                return false;
            }

            return true;
        }


        function checkFormFilled() {
            let allFilled = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                }
            });
            document.getElementById('upi').disabled = !allFilled;
            document.getElementById('razorpay').disabled = !allFilled;
        }

        requiredFields.forEach(field => {
            field.addEventListener('input', checkFormFilled);
        });

        function validateForm() {
            checkFormFilled();
            if (!selectedMethod) {
                alert('Please select a payment method.');
                return false;
            }

            if (!validateAddress()) {
                return false;
            }


            return true;
        }

        function Display(method) {
            selectedMethod = method;

            const upiBtn = document.getElementById('upi');
            const razorpayBtn = document.getElementById('razorpay');
            const qrCode = document.getElementById('qrCode');
            const tid = document.getElementById('tid');
            const placeOrderButton = document.getElementById('place-order-button');

            // Reset both buttons
            upiBtn.classList.remove('active');
            razorpayBtn.classList.remove('active');

            if (method === 'upi') {
                upiBtn.classList.add('active');
                qrCode.style.display = "flex";
                tid.required = true;
                placeOrderButton.disabled = false;
            } else if (method === 'razorpay') {
                razorpayBtn.classList.add('active');
                qrCode.style.display = "none";
                tid.required = false;
                placeOrderButton.disabled = true;

                const formData = $('#checkout-form').serialize();

                $.ajax({
                    url: 'create-order.php',
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        try {
                            const data = JSON.parse(res);

                            const options = {
                                "key": data.key,
                                "amount": data.amount,
                                "currency": "INR",
                                "name": "WrenchKing",
                                "description": "Payment for Service",
                                "order_id": data.order_id,
                                "handler": function (response) {
                                    $('#payment_id').val(response.razorpay_payment_id);

                                    $.post('verify-payment.php', {
                                        payment_id: response.razorpay_payment_id,
                                        order_id: data.order_id
                                    }, function () {
                                        $.post('controllers/place_order.php',
                                            $('#checkout-form').serialize(),
                                            function (res) {
                                                try {
                                                    const result = JSON.parse(res);
                                                    if (result.status === "success") {
                                                        alert(result.message);
                                                        window.location.href =
                                                            "order_history.php";
                                                    } else {
                                                        alert("Order failed: " + result
                                                            .message);
                                                    }
                                                } catch (e) {
                                                    alert("Order placed successfully!");
                                                    window.location.href =
                                                        "order_history.php";
                                                }
                                            });
                                    });
                                },
                                "theme": {
                                    "color": "#0a7fbd"
                                }
                            };

                            const rzp = new Razorpay(options);
                            rzp.open();
                        } catch (err) {
                            alert("Something went wrong with Razorpay setup.");
                        }
                    }
                });
            }
        }

        $(document).ready(function () {
            $('#checkout-form').on('submit', function (e) {
                if (selectedMethod === 'razorpay') {
                    e.preventDefault(); // prevent default submission, Razorpay handles it
                } else {
                    $('#place-order-button').prop('disabled', false);
                }
            });
        });
    </script>



    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>