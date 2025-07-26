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
</head>

<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>
    <!-- Header end -->

    <div class="container mt-4">
        <h2>Payment Details for Service: <?php echo $booking['s_title']; ?></h2>

        <!-- <p><strong>Service: </strong><?php echo $booking['s_title']; ?></p> -->

        <!-- Display UPI QR Code or Bank Details for payment -->
        <div class="text-center">
            <h4>Pay via UPI</h4>
            <?php if (!empty($booking['sp_qrcode'])): ?>
                <img src="admin/controllers/<?php echo $booking['sp_qrcode']; ?>" alt="UPI QR Code" width="300px"
                    class="img-fluid d-block mx-auto" />
            <?php else: ?>
                <p class="text-danger">QR Code not available for this branch.</p>
            <?php endif; ?>
            <!-- Optional bank details -->
            <p>Bank Account: XYZ Bank, Account Number: 1234567890</p>
        </div>

        <h4>
            <strong>Amount: </strong>₹<span style="color: red;"><?php echo $booking['total_amount']; ?></span>
        </h4>
        <p class="text-danger" style="font-weight: 500;">
            ⚠️ Please check the amount carefully before making the payment!
        </p>


        <form action="process-payment.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" class="form-control" id="transaction_id" name="transaction_id" maxlength="12"
                    required>
            </div>

            <div class="mb-3">
                <label for="payment_screenshot" class="form-label">
                    Upload Payment Screenshot <span class="text-muted">(optional)</span>
                </label>
                <input type="file" class="form-control" id="payment_screenshot" name="payment_screenshot"
                    accept="image/*">
            </div>

            <input type="hidden" name="booking_id" value="<?php echo $booking['sb_id']; ?>">
            <input type="hidden" name="amount" value="<?php echo $booking['total_amount']; ?>">
            <button type="submit" class="btn btn-success">Submit Payment</button>
        </form>
    </div>
    <!-- Footer Start -->
    <?php include './includes/footer.php'; ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
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