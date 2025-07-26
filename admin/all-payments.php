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
if (isset($_POST['verify_btn']) && isset($_POST['verify_id'])) {
    $verifyId = $_POST['verify_id'];
    $admin->cud("UPDATE service_booking SET verify = 1 WHERE sb_id = $verifyId", "updated");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Provider</title>
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <style>
        /* Hide horizontal scrollbar but keep functionality */
        .scroll-x-hidden {
            overflow-x: scroll;
            overflow-y: hidden;
        }

        /* For Chrome, Edge, Safari */
        .scroll-x-hidden::-webkit-scrollbar {
            height: 0px;
        }

        /* For Firefox */
        .scroll-x-hidden {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include './includes/sidebar.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <?php include './includes/header.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Services</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Service ID</th>
                                            <th>Customer Name</th>
                                            <th>Service Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Transaction ID</th>
                                            <th>Paid At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $res1 = $admin->ret("
                                        SELECT sb.sb_id, c.c_name, sb.total_amount, sb.pay_status, sb.t_id, sb.paid_at, s.s_title
                                        FROM service_booking sb
                                        JOIN customer c ON sb.c_id = c.c_id
                                        JOIN services s ON sb.s_id = s.s_id
                                    ");
                                        while ($row = $res1->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>
                                            <td>{$row['sb_id']}</td>
                                            <td>{$row['c_name']}</td>
                                            <td>{$row['s_title']}</td>
                                            <td>₹{$row['total_amount']}</td>
                                            <td>{$row['pay_status']}</td>
                                            <td>{$row['t_id']}</td>
                                            <td>{$row['paid_at']}</td>
                                        </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Orders</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $res3 = $admin->ret("
                      SELECT o.or_id, c.c_name, 
                          (SELECT SUM(op.op_amount) FROM ordered_products op WHERE op.or_id = o.or_id) AS total_amount,
                          o.or_payment_status, o.or_payment_method, o.or_date
                      FROM `order` o
                      JOIN customer c ON o.c_id = c.c_id
                  ");

                                        while ($row = $res3->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>
                        <td>{$row['or_id']}</td>
                        <td>{$row['c_name']}</td>
                        <td>₹{$row['total_amount']}</td>
                        <td>{$row['or_payment_status']}</td>
                        <td>{$row['or_payment_method']}</td>
                        <td>{$row['or_date']}</td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Emergency Services </h4>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Emergency ID</th>
                                            <th>Customer Name</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment Mode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $res2 = $admin->ret("
                    SELECT eb.eb_id, c.c_name, eb.eb_amount, eb.eb_payment_status, eb.eb_payment_mode
                    FROM e_booking eb
                    JOIN customer c ON eb.c_id = c.c_id
                ");
                                        while ($row = $res2->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>
                        <td>{$row['eb_id']}</td>
                        <td>{$row['c_name']}</td>
                        <td>₹{$row['eb_amount']}</td>
                        <td>{$row['eb_payment_status']}</td>
                        <td>{$row['eb_payment_mode']}</td>
                    </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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

    <!-- Script for Date Picker     -->
    <script>
        $(document).ready(function () {
            // Initialize datepicker with min date as today
            $("#edit_exp_date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0 // Prevent past dates
            });

            // Reset modal form on open
            $('#editBookingModal').on('show.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            // Populate modal fields when "Edit" button is clicked
            $('.edit-btn').on('click', function () {
                $('#edit_sb_id').val($(this).data('id'));
                $('#edit_sb_status').val($(this).data('status'));
                $('#edit_exp_date').val($(this).data('exp-date')); // Populate expected date
            });
        });
    </script>

</body>

</html>