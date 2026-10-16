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
$emergencyBookings = $admin->ret("
    SELECT e_booking.*, emergency_services.es_title, s_provider.sp_name, workers.w_name, workers.w_phone
    FROM `e_booking` 
    INNER JOIN `emergency_services` ON emergency_services.es_id = e_booking.es_id 
    INNER JOIN `s_provider` ON s_provider.sp_id = emergency_services.sp_id 
    LEFT JOIN `workers` ON workers.w_id = e_booking.assigned_worker_id 
    WHERE `c_id` = '$cId'
    ORDER BY `eb_id` DESC
");

?>

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
                    <h2 class="mb-4">Emergency Booking History</h2>
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>

                                <th class="p-2 text-nowrap">Booking Date</th>
                                <th class="p-2 text-nowrap">Location</th>
                                <th class="p-2 text-nowrap">Service Station</th>
                                <th class="p-2 text-nowrap">Service Name</th>
                                <!-- <th class="p-2">Amount (₹)</th> -->
                                <th class="p-2 text-nowrap">Assigned Worker</th>
                                <th class="p-2 text-nowrap">Status</th>
                                <th class="p-2 text-nowrap">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($emergencyBookings) && $emergencyBookings->rowCount() > 0) {
                                while ($booking = $emergencyBookings->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>

                                <td><?php echo $booking['eb_date']; ?></td>
                                <td><a title="view location in map" target="_blank"
                                        href="<?php echo $booking['eb_location_link'] ?>"><?php echo $booking['eb_location']; ?></a>
                                </td>
                                <td><?php echo $booking['sp_name']; ?></td>
                                <td><?php echo $booking['es_title']; ?></td>
                                <!-- <td><?php
                                        if ($booking['eb_amount'] == 0) { ?>
                                                <small class="text-secondary"><?php echo 'Not yet decided!'; ?></small>
                                            <?php } else {
                                            echo $booking['eb_amount'];
                                        }

                                        ?>
                                        </td> -->
                                <td>
                                    <?php if (!empty($booking['w_name'])) { ?>
                                    <?php echo $booking['w_name']; ?><br>
                                    <small class=""><?php echo $booking['w_phone']; ?></small>
                                    <?php } else { ?>
                                    <small class="text-secondary">Not Assigned</small>
                                    <?php } ?>
                                </td>


                                <td>
                                    <?php
                                            $status = $booking['eb_status'] ?? 'Pending'; // fallback to Pending
                                            $badgeClass = 'bg-secondary'; // default
                                    
                                            switch ($status) {
                                                case 'Approved':
                                                    $badgeClass = 'bg-primary';
                                                    break;
                                                case 'In Progress':
                                                    $badgeClass = 'bg-info';
                                                    break;
                                                case 'Completed':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'Cancelled':
                                                    $badgeClass = 'bg-danger';
                                                    break;
                                                case 'Pending':
                                                default:
                                                    $badgeClass = 'bg-warning';
                                                    $status = 'Pending'; // ensure label consistency
                                                    break;
                                            }
                                            ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo $status; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php
                                            $paymentStatus = $booking['eb_payment_status'];
                                            if ($paymentStatus === 'Verified') {
                                                echo "<span style='color: green;'>$paymentStatus</span>";
                                            } else {
                                                echo $paymentStatus;
                                            }
                                            ?>
                                </td>

                            </tr>
                            <?php }
                            } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">No emergency booking history found!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>

                    <!-- <a href="export_emergency_pdf.php" target="_blank" class="btn btn-danger mb-3">
                        Download PDF
                    </a> -->

                    <hr>

                    <div class="mt-4 p-3 bg-warning-subtle border-start border-4 border-warning rounded" role="alert">
                        If the admin hasn't reviewed your emergency service request yet, please feel free to call us
                        directly for immediate assistance. We're here to help!
                    </div>


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