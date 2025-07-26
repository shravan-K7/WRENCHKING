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
    header("Location: signin.php"); // Redirect to login if session doesn't exist
    exit;
}
// Fetch booking history
$bookingHistory = $admin->ret("
    SELECT sb.*, s.s_title, w.w_name, w.w_phone
    FROM `service_booking` sb
    INNER JOIN `services` s ON sb.s_id = s.s_id
    LEFT JOIN workers w ON sb.assigned_worker_id = w.w_id
    WHERE sb.c_id = '$cId'
    ORDER BY sb.sb_date DESC
");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <?php
    include './includes/header.php';
    ?>
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
                    <h2 class="mb-4">Bookings History</h2>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>

                                <!-- <th class="p-2">Service ID</th> -->
                                <th class="p-2">Booking Date</th>
                                <th class="p-2">Service Name</th>
                                <th class="p-2">Vehicle</th>
                                <th class="p-2">Allotted Date</th>
                                <th class="p-2">Allotted Time</th>
                                <th class="p-2">Worker Details</th>
                                <th class="p-2">Expected Return</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Invoice</th>
                                <th class="p-2">Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($bookingHistory) && $bookingHistory->rowCount() > 0) {

                                while ($booking = $bookingHistory->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>


                                        <td><?php echo $booking['sb_date']; ?></td>
                                        <td><?php echo $booking['s_title']; ?></td>
                                        <td><?php echo $booking['car_model']; ?></td>
                                        <td><?php echo $booking['sb_booked_date']; ?></td>
                                        <td><?php echo $booking['sb_time']; ?></td>
                                        <td>
                                            <?php
                                            if (!empty($booking['w_name'])) {
                                                echo "<strong>" . $booking['w_name'] . "</strong><br>";
                                                echo "<span style='font-size: 0.9em;'>📞" . $booking['w_phone'] . "</span>";
                                            } else {
                                                echo "<i class='text-muted'>Not Assigned</i>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo !empty($booking['exp_date']) ? $booking['exp_date'] : "<i class='text-muted'>Not Set</i>"; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status = ucwords(strtolower(trim($booking['sb_status'])));
                                            switch ($status) {
                                                case 'Pending':
                                                    $badge = 'bg-warning text-dark';
                                                    break;
                                                case 'Approved':
                                                    $badge = 'bg-primary';
                                                    break;
                                                case 'In Progress':
                                                    $badge = 'bg-info text-dark';
                                                    break;
                                                case 'Completed':
                                                    $badge = 'bg-success';
                                                    break;
                                                case 'Cancelled':
                                                    $badge = 'bg-danger';
                                                    break;
                                                default:
                                                    $badge = 'bg-secondary';
                                            }
                                            ?>
                                            <span class="badge <?php echo $badge; ?>"><?php echo $status; ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $invoiceFile = $booking['invoice'];

                                            if (!empty($invoiceFile)) {
                                                echo '<a href="http://localhost/wrenchking/admin/download_invoice.php?file=' . urlencode($invoiceFile) . '" 
                                                class="btn btn-sm btn-success" target="_blank">View</a>';
                                            } else {
                                                echo "<i class='text-muted'>Not Available</i>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($booking['pay_status'] == 'Paid') {
                                                echo '<small>T_ID: ' . $booking["t_id"] . '</small><br>';

                                                if ($booking['verify'] == 1) {
                                                    echo '<span class="badge bg-success">Verified</span>';
                                                    echo '<span class="text-success ps-2">✔</span><br>';

                                                } else {
                                                    echo '<span class="badge bg-warning text-dark">Verifying</span>';
                                                }

                                            } else {
                                                if (!empty($booking['invoice'])) {
                                                    echo '<a href="pay-service.php?booking_id=' . $booking['sb_id'] . '" class="btn btn-sm btn-primary">Pay Now</a>';
                                                } else {
                                                    echo '<button class="btn btn-sm btn-secondary" disabled>Pending</button>';
                                                }
                                            }
                                            ?>
                                        </td>

                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="10" class="text-center">No booking history found!</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <hr>

                </div>
            </main>
        </div>
    </div>
    <!-- Footer Start -->
    <?php include './includes/footer.php'; ?>
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