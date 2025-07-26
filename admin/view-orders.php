<?php
include "../config.php";
$admin = new Admin();

if (!isset($_SESSION['sp_id'])) {
    echo "<script>window.location='./login.php';</script>";
    exit;
}

$aid = $_SESSION['sp_id'];
$adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$aid'");
$profile = $adminProfile->fetch(PDO::FETCH_ASSOC);

$productOrders = $admin->ret("
    SELECT 
        `order`.or_id, 
        `order`.or_date, 
        `order`.or_name, 
        `order`.or_address, 
        `order`.or_pin, 
        `order`.or_transaction_id, 
        `order`.or_status, 
        `order`.or_payment_status, 
        `order`.or_landmark, 
        GROUP_CONCAT(CONCAT(product.p_name, ' × ', ordered_products.op_quantity) SEPARATOR '<br>') AS product_list, 
        SUM(ordered_products.op_amount) AS total_amount
    FROM 
        `ordered_products`
    INNER JOIN 
        `order` ON `order`.or_id = ordered_products.or_id
    INNER JOIN 
        `product` ON product.p_id = ordered_products.p_id
    INNER JOIN 
        `s_provider` ON s_provider.sp_id = product.sp_id
    WHERE 
        s_provider.sp_id = '$aid'
    GROUP BY 
        `order`.or_id
    ORDER BY 
        `order`.or_date DESC
");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Provider</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <style>
        /* Hide scrollbar but keep scroll functionality */
        textarea.hide-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }

        textarea.hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <div class="container-scroller">

        <!-- Side Bar -->
        <?php include './includes/sidebar.php'; ?>

        <div class="container-fluid page-body-wrapper">

            <!-- Header -->
            <?php include './includes/header.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Orders</h4>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="border-top: 1px solid #2c2e33">
                                            <thead class="table-dark">
                                                <tr>
                                                    <!-- <th>S.NO</th> -->
                                                    <th>Order Date</th>
                                                    <th>C Name</th>
                                                    <th>Product</th>
                                                    <th>Address</th>
                                                    <th>Amount (₹)</th>
                                                    <th>Status</th>
                                                    <th>Payment</th>
                                                    <th>Package Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($productOrders) && $productOrders->rowCount() > 0) {
                                                    // $sno = 1;
                                                    $total = 0;
                                                    while ($order = $productOrders->fetch(PDO::FETCH_ASSOC)) {
                                                        $orderId = $order['or_id'];
                                                        ?>
                                                        <tr>
                                                            <!-- <td><?php echo $sno++; ?></td> -->
                                                            <td><?php echo $order['or_date']; ?></td>
                                                            <td><?php echo $order['or_name']; ?></td>
                                                            <td>
                                                                <?php
                                                                $total = 0;
                                                                $getProductsData = $admin->ret("SELECT * FROM ordered_products INNER JOIN product on product.p_id=ordered_products.p_id WHERE or_id='$orderId'");
                                                                while ($data = $getProductsData->fetch(PDO::FETCH_ASSOC)) {
                                                                    $total += $data['op_amount'];
                                                                    ?>
                                                                    <li class="p-1">
                                                                        <?php echo $data['p_name']; ?>*<?php echo $data['op_quantity']; ?>
                                                                    </li>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <div class="no-scroll"
                                                                    style="min-height: 80px; white-space: pre-wrap; word-wrap: break-word; color: white;">
                                                                    <?php echo $order['or_address'] . ' / ' . $order['or_pin'] . ' / ' . $order['or_landmark']; ?>
                                                                </div>

                                                            </td>
                                                            <td><?php echo $total; ?><br><small>Tran Id :
                                                                    <br>
                                                                    <?php echo $order['or_transaction_id'] ?: '<small class="text-muted">N/A</small>'; ?></small>
                                                            </td>
                                                            </td>
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
                                                                    class="badge text-white
                                                                    <?php echo ($order['or_payment_status'] == 'Paid') ? 'bg-success' : 'bg-danger'; ?>">
                                                                    <?php echo $order['or_payment_status']; ?>
                                                                </span>

                                                                <?php if ($order['or_payment_status'] == "Pending") { ?>
                                                                    <?php if ($order['or_status'] != "Cancelled") { ?>
                                                                        <br>
                                                                        <a class="btn btn-success mt-1"
                                                                            href="./controllers/order.php?or_id=<?php echo $order['or_id']; ?>&py_status=Verified&or_status=Accepted">
                                                                            Verify Payment
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <br>
                                                                        <button class="btn btn-secondary mt-1" disabled>Verify
                                                                            Disabled</button>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                                <?php if ($order['or_status'] == "Accepted") { ?>
                                                                    <a class="btn btn-warning mt-1"
                                                                        href="./controllers/order.php?or_id=<?php echo $order['or_id']; ?>&or_status=Dispatched">
                                                                        Dispatched
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($order['or_status'] == 'Dispatched') { ?>
                                                                    <?php
                                                                    $orderDetails = $admin->ret("SELECT or_received FROM `order` WHERE or_id='$orderId'");
                                                                    $orderRow = $orderDetails->fetch(PDO::FETCH_ASSOC);
                                                                    if ($orderRow && $orderRow['or_received'] == 1) {
                                                                        echo '<span class="text-success fw-bold">✔ Received</span>';
                                                                    } else {
                                                                        echo '<span class="text-warning">Dispatched <br>
                                                                        Awaiting Confirmation</span>';
                                                                    }
                                                                    ?>
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
                                                        <td colspan="9" class="text-center">No product order history found!
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Booking Modal -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" role="dialog" aria-labelledby="editBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <!-- dark background and white text -->
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Booking</strong></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="editBookingForm" method="POST" action="./controllers/update-booking.php">
                    <div class="modal-body">
                        <input type="hidden" name="sb_id" id="edit_sb_id">

                        <div class="form-group">
                            <label>Scheduled Time</label>
                            <select class="form-control bg-dark text-white border-secondary" name="sb_time" required>
                                <option value="09:00 AM">09:00 AM</option>
                                <option value="10:30 AM">10:30 AM</option>
                                <option value="12:00 PM">12:00 PM</option>
                                <option value="01:30 PM">01:30 PM</option>
                                <option value="03:00 PM">03:00 PM</option>
                                <option value="04:30 PM">04:30 PM</option>
                                <option value="06:00 PM">06:00 PM</option>
                                <option value="07:30 PM">07:30 PM</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control bg-dark text-white border-secondary" name="sb_status"
                                id="edit_sb_status">
                                <option value="Approved">Approved</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Admin Notes</label>
                            <textarea class="form-control bg-dark text-white border-secondary" rows="3"
                                placeholder="Add notes (optional)" name="sb_notes"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Update Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include './includes/footer.php'; ?>

    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>

    <!-- Scripts -->
    <script>
        $('#editBookingModal').on('show.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        $('.edit-btn').on('click', function () {
            $('#edit_sb_id').val($(this).data('id'));
            $('#edit_sb_status').val($(this).data('status'));
        });
    </script>

</body>

</html>