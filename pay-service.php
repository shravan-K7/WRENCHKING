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
// Check if booking_id is passed
if (isset($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];

    // Fix: Use the booking ID after it's validated
    $serviceBooking = $admin->ret("
        SELECT sb.*, s.s_title, sb.total_amount, sp.sp_qrcode 
        FROM `service_booking` sb 
        INNER JOIN `services` s ON sb.s_id = s.s_id 
        INNER JOIN `s_provider` sp ON s.sp_id = sp.sp_id 
        WHERE sb.sb_id = '$bookingId'
    ");

    if ($serviceBooking->rowCount() > 0) {
        $booking = $serviceBooking->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Invalid booking.";
        exit;
    }
} else {
    echo "Booking ID is required.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Payment - WrenchKing</title>
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

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>
    <!-- Header end -->

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 text-white text-center">Payment Details</h4>
                        <p class="mb-0 text-white-50 text-center small"><?php echo htmlspecialchars($booking['s_title']); ?></p>
                    </div>
                    <div class="card-body p-4">
                        <!-- UPI QR Code -->
                        <div class="text-center mb-4">
                            <h5 class="fw-bold mb-3">Scan & Pay via UPI</h5>
                            <?php if (!empty($booking['sp_qrcode'])): ?>
                                <img src="admin/controllers/<?php echo htmlspecialchars($booking['sp_qrcode']); ?>" alt="UPI QR Code"
                                    class="img-fluid rounded border p-2 mb-2" style="max-width: 250px; width: 100%;" />
                            <?php else: ?>
                                <div class="alert alert-warning">QR Code not available for this service center branch.</div>
                            <?php endif; ?>
                            <p class="text-muted small mb-0">Bank Account: XYZ Bank &bull; A/C: 1234567890</p>
                        </div>

                        <div class="bg-light p-3 rounded text-center mb-4">
                            <span class="text-muted d-block small text-uppercase fw-semibold">Amount to Pay</span>
                            <span class="fs-2 fw-bold text-danger">₹<?php echo htmlspecialchars($booking['total_amount']); ?></span>
                            <div class="text-danger small mt-1">
                                ⚠️ Please verify the amount carefully before making the payment.
                            </div>
                        </div>

                        <form action="process-payment.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="transaction_id" class="form-label fw-semibold">Transaction ID / UTR <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id" maxlength="12"
                                    placeholder="Enter 12-digit UPI / UTR Reference ID" required>
                            </div>

                            <div class="mb-4">
                                <label for="payment_screenshot" class="form-label fw-semibold">
                                    Upload Payment Screenshot <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="file" class="form-control" id="payment_screenshot" name="payment_screenshot"
                                    accept="image/*">
                            </div>

                            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['sb_id']); ?>">
                            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($booking['total_amount']); ?>">
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">Submit Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Start -->
    <?php include './includes/footer.php'; ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
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