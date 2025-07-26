<?php
include "../config.php";
$admin = new Admin();
if (isset($_SESSION['sp_id'])) {
    $spid = $_SESSION['sp_id'];
    $adminProfile = $admin->ret("SELECT * FROM `s_provider` WHERE `sp_id`='$spid'");
    $profile = $adminProfile->fetch(PDO::FETCH_ASSOC);
} else {
    echo "<script>window.location='./login.php';</script>";
}

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
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Add this in the <head> section -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <style>
        .badge-pending {
            background-color: orange;
            color: white;
        }

        .badge-approved {
            background-color: blue;
            color: white;
        }

        .badge-in-progress {
            background-color: cyan;
            color: black;
        }

        .badge-completed {
            background-color: green;
            color: white;
        }

        .badge-cancelled {
            background-color: red;
            color: white;
        }
    </style>


</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->

        <!-- Side Bar Start -->
        <?php include './includes/sidebar.php'; ?>
        <!-- Side Bar End -->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->

            <!-- Header Start -->
            <?php include './includes/header.php'; ?>
            <!-- Header End -->

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center align-self-start">
                                                <?php
                                                // Get Registered Customer Count
                                                $getCustomers = $admin->ret("SELECT COUNT(*) as customer_count 
                                                FROM `customer` WHERE `sp_id` = '$spid' AND `c_status` = 'active'");
                                                $customerCount = $getCustomers->fetch(PDO::FETCH_ASSOC)['customer_count'];
                                                ?>
                                                <h3 class="mb-0"><?php echo $customerCount; ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-success ">
                                                <span class="mdi mdi-account icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal pt-3">Registered sCustomers</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center align-self-start">
                                                <?php
                                                $getAllBookings = $admin->ret("SELECT * FROM `service_booking` INNER JOIN services on services.s_id=service_booking.s_id WHERE services.sp_id='$spid'");
                                                $count = $getAllBookings->rowCount();
                                                ?>
                                                <h3 class="mb-0"><?php echo $count; ?></h3>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-laptop icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal pt-4">Services Booked</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center align-self-start">
                                                <?php
                                                $getAllBookings = $admin->ret("SELECT * FROM `e_booking` INNER JOIN emergency_services on emergency_services.es_id=e_booking.es_id WHERE emergency_services.sp_id='$spid'");
                                                $count = $getAllBookings->rowCount();
                                                ?>
                                                <h3 class="mb-0"><?php echo $count; ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-laptop icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal pt-4">E Services Booked</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center align-self-start">
                                                <?php
                                                $getAllBookings = $admin->ret("SELECT * FROM `ordered_products` 
                                                INNER JOIN product ON product.p_id = ordered_products.p_id 
                                                INNER JOIN `order` ON `order`.or_id = ordered_products.op_id 
                                                WHERE product.sp_id = '$spid' 
                                                AND `order`.or_status != 'cancelled'");
                                                $count = $getAllBookings->rowCount();

                                                ?>
                                                <h3 class="mb-0"><?php echo $count; ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-package-up icon-item"
                                                    style="color: yellow;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal pt-4">Orders</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center align-self-start">
                                                <?php
                                                $salesTotal = 0;
                                                $getAllOrders = $admin->ret("
                                                    SELECT ordered_products.op_amount 
                                                    FROM ordered_products 
                                                    INNER JOIN product ON product.p_id = ordered_products.p_id 
                                                    INNER JOIN s_provider ON s_provider.sp_id = product.sp_id 
                                                    INNER JOIN `order` ON `order`.or_id = ordered_products.or_id 
                                                    WHERE s_provider.sp_id = '$spid' AND `order`.or_status = 'Dispatched'
                                                ");
                                                while ($sales = $getAllOrders->fetch(PDO::FETCH_ASSOC)) {
                                                    $salesTotal += $sales['op_amount'];
                                                }
                                                ?>
                                                <h3 class="mb-0">₹<?php echo $salesTotal; ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-3 pe-2">
                                            <div class="icon icon-box-primary">
                                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal pt-3">Total Product Sales</h6>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center align-self-start">
                                                <?php
                                                $getAllWorkers = $admin->ret("SELECT * FROM `workers` WHERE workers.sp_id='$spid'");
                                                $count = $getAllWorkers->rowCount();
                                                ?>
                                                <h3 class="mb-0"><?php echo $count; ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icon icon-box-danger">
                                                <span class="mdi mdi-worker icon-item" style="color: #ff8c19;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-muted font-weight-normal pt-4">Workers</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <h4 class="card-title mb-1 pb-2">Recent Service Bookings</h4>
                                    </div>
                                    <?php
                                    $latestBookings = $admin->ret("
                                        SELECT 
                                            sb.sb_id, 
                                            c.c_name, 
                                            sb.car_brand,
                                            sb.car_model,
                                            s.s_title, 
                                            sb.sb_time, 
                                            sb.sb_booked_date, 
                                            sb.sb_status,
                                            sb.vehicle_number,
                                            w.w_name AS assigned_worker
                                        FROM 
                                            service_booking sb
                                        JOIN 
                                            customer c ON sb.c_id = c.c_id
                                        JOIN 
                                            services s ON sb.s_id = s.s_id
                                        LEFT JOIN 
                                            workers w ON sb.assigned_worker_id = w.w_id
                                        WHERE 
                                            s.sp_id = '$spid'
                                        ORDER BY 
                                            sb.sb_booked_date DESC, sb.sb_time DESC
                                        LIMIT 5
                                    ");
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Vehicle</th>
                                                    <th>Service</th>
                                                    <th>Date</th>
                                                    <!-- <th>Time</th> -->
                                                    <th>Worker</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $latestBookings->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['c_name']; ?></td>
                                                        <td>
                                                            <?php echo $row['car_brand'] . " - " . $row['car_model'] . "<br>" . $row['vehicle_number']; ?>
                                                        </td>

                                                        <td><?php echo $row['s_title']; ?></td>
                                                        <td><?php echo $row['sb_booked_date']; ?></td>
                                                        <!-- <td><?php echo $row['sb_time']; ?></td> -->
                                                        <td>
                                                            <?php echo !empty($row['assigned_worker']) ? $row['assigned_worker'] : "<span class='text-warning'>Not Assigned</span>"; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $status = strtolower(str_replace(' ', '-', $row['sb_status']));
                                                            echo "<span class='badge badge-$status'>{$row['sb_status']}</span>";
                                                            ?>
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

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row justify-content-between">
                                        <h4 class="card-title mb-1 pb-2">Recent Emergency Bookings</h4>
                                    </div>
                                    <?php
                                    $latestEBookings = $admin->ret("
                                        SELECT 
                                            eb.eb_id, 
                                            c.c_name, 
                                            eb.eb_car, 
                                            eb.eb_model, 
                                            es.es_title, 
                                            eb.eb_date, 
                                            eb.eb_status,
                                            eb.vehicle_number,
                                            w.w_name AS assigned_worker
                                        FROM 
                                            e_booking eb
                                        JOIN 
                                            customer c ON eb.c_id = c.c_id
                                        JOIN 
                                            emergency_services es ON eb.es_id = es.es_id
                                        LEFT JOIN 
                                            workers w ON eb.assigned_worker_id = w.w_id
                                        WHERE 
                                            es.sp_id = '$spid'
                                        ORDER BY 
                                            eb.eb_date DESC
                                        LIMIT 3
                                    ");
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Vehicle</th>
                                                    <th>Service</th>
                                                    <th>Date</th>
                                                    <th>Worker</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $latestEBookings->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['c_name']; ?></td>
                                                        <td><?php echo $row['eb_car'] . " - " . $row['eb_model'] . "<br>" . $row['vehicle_number']; ?>
                                                        </td>
                                                        <td><?php echo $row['es_title']; ?></td>
                                                        <td><?php echo $row['eb_date']; ?></td>
                                                        <td>
                                                            <?php echo !empty($row['assigned_worker']) ? $row['assigned_worker'] : "<span class='text-warning'>Not Assigned</span>"; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $status = strtolower(str_replace(' ', '-', $row['eb_status']));
                                                            echo "<span class='badge badge-$status'>{$row['eb_status']}</span>";
                                                            ?>
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

                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Latest Orders</h4>

                                    <?php
                                    $latestOrders = $admin->ret("
                                            SELECT 
                                                o.or_id, 
                                                o.or_date, 
                                                o.or_name, 
                                                o.or_payment_status, 
                                                GROUP_CONCAT(CONCAT(p.p_name, ' × ', op.op_quantity) SEPARATOR '<br>') AS product_list, 
                                                SUM(op.op_amount) AS total_amount
                                            FROM 
                                                ordered_products op
                                            JOIN 
                                                `order` o ON o.or_id = op.or_id
                                            JOIN 
                                                product p ON p.p_id = op.p_id
                                            JOIN 
                                                s_provider sp ON sp.sp_id = p.sp_id  -- Join with Service Provider
                                            WHERE 
                                                sp.sp_id = '$spid'  -- Using logged-in Service Provider ID
                                            GROUP BY 
                                                o.or_id
                                            ORDER BY 
                                                o.or_date DESC  
                                            LIMIT 4
                                        ");
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th> Customer Name </th>
                                                    <!-- <th> Order No </th> -->
                                                    <th> Products </th>
                                                    <th> Total Amount (₹) </th>
                                                    <th> Order Date </th>
                                                    <th> Payment Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($latestOrders->rowCount() > 0) {
                                                    while ($order = $latestOrders->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($order['or_name']); ?></td>
                                                            <!-- <td><?php echo htmlspecialchars($order['or_id']); ?></td> -->
                                                            <td><?php echo $order['product_list']; ?></td>
                                                            <!-- Displays products with quantity -->
                                                            <td>₹<?php echo number_format($order['total_amount'], 2); ?>
                                                            </td>
                                                            <td><?php echo date("d M Y", strtotime($order['or_date'])); ?>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="badge badge-outline-<?php
                                                                    echo ($order['or_payment_status'] == 'Paid') ? 'success' : 'danger'; ?>">
                                                                    <?php echo htmlspecialchars($order['or_payment_status']); ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No recent orders found.</td>
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
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    </div>
    <?php include './includes/footer.php'; ?>
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
    <!-- End custom js for this page -->
</body>

</html>