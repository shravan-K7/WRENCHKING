<?php
include './config.php';
$admin = new Admin();

if (isset($_SESSION['c_id'])) {
    $cId = $_SESSION["c_id"];
    $customerProfile = $admin->ret("SELECT * FROM `customer` WHERE `c_id`='$cId'");

    if ($customerProfile->rowCount() > 0) {
        $profile = $customerProfile->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No customer data found.";
        exit;
    }
} else {
    header("Location: signin.php");
    exit;
}

// Fetch emergency booking history
$productOrders = $admin->ret("
    SELECT * 
    FROM `order` 
    WHERE c_id = '$cId'
    ORDER BY or_date DESC
");

?>
<!-- INNER JOIN product ON product.p_id = `order`.p_id  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Teeblate Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .hover-effect:hover {
            background-color: #d32f2f;
            color: white !important;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>
    <!-- Header end -->
    <br>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <?php include './includes/sidebar_profile.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10">
                <div class="bg-primary text-center p-4">
                    <h2 class="mb-1 text-white">
                        <?php echo $profile['c_name']; ?>
                    </h2>
                    <p class="mb-0 text-white">
                        <?php echo $profile['c_email']; ?>
                    </p>
                </div>

                <div class="container mt-4">
                    <h2 class="mb-4">Product Order History</h2>
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <!-- <th>S.NO</th> -->
                                <th class="text-nowrap">Order Date</th>
                                <th class="text-nowrap">Product</th>
                                <th class="text-nowrap">Amount (₹)</th>
                                <th class="text-nowrap">City / Pin</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Payment</th>
                                <th class="text-nowrap">Transaction ID</th>
                                <th class="text-nowrap">Cancellation</th>
                                <th class="text-nowrap">Package Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($productOrders) && $productOrders->rowCount() > 0) {
                                // $sno = 1;
                                while ($order = $productOrders->fetch(PDO::FETCH_ASSOC)) {
                                    $orderId = $order['or_id'];
                                    ?>
                                    <tr>
                                        <!-- <td><?php echo $sno++; ?></td> -->
                                        <td><?php echo $order['or_date']; ?></td>
                                        <td>
                                            <?php
                                            $total = 0;
                                            $getProductsData = $admin->ret("SELECT * FROM ordered_products INNER JOIN product on product.p_id=ordered_products.p_id WHERE or_id='$orderId'");
                                            while ($data = $getProductsData->fetch(PDO::FETCH_ASSOC)) {
                                                $total += $data['op_amount']; // Summing the total instead of overwriting
                                                ?>

                                                <li class="p-1" style="list-style-type: none;"></li>
                                                <?php echo $data['p_name']; ?>*<?php echo $data['op_quantity']; ?>
                                                </li>

                                            <?php } ?>
                                        </td>
                                        <td><?php echo "₹ " . $total; ?></td>

                                        <td><?php echo $order['or_city'] . ' / ' . $order['or_pin']; ?></td>
                                        <td>
                                            <span class="badge fw-normal text-white 
                                                <?php
                                                echo ($order['or_status'] == 'Dispatched') ? 'bg-success' :
                                                    (($order['or_status'] == 'Cancelled') ? 'bg-danger' :
                                                        (($order['or_status'] == 'Placed') ? 'bg-primary' :
                                                            (($order['or_status'] == 'Accepted') ? 'bg-warning' : 'bg-secondary')));
                                                ?>">
                                                <?php echo $order['or_status']; ?>
                                            </span>

                                        </td>
                                        <td>
                                            <span
                                                class="badge fw-normal text-white
                                                <?php echo ($order['or_payment_status'] == 'Verified') ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo $order['or_payment_status']; ?>
                                            </span>

                                        </td>
                                        <td><?php echo $order['or_transaction_id'] ?: '<small class="text-muted">N/A</small>'; ?>
                                        </td>
                                        <td>
                                            <?php if ($order['or_status'] == 'Placed' || $order['or_status'] == 'Accepted') { ?>
                                                <form method="POST" action="cancel_order.php"
                                                    onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                                    <input type="hidden" name="or_id" value="<?php echo $orderId; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            <?php } else { ?>
                                                <span class="text-muted">Not Allowed</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($order['or_status'] == 'Dispatched') { ?>
                                                <?php if ($order['or_received'] == 0) { ?>
                                                    <a href="mark_received.php?or_id=<?php echo $order['or_id']; ?>"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Have you really received the package?');">
                                                        Package Received
                                                    </a>
                                                <?php } else { ?>
                                                    <span class="text-success fw-bold">✔ Received</span>
                                                <?php } ?>
                                            <?php } elseif ($order['or_status'] == 'Cancelled') { ?>
                                                <span class="text-danger fw-bold">Order Cancelled</span>
                                            <?php } else { ?>
                                                <span class="text-muted">Pending Dispatch</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="10" class="text-center">No product order history found!</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>

                    <!-- <a href="export_order_pdf.php" class="btn btn-danger mb-3" target="_blank">
                        Download PDF
                    </a> -->

                    <hr>

                </div>
            </main>
        </div>
    </div>
    <!-- Footer Start -->
    <?php
    include './includes/footer.php';
    ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->>
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>